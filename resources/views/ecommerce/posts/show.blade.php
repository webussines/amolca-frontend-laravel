@extends('ecommerce.layouts.site')

@section('title', "$post->title - Amolca Editorial Médica y Odontológica")

<!--Add aditional posts meta tags-->
@section('meta')
<!-- You can use Open Graph tags to customize link previews.-->
<meta property="og:url"           content="{{ Request::fullUrl() }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="$post->title - Amolca Editorial Médica y Odontológica" />
<meta property="og:description"   content="@if (isset($post->excerpt)) {!! substr($post->excerpt, 0, 100) !!} @else {!! substr($post->content, 0, 100) !!} @endif" />
<meta property="og:image"         content="{{ $post->thumbnail }}" />
@endsection

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/single-post.css') }}">
@endsection

@section('contentClass', 'page-container post')
@section('content')
<div class="content-container">
	<div class="row">

		<div class="col s12 m12 l9 post-column">
			<h2 class="title">{!! $post->title !!}</h2>

			<div class="post-meta">
				<div class="date">
					@php $date = new Date($post->created_at); @endphp
					<b>Publicado:</b> {{ $date->format('j F, Y') }}.
				</div>
				<div class="social-buttons">
					Compartir:
					<a class="social-share facebook tooltipped" 
						href="http://www.facebook.com/sharer.php?u={{ Request::fullUrl() }}"
						data-position="top" data-tooltip="Compartir en Facebook" title="Compartir en Facebook"
					>
			            <span class="icon-facebook"></span> Facebook
			        </a>
			        <a class="social-share twitter tooltipped" 
						href="https://twitter.com/share?url={{Request::fullUrl() }}"
						data-position="top" data-tooltip="Compartir en Twitter" title="Compartir en Twitter"
					>
			            <span class="icon-twitter"></span> Twitter
			        </a>
			        <a class="social-share whatsapp" href="https://wa.me/?text=¡Hola!, echale un vistazo a esta publicación: {{Request::fullUrl()}}" target="_blank">
						<span class="icon-whatsapp"></span> Whatsapp
					</a>
				</div>
			</div>

			
			@if ($post->thumbnail !== null)
				<div class="post-thumbnail">
					<img src="{{ $post->thumbnail }}" title="{!! $post->title !!}" alt="{!! $post->title !!}">
				</div>
			@endif

			<div class="post-content">
				{!! $post->content !!}
			</div>

			<div class="bottom-share">
				Compartir con tus amigos:
				<a class="social-share facebook tooltipped" 
					href="http://www.facebook.com/sharer.php?u={{ Request::fullUrl() }}"
					data-position="top" data-tooltip="Compartir en Facebook" title="Compartir en Facebook"
				>
		            <span class="icon-facebook"></span> Facebook
		        </a>
		        <a class="social-share twitter tooltipped" 
					href="https://twitter.com/share?url={{Request::fullUrl() }}"
					data-position="top" data-tooltip="Compartir en Twitter" title="Compartir en Twitter"
				>
		            <span class="icon-twitter"></span> Twitter
		        </a>
		        <a class="social-share whatsapp" href="https://wa.me/?text=¡Hola!, echale un vistazo a esta publicación: {{Request::fullUrl()}}" target="_blank">
					<span class="icon-whatsapp"></span> Whatsapp
				</a>
			</div>
		</div>

		<div class="col s12 m12 l3 related-column">
			<p class="subtitle">Otras publicaciones</p>
			<div class="related-posts-loop">
				@foreach ($related as $rel)
					<div class="post-related">
						<div class="related-thumbnail">
							<img src="{{ $rel->thumbnail }}" alt="{!! $rel->title !!}">
						</div>
						<p class="related-title">
							<a href="{{ $rel->slug }}">{!! $rel->title !!}</a>
						</p>
						<div class="related-excerpt">
							@if (isset($rel->excerpt))
								{!! substr($rel->excerpt, 0, 100) !!}...
							@else
								{!! substr($rel->content, 0, 100) !!}
							@endif
						</div>
						<p><a class="button primary" href="{{ $rel->slug }}">Leer más</a></p>
					</div>
				@endforeach
			</div>
		</div>

	</div>
</div>
@endsection