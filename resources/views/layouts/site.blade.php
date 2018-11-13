<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<!--MATERIALIZE STYLES-->
	@yield('styles')

</head>
<body>

	@include('layouts.partials.top-bar')

	@include('layouts.partials.header')
	
	@yield('content')