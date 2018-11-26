<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Specialties extends GuzzleHttpRequest {

	public function all() {
        return $this->get('specialties');
	}

	public function find($slug) {
		return $this->get("specialties/slug/{$slug}");
	}
	
}