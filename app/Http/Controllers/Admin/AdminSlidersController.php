<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Sliders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminSlidersController extends Controller
{

    protected $sliders;

    public function __construct(Sliders $sliders) {
        $this->sliders = $sliders;
    }

    public function all() {

        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=title&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->sliders->all($params);

        return $resp;
    }

    public function index()
    {
        $params = "orderby=title&order=1&limit=800&skip=0";
        $sliders = $this->sliders->all($params);

        return view('admin.sliders.index', ['sliders' => $sliders]);
    }

    public function show($id)
    {
        $sliders = $this->sliders->findById($id);

        return view('admin.sliders.single', ['slider' => $sliders]);
    }

    public function edit($id)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
