@php
	$type = (isset($type)) ? $type : 'loop';
	$items_per_row = (isset($items_per_row)) ? $items_per_row : 2;
@endphp

@switch($type)
    @case('loop')
		<div class="authors-loop items-per-page-{{ $items_per_row }}">
		@break

	@case('carousel')
		<div class="authors-loop authors-carousel" data-slick='{ "slidesToShow": {{ $items_per_row }} }'>
		@break

	@default
		<div class="authors-loop items-per-page-{{ $items_per_row }}">
@endswitch

	@for ($i = 0; $i < count($authors); $i++)
		@php $author = $authors[$i]; @endphp

		<div class="item">
			<div class="content">
				<div class="image">
					<a href="/autor/{{$author->slug}}">
						<img src="{{$author->thumbnail}}" title="{!! $author->title !!}" alt="{!! $author->title !!}">
					</a>
				</div>
				<div class="info">
					<h3 class="name">
						<a href="/autor/{{$author->slug}}">{!! $author->title !!}</a>
					</h3>
					@if (isset($author->excerpt))
						<div class="description">
							{{ substr($author->excerpt, 0, 100) }}...
						</div>
					@endif
					<p>
						<a class="button primary" href="/autor/{{$author->slug}}">Ver libros</a>
					</p>
				</div>
			</div>
		</div>
	@endfor

</div>

@if ($type !== 'carousel')
{!! $authors->links() !!}
@endif