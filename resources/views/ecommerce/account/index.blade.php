@extends('ecommerce.layouts.site')

@section('title', "Mi cuenta $user->name - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container my-account')
@section('content')
<div class="section-title">
	<h2>{{ $user->name }}</h2>
</div>

<div class="content-container">

	Mi cuenta {{ $user->name }}

</div>
@endsection