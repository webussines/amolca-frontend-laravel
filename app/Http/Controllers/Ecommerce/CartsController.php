<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Response;
use Validator;

class CartsController extends Controller
{

    protected $request;
    protected $orders;

    public function __construct(Request $request, Orders $orders) {
        $this->request = $request;
        $this->orders = $orders;
    }

    public function store() {

        $add = $this->request->all();
        $update = true;

        $object_id = $add['object_id'];
        $quantity = $add['quantity'];
        $price = $add['price'];

        if(session('cart') === null) {

            $order = [];

            $order_session = '';

            if(session('user')) {
                $order_session = session('user')->id;
            } else {
                $order_session = date('Ymdi');
            }

            $order['user_id'] = $order_session;
            $order['country_id'] = 48;
            $order['state'] = 'CART';
            $order['products'] = [$add];

            $resp = $this->orders->create($order);

            return Response::json($resp);

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

            return Response::json(session('cart'));

            if($update) {
                array_push($cart->products, [ "object_id" => $object_id, "quantity" => $quantity, "price" => $price ]);
            }

            $this->request->session()->put('cart', json_decode(json_encode($cart)));

            return Response::json(session('cart'));
        }

    }

}