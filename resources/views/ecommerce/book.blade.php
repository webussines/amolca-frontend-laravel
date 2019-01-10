@extends('ecommerce.layouts.site')

@section('title', "$book->title - Amolca Editorial Médica y Odontológica")

<!--Add single books scripts-->
@section('scripts')
<script src="{{ asset('js/single-book.js') }}"></script>
<script src="{{ asset('js/ecommerce/carousel-books.js') }}"></script>
<script src="{{ asset('libs/slickslider/js/slick.min.js') }}"></script>
@endsection

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/single-book.css') }}">
<link rel="stylesheet" href="{{ asset('libs/slickslider/css/slick.css') }}">
@endsection

@section('contentClass', 'page-container book')
@section('content')

<div id="single-book" class="content-container">

	<div class="row">
		<div class="col s12 l5 image-book">
			<div id="image-container">
				<div class="material-placeholder">
					<img alt="{{ $book->title }}" title="{{ $book->title }}" class="materialboxed" src="{{ $book->image }}">
				</div>

				<!--Countries loop for scroll info interaction-->
				@foreach ($book->countries as $country)
					@if ($country->name == $active_country && $country->price > 0 && $country->state == "STOCK")
					<div class="scroll-info">
						<p class="price">@COPMoney($country->price)</p>
						<div class="add-to-cart">
							<input placeholder="Cantidad..." type="number">
							<a class="button danger waves-effect waves-light">Añadir al carrito</a>
						</div>
					</div>
					@endif
				@endforeach

			</div>
		</div>
		<div class="col s12 l7 summary-book">
			<h1 class="name">
				{{$book->title}}
			</h1>

			<h3 class="author">

				<!--Authors loop-->
				@foreach ($book->author as $author)
					<span>
						<a href="/autor/{{ $author->slug }}"> {{ $author->name }} </a>
					</span>
				@endforeach

			</h3>

			@foreach ($book->countries as $country)
				@if ($country->name == $active_country && $country->price > 0 && $country->state == "STOCK")
					<p class="price">@COPMoney($country->price)</p>
				@endif
			@endforeach

			<p class="shipping">¡Envío gratis a cualquier ciudad de Colombia!</p>
			<p class="versions">Disponible en:

				@foreach ($book->version as $version)
						
					<!--Paper version icon-->
					@if ($version == "PAPER")
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Papel" title="Papel">
							<span class="icon-book"></span>
						</a>
					@endif
					
					<!--Ebook version icon-->
					@if ($version == "EBOOK")
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Ebook" title="Ebook">
							<span class="icon-document-text"></span>
						</a>
					@endif

					<!--Video version icon-->
					@if ($version == "VIDEO")
						<a class="version-btn tooltipped" data-position="top" data-tooltip="Vídeo" title="Vídeo">
							<span class="icon-media-play"></span>
						</a>
					@endif

				@endforeach

			</p>

			@foreach ($book->countries as $country)
				@if ($country->name == $active_country && $country->price > 0 && $country->state == "STOCK")
					<div class="add-to-cart">
						<input placeholder="Cantidad..." type="number">
						<a class="button danger waves-effect waves-light">Añadir al carrito</a>
					</div>
				@endif
			@endforeach

			<ul class="collapsible">

				<!--Book description-->
				@if (isset($book->description) && $book->description !== "")
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Descripción
						</div>
						<div class="collapsible-body">
							{!! $book->description !!}
						</div>
					</li>
				@endif

				<!--Book index-->
				@if (isset($book->index) && $book->index !== "")
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Índice
						</div>
						<div class="collapsible-body">
							{!! $book->index !!}
						</div>
					</li>
				@endif
				
				<!--Book keypoints-->
				@if (isset($book->keyPoints) && $book->keyPoints !== "")
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Puntos clave
						</div>
						<div class="collapsible-body">
							{!! $book->keyPoints !!}
						</div>
					</li>
				@endif
			</ul>

		</div>
	</div>

</div>

<div class="related-products">
		
	<div class="section-title">Libros relacionados</div>

	<div class="content-container">
		<div class="books-loop items-per-page-4">

			@php
				$related_options = [ 
					'type' => 'carousel',
					'items_per_page' => 8,
					'items_per_row' => 4,
					'books' => $related,
				];
			@endphp

			@include('ecommerce.loops.books', $related_options)

		</div>
	</div>

</div>
@endsection