<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Users;
use App\Repositories\Countries;
use App\Repositories\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminUsersController extends Controller
{

    protected $users;
    protected $request;
    protected $countries;
    protected $orders;

    public function __construct(Users $users, Request $request, Countries $countries, Orders $orders) {

        $this->middleware('superadmin', [ "except" => [ "all", "clients", "getclients", "orders" ] ]);

        $this->users = $users;
        $this->request = $request;
        $this->countries = $countries;
        $this->orders = $orders;

    }

    public function all() {

        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=title&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->users->all($params);

        return $resp;
    }

    public function index()
    {
        $params = '';

        if( session('user')->role != ('SUPERADMIN') ) {
            $params = 'country=' . session('user')->country;
        }

        $users = $this->users->all($params);

        return view('admin.users.index', ['users' => $users, 'action' => 'all']);
    }

    public function clients()
    {

        $params = '';

        if( session('user')->role !== ('SUPERADMIN') ) {
            $params = 'country=' . session('user')->country;
        }

        $users = $this->users->clients($params);

        return view('admin.users.index', ['users' => $users, 'action' => 'clients']);
    }

    public function getclients()
    {

        $params = '';

        if( session('user')->role !== ('SUPERADMIN') ) {
            $params = 'country=' . session('user')->country;
        }

        $resp = [];
        $resp['data'] = $this->users->clients($params);

        return $resp;
    }

    public function create()
    {
        $countries = $this->countries->all();

        return view('admin.users.single', [
            'action' => 'create',
            'countries' => $countries
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->all();

        $cc = mailer_get_cc();
        $me = mailer_get_me();
        array_push($cc, $me);

        $mailer['name'] = mailer_get_name();
        $mailer['from'] = mailer_get_me();
        //$mailer['cc'] = $cc;
        $mailer['cc'] = 'mstiven013@gmail.com';
        $mailer['domain'] = mailer_get_domain();
        $mailer['country'] = mailer_get_country();
        $mailer['send_mail'] = false;

        $send = [
            "user" => $user,
            "mailer" => $mailer
        ];

        return $this->users->create($send);
    }

    public function show($id)
    {
        $user = $this->users->findById($id);
        $countries = $this->countries->all();

        return view('admin.users.single', [
            'action' => 'edit',
            'user' => $user,
            'countries' => $countries
        ]);
    }

    public function orders($id)
    {
        $user = $this->users->findById($id);
        $orders = $this->orders->findByUser($user->email);

        if($this->request->ajax()) {
            $resp = [];

            if ( is_object($orders) ) {
                $decode = json_decode($orders);

                if( isset($decode->status) && $decode->status == 404 ) {
                    $resp['data'] = [];
                }

            } else {
                $resp['data'] = $orders;
            }

            return $resp;
        }

        return view('admin.users.orders', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function edit($id)
    {
        $body = $this->request->all();
        return $this->users->updateById($id, $body);
    }

    public function destroy($id)
    {
        return $this->users->deleteById($id);
    }
}
