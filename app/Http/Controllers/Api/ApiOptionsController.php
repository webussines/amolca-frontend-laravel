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
    protected $messages = [
                    'required' => 'El campo :attribute es obligatorio',
                    'option_name.unique' => 'Ya existe un recurso con el mismo option_name',
                ];

    protected $rules = [
                    'option_name' => 'required|string|unique:am_options',
                    'option_value' => 'required',
                ];

	public function __construct(Options $options, Request $request) {
		$this->options = $options;
		$this->request = $request;
	}

	// Controller method for create option
    public function store()
    {

        $all = $this->request->all('body');

        for ($i=0; $i < count($all); $i++) {

            $elem = $all[$i];

            try {

                $validator = Validator::make($elem, $this->rules, $this->messages);

                if ($validator->fails()) {

                    return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $validator->errors() ], 400);

                }

                $option = Options::create($elem);

            } catch(QueryException $e) {

                $eCode = $e->errorInfo[1];
                $eMessage = $e->errorInfo[2];

                if($eCode == 1062){
                    return Response::json([ 'status' => 409, 'message' => $eMessage ], 409);
                }

                return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
                
            }
        }

        return Response::json(["message" => 'Recursos creados correctamente', "status" => 201], 201);

    }
    
	public function show($name) {
		$option = Options::where('option_name', '=', $name)->first();

		if($option == null) {
            return response()->json(['status' => 404, 'message' => 'El recurso que estas buscando no existe'], 404);
        }

        return $option;
	}

	// Controller method for update one option
    public function update(Request $request, $name = null)
    {

        if($name == null) {

            $all = $this->request->get('body');

            for ($o=0; $o < count($all); $o++) {

                $elem = $all[$o];

                $option = Options::where('option_name', '=', $elem['option_name'])->first();

                // SI no existe la opción se crea inmediatamente
                if(!$option) {
                    try {

                        $validator = Validator::make($elem, $this->rules, $this->messages);

                        if ($validator->fails()) {

                            return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $validator->errors(), 'option' => $elem['option_name'] ], 400);

                        }

                        $option = Options::create($elem);

                    } catch(QueryException $e) {

                        $eCode = $e->errorInfo[1];
                        $eMessage = $e->errorInfo[2];

                        if($eCode == 1062){
                            return Response::json([ 'status' => 409, 'message' => $eMessage ], 409);
                        }

                        return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
                        
                    }
                }

                try {

                    //Actualizar la opcion
                    $option->update( $elem );

                } catch(QueryException $e) {

                    $eCode = $e->errorInfo[1];
                    $eMessage = $e->errorInfo[2];

                    return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
                    
                }

            }

            return Response::json(['status' => 200, 'message' => 'Recursos actualizados correctamente', 'option' => $option], 200);
        }

    }

}
