<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Sliders extends GuzzleHttpRequest {

	public function all($params = 'limit=30') {
        return $this->get("sliders?{$params}");
	}

	public function findById($id) {
		return $this->get("sliders/{$id}");
	}

	public function find($slug) {
		return $this->get("sliders/slug/{$slug}");
	}

	public function updateById($id, $update) {
		return $this->put("sliders/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("sliders/{$id}");
	}
	
}