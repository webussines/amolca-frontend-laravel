<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class Countries extends GuzzleHttpRequest {

    public function all() {
        return $this->get('countries');
    }

    public function findById($id) {
		return $this->get("countries/{$id}");
	}

    public function findByTitle($title) {
    	return $this->get('countries/title/' . $title);
    }

}
