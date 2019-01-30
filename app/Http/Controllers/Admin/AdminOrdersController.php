<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminOrdersController extends Controller
{

    protected $orders;
    protected $request;
    protected $response;

    public function __construct(Request $request, Response $response, Orders $orders) {
        $this->orders = $orders;
        $this->response = $response;
        $this->request = $request;
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

    /*Show order*/
    public function show($id)
    {

        $order = $this->orders->findById($id);

        return view('admin.orders.single', [ 'order' => $order ]);
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
