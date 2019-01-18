@php
	$show_searcher = (isset($show_searcher)) ? $show_searcher : false;
@endphp


<div class="banner-container">
  <div class="common-banner">
      <p>Este y muchos más libros encuentralos en Amolca</p>
  </div>

  @if ($show_searcher)
  	@include('ecommerce.layouts.partials.big-searcher')
  @endif
</div>