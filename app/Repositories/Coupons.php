<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Coupons extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($params = 'limit=3000') {
        return $this->get("coupons?{$params}");
	}

	public function findById($id) {
		return $this->get("coupons/{$id}");
	}

	public function findBySlug($slug) {
		return $this->get("coupons/slug/{$slug}");
	}

	public function findByCode($code) {
		return $this->get("coupons/code/{$code}");
	}

	public function create($body) {
		return $this->post("coupons", $body);
	}

	public function updateById($id, $update) {
		return $this->put("coupons/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("coupons/{$id}");
	}
	
}