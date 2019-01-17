@extends('ecommerce.layouts.site')

@section('title', 'Finalizar compra - Amolca Editorial Médica y Odontológica')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/checkout.css') }}">
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
						<input type="text" name="name" id="name" placeholder="Escribe tu nombre...">
					</div>

					<!--Lastname column-->
					<div class="col s12 m6 l6">
						<label for="lastname"><span class="required">*</span> Apellidos:</label>
						<input type="text" name="lastname" id="lastname" placeholder="Escribe tus apellidos...">
					</div>

					<!--Mobile column-->
					<div class="col s12 m6 l6">
						<label for="mobile"><span class="required">*</span> Teléfono celular:</label>
						<input type="text" name="mobile" id="mobile" placeholder="Escribe tu número de celular...">
					</div>

					<!--Phone column-->
					<div class="col s12 m6 l6">
						<label for="phone">Teléfono fijo:</label>
						<input type="text" name="phone" id="phone" placeholder="Escribe tu número de teléfono fijo...">
					</div>

					<!--Email column-->
					<div class="col s12 m12 l12">
						<label for="email"><span class="required">*</span> Correo electrónico:</label>
						<input type="email" name="email" id="email" placeholder="Escribe tu correo electrónico...">
					</div>

					<!--City column-->
					<div class="col s12 m6 l6">
						<label for="city"><span class="required">*</span> Ciudad:</label>
						<input type="text" name="city" id="city" placeholder="Escribe la ciudad de envío...">
					</div>

					<!--Address column-->
					<div class="col s12 m6 l6">
						<label for="address"><span class="required">*</span> Dirección:</label>
						<input type="text" name="address" id="address" placeholder="Escribe tu dirección...">
					</div>

					<!--Aditionals column-->
					<div class="col s12 m6 l6">
						<label for="aditionals">Extra (oficina, interior, etc):</label>
						<input type="text" name="aditionals" id="aditionals" placeholder="Extra (oficina, interior, etc)...">
					</div>

					<!--Postal code column-->
					<div class="col s12 m6 l6">
						<label for="postalCode">Código postal:</label>
						<input type="text" name="postalCode" id="postalCode" placeholder="Escribe tu código postal...">
					</div>

					<!--Notes column-->
					<div class="col s12 m12 l12">
						<label for="aditionals">Notas sobre tu pedido:</label>
						<textarea class="materialize-textarea" name="aditionals" id="aditionals" placeholder="Si tienes notas adicionales sobre tu pedido escríbelas aquí..."></textarea>
					</div>

					<!--Terms and conditions column-->
					<div class="col s12 m12 l12 terms-condition">
						<label>
							<input type="checkbox" />
							<span>He leído y acepto los <a href="/terminos-y-condiciones">Términos y condiciones y Políticas de privacidad</a></span>
						</label>
					</div>

					<!--Button column-->
					<div class="col s12 m12 l12">
						<input type="hidden" id="country" name="country" value="{{ env('APP_COUNTRY') }}">
						<input type="submit" class="button primary" value="¡Pagar ahora!">
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
							<td class="product">{{$product->title}}</td>
							<td class="qty">{{$product->quantity}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<table>
				<tr id="subtotal">
					<th>Subtotal:</th>
					<td>{{ COPMoney($cart->amount) }}</td>
				</tr>
				<tr id="shipping">
					<th>Envío:</th>
					@if (env('APP_COUNTRY') == 'COLOMBIA')
						<td>Envío gratuito a cualquier lugar de Colombia</td>
					@endif
				</tr>
				<tr id="total">
					<th>Total:</th>
					<th id="price">{{ COPMoney($cart->amount) }}</th>
				</tr>
			</table>
	    </div>

	</div>
</div>
@endsection