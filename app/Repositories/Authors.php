<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Authors extends GuzzleHttpRequest {

	public function all() {
        return $this->get('authors');
	}

	public function show($id) {
		return $this->get("authors/{$id}");
	}
	
}