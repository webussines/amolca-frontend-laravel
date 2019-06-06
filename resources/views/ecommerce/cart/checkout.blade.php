@extends('ecommerce.layouts.site')

@php
	$nombre = ( session('user') ) ? session('user')->name : '';
	$apellido = ( session('user') ) ? session('user')->lastname : '';
	$correo = ( session('user') ) ? session('user')->email : '';
	$telefono = ( session('user') ) ? session('user')->phone : '';
	$celular = ( session('user') ) ? session('user')->mobile : '';
@endphp

@section('meta')
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
@endsection

@section('title', 'Finalizar compra - Amolca Editorial Médica y Odontológica')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/checkout.css') }}">
@endsection

<!--Add single books scripts-->
@section('scripts')
	@switch(get_option('sitecountry'))
	    @case('COLOMBIA')
	        <script src="{{ asset('js/payments/redirect.js') }}"></script>
			<script src="{{ asset('js/payments/tucompra/payment.js') }}"></script>
	        @break

	    @case('PANAMA')
		    <script src="https://www.paypal.com/sdk/js?client-id=AX1NFLhCijJRNeF0LSe3WxowryHscT4IuMcjLt6YbTxsAVeN67Vvaw36YkNG4nZryi747-DcJPGPCYt2"></script>
			<script src="{{ asset('js/payments/paypal/payment.js') }}"></script>
	    	@break

		@case('MEXICO')
		    <!--
			<script src="https://www.paypal.com/sdk/js?client-id=AQNT8HrWbdXL1Y6rVtC_UHYWuV1HvGgCVEwSL3zuQsNqxvRgCOZZkfbk0jKoPjJtR_t7pEzwYvs8U1L5"></script>
			<script src="{{ asset('js/payments/paypal/payment.js') }}"></script>
			-->
			<script src="{{ asset('js/payments/redirect.js') }}"></script>
			<script src="{{ asset('js/payments/payu/payment.js') }}"></script>
	    	@break

	    @case('DOMINICAN REPUBLIC')
	    	<script src="{{ asset('js/payments/redirect.js') }}"></script>
	    	<script src="{{ asset('js/payments/cardnet/payment.js') }}"></script>
	    	@break

	    @case('ARGENTINA')
		    <script src="{{ asset('js/payments/redirect.js') }}"></script>
	    	<script src="{{ asset('js/payments/mercadopago/payment.js') }}"></script>
	    	@break

	@endswitch
@endsection

