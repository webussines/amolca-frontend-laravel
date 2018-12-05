<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="icon" type="image/x-icon" href="{{ asset('img/common/favicon.ico') }}">

		<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
		<link rel="stylesheet" href="{{ asset('css/admin/common.css') }}">
		<!--MATERIALIZE STYLES-->
		<link rel="stylesheet" href="{{ asset('libs/materialize/css/materialize.min.css') }}">
		<link rel="stylesheet" href="{{ asset('libs/icomoon/icomoon.css') }}">
		@yield('styles')

	</head>
	<body>
		
		<div class="main @yield('contentClass')">
			@yield('content')
		</div>

		<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('libs/materialize/js/materialize.min.js') }}"></script>
		<script src="{{ asset('js/admin/auth.js') }}"></script>
		@yield('scripts')

	</body>
</html>