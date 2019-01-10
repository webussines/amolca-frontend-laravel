@extends('ecommerce.layouts.site')

@section('title', 'Amolca Editorial Médica y Odontológica')

@section('scripts')
<script src="{{ asset('js/ecommerce/carousel-books.js') }}"></script>
<script src="{{ asset('js/ecommerce/carousel-authors.js') }}"></script>
<script src="{{ asset('libs/slickslider/js/slick.min.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/slickslider/css/slick.css') }}">
@endsection

@section('contentClass', 'home')
@section('content')

<div class="searcher-block">
	@include('ecommerce.layouts.partials.big-searcher')
</div>

<div class="content-block books-block">
	<div class="row">
		<div class="col s12 l6 col-left">
			<h2 class="title">
				<span>Novedades</span> Médicas
			</h2>

			@include('ecommerce.loops.books', ['books' => $medician, 'type' => 'carousel'])

		</div>
		<div class="col s12 l6 col-right">
			<h2 class="title">
				<span>Novedades</span> odontológicas
			</h2>

			@include('ecommerce.loops.books', ['books' => $odontologic, 'type' => 'carousel'])

		</div>
	</div>
</div>

<div class="content-block authors-block">
	<h2 class="title">
		Autores <span class="color-blue-light">destacados</span>
	</h2>

	<div class="common-container">
		@include('ecommerce.loops.authors', ['books' => $authors, 'type' => 'carousel', 'items_per_row' => 4])
	</div>
</div>

@endsection