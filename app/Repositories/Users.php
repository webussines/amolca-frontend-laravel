<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Users extends GuzzleHttpRequest {

	public function all($params = null) {
        return $this->getAuthenticated("users?{$params}");
	}

	public function clients($params = 'limit=1000') {
        return $this->getAuthenticated("users/clients?{$params}");
	}

	public function me($params = null) {
        return $this->getAuthenticated("users/me");
	}

	public function findById($id) {
		return $this->getAuthenticated("users/{$id}");
	}

	public function create($body) {
		return $this->post("users/register", $body);
	}

	public function updateById($id, $update) {
		return $this->put("users/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("users/{$id}");
	}
	
}