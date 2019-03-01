<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminBannersController extends Controller
{

    protected $banners;

    public function __construct(Banners $banners) {

        $this->middleware('superadmin');
        $this->banners = $banners;

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
        $banner = $this->banner->findById($id);

        return view('admin.banners.single', ['slider' => $banner]);
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
