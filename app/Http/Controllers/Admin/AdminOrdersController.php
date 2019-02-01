<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Orders;
use App\Repositories\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminOrdersController extends Controller
{

    protected $orders;
    protected $request;
    protected $response;
    protected $users;

    public function __construct(Request $request, Response $response, Orders $orders, Users $users) {
        $this->orders = $orders;
        $this->response = $response;
        $this->request = $request;
        $this->users = $users;
    }

    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $cart = (Input::get('cart')) ? Input::get('cart') : 0 ;
        $params = "carts={$cart}";

        $orders = $this->orders->all($params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $orders;

            return $resp;
        }

        return Response::json($orders->posts);
    }

    public function all_carts() {

        $orders = $this->orders->all_carts();

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $orders;

            return $resp;
        }

        return Response::json($orders->posts);
    }

    public function carts() {
        return view('admin.orders.carts');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function store_state($id) 
    {

        $state = $this->request->get('body');

        $cc = mailer_get_cc();
        $me = mailer_get_me();
        array_push($cc, $me);

        $mailer['name'] = mailer_get_name();
        $mailer['from'] = mailer_get_me();
        $mailer['cc'] = $cc;
        //$mailer['cc'] = ['mstiven013@gmail.com', 'diseno@webussines.com'];
        $mailer['domain'] = mailer_get_domain();

        $send = [
            "state" => $state,
            "mailer" => $mailer
        ];

        $resp = $this->orders->create_state($id, $send);

        return Response::json($resp);

    }

    /*Show order*/
    public function show($id)
    {

        $order = $this->orders->findById($id);
        $user = $this->users->findById($order->user_id);

        $send_data = [];
        $send_data['order'] = $order;

        //or if you want to be more accurate 
        if(is_object($user)){

            if(isset($user->id)) {
                $send_data['user'] = $user;
            }

        }

        if($order->state == 'CART') {
            return view('admin.orders.single-cart', $send_data);
        }

        return view('admin.orders.single', $send_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
