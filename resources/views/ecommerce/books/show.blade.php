@extends('ecommerce.layouts.site')

@php
	$showaddtocart = true;
	$showprices = true;
	$showtarget = false;
	$target_class = '';
	$target_text = '';

	if($book->state == 'SPENT' || $book->state == 'RESERVED' || $book->state == 'RELEASE') {
		$showtarget = true;
	}

	switch ($book->state) {
		case 'SPENT':
			$target_class = 'spent';
			$target_text = 'Agotado';
			break;
		
		case 'RESERVED':
			$target_class = 'reserved';
			$target_text = 'Reservado';
			break;

		case 'RELEASE':
			$target_class = 'release';
			$target_text = 'Novedad';
			break;
	}

	if (get_option('shop_catalog_mode') == 'SI') {
		$showaddtocart = false;
	}

	if (get_option('shop_show_prices') == 'NO') {
		$showprices = false;
	}

	foreach ($book->inventory as $inventory) {
		if ( strtoupper($inventory->country_name) == get_option('sitecountry') ) {

			switch ($inventory->state) {
				case 'SPENT':
					$target_class = 'spent';
					$target_text = 'Agotado';
					$showtarget = true;
					break;
				
				case 'RESERVED':
					$target_class = 'reserved';
					$target_text = 'Reservado';
					$showtarget = true;
					break;
			}

			if($inventory->state !== 'SPENT' && $inventory->state !== 'RESERVED' && $inventory->active_offer == '1' && $inventory->offer_price > 0) {
				$target_class = 'offer';
				$target_text = 'En oferta!';
				$showtarget = true;
			}
		}
	}
@endphp

@section('fbPixel')
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
fbq('track', 'Lead');
@endsection

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
					@if($showtarget)
					    <div class="target {{ $target_class }}">{!! $target_text !!}</div>
					@endif
					
					<img alt="{!! $book->title !!}" title="{!! $book->title !!}" class="materialboxed" src="{{ $book->thumbnail }}">
				</div>

				<!--Countries loop for scroll info interaction-->
				@foreach ($book->inventory as $inventory)
					@if ($book->state !== 'SPENT' && $book->state !== 'RELEASE' && strtoupper($inventory->country_name) == get_option('sitecountry') && $inventory->price > 0 && $inventory->state == "STOCK" && $showaddtocart)
					<div class="scroll-info">
						@if ($showprices)
							@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
								<p class="price">
									{{ COPMoney($inventory->offer_price) }}<br/>
									<span class="before">Antes:</span> <span class="offer-price">{{ COPMoney($inventory->price) }}</span>
								</p>
							@else
								<p class="price">{{ COPMoney($inventory->price) }}</p>
							@endif
						@endif
						@if ($showaddtocart)
							<div class="add-to-cart">
								<input type="hidden" class="book-id" value="{{ $book->id }}">
								@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
									<input type="hidden" class="book-price" value="{{ $inventory->offer_price }}">
								@else
									<input type="hidden" class="book-price" value="{{ $inventory->price }}">
								@endif
								<input class="quantity" placeholder="Cantidad..." type="number" value="1">
								<button class="add-btn button danger waves-effect waves-light">Añadir al carrito</button>
							</div>
						@endif
					</div>
					@endif
				@endforeach

			</div>
		</div>
		<div class="col s12 l7 summary-book">
			<h1 class="name">
				{!! $book->title !!}
			</h1>

			<h3 class="author">

				<!--Authors loop-->
				@foreach ($book->author as $author)
					<span>
						<a href="/autor/{{ $author->slug }}"> {!! $author->title !!} </a>
					</span>
				@endforeach

			</h3>

			@foreach ($book->inventory as $inventory)
				@if (strtoupper($inventory->country_name) == get_option('sitecountry') && $inventory->price > 0 && $inventory->state == "STOCK" && $showprices)

					@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
						<p class="price">{{ COPMoney($inventory->offer_price) }} - <span class="before">Antes:</span> <span class="offer-price">{{ COPMoney($inventory->price) }}</span></p>
					@else
						<p class="price">{{ COPMoney($inventory->price) }}</p>
					@endif

				@endif
			@endforeach

			@if( isset($release) )
				<p class="release_note"><span class="important">Importante:</span> {!! $release !!}</p>
			@endif
			
			@if (get_option('sitecountry') == 'COLOMBIA')
				<p class="shipping">¡Envío gratis a cualquier ciudad de Colombia!</p>
			@endif
			
			<!--Specialties icons-->
			<div class="cont-specialties">
				<div class="label">Especialidades:</div>
				<div class="items">
					@foreach ($book->taxonomies as $taxonomy)
						@if ($taxonomy->slug != 'medicina' && $taxonomy->slug != 'odontologia' && $taxonomy->icon_img != NULL)
						<p>
							<img class="specialty-icon" src="{{ $taxonomy->icon_img }}" alt="{!! $taxonomy->title!!} "> {!! $taxonomy->title !!}
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
				@if ($book->state !== 'SPENT' && $book->state !== 'RELEASE' && strtoupper($inventory->country_name) == get_option('sitecountry') && $inventory->price > 0 && $inventory->state == "STOCK" && $showaddtocart)
					<div class="add-to-cart">
						<input type="hidden" class="book-id" value="{{ $book->id }}">
						@if ($inventory->active_offer == '1' && $inventory->offer_price > 0)
							<input type="hidden" class="book-price" value="{{ $inventory->offer_price }}">
						@else
							<input type="hidden" class="book-price" value="{{ $inventory->price }}">
						@endif
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
									@php
										$key_title = '';

										switch ($key) {
											case 'publication_year':
												$key_title = 'Año de publicación';
												break;
											case 'number_pages':
												$key_title = 'Número de páginas';
												break;
											case 'impresion':
												$key_title = 'Impresión';
												break;
											case 'tapa':
												$key_title = 'Tapa';
												break;
											case 'formato':
												$key_title = 'Formato';
												break;
											case 'volumes':
												$key_title = 'Número de tomos';
												break;
											case 'isbn':
												$key_title = 'ISBN';
												break;
										}
									@endphp
									<tr>
										<th>{!! $key_title !!}:</th>
										<td>{!! $val !!}</td>
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