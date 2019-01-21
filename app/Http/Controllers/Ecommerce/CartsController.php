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

        if(session('cart') === null) {

            $order = [];

            $order_session = '';

            if(session('user')) {
                $order_session = session('user')->id;
            } else {
                $order_session = date('Ymdi');
            }

            $this->request->session()->put('session_id', $order_session);

            $order['user_id'] = $order_session;
            $order['country_id'] = 48;
            $order['state'] = 'CART';
            $order['products'] = [$add];

            $resp = $this->orders->create($order);

            // Decodificar la respuesta
            $json = json_encode(json_decode($resp));

            // Convertir la respuesta en un JSON
            $order = json_decode($json);

            $this->request->session()->put('cart', $order);

            $send = session('cart');
            if($this->request->ajax()) {
                $send->amountstring = COPMoney($send->amount);
                return Response::json($send);
            }

            return Response::json($send);

        } else {

            $cart = session('cart');

            $update = true;

            $action = $add['action'];
            $object_id = $add['object_id'];
            $quantity = $add['quantity'];
            $price = $add['price'];

            for ($i = 0; $i < count($cart->products); $i++) { 
                $product = json_decode(json_encode($cart->products[$i]));

                if ($product->object_id == $object_id) {

                    switch ($action) {
                        case 'update':
                            $product->quantity = $quantity;
                            break;

                        case 'delete':
                            unset($cart->products[$i]);
                            $cart->products = array_values($cart->products);
                            break;
                        
                        default:
                            $product->quantity = $product->quantity + $quantity;
                            break;
                    }

                    $update = false;
                }

                if($action !== 'delete') {
                    $cart->products[$i] = $product;
                }
            }

            if($update) {
                array_push($cart->products, [ "object_id" => $object_id, "quantity" => $quantity, "price" => $price ]);
            }

            $resp = $this->orders->updateById($cart->id, $cart);

            // Decodificar la respuesta
            $json = json_encode(json_decode($resp));

            // Convertir la respuesta en un JSON
            $order = json_decode($json);

            $this->request->session()->put('cart', $order);

            $send = session('cart');
            if($this->request->ajax()) {
                $send->amountstring = COPMoney($send->amount);

                for ($sp = 0; $sp < count($send->products); $sp++) { 
                    $send->products[$sp]->pricestring = COPMoney($send->products[$sp]->price);
                    $send->products[$sp]->totalstring = COPMoney($send->products[$sp]->price * $send->products[$sp]->quantity);
                }

                return Response::json($send);
            }

            return Response::json($send);
        }

    }

    public function create_order() {

        $cart = session('cart');

        $address = $this->request->all();

        $resp = $this->orders->createPending($cart->id, $address);

        $json = json_encode(json_decode($resp));
        $order = json_decode($json);
        
        if($order->address) {
            $this->request->session()->pull('cart');
        }

        return Response::json($order);

    }

}