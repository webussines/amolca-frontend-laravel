@extends('ecommerce.layouts.site')

@section('fbPixel')
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
fbq('track', 'Search');
@endsection

@section('title', "Novedades de $specialty_title - Amolca Editorial Médica y Odontol&oacute;gica")

@section('contentClass', 'page-container news')
@section('content')
<div class="specialty-title">
	<h2>Novedades de {!! $specialty_title !!}</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.books.loop', ['books' => $posts, 'type' => 'loop', 'items_per_row' => 4])

</div>
@endsection