@extends('admin.layouts.account')

@php
    $title = (isset($book->title)) ? $book->title : '';
    $id = (isset($book->id)) ? $book->id : '';
    $thumbnail = (isset($book->thumbnail)) ? $book->thumbnail : 'https://amolca.webussines.com/uploads/images/no-image.jpg';
    $isbn = (isset($book->datasheet->isbn)) ? $book->datasheet->isbn : '';
    $state = (isset($book->state)) ? $book->state : '';
    $versions = (isset($book->version)) ? $book->version : [];
    $content = (isset($book->content)) ? $book->content : '';
    $index = (isset($book->index)) ? $book->index : '';
    $keypoints = (isset($book->keypoints)) ? $book->keypoints : '';

    $book_specialty = (isset($book->taxonomies)) ? $book->taxonomies : [];
    $bookAuthor = (isset($book->author)) ? $book->author : [];
    $publication_year = (isset($book->datasheet->publication_year)) ? $book->datasheet->publication_year : 0;
    $number_pages = (isset($book->datasheet->number_pages)) ? $book->datasheet->number_pages : 0;
    $volume = (isset($book->datasheet->volume)) ? $book->datasheet->volume : 0;

    $formato = (isset($book->datasheet->formato)) ? $book->datasheet->formato : 0;
    $impresion = (isset($book->datasheet->impresion)) ? $book->datasheet->impresion : 0;
    $tapa = (isset($book->datasheet->tapa)) ? $book->datasheet->tapa : 0;

    $attributes = (isset($book->attributes)) ? $book->attributes : [];
    $countries = (isset($book->countries)) ? $book->countries : [];

@endphp

