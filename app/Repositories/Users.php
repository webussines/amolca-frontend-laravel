<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Users extends GuzzleHttpRequest {

	public function all($params = null) {
        return $this->getAuthenticated("users");
	}

	public function clients($params = null) {
        return $this->getAuthenticated("users/clients");
	}

	public function me($params = null) {
        return $this->getAuthenticated("users/me");
	}

	public function findById($id) {
		return $this->getAuthenticated("users/{$id}");
	}

	public function create($body) {
		return $this->post("register", $body);
	}

	public function updateById($id, $update) {
		return $this->put("users/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("users/{$id}");
	}
	
}