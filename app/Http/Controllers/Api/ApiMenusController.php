<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Menus;
use App\Http\Models\MenuItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Response;
use Validator;

class ApiMenusController extends Controller
{

	protected $menus;
	protected $items;
	protected $request;

    protected $messages = [
        'required' => 'El campo :attribute es obligatorio',
        'slug.unique' => 'Ya existe un recurso con el mismo slug',
    ];

    protected $menu_rules = [ 
    	'title' => 'required',
    	'slug' => 'required|string|unique:am_menus',
    	'items' => 'required' 
    ];

    protected $item_rules = [ 
    	'content' => 'required|string|',
    	'link' => 'required',
    	'order' => 'required'
    ];

	public function __construct(Menus $menus, MenuItems $items, Request $request) {
		$this->menus = $menus;
		$this->items = $items;
		$this->request = $request;
	}

	// Controller method for create menu
    public function store()
    {

        $all = $this->request->all('body')['body'];

        try {

            $validator = Validator::make($all, $this->menu_rules, $this->messages);

            if ($validator->fails()) {

                return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $validator->errors() ], 400);

            }

            $menu = Menus::create($all);

            // Recorrer todos los items
            for ($i=0; $i < count($all['items']); $i++) {

            	$item = $all['items'][$i];

            	$item_created = $this->store_item($item, $menu->id);

            	// return Response::json($item_created['item']);

            	//Si existen items hijos
            	if( isset( $item['childs'] )) {

            		for ($subi=0; $subi < count($item['childs']); $subi++) { 

            			// Crear el los hijos del item recien creado
            			$sub = $item['childs'][$subi];
            			$subitem_created = $this->store_item($sub, $menu->id, $item_created['item']->id);

            		}

            	}

            }

            return Response::json([ 'status' => 200, 'message' => 'Recurso creado correctamente' ], 200);

        } catch(QueryException $e) {

            $eCode = $e->errorInfo[1];
            $eMessage = $e->errorInfo[2];

            if($eCode == 1062){
                return Response::json([ 'status' => 409, 'message' => $eMessage ], 409);
            }

            return Response::json([ 'status' => $eCode, 'message' => $eMessage ], 500);
            
        }

    }

    /*
    * Controlador para guardar los items de un menú pasando como argmentos:
    * $element: @json que contiene el item a crear
    * $menu_id: @integer que contiene la ID del menú al que pertenece el item
    * $parent_id: @integer que contiene la ID del item padre - por defecto se tomará el 0 para los que no tienen padre
    */
    public function store_item($element, $menu_id, $parent_id = 0) {

    	$element['menu_id'] = $menu_id;
    	$element['parent_id'] = $parent_id;

    	try {

            $item_validator = Validator::make($element, $this->item_rules, $this->messages);

            if ($item_validator->fails()) {

                return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $item_validator->errors() ], 400);

            }

            $stored = MenuItems::create($element);

            return [ "status" => 200, "item" => $stored ];

        } catch(QueryException $e) {

            $eCode = $e->errorInfo[1];
            $eMessage = $e->errorInfo[2];

            if($eCode == 1062){
            	return [ 'status' => 409, 'message' => $eMessage ];
            }

            return [ 'status' => $eCode, 'message' => $eMessage ];
            
        }

    }

    /*
    * Controlador para guardar los items de un menú pasando como argmentos:
    * $element: @json que contiene el item a crear
    * $menu_id: @integer que contiene la ID del menú al que pertenece el item
    */
    public function update_item($element, $item_id) {

    	try {

    		$option = MenuItems::where('id', '=', $item_id)->first();

            $updated = $option->update($element);

            return [ "status" => 200, "item" => $updated ];

        } catch(QueryException $e) {

            $eCode = $e->errorInfo[1];
            $eMessage = $e->errorInfo[2];

            if($eCode == 1062){
            	return [ 'status' => 409, 'message' => $eMessage ];
            }

            return [ 'status' => $eCode, 'message' => $eMessage ];
            
        }

    }
    
	public function show($id) {
		$option = Menu::where('option_name', '=', $name)->first();

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

                $option = Menus::where('option_name', '=', $elem['option_name'])->first();

                // SI no existe la opción se crea inmediatamente
                if(!$option) {
                    try {

                        $validator = Validator::make($elem, $this->rules, $this->messages);

                        if ($validator->fails()) {

                            return Response::json([ 'status' => 400, 'error_type' => 'api', 'errors' => $validator->errors(), 'option' => $elem['option_name'] ], 400);

                        }

                        $option = Menu::create($elem);

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
