<?php

namespace App\Http\Controllers;

use App\Repositories\Books;
use Illuminate\Http\Request;

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
		return view('book', ["book" => $book, 'active_country' => env('APP_COUNTRY')]);

	}

}
