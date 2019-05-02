@php
	$type = (isset($type)) ? $type : 'loop';
	$items_per_row = (isset($items_per_row)) ? $items_per_row : 2;
	$show_links = (isset($show_links)) ? $show_links : 'si';
@endphp

@switch($type)
    @case('loop')
		<div class="books-loop items-per-page-{{ $items_per_row }}">
		@break

	@case('carousel')
		<div class="books-loop books-carousel" data-slick='{ "slidesToShow": {{ $items_per_row }} }'>
		@break

	@default
		<div class="books-loop items-per-page-{{ $items_per_row }}">
@endswitch

	@for ($i = 0; $i < count($books); $i++)
		@php
			$book = $books[$i];
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
				}

				if( strtoupper($inventory->country_name) == get_option('sitecountry') && $inventory->state !== 'SPENT' && $inventory->state !== 'RESERVED' && $inventory->active_offer == '1' && $inventory->offer_price > 0) {
					$target_class = 'offer';
					$target_text = 'En oferta!';
					$showtarget = true;
				}
			}
		@endphp

		<div class="item">

			<!--Portada del libro-->
			<a class="contain-img" href="/{{ $book->slug }}">
				@if($showtarget)
				    <div class="target {{ $target_class }}">{!! $target_text !!}</div>
				@endif
				<img src="{{ $book->thumbnail }}" alt="{!! $book->title !!}" title="{!! $book->title !!}">
			</a>

			<!--Versiones-->
			<div class="versions">

				@if (isset($book->version))
					@for ($v = 0; $v < count($book->version); $v++)

						@php
							$title = '';
							$icon = '';
							$version = $book->version[$v];
						@endphp

						@php
							switch($version) :
							    case 'PAPER':
							        $title = 'Papel';
							        $icon = '<span class="icon-book"></span>';
							        break;

							    case 'VIDEO':
							        $title = 'Vídeo';
							        $icon = '<span class="icon-play"></span>';
							        break;

							    case 'EBOOK':
							        $title = 'Ebook';
							        $icon = '<span class="icon-device-tablet"></span>';
							        break;

							    default:
							        $title = 'Papel';
							        $icon = '<span class="icon-book"></span>';
							        break;
							endswitch;
						@endphp


						<a class="version-btn tooltipped" data-position="top" data-tooltip="{{ $title }}">
							@php echo $icon; @endphp
						</a>
					@endfor
				@endif
			</div>

			<div class="info">

				<!--Titulo del libro-->
				<h3 class="name">
					<a href="/{{ $book->slug }}">{!! $book->title !!}</a>
				</h3>

				<!--Autores-->
				<p class="authors">
					@if (isset($book->author))
						@for ($a = 0; $a < count($book->author); $a++)
							@php $author = $book->author[$a]; @endphp

							@if ($a < 4)
								<span><a href="/autor/{{$author->slug}}">
									{!! $author->title !!}@if($a < 3 && count($book->author) > 4 ), @elseif( $a == 3 && count($book->author) > 4 )... @endif
								</a></span>
							@endif
						@endfor
					@endif
				</p>

				<!--Acciones-->
				@if ( isset($book->inventory) && count($book->inventory) > 0 )
					@for ($c = 0; $c < count($book->inventory); $c++)

						@php
							$inventory = $book->inventory[$c];
							$activeds = [];

							$showactions = true;

							if (get_option('shop_catalog_mode') == 'SI' && get_option('shop_show_prices') !== 'NO') {
								$showactions = true;
							} else if(get_option('shop_catalog_mode') == 'SI' && get_option('shop_show_prices') == 'NO') {
								$showactions = false;
							}
						@endphp

						@if ($book->state !== 'SPENT' && strtoupper($inventory->country_name) == get_option('sitecountry') && $inventory->price > 0 && $inventory->state == "STOCK" && $showactions)
							@php
								array_push($activeds, $inventory->country_name);
							@endphp
							@include('ecommerce.loops.books.actions', ['show_price' => true, 'price' => $inventory->price])
						@else
							@include('ecommerce.loops.books.actions', ['show_price' => false])
						@endif

					@endfor
				@else
					@include('ecommerce.loops.books.actions', ['show_price' => false])
				@endif

			</div>
		</div>
	@endfor
</div>

@if ($show_links !== 'no' && $type !== 'carousel' )
{!! $books->links() !!}
@endif
