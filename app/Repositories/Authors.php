<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Authors extends GuzzleHttpRequest {

	public function all($params = 'limit=800') {
        return $this->get("authors?{$params}");
	}

	public function findById($id) {
		return $this->get("authors/{$id}");
	}
	
}