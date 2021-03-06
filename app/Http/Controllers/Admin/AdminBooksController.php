<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Specialties;
use App\Repositories\Inventories;
use App\Repositories\Authors;
use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Response;

class AdminBooksController extends Controller
{

    protected $authors;
    protected $banners;
    protected $specialties;
    protected $books;
    protected $inventories;
    protected $request;

    public function __construct(Specialties $specialties, Posts $books, Authors $authors, Request $request, Inventories $inventories) {

        $this->middleware('superadmin', [ "only" => [ "create", "index", "edit" ] ]);

        $this->specialties = $specialties;
        $this->books = $books;
        $this->inventories = $inventories;
        $this->authors = $authors;
        $this->request = $request;
    }

    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "type=book&orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

        $books = $this->books->all("book", $params);

        if($this->request->ajax()) {
            $resp = [];
            $resp['data'] = $books->posts;

            return $resp;
        }

        return Response::json($books->posts);
    }

    /*Return all books view*/
    public function index()
    {
        $params = "orderby=title&order=1&limit=1&skip=0";
        $books = $this->books->all($params);
        $page_type = 'books';

        return view('admin.books.index', ['books' => $books, 'page_type' => $page_type]);
    }

    /*Mostrar*/
    public function show($id)
    {

        $authors = $this->authors->all();
        $specialties = $this->specialties->all();
        $book = $this->books->inventory($id, "book");

        if($book->post->type == 'post') {

            return redirect('/am-admin/blog/' . $book->post->id);

        } else if($book->post->type == 'event') {

            return redirect('/am-admin/eventos/' . $book->post->id);

        }

        $send_info = [];

        $send_info['specialties'] = $specialties->taxonomies;
        $send_info['authors'] = $authors->posts;
        $send_info['action'] = 'edit';

        $send_info['book'] = $book->post;

        if(isset($book->prev)) {
            $send_info['prev'] = $book->prev;
        }

        if(isset($book->next)) {
            $send_info['next'] = $book->next;
        }

        return view('admin.books.single', $send_info);
    }

    /*Editar*/
    public function edit($id)
    {
        $body = Input::post('body');
        return $this->books->updateById($id, $body);
    }

    /*Inventario*/
    public function inventory()
    {
        $params = "orderby=title&order=1&limit=1&skip=0";
        $books = $this->books->all($params);

        return view('admin.books.inventory', ['books' => $books]);
    }

    /*Por especilidad*/
    public function specialty()
    {
        return view('admin.books.specialties');
    }

    public function update_inventory() {

        $inventories = $this->request->post('body');
        return $this->inventories->updateAll($inventories);

    }

    /**/
    public function create()
    {
        $params = '?orderby=' . Input::get('orderby') . '&order=' . Input::get('order');

        $authors = $this->authors->all();
        $specialties = $this->specialties->all();

        return view('admin.books.single', [
            'action' => 'create',
            'specialties' => $specialties->taxonomies,
            'authors' => $authors->posts,
            'navigation' => null
        ]);
    }

    public function store(Request $request)
    {
        $book = $request->post('body');
        return $this->books->create($book);
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        return $this->books->deleteById($id);
    }
}
