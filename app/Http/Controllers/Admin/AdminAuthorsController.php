<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Authors;
use App\Repositories\Specialties;
use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminAuthorsController extends Controller
{
    protected $authors;
    protected $specialties;
    protected $books;

    public function __construct(Specialties $specialties, Books $books, Authors $authors) {
        $this->authors = $authors;
        $this->specialties = $specialties;
        $this->books = $books;
    }

    public function all() {
        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=name&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->authors->all($params);

        return $resp;
    }

    public function index()
    {
        $params = "orderby=title&order=1&limit=800&skip=0";
        $authors = $this->authors->all($params);

        return view('admin.authors.index', ['authors' => $authors]);
    }

    public function show($id)
    {
        $specialties = $this->specialties->all();
        $author = $this->authors->findById($id);

        return view('admin.authors.edit', ['author' => $author, 'specialties' => $specialties]);
    }

    public function edit($id)
    {
        $update = Input::post('update');
        return $this->authors->updateById($id, $update);
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
