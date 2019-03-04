@php
	$show_searcher = (isset($show_searcher)) ? $show_searcher : false;
	$exists_banner = (isset($exists_banner)) ? $exists_banner : false;
@endphp

<div class="banner-container">

	@if ( $exists_banner && $banner->country_id == get_sitecountry_id() )	

	<div class="common-banner">

		@if ($banner->link !== null)
		<a class="banner-link" href="{!! $banner->link !!}" target="{!! $banner->target_link !!}"></a>
		@endif

		<img src="{!! $banner->image !!}" alt="{!! $banner->title !!}">

	</div>

	@else

	<div class="common-banner example">
		<p>Este y muchos más libros encuentralos en Amolca</p>
	</div>

	@endif

	@if ($show_searcher)
		@include('ecommerce.layouts.partials.big-searcher')
	@endif

</div>