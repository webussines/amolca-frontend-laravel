<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Specialties;
use App\Repositories\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SpecialtiesController extends Controller
{
    
    protected $request;
    protected $banners;
	protected $specialties;
	protected $posts;
	protected $pagination_number = 16;

	public function __construct(Specialties $specialties, Posts $posts, Request $request) {
		$this->specialties = $specialties;
		$this->posts = $posts;
		$this->request = $request;
	}

	public function index() {
		
		$specialties = $this->specialties->findByTerm('especialidades', 'orderby=title');

        return view('ecommerce.specialties.index', [ 'specialties' => $specialties->taxonomies ]);
	}

	public function show($slug) {

		$info_send = [];
		$params = 'orderby=publication_year&order=desc&limit=' . $this->pagination_number;
		$info_send['active_page'] = 1;

		if($this->request->input('page')) {
			$skip = $this->pagination_number * ($this->request->input('page') - 1);
			$params .= '&skip=' . $skip;
		}

		// Obtener informacion y posts de la especialidad
		$specialty = $this->specialties->find($slug);

		// Redirigir al home si el recurso no existe
		if(!isset($specialty->id)) {
			return redirect('/');
		}

		$books = $this->posts->taxonomies($specialty->id, $params);

		// Crear paginacion y arreglo con los posts
		$posts = range(1, 100);
		$pageName = 'page';
		$page = Paginator::resolveCurrentPage($pageName);
		$posts = new LengthAwarePaginator($books->posts, $books->counter, $this->pagination_number, $page, [
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => $pageName,
	    ]);

        return view('ecommerce.specialties.show', [ 'posts' => $posts, 'specialty' => $specialty ]);

	}

}
