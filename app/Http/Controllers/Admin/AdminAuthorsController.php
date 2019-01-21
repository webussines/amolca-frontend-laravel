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
        $author = $this->authors->inventory($id);

        $send_info = [];

        $send_info['specialties'] = $this->specialties->all()->taxonomies;
        $send_info['action'] = 'edit';

        $send_info['author'] = $author->post;

        if(isset($author->prev)) {
            $send_info['prev'] = $author->prev;
        }

        if(isset($author->next)) {
            $send_info['next'] = $author->next;
        }

        return view('admin.authors.single', $send_info);
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
            'specialties' => $specialties->taxonomies
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
