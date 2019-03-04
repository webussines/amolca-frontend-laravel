<div class="big-slider">

	@for ($s = 0; $s < count($items); $s++)

		@php $item = $items[$s]; @endphp

		<div class="item item-{{$s}}">
			@if ($item->link !== null)
			<a href="{{ $item->link }}" target="{{ $item->target_link }}" class="slider-link"></a>
			@endif

			<div class="bg-item" style="background-image: url( {{ $item->image }} )"></div>

			<img class="visible-img" src="{{ $item->image }}">
			<img class="hidden-img" src="{{ $item->image }}">

		</div>
		
	@endfor

</div>