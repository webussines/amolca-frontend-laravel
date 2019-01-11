<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{

    protected $books;

    public function __construct(Books $books) {
        $this->books = $books;
    }
    
	public function index() {
	}

	public function show($slug) {

		$book = $this->books->findBySlug($slug);

		$related_specialty = $book->specialty[0]->_id;

		if(count($book->specialty) > 1) {
			$related_specialty = $book->specialty[1]->_id;
		}

		$params = "orderby=publicationYear&order=-1&limit=12&skip=0";

		$related = $this->books->specialty($related_specialty, $params)->books;

		return view('ecommerce.book', ["book" => $book, "related" => $related]);

	}

}
