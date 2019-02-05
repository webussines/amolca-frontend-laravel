<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Inventories extends GuzzleHttpRequest {

	public function all($params = 'limit=30') {
        return $this->get("inventories?{$params}");
	}

	public function findById($id) {
		return $this->get("inventories/{$id}");
	}

	public function create($body) {
		return $this->post("inventories", $body);
	}

	public function updateById($id, $update) {
		return $this->put("inventories/{$id}", $update);
	}

	public function updateAll($update) {
		return $this->put("inventories", $update);
	}

	public function deleteById($id) {
		return $this->delete("inventories/{$id}");
	}
	
}