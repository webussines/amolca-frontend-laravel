<?php

namespace App\Http\Controllers;

use App\Repositories\Authentication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{

	protected $authentication;
	protected $request;

	public function __construct(Authentication $authentication, Request $request) {
		$this->authentication = $authentication;
		$this->request = $request;
	}

    public function register() {

        $user = $this->request->all();

        $mailer['name'] = mailer_get_name();
        $mailer['cc'] = mailer_get_cc() . ', ' . mailer_get_me();
        //$mailer['cc'] = 'mstiven013@gmail.com';
        $mailer['domain'] = mailer_get_domain();
        $mailer['country'] = mailer_get_country();

        return $this->authentication->register($user, $mailer);
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

    public function AdminLogout() {

    	$this->request->session()->flush();
    	return redirect('am-admin');

    }

    public function EcommerceLogout() {

        $this->request->session()->flush();
        return redirect('/');

    }
}
