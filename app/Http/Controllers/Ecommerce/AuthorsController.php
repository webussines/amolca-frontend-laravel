<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Authors;
use App\Repositories\Posts;
use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorsController extends Controller
{
    protected $authors;
    protected $posts;
    protected $request;
    protected $banners;
    protected $pagination_number = 16;

    public function __construct(Authors $authors, Posts $posts, Request $request, Banners $banners) {
        $this->authors = $authors;
        $this->posts = $posts;
        $this->request = $request;
        $this->banners = $banners;
    }
    
	public function index() {

		$info_send = [];
		$params = 'orderby=thumbnail&order=asc&limit=' . $this->pagination_number;
		$info_send['active_page'] = 1;

		if($this->request->input('page')) {
			$skip = $this->pagination_number * ($this->request->input('page') - 1);
			$params .= '&skip=' . $skip;
		}

		$all = $this->authors->all($params);

		// Crear paginacion y arreglo con los posts
		$authors = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$authors = new LengthAwarePaginator($all->posts, $all->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

		return view('ecommerce.authors.index', [ 'authors' => $authors ]);
	}

	public function show($slug) {

		$author = $this->authors->findBySlug($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($author->id)) {
			return redirect('/');
		}

		$send_data = [];

		$banner = $this->banners->findByResource('author', $author->id);
        if( isset($banner->id) ) {
            $send_data['banner'] = $banner;
        }

		$params = "orderby=publication_year&order=-1";
		$author_books = $this->posts->author($author->id, $params);

		// Crear paginacion y arreglo con los posts
		$books = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$books = new LengthAwarePaginator($author_books->posts, $author_books->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

	    $send_data["author"] = $author;
	    $send_data["books"] = $books;

		return view('ecommerce.authors.show', $send_data);

	}
}
