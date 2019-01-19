<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Authors;
use App\Repositories\Specialties;
use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminAuthorsController extends Controller
{
    protected $authors;
    protected $specialties;
    protected $books;
    protected $request;

    public function __construct(Specialties $specialties, Posts $books, Authors $authors, Request $request) {
        $this->authors = $authors;
        $this->specialties = $specialties;
        $this->books = $books;
        $this->request = $request;
    }

    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $authors = $this->authors->all($params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $authors->posts;

            return $resp;
        }

        return Response::json($authors->posts);

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
            'specialties' => $specialties->taxonomies
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
