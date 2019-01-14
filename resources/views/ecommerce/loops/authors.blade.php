@php
	$type = (isset($type)) ? $type : 'loop';
	$items_per_page = (isset($items_per_page)) ? $items_per_page : 8;
	$items_per_row = (isset($items_per_row)) ? $items_per_row : 2;

	//Paginator
	$total_pages = round($counter / $items_per_page, 0, PHP_ROUND_HALF_UP);
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
						<img src="{{$author->thumbnail}}" title="{{$author->title}}" alt="{{$author->title}}">
					</a>
				</div>
				<div class="info">
					<h3 class="name">
						<a href="/autor/{{$author->slug}}">{{$author->title}}</a>
					</h3>
					@if (isset($author->content))
						<div class="description">
							{!! substr($author->content, 0, 100) !!}...
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

<ul class="pagination">

	<li class="waves-effect @if($active_page == 1) disabled @endif">
		<a href="@if($active_page == $total_pages)  @else ?page={{$active_page - 1}} @endif">Anterior</a>
	</li>

	@for ($p = 1; $p < $total_pages + 1; $p++)
	<li class="waves-effect @if ($active_page == $p) active @endif">
		<a @if ($active_page == $p)  @else href="?page={{$p}}" @endif>{{ $p }}</a>
	</li>
	@endfor
	
	<li class="waves-effect @if($active_page == $total_pages) disabled @endif">
		<a href="@if($active_page == $total_pages)  @else ?page={{$active_page + 1}} @endif">Siguiente</a>
	</li>

</ul>