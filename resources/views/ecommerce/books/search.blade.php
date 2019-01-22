@extends('ecommerce.layouts.site')

@section('title', "Blog - Amolca Editorial Médica y Odontológica")

@section('contentClass', 'page-container search-page')
@section('content')

<div class="header-page">
  Resultados de busqueda para: <b>{{Request::input('s')}}</b>
  @include('ecommerce.layouts.partials.big-searcher')
</div>

<div class="content-container">

	@include('ecommerce.loops.books.loop', ['books' => $posts, 'type' => 'loop', 'items_per_row' => 4, 'show_links' => 'no'])

</div>
@endsection