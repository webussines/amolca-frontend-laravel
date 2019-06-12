@extends('admin.layouts.account')

@php

    $id = (isset($catalog->id)) ? $catalog->id : '';
    $title = (isset($catalog->title)) ? $catalog->title : '';
    $thumbnail = (isset($catalog->thumbnail)) ? $catalog->thumbnail : 'https://amolca.webussines.com/uploads/images/no-image.jpg';
    $slug = (isset($catalog->slug)) ? $catalog->slug : '';
    $meta = (isset($catalog->meta)) ? $catalog->meta : [];
    $country = 0;
    $pdf = '';
    $specialty = 'MEDICIAN';

    foreach ($meta as $key => $value) {

        switch ($value->key) {
            case 'catalog_country_id':
                    $country = $value->value;
                break;
            case 'catalog_pdf_url':
                    $pdf = $value->value;
                break;
            case 'catalog_specialty':
                    $specialty = $value->value;
                break;
        }

    }

@endphp

@if ($title !== '')
    @section('title', 'Catálogo: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Creando catálogo nuevo - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-coupon.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/slug-generator.js') }}"></script>
<script src="{{ asset('js/admin/upload-pdf.js') }}"></script>
<script src="{{ asset('js/admin/intranet_catalogs/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-specialty')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-navigation green save-resource">
            Guardar catálogo
        </a>
        <a class="btn-navigation red previous" href="/am-admin/intranet/catalogos">
            Ver todos los catalogos
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m7 l7">
            <p class="title"> @if ($title !== '') {!! $title !!} @else Creando nuevo catálogo @endif  </p>
        </div>
        <div class="col s12 m5 l5 actions">
            <a class="btn-navigation green save-resource">
                Guardar catálogo
            </a>
            <a class="btn-navigation red previous" href="/am-admin/intranet/catalogos">
                Ver todos los catalogos
            </a>
        </div>
    </div>

    <form class="coupon-form" id="coupon-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_src" value="catalogs">

        <div class="row">

            <div class="col s12 m4 col-image">

                <div class="image-wrap">
                    <img id="resource-image" src="{{ $thumbnail }}" alt="">
                    <input type="hidden" id="image-url" name="image-url" value="{{ $thumbnail }}">

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
                        Las medidas recomendadas son <b>250 x 250</b> (en pixeles).
                    </p>

                    <input type="button" id="save-file-btn" class="save" value="Guardar imagen">

                    <div class="file-upload-wrapper">
                        <button id="upload-file-btn" class="upload">Seleccionar imagen</button>
                        <input type="file" id="image" name="image">
                    </div>
                </div>

            </div>

            <div class="col s12 m8">

                <div class="form-group col s12">
                    <label for="title"><span class="required">*</span> Título del catálogo:</label>
                    <input type="text" name="title" id="title" class="required-field" placeholder="Título del catálogo..." value="{!! $title !!}">
                    <p id="title-error" class="error"></p>
                </div>

                <div class="form-group col s12 m6">
                    <label for="country"><span class="required">*</span> País donde estará activo:</label>
                    <select name="country" id="country" class="select2-normal required-field">
                        @foreach ($countries as $pais)
                            <option value="{!! $pais->id !!}" @if ($country == strtoupper($pais->id)) selected="selected" @endif>{!! $pais->title !!}</option>
                        @endforeach
                        <option value="0" @if ($country == 0) selected="selected" @endif>Todos</option>
                    </select>
                    <p id="country-error" class="error"></p>
                </div>

                <div class="form-group col s12 m6">
                    <label for="specialty"><span class="required">*</span> Especialidad a la que pertenece:</label>
                    <select name="specialty" id="specialty" class="select2-normal required-field">
                        <option value="MEDICIAN" @if ($specialty == 'MEDICIAN') selected="selected" @endif>Medicina</option>
                        <option value="ODONTOLOGY" @if ($specialty == 'ODONTOLOGY') selected="selected" @endif>Odontología</option>
                    </select>
                    <p id="country-error" class="error"></p>
                </div>

                <div class="col s12 global-upload-wrap pdf">

                    <label for="pdf-url">URL del PDF:</label>

                    @php
                        $type = 'hidden';

                        if($action !== 'create') {
                            $type = 'text';
                        }
                    @endphp
                    <input type="{{ $type }}" id="pdf-url" name="pdf-url" value="{{ $pdf }}" placeholder="URL del PDF...">

                    <input type="button" id="pdf-save-file-btn" class="save" value="Guardar PDF">
                    <div class="file-upload-wrapper">
                        <button id="upload-file-btn" class="upload">Seleccionar PDF</button>
                        <input type="file" id="pdf" name="pdf">
                    </div>
                    <p id="pdf-error" class="error center"></p>
                    <p class="desc">El archivo debe pesar menos de 25mb.</p>

                </div>

            </div>

        </div>

    </form>
@endsection
