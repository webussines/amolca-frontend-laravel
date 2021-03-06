<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class Posts extends GuzzleHttpRequest {

	public $country = "COLOMBIA";

	public function all($type = 'post', $params = 'limit=3000') {
        return $this->get("posts?type={$type}&{$params}");
	}

	public function list($type = 'post', $params = 'limit=3000') {
        return $this->get("posts?type={$type}&{$params}");
	}

	public function findById($id) {
		return $this->get("posts/{$id}");
	}

	public function inventory($id, $type, $params = '') {
		return $this->get("posts/inventory/{$id}?type={$type}&{$params}");
	}

	public function findBySlug($slug) {
		return $this->get("posts/slug/{$slug}");
	}

	public function searcher($query) {
		return $this->get("searcher?query={$query}");
	}

	public function meta($id, $data) {
		return $this->get("posts/{$id}/{$data}");
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

	public function author($id, $params = '') {
		return $this->get("authors/{$id}/posts?{$params}");
	}

	public function taxonomies($id, $params = 'type=book') {
		return $this->get("taxonomies/{$id}/posts?{$params}");
	}

}
