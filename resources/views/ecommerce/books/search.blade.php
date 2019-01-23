@extends('ecommerce.layouts.site')

@section('title', "Resultados de busqueda - Amolca Editorial M&eacute;dica y Odontol&oacute;gica")

@section('contentClass', 'page-container search-page')
@section('content')

<div class="header-page">
  Resultados de busqueda para: <b>{{Request::input('s')}}</b>
  @include('ecommerce.layouts.partials.big-searcher')
</div>

<div class="content-container">

	@if (count($posts) > 0)
		@include('ecommerce.loops.books.loop', ['books' => $posts, 'type' => 'loop', 'items_per_row' => 4, 'show_links' => 'no'])
	@else
		
		<div class="search-not-found">
			<p class="title">Lo sentimos pero no existe ningún libro relacionado con su busqueda.</p>

			<ul class="social-list">
				<li>
					<a class="button primary" href="/">Ir al Inicio</a>
				</li>
				<li>
					<a target="_blank" href="https://www.facebook.com/EdAmolca/" class="social">
						<i class="icon-facebook1"></i>
					</a>
				</li>
				<li>
					<a target="_blank" href="https://www.instagram.com/amolcacolombia/" class="social">
						<i class="icon-instagram1"></i>
					</a>
				</li>
				<li>
					<a target="_blank" href="https://twitter.com/EAmolca" class="social">
						<i class="icon-twitter1"></i>
					</a>
				</li>
			</ul>
		</div>

	@endif

</div>
@endsection