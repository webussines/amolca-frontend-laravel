@extends('ecommerce.layouts.site')

@section('title', 'Mi carrito - Amolca Editorial Médica y Odontológica')

@section('contentClass', 'page-container not-found')
@section('content')
<div class="content-not-found">
	<p class="title">No hay productos en el carrito.</p>

	<ul class="social-list">
		<li>
			<a class="button primary" href="/">Ir al Inicio</a>
		</li>
		<li>
			<a target="_blank" href="https://www.facebook.com/EdAmolca/" class="social">
				<i class="icon-facebook1"></i>
			</a>
		</li>
		<li>
			<a target="_blank" href="https://www.instagram.com/amolcacolombia/" class="social">
				<i class="icon-instagram1"></i>
			</a>
		</li>
		<li>
			<a target="_blank" href="https://twitter.com/EAmolca" class="social">
				<i class="icon-twitter1"></i>
			</a>
		</li>
	</ul>
</div>
@endsection
