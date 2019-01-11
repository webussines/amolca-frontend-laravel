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

    public function __construct(Authors $authors, Books $books) {
        $this->authors = $authors;
        $this->books = $books;
    }
    
	public function index() {
	}

	public function show($slug) {

		$author = $this->authors->findBySlug($slug);

		$params = "orderby=publicationYear&order=-1";
		$books = $this->books->author($author->_id, $params);

		return view('ecommerce.author', ["author" => $author, "books" => $books]);

	}
}
