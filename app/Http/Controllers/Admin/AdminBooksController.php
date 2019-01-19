<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Specialties;
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
    protected $request;

    public function __construct(Specialties $specialties, Posts $books, Authors $authors, Request $request) {
        $this->specialties = $specialties;
        $this->books = $books;
        $this->authors = $authors;
        $this->request = $request;
    }

    public function all() {
        $limit = (Input::get('limit')) ? Input::get('limit') : 2000 ;
        $skip = (Input::get('skip')) ? Input::get('skip') : 0 ;
        $inventory = (Input::get('inventory')) ? Input::get('inventory') : 0 ;
        $params = "orderby=title&order=asc&limit={$limit}&skip={$skip}&inventory={$inventory}";

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

        return view('admin.books.index', ['books' => $books]);
    }

    /*Mostrar*/
    public function show($id)
    {

        $params = '?orderby=' . Input::get('orderby') . '&order=' . Input::get('order');
        $navigation = [];

        $authors = $this->authors->all();
        $specialties = $this->specialties->all();
        $book = $this->books->navigation($id, $params);


        if( isset($book->prev) && isset($book->next) ) {
            $navigation['prev'] = $book->prev;
            $navigation['next'] = $book->next;
        }

        if( !isset($book->next) && isset($book->prev) ) {
            $navigation['next'] = $book->prev;
        }

        $navigation['orderby'] = Input::get('orderby');
        $navigation['order'] = Input::get('order');

        return view('admin.books.single', [
            'action' => 'edit',
            'var' => $book,
            'book' => $book->selected,
            'specialties' => $specialties,
            'authors' => $authors,
            'navigation' => $navigation
        ]);
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

    /**/
    public function create()
    {
        $params = '?orderby=' . Input::get('orderby') . '&order=' . Input::get('order');

        $authors = $this->authors->all();
        $specialties = $this->specialties->all();

        return view('admin.books.single', [
            'action' => 'create',
            'specialties' => $specialties,
            'authors' => $authors,
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
