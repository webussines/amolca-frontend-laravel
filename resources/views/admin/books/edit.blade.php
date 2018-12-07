@extends('admin.layouts.account')

@section('title', 'Libro: ' . $book->title . ' - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-book.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/single-book.js') }}"></script>
@endsection

@section('contentClass', 'single-books')
@section('content')

    <div class="loader hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

	<div class="row section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title"> {{$book->title}} </p>
		</div>
		<div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-book">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-books" href="/am-admin/libros">
                <span class="icon-cross"></span>
            </a>
		</div>
	</div>

    <form action="" id="book-edit" class="book-edit">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="id" value="{{ $book->_id }}">

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
                    <img src="{{ $book->image }}" alt="{{ $book->title }}">
                </div>

                <div class="col s12 m7">

                    <div class="form-group col s12 m12">
                        <label for="title"><span class="required">*</span> Título del libro:</label>
                        <input type="text" name="title" id="title" value="{{ $book->title }}">
                    </div>

                    <div class="form-group col s12 m6">
                        <label for="isbn"><span class="required">*</span> ISBN del libro:</label>
                        <input type="text" name="isbn" id="isbn" value="{{ $book->isbn }}">
                    </div>

                    <div class="form-group col s12 m6">
                        <label for="state">Estado:</label>
                        <select name="state" id="satet" class="normal-select">
                            <option @if ($book->state == 'PUBLISHED') selected @endif value="PUBLISHED">Publicado</option>
                            <option @if ($book->state == 'DRAFT') selected @endif value="DRAFT">Borrador</option>
                            <option @if ($book->state == 'TRASH') selected @endif value="TRASH">En papelera</option>
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

                        @foreach ($book->version as $version)
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
                        <textarea name="description" id="description">@if (isset($book->description)) {{ $book->description }} @endif</textarea>
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
                        <textarea name="index" id="index" class="common-editor">@if (isset($book->index)) {{ $book->index }} @endif</textarea>
                    </div>
                </div>
                <div id="puntos-clave" class="content-tabs subtab">
                    <div class="form-group">
                        <textarea name="key-points" id="key-points" class="common-editor">@if (isset($book->keyPoints)) {{ $book->keyPoints }} @endif</textarea>
                    </div>
                </div>

            </div>

        </div>

        <div id="especialidades" class="content-tabs">
            <div class="row specialties">
                @foreach ($specialties as $specialty)
                    @if ($specialty->top)

                        <div class="col s12 m6">
                            <div class="form-group parent">

                                <label for="specialty-{{$specialty->_id}}">
                                    @php $checked = ''; @endphp
                                    
                                    @foreach ($book->specialty as $selected)
                                        @php
                                            if($selected->_id == $specialty->_id){
                                                $checked = 'checked="checked"';
                                            }
                                        @endphp
                                    @endforeach

                                    <input type="checkbox" name="specialty" id="specialty-{{$specialty->_id}}"  {{$checked}} value="{{$specialty->_id}}">

                                    <span>{{$specialty->title}}</span>
                                </label>

                            </div>

                            <div class="childs">
                                
                                @foreach ($specialty->childs as $child)

                                    <div class="form-group col s6 m6">
                                        <label for="specialty-{{$child->_id}}">
                                            @php $checked = ''; @endphp
                                            
                                            @foreach ($book->specialty as $selected)
                                                @php
                                                    if($selected->_id == $child->_id){
                                                        $checked = 'checked="checked"';
                                                    }
                                                @endphp
                                            @endforeach

                                            <input type="checkbox" name="specialty" id="specialty-{{$child->_id}}"  {{$checked}} value="{{$child->_id}}">

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
                    <input type="number" id="publication-year" name="publication-year" value="{{ $book->publicationYear }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col s6 m5">
                    <label for="number-pages"><span class="required">*</span> Número de páginas:</label>
                    <input type="text" readonly id="number-pages-name" name="number-pages-name" value="Número de páginas">
                </div>
                <div class="col s6 m5">
                    <label for="number-pages"><span class="required">*</span> Valor:</label>
                    <input type="number" id="number-pages" name="number-pages" value="{{ $book->numberPages }}">
                </div>
            </div>

            <div class="row">
                <div class="col s6 m5">
                    <label for="number-volumes"><span class="required">*</span> Número de tomos:</label>
                    <input type="text" readonly id="volumes-name" name="volumes-name" value="Número de tomos">
                </div>
                <div class="col s6 m5">
                    <label for="number-volumes"><span class="required">*</span> Valor:</label>
                    <input type="number" id="number-volumes" name="number-volumes" value="{{ $book->volume }}">
                </div>
            </div>

        </div>

        <div id="atributos" class="content-tabs">
            
            @foreach ($book->attributes as $attr)
                
                <div class="row row-attr">
                    
                    <div class="col s12 m5">
                        <label for="name"><span class="required">*</span> Nombre:</label>
                        <input type="text" id="name" class="attr-name" name="name" value="{{ $attr->name }}">
                    </div>
                    <div class="col s12 m5">
                        <label for="value"><span class="required">*</span> Valor:</label>
                        <input type="text" id="value" class="attr-value" name="value" value="{{ $attr->value }}">
                    </div>
                    <div class="col s12 m2">
                        <label>Acciones:</label>
                        <div>
                            <button class="button primary delete-attribute">Borrar</button>
                        </div>
                    </div>

                </div>

            @endforeach

        </div>
        <div id="precios" class="content-tabs">
            
            @foreach ($book->countries as $country)
                
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
                        <label for="state">Estado:</label>
                        <select class="country-state normal-select" name="state" id="state">
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

            <div class="row">
                <div class="col s12">
                    <input type="button" id="add-country" class="button primary" value="Agregar un país">
                </div>
            </div>

        </div>

        <div class="fixed-action-btn">
            <a class="btn-floating btn-large green save-book">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-books" href="/am-admin/libros">
                <span class="icon-cross"></span>
            </a>
        </div>

    </form>
@endsection