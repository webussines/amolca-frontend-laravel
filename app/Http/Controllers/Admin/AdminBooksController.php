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

        $specialties = $this->specialties->all();
        $book = $this->books->navigation($id, $params);

        return view('admin.books.edit', [
            'book' => $book[0],
            'navOrderby' => Input::get('orderby'),
            'navOrder' => Input::get('order'),
            'previousBook' => $book[1],
            'nextBook' => $book[2],
            'specialties' => $specialties
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
