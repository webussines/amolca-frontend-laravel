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
					<img alt="{{ $book->title }}" title="{{ $book->title }}" class="materialboxed" src="{{ $book->thumbnail }}">
				</div>

				<!--Countries loop for scroll info interaction-->
				@foreach ($book->inventory as $inventory)
					@if (strtoupper($inventory->country_name) == "COLOMBIA" && $inventory->price > 0 && $inventory->state == "STOCK")
					<div class="scroll-info">
						<p class="price">{{ COPMoney($inventory->price) }}</p>
						<div class="add-to-cart">
							<input type="hidden" class="book-id" value="{{ $book->id }}">
							<input type="hidden" class="book-price" value="{{ $inventory->price }}">
							<input class="qty" placeholder="Cantidad..." type="number">
							<button class="add-btn button danger waves-effect waves-light">Añadir al carrito</button>
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
						<a href="/autor/{{ $author->slug }}"> {{ $author->title }} </a>
					</span>
				@endforeach

			</h3>

			@foreach ($book->inventory as $inventory)
				@if (strtoupper($inventory->country_name) == "COLOMBIA" && $inventory->price > 0 && $inventory->state == "STOCK")
					<p class="price">{{ COPMoney($inventory->price) }}</p>
				@endif
			@endforeach

			<p class="shipping">¡Envío gratis a cualquier ciudad de Colombia!</p>
			
			<!--Specialties icons-->
			<div class="cont-specialties">
				<div class="label">Especialidades:</div>
				<div class="items">
					@foreach ($book->taxonomies as $taxonomy)
						@if ($taxonomy->slug != 'medicina' && $taxonomy->slug != 'odontologia')
						<p>
							<img class="specialty-icon" src="{{ $taxonomy->icon_img }}" alt="{{ $taxonomy->title}} "> {{ $taxonomy->title }}
						</p>
						@endif
					@endforeach
				</div>
			</div>

			<div class="cont-versions">
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
				<p class="shared">
					<a href="https://wa.me/?text=¡Hola!, echale un vistazo a este libro: {{Request::fullUrl()}}" target="_blank">
						<img src="https://amolca.webussines.com/uploads/images/whatsapp-logo.png" alt="">
					</a>
					<a>Compartir</a>
				</p>
			</div>

			@foreach ($book->inventory as $inventory)
				@if (strtoupper($inventory->country_name) == "COLOMBIA" && $inventory->price > 0 && $inventory->state == "STOCK")
					<div class="add-to-cart">
						<input type="hidden" class="book-id" value="{{ $book->id }}">
						<input type="hidden" class="book-price" value="{{ $inventory->price }}">
						<input class="quantity" placeholder="Cantidad..." type="number" value="1">
						<button class="add-btn button danger waves-effect waves-light">Añadir al carrito</button>
					</div>
					<div class="error-cart error"></div>
				@endif
			@endforeach

			<ul class="collapsible">

				<!--Book description-->
				@if (isset($book->content) && $book->content !== "")
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Descripción
						</div>
						<div class="collapsible-body">
							{!! $book->content !!}
						</div>
					</li>
				@endif

				<!--Book datasheet-->
				@if (isset($book->datasheet))
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Ficha técnica
						</div>
						<div class="collapsible-body">

							<table class="table">
								<tbody>
								@foreach ($book->datasheet as $key => $val)
									<tr>
										<th>{{ $key }}:</th>
										<td>{{ $val }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>

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
				@if (isset($book->keypoints) && $book->keypoints !== "")
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Puntos clave
						</div>
						<div class="collapsible-body">
							{!! $book->keypoints !!}
						</div>
					</li>
				@endif

				@if (isset($book->author) && count($book->author) > 0)
					<li class="collapsible-item">
						<div class="collapsible-header">
							<span class="icon-plus"></span> Autor
						</div>
						<div class="collapsible-body">
							<!--Authors loop-->
							@foreach ($book->author as $author)
							<div class="row author-item">
								<!--Image-->
								<div class="col s12 m3 l3 image">
									<a href="/autor/{{$author->slug }}">
										<img src="{{ $author->thumbnail }}" />
									</a>
								</div>
								<!--Information-->
								<div class="col s12 m9 l9 info">
									<h3 class="name">{{ $author->title }}</h3>
									<p class="description">
										@if (isset($author->content))
											{!! substr($author->content, 0, 100) !!}
										@endif
									</p>
									<p>
										<a routerLink="/autor/{{ $author->slug }}" class="button primary">Ver libros de este autor</a>
									</p>
								</div>
							</div>
							@endforeach
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

			@include('ecommerce.loops.books.loop', $related_options)

		</div>
	</div>

</div>
@endsection