@section('title', 'Libro: ' . $title . ' - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-book.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/books/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-specialty')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m10 l10">
            <p class="title"> @if ($title !== '') {{$title}} @else Creando nuevo libro @endif  </p>
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

    <form id="book-edit" class="book-edit">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_src" value="books">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="id" value="{{ $id }}">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
            <li class="tab">
                <a href="#especialidades">Especialidades</a>
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
                        <label for="title"><span class="required">*</span> Título del libro:</label>
                        <input type="text" name="title" id="title" class="required-field" placeholder="Título del libro..." value="{{ $title }}">
                    </div>

                    <div class="form-group col s12 m6">
                        <label for="isbn"><span class="required">*</span> ISBN del libro:</label>
                        <input type="text" name="isbn" id="isbn" class="required-field" placeholder="ISBN del libro..." value="{{ $isbn }}">
                    </div>

                    <div class="form-group col s12 m6">
                        <label for="state"><span class="required">*</span> Estado:</label>
                        <select name="state" id="state" class="normal-select">
                            <option @if ($state == 'PUBLISHED') selected @endif value="PUBLISHED">Publicado</option>
                            <option @if ($state == 'DRAFT') selected @endif value="DRAFT">Borrador</option>
                            <option @if ($state == 'TRASH') selected @endif value="TRASH">En papelera</option>
                        </select>
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="autores"><span class="required">*</span> Autor/es:</label>
                        <select name="autores" id="autores" class="select2-normal" multiple>

                            @foreach ($authors as $aut)
                                @php $checked = ''; @endphp
                                        
                                @if (count($bookAuthor) > 0)
                                    @foreach ($bookAuthor as $selected)
                                        @php
                                            if($selected->id == $aut->id){
                                                $checked = 'selected="selected"';
                                            }
                                        @endphp
                                    @endforeach
                                @endif
                                <option {{ $checked }} value="{{ $aut->id }}">{{ $aut->title }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col s12 col-versions">
                        <div class="version">
                            <p>Versiones:</p>
                        </div>

                        @php
                            $paper = false;
                            $ebook = false;
                            $video = false;
                        @endphp

                        @foreach ($versions as $version)
                            @php
                                if($version == 'PAPER'){
                                    $paper = true;
                                } else if($version == 'EBOOK'){
                                    $ebook = true;
                                } else if($version == 'VIDEO'){
                                    $video = true;
                                }
                            @endphp
                        @endforeach

                        <div class="version">
                            <label for="version-paper">
                                <input type="checkbox" name="version" id="version-paper" @if ($paper) checked="checked" @endif value="PAPER">
                                <span>Papel</span>
                            </label>
                        </div>

                        <div class="version">
                            <label for="version-video">
                                <input type="checkbox" name="version" id="version-video" @if ($video) checked="checked" @endif value="VIDEO">
                                <span>Vídeo</span>
                            </label>
                        </div>

                        <div class="version">
                            <label for="version-ebook">
                                <input type="checkbox" name="version" id="version-ebook" @if ($ebook) checked="checked" @endif value="EBOOK">
                                <span>Ebook</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="description">Descripción:</label>
                        <textarea name="description" id="description" placeholder="Descripción del libro...">{{$content}}</textarea>
                    </div>

                </div>
            </div>

            <div class="row">
                
                <ul class="tabs inside-tabs">
                    <li class="tab">
                        <a class="active" href="#indice">Índice</a>
                    </li>
                    <li class="tab">
                        <a href="#puntos-clave">Puntos clave</a>
                    </li>
                </ul>

                <div id="indice" class="content-tabs subtab">
                    <div class="form-group">
                        <textarea name="index" id="index" class="common-editor">{{ $index }}</textarea>
                    </div>
                </div>
                <div id="puntos-clave" class="content-tabs subtab">
                    <div class="form-group">
                        <textarea name="key-points" id="key-points" class="common-editor">{{ $keypoints }}</textarea>
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
                                    
                                    @if (count($book_specialty) > 0)
                                        @foreach ($book_specialty as $selected)
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
                                            
                                            @if (count($book_specialty) > 0)
                                                @foreach ($book_specialty as $selected)
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

        <div id="ficha" class="content-tabs">

            <div class="row">
                <div class="col s6 m5">
                    <label for="publication-year"><span class="required">*</span> Año de publicación:</label>
                    <input type="text" readonly id="publication-year-name" name="publication-year-name" value="Año de publicación">
                </div>
                <div class="col s6 m5">
                    <label for="publication-year"><span class="required">*</span> Valor:</label>
                    <input type="number" id="publication-year" name="publication-year" value="{{ $publication_year }}">
                </div>
            </div>

            <div class="row">
                <div class="col s6 m5">
                    <label for="number-pages"><span class="required">*</span> Número de páginas:</label>
                    <input type="text" readonly id="number-pages-name" name="number-pages-name" value="Número de páginas">
                </div>
                <div class="col s6 m5">
                    <label for="number-pages"><span class="required">*</span> Valor:</label>
                    <input type="number" id="number-pages" name="number-pages" value="{{ $number_pages }}">
                </div>
            </div>

            <div class="row">
                <div class="col s6 m5">
                    <label for="number-volumes"><span class="required">*</span> Número de tomos:</label>
                    <input type="text" readonly id="volumes-name" name="volumes-name" value="Número de tomos">
                </div>
                <div class="col s6 m5">
                    <label for="number-volumes"><span class="required">*</span> Valor:</label>
                    <input type="number" id="number-volumes" name="number-volumes" value="{{ $volume }}">
                </div>
            </div>

        </div>

        <div id="atributos" class="content-tabs">
                    
            <div class="row">
                <div class="col s6 m5">
                    <label for="impresion"><span class="required">*</span> Impresión:</label>
                    <input type="text" readonly id="impresion" name="impresion" value="Impresión">
                </div>
                <div class="col s6 m5">
                    <label for="impresion"><span class="required">*</span> Valor:</label>
                    <input type="text" id="impresion" name="impresion" value="{{ $impresion }}">
                </div>
            </div>

            <div class="row">
                <div class="col s6 m5">
                    <label for="formato"><span class="required">*</span> Formato:</label>
                    <input type="text" readonly id="formato-name" name="formato-name" value="Formato">
                </div>
                <div class="col s6 m5">
                    <label for="formato"><span class="required">*</span> Valor:</label>
                    <input type="text" id="formato" name="formato" value="{{ $formato }}">
                </div>
            </div>

            <div class="row">
                <div class="col s6 m5">
                    <label for="tapa"><span class="required">*</span> Tapa:</label>
                    <input type="text" readonly id="tapa-name" name="tapa-name" value="Tapa">
                </div>
                <div class="col s6 m5">
                    <label for="tapa"><span class="required">*</span> Valor:</label>
                    <input type="text" id="tapa" name="tapa" value="{{ $tapa }}">
                </div>
            </div>

        </div>
        <div id="precios" class="content-tabs">
            
            @if (count($countries) > 0)
                @foreach ($countries as $country)
                    
                    <div class="row row-country">
                        
                        <div class="col s12 m4">
                            <label for="name"><span class="required">*</span> País:</label>
                            <input type="text" readonly class="country-name" id="name" name="name" value="{{ $country->name }}">
                        </div>
                        <div class="col s12 m2">
                            <label for="price"><span class="required">*</span> Precio:</label>
                            <input type="text" class="country-price" id="price" name="price" value="{{ $country->price }}">
                        </div>
                        <div class="col s12 m2">
                            <label for="country-state">Estado:</label>
                            <select class="country-state normal-select" name="country-state" id="country-state">
                                <option value="STOCK" @if ($country->state == "STOCK") selected @endif>Disponible</option>
                                <option value="RESERVED" @if ($country->state == "RESERVED") selected @endif>Reservado</option>
                                <option value="SPENT" @if ($country->state == "SPENT") selected @endif>Agotado</option>
                            </select>
                        </div>
                        <div class="col s12 m2">
                            <label for="quantity">Cantidad:</label>
                            <input type="text" class="country-quantity" id="quantity" name="quantity" value="{{ $country->quantity }}">
                        </div>
                        <div class="col s12 m2">
                            <label>Acciones:</label>
                            <div>
                                <button class="button primary delete-attribute">Borrar</button>
                            </div>
                        </div>

                    </div>

                @endforeach
            @endif

            <div class="row">
                <div class="col s12">
                    <input type="button" id="add-country" class="button primary" value="Agregar un país">
                </div>
            </div>

        </div>

        <div class="single-navigation">

            @if (isset($prev))
                <a class="btn-navigation previous" href="/am-admin/libros/{{$prev}}"><span class="icon-arrow-left2"></span> Anterior</a>
            @endif

            @if (isset($next))
                <a class="btn-navigation next" href="/am-admin/libros/{{$next}}">Siguiente <span class="icon-arrow-right2"></span></a>
            @endif

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