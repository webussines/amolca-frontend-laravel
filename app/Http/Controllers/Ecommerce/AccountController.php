<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    
	public function account() {
		return view('ecommerce/account/index', [ 'user' => session('user') ]);
	}

	public function orders() {
		return view('ecommerce/account/orders', [ 'user' => session('user') ]);
	}

	public function direction() {
		return view('ecommerce/account/direction', [ 'user' => session('user') ]);
	}

	public function information() {
		return view('ecommerce/account/information', [ 'user' => session('user') ]);
	}

}
