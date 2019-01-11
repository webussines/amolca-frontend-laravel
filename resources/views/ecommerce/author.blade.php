@extends('ecommerce.layouts.site')

@section('title', "$author->name - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container author')
@section('content')
<div class="content-container">
	<div class="row">
		<!--Image column-->
		<div class="col s12 m3 l3 image">
			<div class="image-container">
				<img src="{{$author->image}}" />
			</div>
		</div>
		<!--Information column-->
		<div class="col s12 m9 l9 information">
			<h2 class="name">{{$author->name}}</h2>
			<div class="description">{!! $author->description !!}</div>
		</div>
	</div>

	<div class="common-separator"></div>

	<div class="author-books">
		<p class="subtitle">Libros de <b>{{$author->name}}</b></p>

		@php
			$books_options = [ 
				'type' => 'loop',
				'items_per_page' => 12,
				'items_per_row' => 4,
				'books' => $books,
			];
		@endphp

		@include('ecommerce.loops.books', $books_options)
	</div>
</div>
@endsection