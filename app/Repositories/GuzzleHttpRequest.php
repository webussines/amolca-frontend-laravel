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

        try {

        	$response = $this->client->request('GET', $url);
            return json_decode( $response->getBody()->getContents() );

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;
            
        }

    }

    public function getAuthenticated($url) {

        try {

            $headers = [
                        "Content-type" => "application/json",
                        "authorization" => "Bearer " . session('access_token')
                    ];

            $req = $this->client->request('GET', $url, ["headers" => $headers]);
            $resp = $req->getBody()->getContents();

            return json_decode($resp);

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;
            
        }

    }

    public function post($url, $body) {

        try {

            $headers = [
                        "Content-type" => "application/json",
                        "authorization" => "Bearer " . session('access_token')
                    ];

            $req = $this->client->request('POST', $url, ["headers" => $headers, "json" => $body ]);
            $resp = $req->getBody()->getContents();

            return $resp;

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;
            
        }

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