<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Specialties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminSpecialtiesController extends Controller
{

    protected $specialties;

    public function __construct(Specialties $specialties) {
        $this->specialties = $specialties;
    }

    public function all() {

        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=title&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->specialties->all($params);

        return $resp;

    }

    public function index()
    {
        $params = "orderby=title&order=1&limit=100&skip=0";
        $specialties = $this->specialties->all($params);

        return view('admin.specialties.index', ['specialties' => $specialties]);
    }

    public function show($id)
    {
        $specialties = $this->specialties->all();
        $specialty = $this->specialties->findById($id);

        return view('admin.specialties.edit', ['specialty' => $specialty, 'specialties' => $specialties]);
    }

    public function edit($id)
    {
        $update = Input::post('update');
        return $this->specialties->updateById($id, $update);
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
