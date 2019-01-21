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

	public function navigation($id, $params) {
		return $this->get("orders/navigation/{$id}{$params}");
	}

	public function findBySlug($slug) {
		return $this->get("orders/slug/{$slug}");
	}

	public function meta($id, $data) {
		return $this->get("orders/{$id}/{$data}");
	}

	public function create($body) {
		return $this->post("orders", $body);
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

	public function author($id, $params = '') {
		return $this->get("authors/{$id}/orders?{$params}");
	}

	public function taxonomies($id, $params = '') {
		return $this->get("taxonomies/{$id}/orders?{$params}");
	}
	
}