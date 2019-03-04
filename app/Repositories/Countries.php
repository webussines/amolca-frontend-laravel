<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Countries extends GuzzleHttpRequest {

    public function all() {

        return $this->get('countries');

    }

    public function findByTitle($title) {
    	return $this->get('countries/title/' . $title);
    }

}