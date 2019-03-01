@extends('ecommerce.layouts.site')

@section('fbPixel')
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
fbq('track', 'Lead');
@endsection

@section('title', "$author->title - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container author')
@section('content')
<div class="content-container">
	<div class="row">
		<!--Image column-->
		<div class="col s12 m3 l3 image">
			<div class="image-container">
				@php
					$thumbnails = [
						'http://amolca.webussines.com/uploads/authors/odontologia-hombre.png',
	                    'http://amolca.webussines.com/uploads/authors/odontologia-mujer.png',
	                    'http://amolca.webussines.com/uploads/authors/medicina-hombre.png',
	                    'http://amolca.webussines.com/uploads/authors/medicina-mujer.png'
					];

					$styles = '';

					if ( in_array($author->thumbnail, $thumbnails) ) {
						$styles = 'width: 100%; height: auto;';
					} else {
						$styles = 'max-height: 150%; max-width: 150%;';
					}
				@endphp
				
				<img src="{{$author->thumbnail}}" title="{!! $author->title !!}" alt="{!! $author->title !!}" style="{!! $styles !!}">
			</div>
		</div>
		<!--Information column-->
		<div class="col s12 m9 l9 information">
			<h2 class="name">{!! $author->title !!}</h2>
			<div class="description">{!! $author->content !!}</div>
		</div>
	</div>

	<div class="common-separator"></div>

	<div class="author-books">
		<p class="subtitle">Libros de <b>{!! $author->title !!}</b></p>

		@php
			$books_options = [ 
				'type' => 'loop',
				'items_per_page' => 12,
				'items_per_row' => 4,
				'books' => $books,
			];
		@endphp

		@include('ecommerce.loops.books.loop', $books_options)
	</div>
</div>
@endsection