@php
    $hash = md5("8xqzOaKIZ4RgPO3AAz9i7NzMpm~806927~" . session('cart')->id . "~" . session('cart')->amount . "~MXN");
@endphp

<input id="merchantId" name="merchantId" type="hidden"  value="806927"   >
<input id="accountId" name="accountId" type="hidden"  value="813981" >
<input id="tax" name="tax" type="hidden"  value="0"  >
<input id="taxReturnBase" name="taxReturnBase" type="hidden"  value="0" >
<input id="currency" name="currency" type="hidden"  value="MXN" >
<input id="signature" name="signature" type="hidden"  value="{{ $hash }}"  >
<input id="test" name="test" type="hidden"  value="0" >
