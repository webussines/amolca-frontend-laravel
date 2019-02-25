@extends('ecommerce.layouts.site')

@section('title', "Eventos - Amolca Editorial Médica y Odontol&oacute;gica")

@section('contentClass', 'page-container news')
@section('content')
<div class="specialty-title">
	<h2>Todos los eventos</h2>
</div>

<div class="content-container">
	@include('ecommerce.loops.events.loop', ['posts' => $posts, 'type' => 'loop', 'items_per_row' => 4])
</div>
@endsection