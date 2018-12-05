@extends('admin.layouts.account')

@section('title', 'Editar: Libro - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-book.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('js/admin/single-book.js') }}"></script>
@endsection

@section('contentClass', 'single-books')
@section('content')

	<div class="row section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title"> {{$book->title}} </p>
		</div>
		<div class="col s12 m2 l2 actions">
		</div>
	</div>

    <form action="">
        <ul class="tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
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
                        <label for="title">Título del libro:</label>
                        <input type="text" name="title" id="title" value="{{ $book->title }}">
                    </div>

                    <div class="form-group col s12 m6">
                        <label for="isbn">ISBN del libro:</label>
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

                    <div class="form-group col s12 m12">
                        <label for="description">Descripción:</label>
                        <textarea name="description" id="description">
                            @if (isset($book->description))
                                {{ $book->description }}
                            @endif
                        </textarea>
                    </div>

                </div>
            </div>

            <div class="row">
                
                <ul class="tabs">
                    <li class="tab">
                        <a class="active" href="#indice">Índice</a>
                    </li>
                    <li class="tab">
                        <a href="#puntos-clave">Puntos clave</a>
                    </li>
                </ul>

                <div id="indice" class="content-tabs subtab">
                    <div class="form-group">
                        <textarea name="index" id="index" class="common-editor">
                            @if (isset($book->index))
                                {{ $book->index }}
                            @endif
                        </textarea>
                    </div>
                </div>
                <div id="puntos-clave" class="content-tabs subtab">
                    <div class="form-group">
                        <textarea name="key-points" id="key-points" class="common-editor">
                            @if (isset($book->keyPoints))
                                {{ $book->keyPoints }}
                            @endif
                        </textarea>
                    </div>
                </div>

            </div>

        </div>

        <div id="atributos" class="content-tabs">
            
            @foreach ($book->attributes as $attr)
                
                <div class="row">
                    
                    <div class="col s12 m5">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" value="{{ $attr->name }}">
                    </div>
                    <div class="col s12 m5">
                        <label for="value">Valor:</label>
                        <input type="text" id="value" name="value" value="{{ $attr->value }}">
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
                
                <div class="row">
                    
                    <div class="col s12 m5">
                        <label for="name">País:</label>
                        <input type="text" readonly id="name" name="name" value="{{ $country->name }}">
                    </div>
                    <div class="col s12 m5">
                        <label for="value">Precio:</label>
                        <input type="text" id="value" name="value" value="{{ $country->price }}">
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

    </form>
@endsection