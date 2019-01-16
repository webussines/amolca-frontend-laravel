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

		// Redirigir al home si el recurso no existe
		if(!isset($book->id)) {
			return redirect('/');
		}

		$related_specialty = $book->taxonomies[0]->id;

		if(count($book->taxonomies) > 1) {
			$related_specialty = $book->taxonomies[1]->id;
		}

		$params = "orderby=title&order=asc&limit=12&random=1";

		$related = $this->books->taxonomies($related_specialty, $params)->posts;

		return view('ecommerce.book', ["book" => $book, "related" => $related]);

	}

}
