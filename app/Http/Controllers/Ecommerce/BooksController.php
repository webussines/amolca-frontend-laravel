<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{

    protected $posts;

    public function __construct(Posts $posts) {
        $this->posts = $posts;
    }
    
	public function index() {
	}

	public function show($slug) {

		$book = $this->posts->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($book->id)) {
			return redirect('/');
		}

		if($book->type == 'author') {
			return redirect('/autor/' . $book->slug);
		}

		$related_specialty = $book->taxonomies[0]->id;

		if(count($book->taxonomies) > 1) {
			$related_specialty = $book->taxonomies[1]->id;
		}

		$params = "orderby=title&order=asc&limit=12&random=1";

		$related = $this->posts->taxonomies($related_specialty, $params)->posts;

		return view('ecommerce.book', ["book" => $book, "related" => $related]);

	}

}
