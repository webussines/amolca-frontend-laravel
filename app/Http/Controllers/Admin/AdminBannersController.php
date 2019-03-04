<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminBannersController extends Controller
{

    protected $banners;
    protected $request;

    public function __construct(Banners $banners, Request $request) {

        $this->middleware('superadmin');
        $this->banners = $banners;
        $this->request = $request;

    }

    public function all() {

        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=title&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->banners->all($params);

        return $resp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = "orderby=title&order=1&limit=800&skip=0";
        $banners = $this->banners->all($params);

        return view('admin.banners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.single', [ 'action' => 'create' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = $request->post('body');
        return $this->banners->create($banner);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = $this->banners->findById($id);

        if( !$banner->id ) {
            return redirect('/am-admin/banner');
        }

        if( $banner->resource_type == 'PAGE' ) {
        switch ( $banner->resource_id ) {
            case 1:
                $banner->resource_title = 'Carrito de compras';
                break;
            case 2:
                $banner->resource_title = 'Finalizar compra';
                break;
            case 3:
                $banner->resource_title = 'Términos y condiciones';
                break;
            case 4:
                $banner->resource_title = 'Contacto';
                break;
            case 5:
                $banner->resource_title = 'Página de todos los blogs';
                break;
            case 6:
                $banner->resource_title = 'Página de todos los autores';
                break;
            case 7:
                $banner->resource_title = 'Página de novedades médicas';
                break;
            case 8:
                $banner->resource_title = 'Página de novedades odontológicas';
                break;
        }
    }

        return view('admin.banners.single', ['banner' => $banner, 'action' => 'edit']);
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
        return $this->banners->updateById($id, $body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->banner->deleteById($id);
    }
}
