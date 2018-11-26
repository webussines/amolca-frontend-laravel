<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Books extends GuzzleHttpRequest {

	public function all() {

        return $this->get('specialties');

	}

	public function show($id) {

		return $this->get("specialties/{$id}");

	}
	
}