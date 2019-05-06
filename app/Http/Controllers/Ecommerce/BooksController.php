<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Lots;
use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Date\Date;

class BooksController extends Controller
{

    protected $posts;
    protected $lots;
    protected $banners;
    protected $pagination_number = 16;

    public function __construct(Posts $posts, Lots $lots, Banners $banners) {
        $this->posts = $posts;
        $this->lots = $lots;
        $this->banners = $banners;
    }

	public function index() {
	}

	public function show($slug) {

		$book = $this->posts->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($book->id)) {
			return redirect('/' . $slug);
		}

        $send_data = [];

        $banner = get_banners_src($this->banners, 'book', $book->id);

        for ($taxs = 0; $taxs < count($book->taxonomies); $taxs++) {
        	$specialty_banner = get_banners_src($this->banners, 'specialty', $book->taxonomies[$taxs]->id);
        	if( isset($specialty_banner->id) ) {
        		$banner = $specialty_banner;
        	}
        }

        if( isset($banner->id) ) {
            $send_data['banner'] = $banner;
        }

		$related_specialty = $book->taxonomies[0]->id;

		if(count($book->taxonomies) > 1) {
			$related_specialty = $book->taxonomies[1]->id;
		}

		$params = "orderby=title&order=asc&limit=12&random=1";

		$related = $this->posts->taxonomies($related_specialty, $params)->posts;

		$send_data["book"] = $book;
		$send_data["related"] = $related;

		if($book->state == 'RELEASE') {
			$lot = $this->lots->findByPost($book->id);

			if( isset($lot->id) ) {
				if($lot->arrival_date !== null) {

					$date = format_date($lot->arrival_date);

					$send_data['release'] = 'Este libro es una de nuestras novedades con fecha de llegada: <b>' . $date . '</b>.';

				} else {
					$send_data['release'] = 'Este libro es una de nuestras novedades. <b>¡Pronto podrás comprarlo!</b>.';
				}
			}
		}

		return view('ecommerce.books.show', $send_data);

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

		$lot_books = $this->lots->findActiveLot();
        if( !isset($lot_books->id) ) {
            // Obtener los libros del ultimo lote
            $releases_books = $this->lots->findMostRecent()->books;
        } else {
            $releases_books = $lot_books->books;
        }

		$books = [];

		for ($i = 0; $i < count($releases_books); $i++) {

			$book = $releases_books[$i];

			for ($t=0; $t < count($releases_books[$i]->taxonomies); $t++) {
				if($releases_books[$i]->taxonomies[$t]->id == $specialty_id) {
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
