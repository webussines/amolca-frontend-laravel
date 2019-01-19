<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Response;
use Validator;

class CartsController extends Controller
{

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function store() {

        $add = $this->request->all();
        $update = true;

        $object_id = $add['object_id'];
        $quantity = $add['quantity'];
        $price = $add['price'];

        if(session('cart') === null) {
            //crear un carrito

        } else {

            $cart = session('cart');

            for ($i=0; $i < count($cart->products); $i++) { 
                $product = json_decode(json_encode($cart->products[$i]));

                if ($product->object_id == $object_id) {
                    $product->quantity = $product->quantity + $quantity;
                    $update = false;
                }

                $cart->products[$i] = $product;
            }

            if($update) {
                array_push($cart->products, [ "object_id" => $object_id, "quantity" => $quantity, "price" => $price ]);
            }

            $this->request->session()->put('cart', json_decode(json_encode($cart)));

            return Response::json($this->request->session()->get('cart'));
        }

    }

}