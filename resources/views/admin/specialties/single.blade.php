@php
    $id = (isset($specialty->id)) ? $specialty->id : '';
    $thumbnail = (isset($specialty->thumbnail)) ? $specialty->thumbnail : 'https://amolca.webussines.com/uploads/images/no-image.jpg';
    $title = (isset($specialty->title)) ? $specialty->title : '';
    $slug = (isset($specialty->slug)) ? $specialty->slug : '';
    $description = (isset($specialty->description)) ? $specialty->description : '';
@endphp

@extends('admin.layouts.account')

@if ($title !== '')
    @section('title', 'Especialidad: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Crear nueva especialidad - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-specialty.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/specialties/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-specialty')

@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green save-resource">
            <span class="icon-save1"></span>
        </a>
        <a class="btn-floating btn-large red go-all-resources" href="/am-admin/especialidades">
            <span class="icon-cross"></span>
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title">@if ($title !== '') {{$title}} @else Creando nueva especialidad @endif</p>
		</div>
		<div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/especialidades">
                <span class="icon-cross"></span>
            </a>
		</div>
	</div>

    <form id="specialty-form" class="specialty-form">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_src" value="specialties">
        <input type="hidden" id="_action" value="{{ $action }}">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
        </ul>

        <div id="ajustes-basicos" class="content-tabs simple-form">
            
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
                            <button id="upload-file-btn" class="upload">Modificar imagen</button>
                            <input type="file" id="image" name="image">
                        </div>
                    </div>

                </div>

                <div class="col s12 m7">

                    <div class="form-group col s12 m12">
                        <label for="title"><span class="required">*</span> Título de la especialidad:</label>
                        <input type="text" name="title" id="title" value="{{ $title }}">
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="slug"><span class="required">*</span> Slug:</label>
                        @if ($slug !== '')
                        {{$slug}}
                        @else
                        <input type="text" name="slug" id="slug">
                        @endif
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="description">Descripción:</label>
                        <textarea name="description" id="description">{{ $description }}</textarea>
                    </div>

                </div>

            </div>

        </div>

    </form>
@endsection