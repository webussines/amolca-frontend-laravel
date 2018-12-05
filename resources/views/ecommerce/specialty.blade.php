@extends('ecommerce.layouts.site')

@section('title', "Libros de $specialty->title - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container specialty')
@section('content')
<div class="specialty-title">
	<h2>{{ $specialty->title }}</h2>
</div>

<div class="content-container">

	<div class="books-loop items-per-page-4">

		@foreach ($books as $book)
			<div class="item">
				<a class="contain-img" href="/{{$book->slug}}">
					<img alt="{{$book->title}}" title="{{$book->title}}" src="{{$book->image}}">
				</a>
				<!--Versions book loop-->
				<div class="versions">
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
				</div>
				<div class="info">
					<h3 class="name">
						<a href="/{{$book->slug}}">{{$book->title}}</a>
					</h3>
					<p class="authors">

						<!--Authors loop-->
						@foreach ($book->author as $author)
							<span>
								<a href="/autor/{{$author->slug}}">{{$author->name}} </a>
							</span>
						@endforeach

					</p>

					<!--Countries loop-->
					@foreach ($book->countries as $country)
						<!--Show price if country is the actual-->
						@if ($country->name == $active_country)
							<div class="actions">
								<p class="price" id="price">@COPMoney($country->price)</p>
								<p class="btns">
									<a class="cart-btn tooltipped" data-position="top" data-tooltip="Añadir al carrito">
										<span class="icon-add_shopping_cart"></span>
									</a>
									<a class="hearth-btn tooltipped" data-position="top" data-tooltip="Añadir a mi lista de deseos">
										<span class="icon-heart-outline"></span>
									</a>
								</p>
							</div>
						@endif

					@endforeach

				</div>
			</div>
		@endforeach

	</div>

</div>
@endsection