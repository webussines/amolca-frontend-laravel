+@extends('admin.layouts.account')

@if ($form->id !== '')
    @section('title', 'Formulario ID: #' . $form->id . ' - Admin Amolca')
@endif


@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-form.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/forms/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-form')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-navigation red previous" href="/am-admin/formularios">
            Ver todos los formularios
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m9 l9">
            <p class="title">Formulario ID: #{{ $form->id }}</p>
        </div>
        <div class="col s12 m3 l3 actions">
            <a class="btn-navigation red previous" href="/am-admin/formularios">
                Ver todos los formularios
            </a>
        </div>
    </div>

    <form class="form-form" id="form-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $form->id }}">
        <input type="hidden" id="_src" value="forms">

        <table>
            
            <tbody>
                
                <tr>
                    <th>Enviado por:</th>
                    <td>{!! $form->name !!} - <b>[{{ $form->from }}]</b></td>
                </tr>

                @if ($form->cc !== null)
                    <tr>
                        <th>Con copia a:</th>
                        <td>{{ $form->cc }}</td>
                    </tr>
                @endif

                <tr>
                    <th>Asunto del correo:</th>
                    <td>{{ $form->subject }}</td>
                </tr>

                <tr>
                    <th>Fecha de envío:</th>
                    <td>
                        @php $date = new Date($form->created_at); @endphp
                        {{ $date->format('j F, Y') }}
                    </td>
                </tr>

                <tr>
                    <th>País desde dónde se envió:</th>
                    <td>{{ $form->country_id }}</td>
                </tr>

                <tr>
                    <th>Dominio del sitio web desde donde se envió:</th>
                    <td>{{ $form->domain }}</td>
                </tr>
                
                @if (isset($form->items) && count($form->items) > 0)
                    <tr>
                        <th>Campos enviados:</th>
                        <td>
                            
                            @foreach ($form->items as $item)
                                <p><b>{!! $item->item_name !!}:</b> {!! $item->item_value !!}</p>
                            @endforeach

                        </td>
                    </tr>
                @endif

            </tbody>

        </table>

    </form>
@endsection