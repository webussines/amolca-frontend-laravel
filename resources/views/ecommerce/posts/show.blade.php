@extends('ecommerce.layouts.site')

@section('title', "$post->title - Amolca Editorial Médica y Odontológica")

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/single-post.css') }}">
@endsection

@section('contentClass', 'page-container post')
@section('content')
<div class="content-container">
	<div class="row">

		<div class="col s12 m9 l9 post-column">
			<h2 class="title">{{ $post->title }}</h2>

			<div class="post-meta">
				@php $date = new Date($post->created_at); @endphp
				Publicado: {{ $date->format('j F, Y') }}
			</div>

			
			@if ($post->thumbnail !== null)
				<div class="post-thumbnail">
					<img src="{{ $post->thumbnail }}" title="{{ $post->title }}" alt="{{ $post->title }}">
				</div>
			@endif

			<div class="post-content">
				{!! $post->content !!}
			</div>
		</div>

		<div class="col s12 m3 l3">
			Posts relacionado
		</div>

	</div>
</div>
@endsection