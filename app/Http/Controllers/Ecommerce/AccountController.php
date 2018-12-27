<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    
	public function account() {

		$user = session('user');

		return view('ecommerce/account/index', [ 'user' => $user ]);

	}

	public function orders() {

		$user = session('user');

		return view('ecommerce/account/orders', [ 'user' => $user ]);

	}

}
