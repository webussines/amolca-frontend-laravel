@extends('admin.layouts.account')

@php

    $id = (isset($dealer->id)) ? $dealer->id : '';
    $title = (isset($dealer->title)) ? $dealer->title : '';
    $slug = (isset($dealer->slug)) ? $dealer->slug : '';
    $thumbnail = (isset($dealer->thumbnail)) ? $dealer->thumbnail : 'https://amolca.webussines.com/uploads/images/no-image.jpg';
    $country = (isset($dealer->country_id)) ? $dealer->country_id : '';

    $contact = '';
    $phone = '';
    $address = '';
    $email = '';

    if(isset($dealer->meta)) {

        for ($i = 0; $i < count($dealer->meta); $i++) { 
            switch ($dealer->meta[$i]->meta_key) {
                case 'contact_person':
                    $contact = $dealer->meta[$i]->meta_value;
                    break;

                case 'address':
                    $address = $dealer->meta[$i]->meta_value;
                    break;

                case 'phone':
                    $phone = $dealer->meta[$i]->meta_value;
                    break;

                case 'email':
                    $email = $dealer->meta[$i]->meta_value;
                    break;
            }
        }

    }

@endphp

@if ($title !== '')
    @section('title', 'Distribuidor: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Creando distribuidor nuevo - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-dealer.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/slug-generator.js') }}"></script>
<script src="{{ asset('js/admin/dealers/single.js') }}"></script>
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
            Guardar distribuidor
        </a>
        <a class="btn-navigation red previous" href="/am-admin/distribuidores">
            Ver todos los distribuidores
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m7 l7">
            <p class="title"> @if ($title !== '') {!! $title !!} @else Creando nuevo distribuidor @endif  </p>
        </div>
        <div class="col s12 m5 l5 actions">
            <a class="btn-navigation green save-resource">
                Guardar distribuidor
            </a>
            <a class="btn-navigation red previous" href="/am-admin/distribuidores">
                Ver todos los distribuidores
            </a>
        </div>
    </div>

    <form class="author-form" id="author-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_src" value="dealers">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
        </ul>

        <div id="ajustes-basicos" class="content-tabs">

            <div class="row">

                <div class="col s12 m5 col-image">

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

                <div class="col s12 m7">

                    <div class="form-group col s12 m12">
                        <label for="title"><span class="required">*</span> Nombre del distribuidor:</label>
                        <input type="text" name="title" id="title" class="required-field" placeholder="Nombre del distribuidor..." value="{!! $title !!}">
                    </div>

                    <div class="form-group meta-group col s12 m12">
                        <label for="contact_person"><span class="required">*</span> Nombre de la persona contacto:</label>
                        <input type="text" name="contact_person" id="contact_person" class="required-field" placeholder="Nombre de la persona contacto..." value="{!! $contact !!}">
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="country"><span class="required">*</span> País:</label>
                        <select name="country" id="country" class="select2-normal">
                            @foreach ($countries as $pais)
                                <option value="{!! $pais->id !!}" @if ($country == $pais->id) selected="selected" @endif>{!! $pais->title !!}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                
            </div>

        </div>

    </form>
@endsection