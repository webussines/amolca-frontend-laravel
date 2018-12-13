<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

class ApiArchivesController extends Controller
{

	protected $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

    public function index() {
    	return 'Index';
    }

    public function upload_file() {

    	$resp = [];

    	$route = $this->request->post('src');

    	$file = $this->request->file('file');

        if(Storage::exists($route . '/' . $file->getClientOriginalName())) {

            $resp['status'] = 409;
            $resp['message'] = 'This resource already exists';

        } else {

            $resp['status'] = 200;
            $resp['message'] = 'This resource is saved successfully';
            $resp['fileName'] = $file->getClientOriginalName();

            Storage::putFileAs($route, $file, $file->getClientOriginalName());

        }

 		return $resp;

    }
}
