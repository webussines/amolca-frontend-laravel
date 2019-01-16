<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Specialties extends GuzzleHttpRequest {

	public function all($params = 'limit=30') {
        return $this->get("taxonomies?{$params}");
	}

	public function findById($id) {
		return $this->get("taxonomies/{$id}");
	}

	public function find($slug) {
		return $this->get("taxonomies/slug/{$slug}");
	}

	public function updateById($id, $update) {
		return $this->put("taxonomies/{$id}", $update);
	}
	
}