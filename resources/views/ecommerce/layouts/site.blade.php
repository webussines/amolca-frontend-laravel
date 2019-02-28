<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="canonical" href="{{ Request::fullUrl() }}" >
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="country-active" content="{{ get_option('sitecountry') }}">
		<meta name="user-id" content="@if (session('user')) {{ session('user')->id }} @else 0 @endif">
		<link rel="icon" type="image/x-icon" href="{{ asset('img/common/favicon.ico') }}">
		@yield('meta')

		<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common-responsive.css') }}">
		<!--MATERIALIZE STYLES-->
		<link rel="stylesheet" href="{{ asset('libs/materialize/css/materialize.min.css') }}">
		<link rel="stylesheet" href="{{ asset('libs/icomoon/icomoon.css') }}">
		@yield('styles')

		<!-- Facebook Pixel Code
		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window,document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '942229042628428'); 
			fbq('track', 'PageView');

			fbq('track', 'ViewContent');
			@yield('fbPixel')
		</script>
		<noscript>
			<img height="1" width="1" 
			src="https://www.facebook.com/tr?id=942229042628428&ev=PageView
			&noscript=1"/>
		</noscript>
		-->
		<!-- End Facebook Pixel Code -->

		<!-- Global site tag (gtag.js) - Google Analytics
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132350648-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-132350648-1');
		</script> -->

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
				$pages_not_banner = ["/", "iniciar-sesion", "buscar", "carrito", "finalizar-compra", "mi-cuenta"];
			@endphp

			@if (!in_array(Route::getCurrentRoute()->uri(), $pages_not_banner) && $active_controller !== 'AccountController')
				<div class="content-container">
					@include('ecommerce.layouts.partials.banner', ["show_searcher" => true])
				</div>
			@endif

			@yield('content')
		</div>

	@include('ecommerce.layouts.partials.footer')
	@include('ecommerce.layouts.partials.bottom-bar')

	<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('libs/materialize/js/materialize.min.js') }}"></script>
	<script src="{{ asset('js/ecommerce/common.js') }}"></script>
	
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
	@yield('scripts')