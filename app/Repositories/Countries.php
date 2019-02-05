<?php 

namespace App\Repositories;

use GuzzleHttp\Client;

class Countries extends GuzzleHttpRequest {

    public function all() {

        return $this->get('countries');

    }

}