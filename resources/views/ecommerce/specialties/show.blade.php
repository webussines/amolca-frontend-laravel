@extends('ecommerce.layouts.site')

@section('title', "Libros de $specialty->title - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container specialty')
@section('content')
<div class="specialty-title">
	<h2>{{ $specialty->title }}</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.books.loop', ['books' => $posts, 'type' => 'loop', 'items_per_row' => 4])

</div>
@endsection