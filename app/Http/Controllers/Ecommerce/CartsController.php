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

    public function get_orders($id) {

        $orders = $this->orders->findAllByUser($id);

        if($this->request->ajax()) {

            $resp['data'] = $orders;

            return $resp;

        }

        return Response::json($orders);
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

            if(isset($cart->products)) {
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
            } else {
                $cart->products = [];
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

            if($add['action'] != 'delete') {
                $send = session('cart');
                if($this->request->ajax()) {
                    $send->amountstring = COPMoney($order->amount);

                    for ($sp = 0; $sp < count($order->products); $sp++) { 
                        $order->products[$sp]->pricestring = COPMoney($order->products[$sp]->price);
                        $order->products[$sp]->totalstring = COPMoney($order->products[$sp]->price * $order->products[$sp]->quantity);
                    }

                    return Response::json($order);
                }
            }

            return Response::json($order);
        }

    }

    public function create_order() {

        $cart = session('cart');

        $cc = mailer_get_cc();
        $me = mailer_get_me();
        array_push($cc, $me);

        $address = $this->request->all();
        $mailer['name'] = mailer_get_name();
        $mailer['from'] = mailer_get_me();
        $mailer['cc'] = $cc;
        //$mailer['cc'] = 'mstiven013@gmail.com';
        $mailer['domain'] = mailer_get_domain();

        $send = [
            "address" => $address,
            "mailer" => $mailer
        ];

        $resp = $this->orders->createPending($cart->id, $send);

        $json = json_encode(json_decode($resp));
        $order = json_decode($json);
        
        if($order->address) {
            $this->request->session()->pull('cart');
        }

        return Response::json($order);

    }

}