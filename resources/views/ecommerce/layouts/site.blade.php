<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="canonical" href="{{ Request::fullUrl() }}" >
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" type="image/x-icon" href="{{ asset('img/common/favicon.ico') }}">
		@yield('meta')

		<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common.css') }}">
		<link rel="stylesheet" href="{{ asset('css/ecommerce/common-responsive.css') }}">
		<!--MATERIALIZE STYLES-->
		<link rel="stylesheet" href="{{ asset('libs/materialize/css/materialize.min.css') }}">
		<link rel="stylesheet" href="{{ asset('libs/icomoon/icomoon.css') }}">
		@yield('styles')

	</head>
	<body>

		@include('ecommerce.layouts.partials.top-bar')

		@include('ecommerce.layouts.partials.header')
		
		<div class="main @yield('contentClass')">

			@if (Route::getCurrentRoute()->uri() !== '/')
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
	<script src="{{ asset('js/ecommerce/responsive-menu.js') }}"></script>
	<script src="{{ asset('js/ecommerce/cart.js') }}"></script>
	<script src="{{ asset('js/common.js') }}"></script>
	@yield('scripts')