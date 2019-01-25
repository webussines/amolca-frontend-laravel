<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Forms extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($type = 'contact', $params = 'limit=200') {
        return $this->get("forms?type={$type}&{$params}");
	}

	public function findById($id) {
		return $this->get("forms/{$id}");
	}

	public function findByTitle($title) {
		return $this->get("forms/title/{$title}");
	}

	public function create($body) {
		return $this->post("forms", $body);
	}
	
}