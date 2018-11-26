<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

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

}