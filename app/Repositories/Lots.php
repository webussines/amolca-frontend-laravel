<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Lots extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($params = 'limit=3000') {
        return $this->get("lots?{$params}");
	}

	public function findById($id) {
		return $this->get("lots/{$id}");
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