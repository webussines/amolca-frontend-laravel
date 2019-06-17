<?php

namespace App\Http\Controllers;

use App\Repositories\Authentication;
use App\Repositories\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{

	protected $authentication;
	protected $request;
	protected $users;

	public function __construct(Authentication $authentication, Request $request, Users $users) {
		$this->authentication = $authentication;
		$this->users = $users;
		$this->request = $request;
	}

	public function validate_wb() {
		$email = $this->request->all();
		return $this->users->validate($email);
	}

    public function register() {

        $user = $this->request->all();

        $cc = mailer_get_cc();
        $me = mailer_get_me();
        array_push($cc, $me);

        $mailer['name'] = mailer_get_name();
        $mailer['from'] = mailer_get_me();
        $mailer['cc'] = $cc;
        //$mailer['cc'] = 'mstiven013@gmail.com';
        $mailer['domain'] = mailer_get_domain();
        $mailer['country'] = mailer_get_country();
        $mailer['send_mail'] = true;

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

	public function autologin() {
		$token = $this->request->get('token');
		$login = $this->authentication->login('', '', $token);

		if( isset($login->token) ) {
			return redirect('/mi-cuenta');
		} else {
			return redirect('/registrarse');
		}
	}

	public function restore_password() {
		$email = $this->request->get('email');
		$send_mail = $this->request->get('send_mail');
		$new_password = $this->request->get('new_password');
		$restore_password = $this->authentication->restore_password($email, $send_mail, $new_password);

		return $restore_password;
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
