<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ecommerce\BooksController;

class PostsController extends Controller
{

    protected $posts;
    protected $books;

    public function __construct(Posts $posts, BooksController $books) {
        $this->posts = $posts;
        $this->books = $books;
    }
    
	public function index() {
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
