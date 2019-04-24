@extends('ecommerce.layouts.site')

@section('title', "$specialty - Amolca Editorial Médica y Odontol&oacute;gica")

@section('contentClass', 'page-container news')
@section('content')

<div class="specialty-title">
	<h2>Catalogos {!! $specialty !!}</h2>
</div>

<div class="content-container">

	@include('ecommerce.loops.catalogs.loop', [ 'catalogs' => $catalogs ])

</div>
@endsection
