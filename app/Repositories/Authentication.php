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
                "authorization" => "Bearer " . session('access_token')
            ];

            // Get user info
            $user_req = $this->client->request('GET', '/users/me', ["headers" => $headers]);
            $user = $user_req->getBody()->getContents();

			$this->request->session()->put('user', json_decode($user));

			return $resp;

		} catch(ClientException $e) {

			$response = $e->getResponse();
        	$responseBodyAsString = $response->getBody()->getContents();

        	return $responseBodyAsString;
        	
		}

	}
	
}