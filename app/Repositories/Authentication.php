<?php 

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class Authentication {

	protected $client;
	protected $request;

    public function __construct(Request $request, Client $client) {
    	$this->client = $client;
    	$this->request = $request;
    }

	public function login($user, $password) {

		try {

			// Send user info to login
			$req = $this->client->request('POST', '/users/login', [ "form_params" => ["email" => $user, "password" => $password] ]);
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

        	return $responseBodyAsString;
        	
		}

	}
	
}