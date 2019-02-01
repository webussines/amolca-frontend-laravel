@extends('admin.layouts.account')

@php
    $title = (isset($lot->title)) ? $lot->title : '';
    $slug = (isset($lot->slug)) ? $lot->slug : '';
    $id = (isset($lot->id)) ? $lot->id : '';
    $arrival_date = (isset($lot->arrival_date)) ? $lot->arrival_date : '';
    $start_sales = (isset($lot->start_sales)) ? $lot->start_sales : '';
    $books = (isset($lot->books)) ? $lot->books : [];

    $all_books = (isset($all_books)) ? $all_books : [];
@endphp

@if ($id !== '')
    @section('title', 'Lote: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Creando lote nuevo - Admin Amolca')
@endif


@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-lot.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/slug-generator.js') }}"></script>
<script src="{{ asset('js/admin/lots/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-lot')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-navigation green save-resource">
            Guardar lote
        </a>
        <a class="btn-navigation red previous" href="/am-admin/lotes">
            Ver todos los lotes
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m12 l8">
            @if ($title !== '')
                <p class="title">Lote: {{ $title }}</p>
            @else
                <p class="title">Creando lote nuevo</p>
            @endif
        </div>
        <div class="col s12 m12 l4 actions">
            <a class="btn-navigation green save-resource">
                Guardar lote
            </a>
            <a class="btn-navigation red previous" href="/am-admin/lotes">
                Ver todos los lotes
            </a>
        </div>
    </div>

    <form class="lot-form" id="lot-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_src" value="lots">

        <div class="row">

            <div class="col s12 m12 l10 offset-l1">
                <div class="form-group col s12 m12">
                    <label for="title"><span class="required">*</span> Título del libro:</label>
                    <input type="text" name="title" id="title" class="required-field" placeholder="Título del libro..." value="{{ $title }}">
                    <p id="title-error" class="error"></p>
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="arrival_date">Fecha de llegada del lote:</label>
                    <input type="text" name="arrival_date" id="arrival_date" class="datepicker" placeholder="Fecha de llegada del lote..." value="{{ $arrival_date }}">
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="start_sales">Fecha de inicio de ventas:</label>
                    <input type="text" name="start_sales" id="start_sales" class="datepicker" placeholder="Fecha de inicio de ventas..." value="{{ $start_sales }}">
                </div>

                <div class="col s12 m12 l12">
                    <label for="books">Libros que pertenecen al lote:</label>
                    <select name="books" id="books" multiple="multiple">
                        @foreach ($all_books as $book)
                            @php $checked = ''; @endphp
                                            
                            @if (count($books) > 0)
                                @foreach ($books as $selected)
                                    @php
                                        if($selected->id == $book->id){
                                            $checked = 'selected="selected"';
                                        }
                                    @endphp
                                @endforeach
                            @endif

                            <option {{ $checked }} value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>

    </form>
@endsection