<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Coupons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AdminCouponsController extends Controller
{

    protected $request;
    protected $response;
    protected $coupons;

    public function __construct(Response $response, Request $request, Coupons $coupons) {
        $this->request = $request;
        $this->response = $response;
        $this->coupons = $coupons;
    }

    public function all() {
        $params = "";

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
        return view('admin.coupons.single', [ 'action' => 'create' ]);
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

        $coupon = $this->coupons->findById($id);

        return view('admin.coupons.single', [ 'action' => 'edit', 'coupon' => $coupon ]);

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
