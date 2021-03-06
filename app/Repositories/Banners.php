<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Banners extends GuzzleHttpRequest {

	public function all($params = 'limit=1000') {
        return $this->get("banners?{$params}");
	}

	public function findById($id) {
		return $this->get("banners/{$id}");
	}

	public function findByResource($type = 'specialty', $id) {
		return $this->get("banners/type/{$type}/{$id}");
	}

	public function find($slug) {
		return $this->get("banners/slug/{$slug}");
	}

	public function create($body) {
		return $this->post("banners", $body);
	}

	public function updateById($id, $update) {
		return $this->put("banners/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("banners/{$id}");
	}
	
}