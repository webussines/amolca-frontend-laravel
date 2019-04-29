<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Coupons;
use App\Repositories\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AdminCouponsController extends Controller
{

    protected $request;
    protected $response;
    protected $coupons;
    protected $countries;

    public function __construct(Response $response, Request $request, Coupons $coupons, Countries $countries) {
        $this->request = $request;
        $this->response = $response;
        $this->coupons = $coupons;
        $this->countries = $countries;
    }

    public function all() {

        $params = '';

        if( session('user')->role != ('SUPERADMIN') ) {
            $params = 'country=' . session('user')->country;
        }

        $coupons = $this->coupons->all($params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $coupons;

            return $resp;
        }

        return Response::json($coupons);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user_country_name = '';
        $user_country_id = '';

        if( session('user')->role == 'ADMIN' ) {
            $user_country_name = $this->countries->findById(session('user')->country)->title;
            $user_country_id = session('user')->country;
        }

        $countries = $this->countries->all();

        $info_send = [
            'action' => 'create',
            'countries' => $countries,
            'user_country_name' => $user_country_name,
            'user_country_id' => $user_country_id
        ];

        return view('admin.coupons.single', $info_send);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = $request->post('body');
        return $this->coupons->create($coupon);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user_country_name = '';
        $user_country_id = '';

        if( session('user')->role == 'ADMIN' ) {
            $user_country_name = $this->countries->findById(session('user')->country)->title;
            $user_country_id = session('user')->country;
        }

        $countries = $this->countries->all();
        $coupon = $this->coupons->findById($id);

        $info_send = [
            'action' => 'edit',
            'coupon' => $coupon,
            'countries' => $countries,
            'user_country_name' => $user_country_name,
            'user_country_id' => $user_country_id
        ];

        return view('admin.coupons.single', $info_send );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $body = $this->request->get('body');
        return $this->coupons->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->coupons->deleteById($id);
    }
}