@section('contentClass', 'page-container order')
@section('content')
<div class="content-container">

	<div class="row">

		<!--Form column-->
    	<div class="col s12 m8 l8">
    		<p class="title">Detalles de facturación y envío</p>

			<form id="checkoutform" class="checkoutform">
				<div class="row">

					<!--Name column-->
					<div class="col s12 m6 l6">
						<label for="name"><span class="required">*</span> Nombres:</label>
						<input type="text" name="name" class="required-field" id="name" placeholder="Escribe tu nombre..." value="{!! $nombre !!}">
						<p id="error-name" class="error"></p>
					</div>

					<!--Lastname column-->
					<div class="col s12 m6 l6">
						<label for="lastname"><span class="required">*</span> Apellidos:</label>
						<input type="text" name="lastname" class="required-field" id="lastname" placeholder="Escribe tus apellidos..." value="{!! $apellido !!}">
						<p id="error-lastname" class="error"></p>
					</div>

					<!--Mobile column-->
					<div class="col s12 m6 l6">
						<label for="mobile"><span class="required">*</span> Teléfono celular:</label>
						<input type="text" name="mobile" class="required-field" id="mobile" placeholder="Escribe tu número de celular..." value="{!! $celular !!}">
						<p id="error-mobile" class="error"></p>
					</div>

					<!--Phone column-->
					<div class="col s12 m6 l6">
						<label for="phone">Teléfono fijo:</label>
						<input type="text" name="phone" id="phone" placeholder="Escribe tu número de teléfono fijo..." value="{!! $telefono !!}">
					</div>

					<!--Email column-->
					<div class="col s12 m12 l12">
						<label for="email"><span class="required">*</span> Correo electrónico:</label>
						<input type="email" name="email" class="required-field" id="email" placeholder="Escribe tu correo electrónico..." value="{!! $correo !!}">
						<p id="error-email" class="error"></p>
					</div>

					<!--City column-->
					<div class="col s12 m6 l6">
						<label for="city"><span class="required">*</span> Ciudad:</label>
						<input type="text" name="city" class="required-field" id="city" placeholder="Escribe la ciudad de envío...">
						<p id="error-city" class="error"></p>
					</div>

					<!--Address column-->
					<div class="col s12 m6 l6">
						<label for="address"><span class="required">*</span> Dirección:</label>
						<input type="text" name="address" class="required-field" id="address" placeholder="Escribe tu dirección...">
						<p id="error-address" class="error"></p>
					</div>

					<!--Aditionals column-->
					<?php if( get_option('sitecountry') !== 'COLOMBIA' ) {
						$col_extra = 'm6 l6';
					} else {
						$col_extra = 'm12 l12';
					} ?>
					<div class="col s12 <?php echo $col_extra; ?>">
						<label for="extra_address">Extra (oficina, interior, etc):</label>
						<input type="text" name="extra_address" id="extra_address" placeholder="Extra (oficina, interior, etc)...">
					</div>

					@if( get_option('sitecountry') !== 'COLOMBIA' )
						<!--Postal code column-->
						<div class="col s12 m6 l6">
							<label for="postal_code"><span class="required">*</span> Código postal:</label>
							<input type="text" name="postal_code" class="required-field" id="postal_code" placeholder="Escribe tu código postal...">
							<p id="error-postal_code" class="error"></p>
						</div>
					@endif

					<!--Notes column-->
					<div class="col s12 m12 l12">
						<label for="aditionals">Notas sobre tu pedido:</label>
						<textarea class="materialize-textarea" name="aditionals" id="aditionals" placeholder="Si tienes notas adicionales sobre tu pedido escríbelas aquí..."></textarea>
					</div>

					<!--Terms and conditions column-->
					<div class="col s12 m12 l12 terms-condition">
						<label>
							<input type="checkbox" id="terms" />
							@if (get_option('sitecountry') == 'MEXICO')
								<span>He leído y acepto los <a href="https://amolca.webussines.com/uploads/archivos/terminos-y-condiciones-amolca-mx.pdf" target="_blank">Términos y condiciones y Políticas de privacidad</a></span>
							@else
								<span>He leído y acepto los <a href="/terminos-y-condiciones">Términos y condiciones y Políticas de privacidad</a></span>
							@endif
						</label>
					</div>

					<div class="col s12 m12 l12 global-error error">

					</div>

					<!--Button column-->
					<div class="col s12 m12 l12">
						<input type="hidden" id="country" name="country" value="{{ get_option('sitecountry') }}">
						<input type="hidden" id="total-amount" name="total-amount" value="{{ $cart->amount }}">

						@switch(get_option('sitecountry'))
							@case('COLOMBIA')
	                	        <input type="submit" class="button primary" value="¡Pagar ahora!">
	                	        @break

	                	    @case('PANAMA')
	                		    <div id="paypal-button-container"></div>
	                	    	@break

							@case('MEXICO')
								@include('ecommerce.layouts.forms.payu')
	                		    <input type="submit" class="button primary" value="¡Pagar ahora!">
	                	    	@break

	                	    @case('DOMINICAN REPUBLIC')
	                	    	<input type="submit" class="button primary" value="¡Pagar ahora!">
	                	    	@break

	                	    @case('ARGENTINA')
	                		    <input type="submit" class="button primary" value="¡Pagar ahora!">
	                	    	@break
	                	@endswitch
					</div>

				</div>
			</form>

    	</div>

		<!--Content table column-->
	    <div class="col s12 m4 l4 order">
	    	<p class="title">Tu pedido</p>

			<table class="striped highlight">
				<thead>
					<tr>
						<th class="product">Producto</th>
						<th class="qty">Cantidad</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cart->products as $product)
						<tr>
							<td class="product">{!! $product->title !!}</td>
							<td class="qty">{{ $product->quantity }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<table>
				<tr id="subtotal">
					<th>Subtotal:</th>
					@if ( isset($cart->subtotal) )
						<td>{{ COPMoney($cart->subtotal) }}</td>
					@else
						<td>{{ COPMoney($cart->amount) }}</td>
					@endif
				</tr>
				@if (get_option('sitecountry') == 'COLOMBIA')
					<tr id="shipping">
						<th>Envío:</th>
						<td>Envío gratuito a cualquier lugar de Colombia</td>
					</tr>
				@endif
				@if ( session('coupon') )
					@php
						$amount = '';

						switch (session('coupon')['discount_type']) {
							case 'FIXED':
								$amount = COPMoney(session('coupon')['discount_amount']);
								break;

							case 'PERCENTAGE':
								$amount = session('coupon')['discount_amount'] . '%';
								break;
						}
					@endphp

					<tr id="coupon">
						<th>Descuento:</th>
						<td><b>{{ $amount }}</b> - {{ session('coupon')['code'] }}</td>
					</tr>
				@endif
				<tr id="total">
					<th>Total:</th>
					<th id="price">{{ COPMoney($cart->amount) }}</th>
				</tr>
			</table>
	    </div>

	</div>
</div>
@endsection
