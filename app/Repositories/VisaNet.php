<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class VisaNet extends GuzzleHttpRequest {

	public function transaction($token, $merchant_id, $body) {

        try {

            $headers = [
                        "Content-type" => "application/json",
                        "Authorization" => $token
                    ];

			//$url = 'https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/'; // Dev
			$url = 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/'; // Prod

            $client = new Client();
            $req = $client->request('POST', $url . $merchant_id, [
                "headers" => $headers,
                "json" => $body
            ]);
            $resp = $req->getBody()->getContents();

            return $resp;

        } catch(ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return $responseBodyAsString;

        }
	}

}
