<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Banners extends GuzzleHttpRequest {

	public function all() {
        return $this->get('banners');
	}

	public function findById($id) {
		return $this->get("banners/{$id}");
	}

	public function findByResourceId($id) {
		return $this->get("banners/resource/{$id}");
	}
	
}