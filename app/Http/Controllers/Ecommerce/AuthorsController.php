<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Authors;
use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

			$info_send['active_page'] = $this->request->input('page');
		}

		$authors = $this->authors->all($params);

		$info_send['authors'] = $authors->posts;
		$info_send['items_per_page'] = $this->pagination_number;
		$info_send['counter'] = $authors->counter;

		return view('ecommerce.authors.index', $info_send);
	}

	public function show($slug) {

		$author = $this->authors->findBySlug($slug);

		$params = "orderby=publication_year&order=-1";
		$books = $this->books->author($author->id, $params);

		return view('ecommerce.author', ["author" => $author, "books" => $books]);

	}
}
