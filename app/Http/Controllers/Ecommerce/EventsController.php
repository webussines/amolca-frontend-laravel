<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Date\Date;

class EventsController extends Controller
{
    protected $posts;
    protected $books;
    protected $request;
    protected $pagination_number = 16;

    public function __construct(Request $request, Posts $posts, BooksController $books) {
    	$this->request = $request;
        $this->posts = $posts;
        $this->books = $books;
    }
    
	public function index() {

		$params = 'orderby=created_at&order=desc&limit=' . $this->pagination_number;

		if($this->request->input('page')) {
			$skip = $this->pagination_number * ($this->request->input('page') - 1);
			$params .= '&skip=' . $skip;
		}

		$all = $this->posts->all("event", $params);

		// Crear paginacion y arreglo con los posts
		$posts = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$posts = new LengthAwarePaginator($all->posts, $all->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

	    return view('ecommerce.events.index', [ 'posts' => $posts ]);

	}

	public function show($slug) {

		$event = $this->posts->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($event->id)) {
			return redirect('/');
		}

		// Redirigir a la ruta o controlador dependiendo del tipo de post que sea
		switch ($event->type) {
			case 'author':
				return redirect('/autor/' . $event->slug);
				break;

			case 'book':
				return $this->books->show($event->slug);
				break;
		}

		foreach ($event->meta as $key => $value) {

	        switch ($value->key) {
	            case 'event_date':
	                    $event->event_date = $value->value;
	                break;
	            case 'event_info_btn_type':
	                    $event->info_btn_type = $value->value;
	                break;
	            case 'event_info_btn':
	                    $event->info_btn = $value->value;
	                break;
	        }

	    }

		$related = $this->posts->all("event", "limit=3&orderby=title&order=desc&random=1")->posts;

		return view('ecommerce.events.single', ["event" => $event, "related" => $related]);

	}
}
