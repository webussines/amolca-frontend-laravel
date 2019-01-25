<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Orders extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($type = 'post', $params = 'limit=30') {
        return $this->get("orders?type={$type}&{$params}");
	}

	public function findById($id) {
		return $this->get("orders/{$id}");
	}

	public function create($body) {
		return $this->post("orders", $body);
	}

	public function findByUser($id) {
		return $this->get("orders/user/{$id}");
	}

	public function updateById($id, $update) {
		return $this->put("orders/{$id}", $update);
	}

	public function createPending($id, $address) {
		return $this->put("orders/pending/{$id}", $address);
	}

	public function deleteById($id) {
		return $this->delete("orders/{$id}");
	}
	
}