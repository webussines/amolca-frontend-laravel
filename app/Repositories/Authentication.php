<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Response;

class Authentication extends GuzzleHttpRequest {

	protected $client;
	protected $request;

    public function __construct(Request $request, Client $client) {
    	$this->client = $client;
    	$this->request = $request;
    }

	public function login($user, $password, $token = null) {

		$headers = [
			"Content-type" => "application/json",
		];

		try {

			$this->request->session()->flush();

			if( $token == null ) {

				// Send user info to login
				$req = $this->client->request('POST', '/users/login', [ "form_params" => ["email" => $user, "password" => $password] ]);
				$resp = $req->getBody()->getContents();

				$json = json_decode($resp);

				$this->request->session()->put('access_token', $json->token);
				$headers["Authorization"] = "Bearer " . $json->token;

			} else {

				$this->request->session()->put('access_token', $token);
				$headers["Authorization"] = "Bearer " . $token;
				$resp = (Object) [
					"token" => $token
				];

			}

            // Get user info
            $user_req = $this->client->request('GET', '/users/me', ["headers" => $headers]);
            $user = $user_req->getBody()->getContents();
            $user_json = json_decode($user);

			$this->request->session()->put('user', json_decode($user));

			// Get cart if this exists
			$order_req = $this->client->request('GET', '/orders/user/' . $user_json->id . '/cart');
            $order = $order_req->getBody()->getContents();
            $order_json = json_decode($order);

            if(!isset($order_json->status)) {
            	$this->request->session()->put('cart', json_decode($order));
            }

			return $resp;

		} catch(ClientException $e) {

			$response = $e->getResponse();
        	$responseBodyAsString = $response->getBody()->getContents();

        	$resp_decode = json_decode($responseBodyAsString);

        	if(isset($resp_decode->src) && $resp_decode->src == 'order') {
        		return '{"token": "' . session('access_token') . '" }';
        	} else {
        		return $responseBodyAsString;
        	}

		}

	}

	public function register($user, $mailer) {

		try {

			// Send user info to login
			$req = $this->client->request('POST', '/users/register', [ "form_params" => ["user" => $user, "mailer" =>  $mailer] ]);
			$resp = $req->getBody()->getContents();

			$json = json_decode($resp);

			$this->request->session()->put('access_token', $json->token);

			$headers = [
                "Content-type" => "application/json",
                "Authorization" => "Bearer " . $json->token
            ];

            // Get user info
            $user_req = $this->client->request('GET', '/users/me', ["headers" => $headers]);
            $user = $user_req->getBody()->getContents();
            $user_json = json_decode($user);

			$this->request->session()->put('user', json_decode($user));

			// Get cart if this exists
			$order_req = $this->client->request('GET', '/orders/user/' . $user_json->id);
            $order = $order_req->getBody()->getContents();
            $order_json = json_decode($order);

            if(!isset($order_json->status)) {
            	$this->request->session()->put('cart', json_decode($order));
            }

			return $resp;

		} catch(ClientException $e) {

			$response = $e->getResponse();
        	$responseBodyAsString = $response->getBody()->getContents();

        	$resp_decode = json_decode($responseBodyAsString);

            if(isset($resp_decode->src) && $resp_decode->src == 'order') {
                return '{"token": "' . session('access_token') . '" }';
            } else {
                return $responseBodyAsString;
            }

		}
	}

}
