<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class Catalogs extends GuzzleHttpRequest {

	public function all($params = 'limit=3000') {
        return $this->get("posts?type=catalog&{$params}");
	}

	public function findById($id) {
		return $this->get("posts/{$id}");
	}

	public function findBySlug($slug) {
		return $this->get("posts/slug/{$slug}");
	}

	public function medician() {
		return $this->get("catalogs/medician");
	}

	public function odontology() {
		return $this->get("catalogs/odontology");
	}

	public function create($body) {
		return $this->post("posts", $body);
	}

	public function updateById($id, $update) {
		return $this->put("posts/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("posts/{$id}");
	}

}
