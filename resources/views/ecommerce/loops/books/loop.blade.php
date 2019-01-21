@php
	$loopType = (isset($type)) ? $type : 'loop';
	$itemsPerRow = (isset($items_per_row)) ? $items_per_row : 2;
@endphp

@switch($loopType)
    @case('loop')
		<div class="books-loop items-per-page-{{ $itemsPerRow }}">
		@break

	@case('carousel')
		<div class="books-loop books-carousel" data-slick='{ "slidesToShow": {{ $itemsPerRow }} }'>
		@break

	@default
		<div class="books-loop items-per-page-{{ $itemsPerRow }}">
@endswitch

	@for ($i = 0; $i < count($books); $i++)
		@php
			$book = $books[$i];
		@endphp

		<div class="item">

			<!--Portada del libro-->
			<a class="contain-img" href="/{{ $book->slug }}">
				<img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" title="{{ $book->title }}">
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
					<a href="/{{ $book->slug }}">{{ $book->title }}</a>
				</h3>

				<!--Autores-->
				<p class="authors">
					@if (isset($book->author))
						@for ($a = 0; $a < count($book->author); $a++)
							@php $author = $book->author[$a]; @endphp

							@if ($a < 4)
								<span><a href="/autor/{{$author->slug}}">
									{{ $author->title }}@if($a < 3 && count($book->author) > 4 ), @elseif( $a == 3 && count($book->author) > 4 )... @endif
								</a></span>
							@endif
						@endfor
					@endif
				</p>

				<!--Acciones-->
				@if ( isset($book->inventory) && count($book->inventory) > 0 )
					@for ($c = 0; $c < count($book->inventory); $c++)
						
						@php $inventory = $book->inventory[$c]; @endphp

						@if (strtoupper($inventory->country_name) == "COLOMBIA")
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

@if ($type !== 'carousel')
{{ $books->links() }}
@endif