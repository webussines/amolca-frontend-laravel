<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Banners;
use App\Repositories\VisaNet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use MercadoPago;
use Response;

class CheckoutController extends Controller
{

    protected $request;
    protected $banners;
    protected $visanet;

    public function __construct(Request $request, Banners $banners, VisaNet $visanet) {
        $this->request = $request;
        $this->banners = $banners;
        $this->visanet = $visanet;
    }

    public function checkout()
    {

        $page_id = 2;
        $send = [];
        $banner = $this->banners->findByResource('page', $page_id);

        if( isset($banner->id) ) {
            $send['banner'] = $banner;
        }

        if (!session('cart')) {
            return view('ecommerce.cart.empty', $send);
        } else {

            $cart = session('cart');
            $send['cart'] = $cart;

            return view('ecommerce.cart.checkout', $send);

        }
    }

    public function PaymentResponse(Request $req) {

        $response = [];

        switch ( get_option('sitecountry') ) {
            case 'COLOMBIA':
                    return Response::json(['status' => 200, 'message' => 'info received successfully'], 200);
                break;

            case 'MEXICO':
                    return Response::json(['status' => 200, 'message' => 'info received successfully'], 200);
                break;

            case 'DOMINICAN REPUBLIC':

                    $response['exists'] = false;
                    $response['credit_card'] = $this->request->get('CreditCardNumber');
                    $response['response_code'] = $this->request->get('ResponseCode');
                    $response['authorization_code'] = $this->request->get('AuthorizationCode');
                    $response['retrieval_reference'] = $this->request->get('RetrievalReferenceNumber');
                    $response['orden_id'] = $this->request->get('OrdenID');
                    $response['transaction_id'] = $this->request->get('TransactionId');

                    switch ($response['response_code']) {
                        case '00':
                            $response['response_text'] = 'Aprobada';
                            break;
                        case '03':
                            $response['response_text'] = 'Comercio Invalido';
                            break;
                        case '04':
                            $response['response_text'] = 'Rechazada';
                            break;
                        case '05':
                            $response['response_text'] = 'Rechazada';
                            break;
                        case '07':
                            $response['response_text'] = 'Tarjeta Rechazada';
                            break;
                        case '12':
                            $response['response_text'] = 'Transaccion Invalida';
                            break;
                        case '13':
                            $response['response_text'] = 'Monto Invalido';
                            break;
                        case '14':
                            $response['response_text'] = 'Cuenta Invalida';
                            break;
                        case '00':
                            $response['response_text'] = 'Aprobada';
                            break;
                    }

                break;

            case 'PERU':

                $visa = $this->VisanetTransactionAuth($this->request->get('channel'), $this->request->get('transactionToken'));
                if( isset($visa['error_code']) ) {
                    return view('ecommerce.payment-responses.visanet-error', ['response' => $visa]);
                } else if( isset($visa['transaction_date'] ) ) {
                    return view('ecommerce.payment-responses.visanet-success', ['response' => $visa]);
                } else {
                    echo 'Final<br/>';
                    return $visa;
                }

                break;
        }

        return redirect('/checkout/respuesta')->with( 'response', $response );

    }

    public function VisanetTransactionAuth($channel, $transaction_token) {
        $token_seguridad = session('visanet_tokenSeguridad');
        $merchant_id = session('visanet_merchantId');

        $transaction_req = [
            "merchantId" => $token_seguridad,
            "tokenSeguridad" => $merchant_id,
            "antifraud" => null,
            "captureType" => "manual",
            "channel" => $channel,
            "countable" => true,
            "order" => [
                "tokenId" => $transaction_token,
                "amount" => session('visanet_order_amount'),
                "purchaseNumber" => session('visanet_order_id'),
                "currency" => "PEN"
            ]
        ];

        $request_visa = $this->visanet->transaction($token_seguridad, $merchant_id, $transaction_req);
        if(gettype($request_visa) === 'string') {
            $req_json = json_decode($request_visa, true);
        }

        if(isset($req_json['errorCode'])) {

            $response = [
                "error_code" => $req_json['errorCode'],
                "error_message" => $req_json['errorMessage'],
                "order_amount" => session('visanet_order_amount'),
                "orden_id" => session('visanet_order_id'),
            ];

        } else if(isset($req_json['dataMap'])) {

            $response = $this->VisaNetResponseData($req_json);

        } else {

            // return redirect('/');
            $response = 'Holi';
        }

        return $response;
    }

    public function VisaNetResponseData($data) {

        $response = [];
        $response['credit_card'] = $data['dataMap']['CARD'];
        $response['action_code'] = $data['dataMap']['ACTION_CODE'];
        $response['response_code'] = $data['dataMap']['ECI'];
        $response['response_text'] = $data['dataMap']['ACTION_DESCRIPTION'];
        $response['authorization_code'] = $data['dataMap']['AUTHORIZATION_CODE'];
        $response['orden_id'] = $data['order']['purchaseNumber'];
        $response['transaction_id'] = $data['dataMap']['TRANSACTION_ID'];
        $response['transaction_date'] = $data['dataMap']['TRANSACTION_DATE'];

        return $response;

    }

    public function PaymentResponseView() {

        $response = session('response');

        $view = '';

        switch (get_option('sitecountry')) {

            case 'DOMINICAN REPUBLIC':
                $view = 'ecommerce.payment-responses.cardnet';
                break;

        }

        return view($view, [ 'response' => $response]);

    }

    public function mercadopago() {

        $order = $this->request->get('order');
        $user = $this->request->get('user');

        //MercadoPago\SDK::setAccessToken("TEST-8376813153840242-022212-5906e9f433a17e2d3b8758c5c9a7ce08-337985950");
        MercadoPago\SDK::setAccessToken("APP_USR-8376813153840242-022212-15e34f6af4fadfe03513c87eb1eae978-337985950");

        $body = array(
            "json_data" => array(
                "site_id" => "MLA"
            )
        );

        $result = MercadoPago\SDK::post('/users/test_user', $body);

        # Create a preference object
        $preference = new MercadoPago\Preference();

        # Create an item object

        $all_items = [];
        for ($i = 0; $i < count($order['products']); $i++) {
            $item = new MercadoPago\Item();
            $item->id = $order['products'][$i]['object_id'];
            $item->title = $order['products'][$i]['title'];
            $item->quantity = $order['products'][$i]['quantity'];
            $item->currency_id = "ARS";
            $item->unit_price = $order['products'][$i]['price'];

            array_push($all_items, $item);
        }

        # Create a payer object
        $payer = new MercadoPago\Payer();
        $payer->name = $user['name'];
        $payer->surname = $user['lastname'];
        $payer->email = $user['email'];
        $payer->address = [
            "street_name" => $user['address'],
        ];
        $payer->zip_code = $user['postal_code'];

        # Setting preference properties
        $preference->items = $all_items;
        $preference->payer = $payer;
        $preference->back_urls = array(
            "success" => $this->request->get('url_return'),
            "failure" => $this->request->get('url_return'),
            "pending" => $this->request->get('url_return')
        );
        $preference->auto_return = "approved";

        # Save and posting preference
        $preference->save();

        return $preference->init_point;
    }
}
