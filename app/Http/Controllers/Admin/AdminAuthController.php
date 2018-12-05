<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Authentication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminAuthController extends Controller
{

	protected $authentication;
	protected $request;

	public function __construct(Authentication $authentication, Request $request) {
		$this->authentication = $authentication;
		$this->request = $request;
	}

    public function login() {

    	$username = Input::get('username');
        $password = Input::get('password');
        /*
        $username = "mstiven013@gmail.com";
        $password = "SoloNacional";
        */

    	return $this->authentication->login($username, $password);

    }

    public function logout() {

    	$this->request->session()->flush();
    	return redirect('am-admin');

    }
}
