<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Forms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AdminFormsController extends Controller
{

    protected $request;
    protected $response;
    protected $forms;

    public function __construct(Response $response, Request $request, Forms $forms) {
        $this->request = $request;
        $this->response = $response;
        $this->forms = $forms;
    }

    public function all() {
        
        $params = "";

        if( session('user')->role != ('SUPERADMIN') ) {
            $params = 'country=' . session('user')->country;
        }

        $forms = $this->forms->all('contact', $params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $forms;

            return $resp;
        }

        return Response::json($forms);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forms.index');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = $this->forms->findById($id);

        return view('admin.forms.single', [ "form" => $form ]);
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
