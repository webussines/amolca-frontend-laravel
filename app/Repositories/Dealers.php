<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Dealers extends GuzzleHttpRequest {

	public function all($params = 'limit=3000') {
        return $this->get("dealers?{$params}");
	}

	public function findById($id) {
		return $this->get("dealers/{$id}");
	}

	public function findByPost($id) {
		return $this->get("dealers/posts/{$id}");
	}

	public function findMostRecent() {
		return $this->get("dealers/news/recent");
	}

	public function create($body) {
		return $this->post("dealers", $body);
	}

	public function updateById($id, $update) {
		return $this->put("dealers/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("dealers/{$id}");
	}
	
}