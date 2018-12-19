<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Specialties extends GuzzleHttpRequest {

	public function all($params = 'limit=30') {
        return $this->get("specialties?{$params}");
	}

	public function findById($id) {
		return $this->get("specialties/{$id}");
	}

	public function find($slug) {
		return $this->get("specialties/slug/{$slug}");
	}

	public function updateById($id, $update) {
		return $this->put("specialties/{$id}", $update);
	}
	
}