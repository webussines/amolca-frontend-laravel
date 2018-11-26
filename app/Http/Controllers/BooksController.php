<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    
	public function index() {
	}

	public function show($id) {
		//$API_URL = 'http://localhost:3000/api/1.0';
        $API_URL = 'https://amolca-backend.herokuapp.com/api/1.0/';

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $API_URL
        ]);

        $response = $client->request('GET', "specialties/{$id}");	
	}

}
