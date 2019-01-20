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

        $limit = (Input::post('limit')) ? Input::post('limit') : '10000';
        $skip = (Input::post('skip')) ? Input::post('skip') : '0';
        $inventory = (Input::post('inventory')) ? Input::post('inventory') : 0;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $resp = [];

        $resp['data'] = $this->specialties->all($params)->taxonomies;

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

        return view('admin.specialties.single', [
            'specialty' => $specialty,
            'specialties' => $specialties,
            'action' => 'edit'
        ]);
    }

    public function edit($id)
    {
        $update = Input::post('update');
        return $this->specialties->updateById($id, $update);
    }

    public function create()
    {
        return view('admin.specialties.single', [
            'action' => 'create'
        ]);
    }

    public function store(Request $request)
    {
        $specialty = Input::post('body');
        return $this->specialties->create($specialty);
    }

    public function destroy($id)
    {
        return $this->specialties->deleteById($id);
    }
}
