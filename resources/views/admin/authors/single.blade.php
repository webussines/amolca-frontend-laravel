@extends('admin.layouts.account')
@php
    $id = (isset($author->id)) ? $author->id : '';
    $title = (isset($author->title)) ? $author->title : '';
    $thumbnail = (isset($author->thumbnail)) ? $author->thumbnail : 'https://amolca.webussines.com/uploads/authors/no-author-image.png';
    $content = (isset($author->content)) ? $author->content : ' ';
    $authorTaxonomies = (isset($author->taxonomies)) ? $author->taxonomies : [];

    $meta_title = '';
    $meta_description = '';
    $meta_tags = [];

    if(isset($author->meta)) {
        for ($m = 0; $m < count($author->meta); $m++) { 
            if($author->meta[$m]->key == 'meta_title') {
                $meta_title = $author->meta[$m]->value;
            }

            if($author->meta[$m]->key == 'meta_tags') {
                $tags = str_replace(str_split('[]'), '', $author->meta[$m]->value);
                $meta_tags = explode(',', $tags);
            }

            if($author->meta[$m]->key == 'meta_description') {
                $meta_description = $author->meta[$m]->value;
            }
        }
    }
@endphp

@if ($title !== '')
    @section('title', 'Autor: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Crear nuevo autor - Admin Amolca')
@endif


@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-author.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/authors/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-author')
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
        <a class="btn-floating btn-large red go-all-resources" href="/am-admin/autores">
            <span class="icon-cross"></span>
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m10 l10">
            <p class="title">@if ($title !== '') {{$title}} @else Creando nuevo autor @endif</p>
        </div>
        <div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/autores">
                <span class="icon-cross"></span>
            </a>
        </div>
    </div>

    <form class="author-form" id="author-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_src" value="authors">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
            <li class="tab">
                <a href="#especialidades">Especialidades</a>
            </li>
            <li class="tab">
                <a href="#seo">SEO</a>
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
                        <label for="title"><span class="required">*</span> Nombre del autor:</label>
                        <input type="text" name="title" id="title" class="required-field" placeholder="Nombre del autor..." value="{{ $title }}">
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="content">Descripción:</label>
                        <textarea name="content" id="content" placeholder="Descripción del autor...">{{ $content }}</textarea>
                    </div>

                </div>
                
            </div>

        </div>

        <div id="especialidades" class="content-tabs">
            <div class="row specialties">
                @foreach ($specialties as $specialty)
                    @if ($specialty->parent_id == 0)

                        <div class="col s12 m6">
                            <div class="form-group parent">

                                <label for="specialty-{{$specialty->id}}">
                                    @php $checked = ''; @endphp
                                    
                                    @if (count($authorTaxonomies) > 0)
                                        @foreach ($authorTaxonomies as $selected)
                                            @php
                                                if($selected->id == $specialty->id){
                                                    $checked = 'checked="checked"';
                                                }
                                            @endphp
                                        @endforeach
                                    @endif

                                    <input type="checkbox" name="specialty" id="specialty-{{$specialty->id}}"  {{$checked}} value="{{$specialty->id}}">

                                    <span>{{$specialty->title}}</span>
                                </label>

                            </div>

                            <div class="childs">
                                
                                @foreach ($specialty->childs as $child)

                                    <div class="form-group col s6 m6">
                                        <label for="specialty-{{$child->id}}">
                                            @php $checked = ''; @endphp
                                            
                                            @if (count($authorTaxonomies) > 0)
                                                @foreach ($authorTaxonomies as $selected)
                                                    @php
                                                        if($selected->id == $child->id){
                                                            $checked = 'checked="checked"';
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif

                                            <input type="checkbox" name="specialty" id="specialty-{{$child->id}}"  {{$checked}} value="{{$child->id}}">

                                            <span>{{$child->title}}</span>
                                        </label>
                                    </div>
                                    
                                @endforeach

                            </div>
                        </div>

                    @endif
                @endforeach
            </div>
        </div>

        <div id="seo" class="content-tabs">
            
            <div class="row valign-wrapper">
                <div class="col s12 m4">
                    <p class="subtitle">Meta titulo:</p>
                </div>

                <div class="form-group col s12 m8">
                    <label for="meta-title">Meta titulo:</label>
                    <input type="text" id="meta-title" name="meta-title" placeholder="Meta titulo del autor..." value="{{ $meta_title }}">
                </div>
            </div>

            <div class="row valign-wrapper">
                <div class="col s12 m4">
                    <p class="subtitle">Meta descripción:</p>
                </div>

                <div class="form-group col s12 m8">
                    <label for="meta-description">Meta descripción:</label>
                    <textarea rows="3" id="meta-description" name="meta-description" placeholder="Meta descripción del autor...">{{$meta_description}}</textarea>
                </div>
            </div>

            <div class="row valign-wrapper">
                <div class="col s12 m4">
                    <p class="subtitle">Meta etiquetas:</p>
                </div>

                <div class="form-group col s12 m8">
                    <label for="meta-tags">Meta etiquetas:</label>
                    
                        @if (count($meta_tags) > 0)
                            <textarea rows="6" id="meta-tags" name="meta-tags" placeholder="Meta etiquetas del autor...">@foreach ($meta_tags as $tag){{$tag}},@endforeach</textarea>
                        @else
                            <textarea rows="6" id="meta-tags" name="meta-tags" placeholder="Separar cada etiqueta con una comma ( , )..."></textarea>
                        @endif
                </div>
            </div>

        </div>

    </form>
@endsection