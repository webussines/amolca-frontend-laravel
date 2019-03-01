@extends('admin.layouts.account')

@php
    $id = (isset($slider->id)) ? $slider->id : '';
    $image = (isset($slider->image)) ? $slider->image : '';
    $state = (isset($slider->state)) ? $slider->state : '';
    $link = (isset($slider->link)) ? $slider->link : '';
    $resource_slug = (isset($slider->resource_slug)) ? $slider->resource_slug : '';
@endphp

@if ($id !== '')
    @section('title', 'Banner: ' . $resource_slug . ' - Admin Amolca')
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
        <div class="col s12 m10 l10">
            <p class="title">
                @if ($id !== '')
                    Banner: {{ $resource_slug }} 
                @else
                    Creando banner nuevo
                @endif
            </p>
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
                        <img id="resource-image" src="https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg" alt="">
                        <input type="hidden" id="image-url" name="image-url" value="">
                        <input type="hidden" id="slide-index" name="slide-index" value="">

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
                            Las medidas recomendadas son <b>1888 x 560</b> (en pixeles).
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
                        <label for="resource_slug"><span class="required">*</span> ¿En qué página desea publicar el banner?:</label>
                        <input type="text" id="resource_slug" name="resource_slug" value="{{ $resource_slug }}">
                    </div>

                    <div class="form-group">
                        <label for="link">Link del slide:</label>
                        <input type="text" name="image-link" id="image-link" value="{{ $link }}" placeholder="Ejemplo de URL: /novedades/medicina">
                        <span><b>Importante:</b> En el link del slide no poner el dominio. Solo poner la url relativa como por ejemplo: "/medicina"</span>
                    </div>
                </div>

            </div>

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