@extends('ecommerce.layouts.site')

@section('title', "Especialidades - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container author-index')
@section('content')

	@foreach ($specialties as $specialty)
	<div class="specialty-title">
		<h2>{{ $specialty->title }}</h2>
	</div>

	<div class="content-container">
		<div class="specialties-loop">

		@foreach ($specialty->childs as $child)
		<div class="item">

			@if ($child->icon_img !== null)
			<a href="/especialidad/{{ $child->slug }}">
				<img class="specialty-image" src="{{ $child->icon_img }}" alt="">
			</a>
			@else
			<a href="/especialidad/{{ $child->slug }}">
				<img class="specialty-image" src="https://amolca.webussines.com/uploads/images/no-image.jpg" alt="">
			</a>
			@endif

			<p class="title">
				<a href="/especialidad/{{ $child->slug }}">{{ $child->title }}</a>
			</p>
		</div>
		@endforeach

		</div>
	</div>

	@endforeach

@endsection