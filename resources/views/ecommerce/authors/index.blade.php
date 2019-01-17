@extends('ecommerce.layouts.site')

@section('title', "Autores - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container author-index')
@section('content')
<div class="content-container">

	@include('ecommerce.loops.authors.loop', ['authors' => $authors, 'type' => 'loop', 'items_per_row' => 4])

</div>
@endsection