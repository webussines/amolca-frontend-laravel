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

	public function findByCountry($id) {
		return $this->get("dealers?country={$id}");
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