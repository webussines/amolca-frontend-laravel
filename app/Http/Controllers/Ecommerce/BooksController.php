<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Lots;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class BooksController extends Controller
{

    protected $posts;
    protected $lots;
    protected $pagination_number = 16;

    public function __construct(Posts $posts, Lots $lots) {
        $this->posts = $posts;
        $this->lots = $lots;
    }
    
	public function index() {
	}

	public function show($slug) {

		$book = $this->posts->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($book->id)) {
			return redirect('/');
		}

		$related_specialty = $book->taxonomies[0]->id;

		if(count($book->taxonomies) > 1) {
			$related_specialty = $book->taxonomies[1]->id;
		}

		$params = "orderby=title&order=asc&limit=12&random=1";

		$related = $this->posts->taxonomies($related_specialty, $params)->posts;

		return view('ecommerce.books.show', ["book" => $book, "related" => $related]);

	}

	public function news($slug) {

		$specialty_id = 1;
		$specialty_title = 'Medicina';

		switch ($slug) {
			case 'medicina':
				$specialty_id = 1;
				$specialty_title = 'Medicina';
				break;
			case 'odontologia':
				$specialty_id = 2;
				$specialty_title = 'Odontología';
				break;
		}

		$lot_books = $this->lots->findMostRecent()->books;

		$books = [];

		for ($i = 0; $i < count($lot_books); $i++) { 

			$book = $lot_books[$i];

			for ($t=0; $t < count($lot_books[$i]->taxonomies); $t++) { 
				if($lot_books[$i]->taxonomies[$t]->id == $specialty_id) {
					array_push($books, $book);
				}
			}
		}

		// Crear paginacion y arreglo con los posts
		$posts = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$posts = new LengthAwarePaginator($books, count($books), $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

		return view('ecommerce.books.news', [ "posts" => $posts, "specialty_title" => $specialty_title ]);

	}

}
