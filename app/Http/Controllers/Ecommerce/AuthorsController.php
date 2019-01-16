<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Authors;
use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorsController extends Controller
{
    protected $authors;
    protected $books;
    protected $request;
    protected $pagination_number = 16;

    public function __construct(Authors $authors, Books $books, Request $request) {
        $this->authors = $authors;
        $this->books = $books;
        $this->request = $request;
    }
    
	public function index() {

		$info_send = [];
		$params = 'orderby=thumbnail&order=asc&limit=' . $this->pagination_number;
		$info_send['active_page'] = 1;

		if($this->request->input('page')) {
			$skip = $this->pagination_number * ($this->request->input('page') - 1);
			$params .= '&skip=' . $skip;
		}

		$all = $this->authors->all($params);

		// Crear paginacion y arreglo con los posts
		$authors = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$authors = new LengthAwarePaginator($all->posts, $all->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

		return view('ecommerce.authors.index', [ 'authors' => $authors ]);
	}

	public function show($slug) {

		$author = $this->authors->findBySlug($slug);

		$params = "orderby=publication_year&order=-1";
		$author_books = $this->books->author($author->id, $params);

		// Crear paginacion y arreglo con los posts
		$books = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$books = new LengthAwarePaginator($author_books->posts, $author_books->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

		return view('ecommerce.author', ["author" => $author, "books" => $books]);

	}
}
