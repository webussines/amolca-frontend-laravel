@extends('ecommerce.layouts.site')

@section('fbPixel')
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
@endsection

@if (get_option('sitename') && get_option('sitename') !== 'NULL')
	@section('title', get_option('sitename'))
@else
	@section('title', 'Amolca Editorial Médica y Odontológica')
@endif

@section('scripts')
<script src="{{ asset('js/ecommerce/carousel-books.js') }}"></script>
<script src="{{ asset('js/ecommerce/carousel-authors.js') }}"></script>
<script src="{{ asset('js/ecommerce/carousel-posts.js') }}"></script>
<script src="{{ asset('js/ecommerce/slider.js') }}"></script>
<script src="{{ asset('libs/slickslider/js/slick.min.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/slickslider/css/slick.css') }}">
@endsection

@section('contentClass', 'home')
@section('content')

<div class="home-slider">
	@include('ecommerce.layouts.partials.big-slider', [ "items" => $slider ])
</div>

<div class="searcher-block">
	@include('ecommerce.layouts.partials.big-searcher')
</div>

<div class="content-block books-block">
	<div class="row">
		<div class="col s12 l6 col-left">
			<h2 class="title">
				<span>Novedades</span> Médicas
			</h2>

			@include('ecommerce.loops.books.loop', ['books' => $medician, 'type' => 'carousel'])

		</div>
		<div class="col s12 l6 col-right">
			<h2 class="title">
				<span>Novedades</span> odontológicas
			</h2>

			@include('ecommerce.loops.books.loop', ['books' => $odontologic, 'type' => 'carousel'])

		</div>
	</div>
</div>

<div class="content-block authors-block">
	<h2 class="title">
		Autores <span class="color-blue-light">destacados</span>
	</h2>

	<div class="common-container">
		@include('ecommerce.loops.authors.loop', ['authors' => $authors, 'type' => 'carousel', 'items_per_row' => 4])
	</div>

	<p class="btn-large-container">
		<a class="button primary" href="/autores">Ver todos los autores</a>
	</p>
</div>

<div class="content-block posts-block">
	<h2 class="title">
		Últimas publicaciones <span class="color-blue-light">de nuestro blog</span>
	</h2>

	<div class="common-container">
		@include('ecommerce.loops.posts.loop', ['posts' => $posts, 'type' => 'carousel', 'items_per_row' => 4])
	</div>

	<p class="btn-large-container">
		<a class="button primary" href="/blog">Ver todas las publicaciones</a>
	</p>
</div>

@endsection