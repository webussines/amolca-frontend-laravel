<?php 

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GuzzleHttpRequest {

	protected $client;

    public function __construct(Client $client) {
    	$this->client = $client;
    }

    public function get($url) {

    	$response = $this->client->request('GET', $url);
        return json_decode( $response->getBody()->getContents() );

    }

    public function post($url) {

    	$response = $this->client->request('POST', $url);
        return json_decode( $response->getBody()->getContents() );

    }

    public function put($url, $body) {

        try {

            $headers = [
                        "Content-type" => "application/json",
                        "authorization" => "Bearer " . session('access_token')
                    ];

            $req = $this->client->request('PUT', $url, ["headers" => $headers, "json" => $body ]);
            $resp = $req->getBody()->getContents();

            return $resp;

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;
            
        }

    }

    public function delete($url) {

        try {

            $headers = [
                        "Content-type" => "application/json",
                        "authorization" => "Bearer " . session('access_token')
                    ];

            $req = $this->client->request('DELETE', $url, ["headers" => $headers ]);
            $resp = $req->getBody()->getContents();

            return $resp;

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;
            
        }

    }

}