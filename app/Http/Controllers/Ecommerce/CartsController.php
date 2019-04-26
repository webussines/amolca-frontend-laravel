<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Orders;
use App\Repositories\Posts;
use App\Repositories\Banners;
use App\Repositories\Coupons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Response;
use Validator;

class CartsController extends Controller
{

    protected $request;
    protected $orders;
    protected $coupons;
    protected $posts;
    protected $banners;

    public function __construct(Request $request, Orders $orders, Coupons $coupons, Posts $posts, Banners $banners) {
        $this->request = $request;
        $this->orders = $orders;
        $this->coupons = $coupons;
        $this->posts = $posts;
        $this->banners = $banners;
    }

    public function get_orders($id) {

        $orders = $this->orders->findAllByUser($id);

        if($this->request->ajax()) {

            $resp['data'] = $orders;

            return $resp;

        }

        return Response::json($orders);
    }

    public function index()
    {

        $page_id = 1;
        $send = [];
        $banner = $this->banners->findByResource('page', $page_id);

        if( isset($banner->id) ) {
            $send['banner'] = $banner;
        }

        if (!session('cart')) {
            return view('ecommerce.cart.empty', $send);
        } else {

            $cart = session('cart');

            if(!isset(session('cart')->products)) {
                return view('ecommerce.cart.empty');
            }

            if(count(session('cart')->products) < 1) {
                return view('ecommerce.cart.empty');
            }

            $send = [ 'cart' => $cart ];

            //Related posts
            $related = $this->posts->all("book", "orderby=title&order=asc&limit=8&random=1")->posts;
            $send['related'] = $related;

            return view('ecommerce.cart.index', $send);

        }
    }

    public function store() {

        $add = $this->request->all();

        if(session('cart') === null || is_array(session('cart')) ) {

            $order = [];

            $order_session = '';

            if(session('user')) {
                $order_session = session('user')->id;
            } else {
                $order_session = date('Ymdi');
            }

            $this->request->session()->put('session_id', $order_session);

            $order['user_id'] = $order_session;
            $order['country_id'] = get_option('sitecountry_id');
            $order['state'] = 'CART';
            $order['products'] = [$add];

            $resp = $this->orders->create($order);

            // Decodificar la respuesta
            $json = json_encode(json_decode($resp));

            // Convertir la respuesta en un JSON
            $order = json_decode($json);

            $this->request->session()->put('cart', $order);

            $send = session('cart');

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

            $coupon_objects_affected = [];

            if( session('coupon') ) {

                switch ( session('coupon')['affected'] ) {
                    case 'PRODUCT':

                        for ($i = 0; $i < count( session('coupon')['objects'] ); $i++) {

                            $id = session('coupon')['objects'][$i]['id']; // Objeto afectado por el cupon

                            for ($o = 0; $o < count( $order->products ); $o++) {

                                // Si el producto y el objeto coinciden
                                if($order->products[$o]->object_id == $id) {

                                    //Si el cupon es de monto fijo
                                    if( session('coupon')['discount_type'] == 'FIXED' ) {
                                        $order->products[$o]->discount = ($order->products[$o]->price * $order->products[$o]->quantity) - session('coupon')['discount_amount'];
                                    }

                                    //Si el cupon es de monto fijo
                                    if( session('coupon')['discount_type'] == 'PERCENTAGE' ) {
                                        $total = $order->products[$o]->price * $order->products[$o]->quantity;
                                        $order->products[$o]->discount = ( $total * session('coupon')['discount_amount'] ) / 100;
                                    }

                                    array_push($coupon_objects_affected, $id);
                                }

                            }

                        }

                        break;

                    case 'USER':

                        for ($i = 0; $i < count( session('coupon')['objects'] ); $i++) {

                            $id = session('coupon')['objects'][$i]['id'];

                            // Si el id del usuario y el objeto coinciden
                            if(session('user')->id == $id) {
                                array_push($coupon_objects_affected, $id);
                            }

                        }

                        break;

                    default:
                        # code...
                        break;
                }

                if($order->amount < 0) {
                    $order->amount = 0;
                }

            }

            if(count($coupon_objects_affected) > 0) {

                switch (session('coupon')['discount_type']) {
                    case 'FIXED':
                            $order->subtotal = $order->amount;

                            switch (session('coupon')['affected']) {
                                case 'USER':
                                    $discount = ( $order->amount * session('coupon')['discount_amount'] ) / 100;
                                    $order->amount = $order->amount - $discount;
                                    break;

                                case 'PRODUCT':
                                    $products_amount = 0;

                                    for ($i = 0; $i < count( $order->products ); $i++) {
                                        if( isset($order->products[$i]->discount) ) {
                                            $products_amount += $order->products[$i]->discount;
                                        } else {
                                            $products_amount += $order->products[$i]->price * $order->products[$i]->quantity;
                                        }
                                    }

                                    $order->amount = $products_amount;
                                    break;
                            }
                        break;

                    case 'PERCENTAGE':
                            $order->subtotal = $order->amount;

                            switch (session('coupon')['affected']) {
                                case 'USER':
                                    $discount = ( $order->amount * session('coupon')['discount_amount'] ) / 100;
                                    $order->amount = $order->amount - $discount;
                                    break;

                                case 'PRODUCT':
                                    $products_amount = 0;

                                    for ($i = 0; $i < count( $order->products ); $i++) {
                                        if( isset($order->products[$i]->discount) ) {
                                            $products_amount += $order->products[$i]->discount;
                                        } else {
                                            $products_amount += $order->products[$i]->price * $order->products[$i]->quantity;
                                        }
                                    }

                                    $order->amount = $products_amount;
                                    break;
                            }

                        break;
                }

            } else {

                $normal_amount = 0;

                if(isset($order->products) && count($order->products) > 0) {
                    for ($i = 0; $i < count( $order->products ); $i++) {
                        $normal_amount += $order->products[$i]->price * $order->products[$i]->quantity;
                    }
                }

                $order->amount = $normal_amount;
                $this->request->session()->forget('coupon');

            }

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

        if( isset($order->address) ) {
            $this->request->session()->pull('cart');
        }

        return Response::json($order);

    }

    public function validate_coupon($code) {

        return Response::json($this->coupons->findByCode($code));

    }

    public function change_amount() {

        if(!(session('coupon'))) {

            $new_total = $this->request->get('total');
            $coupon = $this->request->get('coupon');

            session('cart')->subtotal = session('cart')->amount;
            session('cart')->amount = $new_total;

            $this->request->session()->put('coupon', $coupon);

            return Response::json(session('cart'));

        } else {

            return Response::json([ "status" => 209 ], 209 );

        }

    }

}
