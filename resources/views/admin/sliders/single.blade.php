@extends('admin.layouts.account')

@section('title', 'Libro: ' . $slider->title . ' - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-slider.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/sliders/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-slider')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

	<div class="row single section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title"> {{$slider->title}} </p>
		</div>
		<div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/libros">
                <span class="icon-cross"></span>
            </a>
		</div>
	</div>

    <form id="slider-edit" class="slider-edit">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="id" value="{{ $slider->_id }}">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
            <li class="tab">
                <a href="#items">Ítems</a>
            </li>
            <li class="tab">
                <a href="#ficha">Ficha técnica</a>
            </li>
            <li class="tab">
                <a href="#atributos">Atributos</a>
            </li>
            <li class="tab">
                <a href="#precios">Precios</a>
            </li>
        </ul>

        <div id="ajustes-basicos" class="content-tabs">



        </div>

        <div class="fixed-action-btn">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/libros">
                <span class="icon-cross"></span>
            </a>
        </div>

    </form>
@endsection