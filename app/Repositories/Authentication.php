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

			$req = $this->client->request('POST', 'login', [ "form_params" => ["username" => $user, "password" => $password] ]);
			$resp = $req->getBody()->getContents();

			$json = json_decode($resp);

			$this->request->session()->put('access_token', $json->access_token);
			$this->request->session()->put('user', $json->user);

			return $resp;

		} catch(ClientException $e) {

			$response = $e->getResponse();
        	$responseBodyAsString = $response->getBody()->getContents();

        	return $responseBodyAsString;
        	
		}

	}
	
}