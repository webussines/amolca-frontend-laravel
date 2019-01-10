<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Options;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Response;
use Validator;

class ApiOptionsController extends Controller
{

	protected $options;
	protected $request;

	public function __construct(Options $options, Request $request) {
		$this->options = $options;
		$this->request = $request;
	}

	// Controller method for create option
    public function store()
    {

        try {

            $messages = [
                'required' => 'El campo :attribute es obligatorio',
                'option_name.unique' => 'Ya existe un recurso con el mismo option_name',
            ];

            $rules = [
                'option_name' => 'required|string|unique:am_options',
                'option_value' => 'required',
            ];

            $validator = Validator::make($this->request->all(), $rules, $messages);

            if ($validator->fails()) {

                return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $validator->errors() ], 400);

            }

            $option = Options::create($this->request->all());

            return Response::json(["message" => 'Recurso creado correctamente', "status" => 201], 201);

        } catch(QueryException $e) {

            $eCode = $e->errorInfo[1];
            $eMessage = $e->errorInfo[2];

            if($eCode == 1062){
                return Response::json([ 'status' => 409, 'message' => $eMessage ], 409);
            }

            return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
            
        }

    }
    
	public function show($name) {
		$option = Options::where('option_name', '=', $name)->first();

		if($option == null) {
            return response()->json(['status' => 404, 'message' => 'El recurso que estas buscando no existe'], 404);
        }

        return $option;
	}

	// Controller method for update one option
    public function update(Request $request, $name)
    {
        $option = Options::where('option_name', '=', $name)->first();

        if(!$option) {
            return response()->json(['status' => 404, 'message' => 'El recurso que estas buscando no existe'], 404);
        }

        try {

            //Actualizar la taxonomia
            $option->update( $this->request->all() );

            return Response::json(['status' => 200, 'message' => 'Recurso actualizado correctamente', 'option' => $option], 200);

        } catch(QueryException $e) {

            $eCode = $e->errorInfo[1];
            $eMessage = $e->errorInfo[2];

            return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
            
        }
    }

}
