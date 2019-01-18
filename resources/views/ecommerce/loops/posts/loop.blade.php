@php
	$type = (isset($type)) ? $type : 'loop';
	$items_per_row = (isset($items_per_row)) ? $items_per_row : 2;
@endphp

@switch($type)
    @case('loop')
		<div class="posts-loop items-per-page-{{ $items_per_row }}">
		@break

	@case('carousel')
		<div class="posts-loop posts-carousel" data-slick='{ "slidesToShow": {{ $items_per_row }} }'>
		@break

	@default
		<div class="posts-loop items-per-page-{{ $items_per_row }}">
@endswitch

	@for ($i = 0; $i < count($posts); $i++)
		@php
			$post = $posts[$i];
		@endphp

		<div class="item">

			<!--Portada del libro-->
			<a class="contain-img" href="/{{ $post->slug }}">
				<img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" title="{{ $post->title }}">
			</a>
			
			<div class="info">

				<!--Titulo del libro-->
				<h3 class="name">
					<a href="/{{ $post->slug }}">{{ $post->title }}</a>
				</h3>

				<div class="excerpt">
					@if (isset($post->excerpt))
						{!! substr($post->excerpt, 0, 100) !!}...
					@else
						{!! substr($post->content, 0, 100) !!}
					@endif
				</div>

				<div class="actions">
					<div class="view-more">
						<a class="button primary" href="/{{ $post->slug }}">Leer más</a>
					</div>

					<div class="button">
						<a class="social-share facebook tooltipped" 
							href="http://www.facebook.com/sharer.php?u={{Request::root()}}/{{ $post->slug }}"
							data-position="top" data-tooltip="Compartir en Facebook" title="Compartir en Facebook"
						>
				            <span class="icon-facebook"></span>
				        </a>
				        <a class="social-share twitter tooltipped" 
							href="https://twitter.com/share?url={{Request::root()}}/{{ $post->slug }}"
							data-position="top" data-tooltip="Compartir en Twitter" title="Compartir en Twitter"
						>
				            <span class="icon-twitter"></span>
				        </a>
					</div>
				</div>

			</div>
		</div>
	@endfor
</div>

@if ($type !== 'carousel')
{{ $posts->links() }}
@endif