@php
    $merchant_id = 806927;
    $account_id = 813981;
    $api_key = '8xqzOaKIZ4RgPO3AAz9i7NzMpm';

    /*
    $merchant_id = 508029; // Test
    $account_id = 512321; // Test
    $api_key = '4Vj8eK4rloUd272L48hsrarnUA'; // Test
    */

    $hash = md5($api_key . "~" . $merchant_id . "~" . session('cart')->id . "~" . session('cart')->amount . "~MXN");
@endphp

<input id="merchantId" name="merchantId" type="hidden"  value="{{$merchant_id}}"   >
<input id="accountId" name="accountId" type="hidden"  value="{{$account_id}}" >
<input id="tax" name="tax" type="hidden"  value="0"  >
<input id="taxReturnBase" name="taxReturnBase" type="hidden"  value="0" >
<input id="currency" name="currency" type="hidden"  value="MXN" >
<input id="signature" name="signature" type="hidden"  value="{{ $hash }}"  >
<input id="test" name="test" type="hidden"  value="0" >
