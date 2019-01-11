<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Specialties;
use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtiesController extends Controller
{
    
    protected $banners;
	protected $specialties;
	protected $books;

	public function __construct(Specialties $specialties, Books $books) {
		$this->specialties = $specialties;
		$this->books = $books;
	}

	public function index() {
		
        return view('ecommerce.specialty');
	}

	public function show($slug) {


		$specialty = $this->specialties->find($slug);
		$books = $this->books->specialty($specialty->_id, 'orderby=publicationYear&order=-1');
		$country = $this->books->country;

        return view('ecommerce.specialty', ['specialty' => $specialty, 'books' => $books->books, 'active_country' => env('APP_COUNTRY')]);

	}

}
