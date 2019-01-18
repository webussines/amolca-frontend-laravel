<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ecommerce\BooksController;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class PostsController extends Controller
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

		$all = $this->posts->all("post", $params);

		// Crear paginacion y arreglo con los posts
		$posts = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$posts = new LengthAwarePaginator($all->posts, $all->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

	    return view('ecommerce.posts.index', [ 'posts' => $posts ]);

	}

	public function show($slug) {

		$post = $this->posts->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($post->id)) {
			return redirect('/');
		}

		// Redirigir a la ruta o controlador dependiendo del tipo de post que sea
		switch ($post->type) {
			case 'author':
				return redirect('/autor/' . $post->slug);
				break;

			case 'book':
				return $this->books->show($post->slug);
				break;
		}

		$related = $this->posts->all("post", "limit=3&orderby=title&order=desc&random=1")->posts;

		return view('ecommerce.posts.show', ["post" => $post, "related" => $related]);

	}

}
