<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Lots extends GuzzleHttpRequest {

	public function all($params = 'limit=3000') {
        return $this->get("lots?{$params}");
	}

	public function findById($id) {
		return $this->get("lots/{$id}");
	}

	public function findByPost($id) {
		return $this->get("lots/posts/{$id}");
	}

	public function findActiveLot() {
		return $this->get("lots/releases/active");
	}

	public function findMostRecent() {
		return $this->get("lots/releases/recent");
	}

	public function create($body) {
		return $this->post("lots", $body);
	}

	public function updateById($id, $update) {
		return $this->put("lots/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("lots/{$id}");
	}
	
}