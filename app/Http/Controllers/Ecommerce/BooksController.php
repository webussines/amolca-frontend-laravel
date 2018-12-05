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

		$params = "orderby=title&order=-1&limit=4&skip=0";
		$related = $this->books->specialty($book->specialty[1]->_id, $params)->books;

		return view('ecommerce.book', ["book" => $book, "related" => $related, 'active_country' => env('APP_COUNTRY')]);

	}

}
