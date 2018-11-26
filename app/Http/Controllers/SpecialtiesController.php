<?php

namespace App\Http\Controllers;

use App\Repositories\Specialties;
use App\Repositories\Books;
use Illuminate\Http\Request;

class SpecialtiesController extends Controller
{
    
	protected $specialties;
	protected $books;

	public function __construct(Specialties $specialties, Books $books) {
		$this->specialties = $specialties;
		$this->books = $books;
	}

	public function index() {
		
        return view('specialty');
	}

	public function show($slug) {

		$specialty = $this->specialties->find($slug);
		$books = $this->books->specialty($specialty->_id);
		$country = $this->books->country;

        return view('specialty', ['specialty' => $specialty, 'books' => $books, 'active_country' => env('APP_COUNTRY')]);

	}

}
