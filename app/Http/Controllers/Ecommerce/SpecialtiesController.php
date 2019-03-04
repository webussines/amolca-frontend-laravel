<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Specialties;
use App\Repositories\Posts;
use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SpecialtiesController extends Controller
{
    
    protected $request;
	protected $specialties;
	protected $posts;
	protected $banners;
	protected $pagination_number = 16;

	public function __construct(Specialties $specialties, Posts $posts, Request $request, Banners $banners) {
		$this->specialties = $specialties;
		$this->posts = $posts;
		$this->request = $request;
		$this->banners = $banners;
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

        $send_data = [];
        $banner = $this->banners->findByResource('specialty', $specialty->id);

        if( isset($banner->id) ) {
            $send_data['banner'] = $banner;
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

	    $send_data['posts'] = $posts;
	    $send_data['specialty'] = $specialty;

        return view('ecommerce.specialties.show', $send_data );

	}

}
