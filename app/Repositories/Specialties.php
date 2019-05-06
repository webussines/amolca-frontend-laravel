<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class Specialties extends GuzzleHttpRequest {

	public function all($params = 'limit=30') {
        return $this->get("taxonomies?{$params}");
	}

	public function findByTerm($term, $params = 'orderby=title') {
		return $this->get("taxonomies/term/{$term}?{$params}");
	}

	public function findById($id) {
		return $this->get("taxonomies/{$id}");
	}

	public function book($tax, $book) {
		return $this->get("taxonomies/{$tax}/posts/{$book}");
	}

	public function find($slug) {
		return $this->get("taxonomies/slug/{$slug}");
	}

	public function create($body) {
		return $this->post("taxonomies", $body);
	}

	public function updateById($id, $update) {
		return $this->put("taxonomies/{$id}", $update);
	}

	public function deleteById($id) {
		return $this->delete("taxonomies/{$id}");
	}

}
