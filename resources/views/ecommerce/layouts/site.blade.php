<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="canonical" href="{{ Request::fullUrl() }}" >
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="country-active" content="{{ get_option('sitecountry') }}">
		<meta name="country-active-id" content="{{ get_option('sitecountry_id') }}">
		<meta name="user-id" content="@if (session('user')) {{ session('user')->id }} @else 0 @endif">
		<meta name="user-email" content="@if (session('user')) {{ session('user')->email }} @else 0 @endif">
		<link rel="icon" type="image/x-icon" href="{{ asset('img/common/favicon.ico') }}">
		@yield('meta')

		<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common-responsive.css') }}">
		<!--MATERIALIZE STYLES-->
		<link rel="stylesheet" href="{{ asset('libs/materialize/css/materialize.min.css') }}">
		<link rel="stylesheet" href="{{ asset('libs/icomoon/icomoon.css') }}">
		@yield('styles')

		<!--If has facebook pixel-->
		@if (get_option('facebook_pixel') !== 'NULL')
			{!! get_option('facebook_pixel') !!}

			<script type="text/javascript">
				@yield('fbPixel')
			</script>
		@endif

		<!--If has google analytics code-->
		@if (get_option('analytics_script') !== 'NULL')
			{!! get_option('analytics_script') !!}
		@endif

	</head>
	<body>

		@include('ecommerce.layouts.partials.top-bar')

		@include('ecommerce.layouts.partials.header')

		<div id="notification-modal" class="modal open">
			<div class="modal-content">
				<p id="resp-icon">
					<a class="check"><span class="icono icon-check1"></span></a>
				</p>
				<p id="resp-text">Se agregó correctamente el libro <b>Fracturas de hombro</b> a tu carrito de compras.</p>
				<p id="resp-desc">Este mensaje desaparecerá en unos segundos...</p>
				<p id="resp-buttons"><a href="/carrito" class="button primary">Ver carrito</a> <a class="modal-close button gray">Cerrar</a></p>
			</div>
		</div>

		<div class="main @yield('contentClass')">

			@php
				$complete = explode('\\', Route::getCurrentRoute()->getActionName());
				$controller = $complete[count($complete) - 1];
				$active_controller = explode('@', $controller)[0];
				$pages_not_banner = ["/", "iniciar-sesion", "registrarse", "buscar", "mi-cuenta"];

				$send_to_banner = ["show_searcher" => true, "exists_banner" => false];

				if (isset($banner)) {
					$send_to_banner["exists_banner"] = true;
				}

			@endphp

			@if (!in_array(Route::getCurrentRoute()->uri(), $pages_not_banner) && $active_controller !== 'AccountController' )
				<div class="content-container">
					@include('ecommerce.layouts.partials.banner', $send_to_banner)
				</div>
			@endif

			@yield('content')
		</div>

	@include('ecommerce.layouts.partials.footer')
	@include('ecommerce.layouts.partials.bottom-bar')

	<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('libs/materialize/js/materialize.min.js') }}"></script>
	<script src="{{ asset('js/ecommerce/common.js') }}"></script>
	<script src="{{ asset('js/geolocalization/redirection.js') }}"></script>

	@switch(get_option('sitecountry'))
	    @case('COLOMBIA')
	        <script src="{{ asset('js/geolocalization/colombia.js') }}"></script>
	        @break

	    @case('ARGENTINA')
	        <script src="{{ asset('js/geolocalization/argentina.js') }}"></script>
	        @break

	    @case('DOMINICAN REPUBLIC')
	        <script src="{{ asset('js/geolocalization/republica-dominicana.js') }}"></script>
	        @break

	    @case('PERU')
	        <script src="{{ asset('js/geolocalization/peru.js') }}"></script>
	        @break

	    @case('PANAMA')
	        <script src="{{ asset('js/geolocalization/panama.js') }}"></script>
	        @break

	    @case('MEXICO')
	        <script src="{{ asset('js/geolocalization/mexico.js') }}"></script>
	        @break

	    @default
	        <script src="{{ asset('js/geolocalization/casa-matriz.js') }}"></script>
	@endswitch

	<script src="{{ asset('js/ecommerce/responsive-menu.js') }}"></script>
	<script src="{{ asset('js/ecommerce/cart.js') }}"></script>
	<script src="{{ asset('js/common.js') }}"></script>

	<script src="{{ asset('libs/crypto-js/core.js') }}"></script>
	<script src="{{ asset('libs/crypto-js/hmac.js') }}"></script>
	<script src="{{ asset('libs/crypto-js/enc-base64.js') }}"></script>
	<script src="{{ asset('libs/crypto-js/sha256.js') }}"></script>
	<script src="{{ asset('js/ecommerce/jwt-token.js') }}"></script>
	@yield('scripts')
