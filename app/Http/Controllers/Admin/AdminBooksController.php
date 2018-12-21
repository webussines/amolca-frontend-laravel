<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Specialties;
use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminBooksController extends Controller
{

    protected $banners;
    protected $specialties;
    protected $books;

    public function __construct(Specialties $specialties, Books $books) {
        $this->specialties = $specialties;
        $this->books = $books;
    }

    public function getBooks() {

        $limit = Input::post('limit');
        $skip = Input::post('skip');
        $params = "orderby=title&order=1&limit={$limit}&skip={$skip}";

        $resp = [];

        $resp['data'] = $this->books->all($params);

        return $resp;
    }

    /*Return all books view*/
    public function index()
    {
        $params = "orderby=title&order=1&limit=100&skip=0";
        $books = $this->books->all($params);

        return view('admin.books.index', ['books' => $books]);
    }

    /*Mostrar*/
    public function show($id)
    {

        $params = '?orderby=' . Input::get('orderby') . '&order=' . Input::get('order');
        $navigation = [];

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
            'navigation' => $navigation
        ]);
    }

    /*Editar*/
    public function edit($id)
    {
        $update = Input::post('update');
        return $this->books->updateById($id, $update);
    }

    /*Inventario*/
    public function inventory()
    {
        $params = "orderby=title&order=1&limit=100&skip=0";
        $books = $this->books->all($params);

        return view('admin.books.inventory', ['books' => $books]);
    }

    /**/
    public function create()
    {
        $params = '?orderby=' . Input::get('orderby') . '&order=' . Input::get('order');

        $specialties = $this->specialties->all();

        return view('admin.books.single', [
            'action' => 'create',
            'specialties' => $specialties,
            'navigation' => null
        ]);
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
