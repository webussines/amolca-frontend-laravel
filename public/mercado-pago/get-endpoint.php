<?php

    require __DIR__  . '/vendor/autoload.php';

    $user = $_POST['user'];
    $order = $_POST['order'];

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
        "success" => $_POST['url_return'],
        "failure" => $_POST['url_return'],
        "pending" => $_POST['url_return']
    );
    $preference->auto_return = "approved";

    # Save and posting preference
    $preference->save();

    echo $preference->init_point;

?>
