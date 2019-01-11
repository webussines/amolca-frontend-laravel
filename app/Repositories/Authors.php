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

	public function findBySlug($slug) {
		return $this->get("authors/slug/{$slug}");
	}

	public function create($body) {
		return $this->post("authors", $body);
	}

	public function updateById($id, $update) {
		return $this->put("authors/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("authors/{$id}");
	}
	
}