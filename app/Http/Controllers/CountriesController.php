<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Countries;

class CountriesController extends Controller
{

	protected $countries;

	public function __construct(Countries $countries) {
		$this->countries = $countries;
	}
    
	public function index() {

		return json_encode($this->countries->all());

	}

	public function bytitle($title) {

		return json_encode($this->countries->findByTitle($title));

	}

}
