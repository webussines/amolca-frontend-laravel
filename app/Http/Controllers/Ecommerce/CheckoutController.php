<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CheckoutController extends Controller
{

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function checkout() 
    {

        if (!session('cart')) {
            return view('ecommerce.cart.empty');
        } else {

            $cart = session('cart');
            return view('ecommerce.cart.checkout', [ 'cart' => $cart ]);

        }
    }

    public function PaymentResponse(Request $req) {

        $response = [];

        switch ( get_option('sitecountry') ) {
            case 'COLOMBIA':
                # code...
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
        }

        return redirect('/checkout/respuesta')->with( 'response', $response );

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
}
