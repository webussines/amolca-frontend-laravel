@extends('admin.layouts.account')

@php
    $id = (isset($banner->id)) ? $banner->id : '';
    $title = (isset($banner->title)) ? $banner->title : '';
    $image = (isset($banner->image)) ? $banner->image : 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg';
    $state = (isset($banner->state)) ? $banner->state : '';
    $link = (isset($banner->link)) ? $banner->link : '';

    $resource_type = (isset($banner->resource_type)) ? $banner->resource_type : '';
    $resource_id = (isset($banner->resource_id)) ? $banner->resource_id : '';
    $resource_title = (isset($banner->resource_title)) ? $banner->resource_title : '';

    $country_id = (isset($banner->country_id)) ? $banner->country_id : '';
    $country_title = (isset($banner->country_title)) ? $banner->country_title : '';

@endphp

@if ($title !== '')
    @section('title', 'Banner: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Creando banner nuevo - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-banner.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="https://unpkg.com/web-animations-js@2.3.1/web-animations.min.js"></script>
<script src="https://unpkg.com/hammerjs@2.0.8/hammer.min.js"></script>
<script src="https://unpkg.com/muuri@0.7.1/dist/muuri.min.js"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/banners/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-slider')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m7 l7">
            <p class="title">
                @if ($id !== '')
                    Banner: {!! $title !!}
                @else
                    Creando banner nuevo
                @endif
            </p>
        </div>
        <div class="col s12 m5 l5 actions">
            <a class="btn-navigation green save-resource">
                Guardar banner
            </a>
            <a class="btn-navigation red previous" href="/am-admin/banner">
                Ver todos los banners
            </a>
        </div>
    </div>

    <form id="slider-edit" class="slider-edit">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_src" value="banners">
        <input type="hidden" id="id" value="{{ $id }}">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
        </ul>

        <div id="ajustes-basicos" class="content-tabs">

            <div class="row">

                <div class="col s12 m7">
                    <div class="image-wrap">
                        <img id="resource-image" src="{{ $image }}" alt="">
                        <input type="hidden" id="image-url" name="image-url" value="{{ $image }}">

                        <div class="circle-preloader preloader-wrapper big active">
                            <div class="spinner-layer spinner-green-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="global-upload-wrap">

                        <p id="image-error" class="error"></p>

                        <p class="desc">
                            El archivo debe pesar menos de 25mb.<br/>
                            Las medidas recomendadas son <b>1600 x 132</b> (en pixeles).
                        </p>

                        <div class="buttons">

                            <input type="button" id="save-file-btn" class="save" value="Subir imagen">

                            <div class="file-upload-wrapper">
                                <button id="upload-file-btn" class="upload">Seleccionar imagen</button>
                                <input type="file" id="image" name="image">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col s5">

                    <div class="form-group">
                        <label for="title"><span class="required">*</span> Título del banner:</label>
                        <input type="text" name="title" id="title" class="required-field" value="{!! $title !!}" placeholder="Título del banner...">
                    </div>

                    <div class="form-group">
                        <label for="resource_slug"><span class="required">*</span> Tipo de página donde se publicará el banner:</label>
                        <select name="resource_type" id="resource_type" class="normal-select required-field">
                            <option value="0">Seleccione una opción</option>
                            <option @if ( $resource_type == 'BOOK') selected="selected" @endif value="BOOK">Página de libro</option>
                            <option @if ( $resource_type == 'AUTHOR') selected="selected" @endif value="AUTHOR">Página de autor</option>
                            <option @if ( $resource_type == 'SPECIALTY') selected="selected" @endif value="SPECIALTY">Especialidad</option>
                            <option @if ( $resource_type == 'PAGE') selected="selected" @endif value="PAGE">Página estática</option>
                            <option @if ( $resource_type == 'BLOG') selected="selected" @endif value="BLOG">Publicación del blog</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="resource_id"><span class="required">*</span> ¿En qué recurso desea publicar el banner?:</label>
                        <select name="resource_id" id="resource_id" class="select2-normal required-field">
                            @if ($resource_id !== '')
                                <option selected="selected" value="{!! $resource_id !!}">{!! $resource_title !!}</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="country_id"><span class="required">*</span> País donde estará activo el banner:</label>
                        <select name="country_id" id="country_id" class="select2-normal required-field">
                            @if ($country_id !== '')
                                <option selected="selected" value="{!! $country_id !!}">{!! $country_title !!}</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="link">Link del banner:</label>
                        <input type="text" name="image-link" id="image-link" value="{!! $link !!}" placeholder="Ejemplo de URL: https://www.dominio.com">
                    </div>

                    <div class="form-group">
                        <label for="target_link">Abrir link en:</label>
                        <select name="target_link" id="target_link" class="normal-select">
                            <option @if ( $resource_type == '_self') checked="checked" @endif value="_self">Misma pestaña</option>
                            <option @if ( $resource_type == '_blank') checked="checked" @endif value="_blank">Nueva pestaña</option>
                        </select>
                    </div>

                </div>

            </div>

        </div>

        <div class="fixed-action-btn">
            <a class="btn-navigation green save-resource">
                Guardar banner
            </a>
            <a class="btn-navigation red previous" href="/am-admin/banner">
                Ver todos los banners
            </a>
        </div>

    </form>
@endsection
