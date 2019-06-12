@extends('ecommerce.layouts.site')

@section('title', "Catálogos de Medicina - Amolca Editorial Médica y Odontol&oacute;gica")

@section('contentClass', 'page-container news')
@section('content')

<div class="specialty-title">
	<h2>Cat&aacute;logos Medicina</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.catalogs.loop', [ 'catalogs' => $catalogs, "specialty" => "Medicina" ])

</div>
@endsection
