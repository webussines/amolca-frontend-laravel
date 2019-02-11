@extends('ecommerce.layouts.site')

@section('fbPixel')
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
@endsection

@section('title', 'Mi carrito - Amolca Editorial Médica y Odontológica')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/cart.css') }}">
<link rel="stylesheet" href="{{ asset('libs/slickslider/css/slick.css') }}">
@endsection

<!--Add single books scripts-->
@section('scripts')
<script src="{{ asset('js/ecommerce/coupons.js') }}"></script>
<script src="{{ asset('js/ecommerce/carousel-books.js') }}"></script>
<script src="{{ asset('libs/slickslider/js/slick.min.js') }}"></script>
@endsection

@section('contentClass', 'page-container')
@section('content')
<div class="content-container">

	<!--Products table-->
	<table class="cart striped centered highlight">
		<thead>
			<tr>
				<th id="image"></th>
				<th id="product">Producto</th>
				<th id="price">Precio</th>
				<th id="qty">Cantidad</th>
				<th id="total">Total</th>
				<th id="actions"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($cart->products as $product)
				<tr id="{{ $product->object_id }}">
					<td class="image">
						<img class="materialboxed" src="{{ $product->thumbnail }}">
					</td>
					<td class="name">
						{{ $product->title }}
					</td>
					<td class="price">
						{{ COPMoney($product->price) }}
					</td>
					<td class="qty">
						<input class="qty" value="{{ $product->quantity }}" mattooltip="Cantidad" type="number">
					</td>
					<td class="total">
						@if ( isset($product->discount) )
							<span class="normal-price">{{ COPMoney($product->discount) }}</span>
							<span class="without-discount">{{ COPMoney($product->quantity * $product->price) }}</span>
						@else
							<span class="normal-price">{{ COPMoney($product->quantity * $product->price) }}</span>
						@endif
					</td>
					<td class="actions">
						<input type="hidden" class="book-id" value="{{ $product->object_id }}">
						<input type="hidden" class="book-price" value="{{ $product->price }}">
						<button class="delete" mattooltip="Eliminar">
							<span class="icon-trash-o"></span>
						</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	<!--Coupons container-->
	<div class="coupon-contain">
      <input type="text" id="coupon" placeholder="Escribe aquí el código de tu cupón">
      <button class="button primary">Aplicar cupón</button>
      <p id="coupon-error" class="error"></p>
    </div>
	
	<!--Info cart-->
    <div class="info-cart">

		<div class="related-products">
			<p class="title">Libros relacionados</p>

			@php
				$related_options = [ 
					'type' => 'carousel',
					'items_per_page' => 8,
					'items_per_row' => 2,
					'books' => $related,
				];
			@endphp

			@include('ecommerce.loops.books.loop', $related_options)
		</div>
      
		<div class="cart-totals">
			<table>
				<tr id="subtotal">
					<th>Subtotal:</th>
					@if ( isset($cart->subtotal) )
						<td>{{ COPMoney($cart->subtotal) }}</td>
					@else
						<td>{{ COPMoney($cart->amount) }}</td>
					@endif
				</tr>
				<tr id="shipping">
					<th>Envío:</th>
					@if (get_option('sitecountry') == 'COLOMBIA')
						<td>Envío gratuito a cualquier lugar de Colombia</td>
					@endif
				</tr>
				@if ( isset($cart->subtotal) && session('coupon') )
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
				<tr id="actions">
					<td colspan="2">
						<a class="button primary" href="/finalizar-compra">Finalizar compra</a>
					</td>
				</tr>
			</table>
      </div>

    </div>

</div>
@endsection