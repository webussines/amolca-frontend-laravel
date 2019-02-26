<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Dealers;
use App\Repositories\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AdminDealersController extends Controller
{

    protected $request;
    protected $response;
    protected $dealers;
    protected $countries;

    public function __construct(Response $response, Request $request, Dealers $dealers, Countries $countries) {

        $this->middleware('superadmin');

        $this->request = $request;
        $this->response = $response;
        $this->dealers = $dealers;
        $this->countries = $countries;

    }

    public function all() {
        $params = "";

        $dealers = $this->dealers->all($params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $dealers;

            return $resp;
        }

        return Response::json($dealers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dealers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries = $this->countries->all();
        return view('admin.dealers.single', [ 'action' => 'create', 'countries' => $countries ]);

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
        return $this->dealers->create($coupon);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dealer = $this->dealers->findById($id);

        if(!isset($dealer->id)) {
            return redirect('/am-admin/distribuidores');
        }

        $countries = $this->countries->all();

        return view('admin.dealers.single', [ "dealer" => $dealer, "action" => "edit", 'countries' => $countries ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $body = Input::post('body');
        return $this->dealers->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->dealers->deleteById($id);
    }
}
