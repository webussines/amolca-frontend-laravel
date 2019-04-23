<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Catalogs;
use App\Repositories\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AdminCatalogsController extends Controller
{

    protected $request;
    protected $response;
    protected $catalogs;
    protected $countries;

    public function __construct(Response $response, Request $request, Catalogs $catalogs, Countries $countries) {
        $this->request = $request;
        $this->response = $response;
        $this->catalogs = $catalogs;
        $this->countries = $countries;
    }

    public function all() {
        $params = "";

        $all_catalogs = $this->catalogs->all($params);

        $catalogs = [];

        if( isset($all_catalogs->posts) ) {
            $catalogs = $all_catalogs->posts;
        }

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $catalogs;

            return $resp;
        }

        return Response::json($catalogs);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->countries->all();
        return view('admin.catalogs.single', [ 'action' => 'create', 'countries' => $countries ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $catalog = $request->post('body');
      return $this->catalogs->create($catalog);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $countries = $this->countries->all();
        $catalog = $this->catalogs->findById($id);

        return view('admin.catalogs.single', [ 'action' => 'edit', 'catalog' => $catalog, 'countries' => $countries ]);
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
      return $this->catalogs->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->catalogs->deleteById($id);
    }
}
