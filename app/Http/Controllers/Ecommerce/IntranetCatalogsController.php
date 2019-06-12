<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\IntranetCatalogs;

class IntranetCatalogsController extends Controller
{

    protected $catalogs;

    public function __construct(IntranetCatalogs $catalogs) {
        $this->catalogs = $catalogs;
    }

    public function all_catalogs() {
        $catalogs = $this->catalogs->all();
        if( isset($catalogs->posts) ) {
            $all_catalogs = $catalogs->posts;
        } else {
            $all_catalogs = [];
        }
		return view('amolca/releases/index', ['catalogs' => $all_catalogs]);
    }

	public function medician_catalogs() {
        $catalogs = $this->catalogs->medician();
		return view('amolca/releases/medician', ['catalogs' => $catalogs]);
	}

    public function odontology_catalogs() {
        $catalogs = $this->catalogs->odontology();
		return view('amolca/releases/odontology', ['catalogs' => $catalogs]);
	}

}
