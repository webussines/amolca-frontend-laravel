<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Books extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all() {
        return $this->get('books');
	}

	public function findBySlug($slug) {
		return $this->get("books/slug/{$slug}");
	}

	public function specialty($id) {
		return $this->get("specialties/{$id}/books");
	}
	
}