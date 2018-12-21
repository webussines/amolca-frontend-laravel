<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Books extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($params = 'limit=30') {
        return $this->get("books?{$params}");
	}

	public function findById($id) {
		return $this->get("books/{$id}");
	}

	public function navigation($id, $params) {
		return $this->get("books/navigation/{$id}{$params}");
	}

	public function findBySlug($slug) {
		return $this->get("books/slug/{$slug}");
	}

	public function updateById($id, $update) {
		return $this->put("books/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("books/{$id}");
	}

	public function specialty($id, $params = '') {
		return $this->get("specialties/{$id}/books?{$params}");
	}
	
}