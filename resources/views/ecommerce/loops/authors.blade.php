@php
	$loopType = (isset($type)) ? $type : 'loop';
	$itemsPerPage = (isset($items_per_page)) ? $items_per_page : 8;
	$itemsPerRow = (isset($items_per_row)) ? $items_per_row : 2;
@endphp

@switch($loopType)
    @case('loop')
		<div class="authors-loop items-per-page-{{ $itemsPerRow }}">
		@break

	@case('carousel')
		<div class="authors-loop authors-carousel" data-slick='{ "slidesToShow": {{ $itemsPerRow }} }'>
		@break

	@default
		<div class="authors-loop items-per-page-{{ $itemsPerRow }}">
@endswitch

	@for ($i = 0; $i < count($authors); $i++)
		@php $author = $authors[$i]; @endphp

		<div class="content">
			<div class="image">
				<a href="/autor/{{$author->slug}}">
					<img src="{{$author->image}}" title="{{$author->name}}" alt="{{$author->name}}">
				</a>
			</div>
			<div class="info">
				<h3 class="name">
					<a href="/autor/{{$author->slug}}">{{$author->name}}</a>
				</h3>
				@if (isset($author->description))
					<div class="description">
						{!! substr($author->description, 0, 100) !!}...
					</div>
				@endif
				<p>
					<a class="button primary" href="/autor/{{$author->slug}}">Ver libros</a>
				</p>
			</div>
		</div>
	@endfor

</div>