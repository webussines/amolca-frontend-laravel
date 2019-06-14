@extends('ecommerce.layouts.site')

@section('title', "Catálogos de Medicina - Amolca Editorial Médica y Odontol&oacute;gica")

@section('contentClass', 'page-container news')
@section('content')

<div class="specialty-title">
	<h2>&Uacute;ltimas Novedades Medicina</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.catalogs.loop', [ 'btn_text' => 'Ver ficha', 'catalogs' => $catalogs, "specialty" => "Medicina" ])

</div>
@endsection
