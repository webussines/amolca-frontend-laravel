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
        $params = "orderby=title&order=1&limit=1000&skip=0";
        $authors = $this->authors->all($params);

        return view('admin.authors.index', ['authors' => $authors]);
    }

    public function show($id)
    {
        $specialties = $this->specialties->all();
        $author = $this->authors->findById($id);

        return view('admin.authors.single', [
            'action' => 'edit',
            'author' => $author,
            'specialties' => $specialties
        ]);
    }

    public function edit($id)
    {
        $body = Input::post('body');
        return $this->authors->updateById($id, $body);
    }

    public function create()
    {
        $specialties = $this->specialties->all();

        return view('admin.authors.single', [
            'action' => 'create',
            'specialties' => $specialties
        ]);
    }

    public function store(Request $request)
    {
        $author = $request->post('body');
        return $this->authors->create($author);
    }

    public function destroy($id)
    {
        return $this->authors->deleteById($id);
    }

    public function update(Request $request, $id)
    {
        //
    }
}
