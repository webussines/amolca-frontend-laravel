@extends('admin.layouts.account')

@php
    switch($order->state) {
        case 'PENDING':
            $state_text = 'Pendiente';
        break;
        case 'QUEUED_PAYMENT':
            $state_text = 'Pago pendiente';
        break;
        case 'PROCESSING':
            $state_text = 'En proceso';
        break;
        case 'COMPLETED':
            $state_text = 'Completado';
        break;
        case 'CANCELLED':
            $state_text = 'Cancelado';
        break;
        case 'FAILED':
            $state_text = 'Fallido';
        break;
        case 'REFUNDED':
            $state_text = 'Reembolsado';
        break;
        case 'FAILED':
            $state_text = 'Fallido';
        break;
    }
@endphp

@if ($order->id !== '')
    @section('title', 'Pedido #' . $order->id . ' - Admin Amolca')
@else
    @section('title', 'Crear nuevo autor - Admin Amolca')
@endif


@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-order.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/slug-generator.js') }}"></script>
<script src="{{ asset('js/admin/orders/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-order')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div id="order-modal" class="modal open">
        <div class="modal-content">

            <div class="loader top hidde">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>

            <p class="title">Estado del pedido #{{ $order->id }}</p>
            <p>El estado actual del pedido es: <span class="state {{ strtolower($order->state) }}">{{ $state_text }}</span></p>

            <p class="subtitle">Selecciónar nuevo estado:</p>
            <select class="normal-select" name="order-state" id="order-state">
                <option @if($order->state == 'PENDING') selected="selected" @endif value="PENDING">Pendiente</option>
                <option @if($order->state == 'QUEUED_PAYMENT') selected="selected" @endif value="QUEUED_PAYMENT">Pago pendiente</option>
                <option @if($order->state == 'PROCESSING') selected="selected" @endif value="PROCESSING">En proceso</option>
                <option @if($order->state == 'COMPLETED') selected="selected" @endif value="COMPLETED">Completado</option>
                <option @if($order->state == 'CANCELLED') selected="selected" @endif value="CANCELLED">Cancelado</option>
                <option @if($order->state == 'FAILED') selected="selected" @endif value="FAILED">Fallido</option>
                <option @if($order->state == 'REFUNDED') selected="selected" @endif value="REFUNDED">Reembolsado</option>
                <option @if($order->state == 'FAILED') selected="selected" @endif value="FAILED">Fallido</option>
            </select>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="add-notes" value="add-notes" />
                    <span>Agregar una nota adicional</span>
                </label>

                <textarea name="notes-state" id="notes-state" placeholder="Agregar una nota a este cambio de estado indicando la razón de este cambio..."></textarea>
                <p id="notes-state-error" class="error"></p>
            </div>

            <p class="desc"><b>Importante:</b> Al actualizar el estado de un pedido, se le enviará un correo al titular del pedido para notificarle el cambio.</p>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="actual-state" value="{{ $order->state }}">
            <p id="resp-buttons"><a class="change-state button primary">Actualizar estado</a> <a class="modal-close button gray">Cerrar modal</a></p>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-navigation red previous" href="/am-admin/pedidos">
            Ver todos los pedidos
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m9 l9">
            <p class="title">Pedido #{{ $order->id }} - <span>{{ $order->address->name }} {{ $order->address->lastname }}</span></p>
        </div>
        <div class="col s12 m3 l3 actions">
            <a class="btn-navigation red previous" href="/am-admin/pedidos">
                Ver todos los pedidos
            </a>
        </div>
    </div>

    <form class="order-form" id="order-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $order->id }}">
        <input type="hidden" id="_src" value="authors">

        <div class="row">

            <div class="col s12 m12">
                
                <div class="order-info">
                    
                    <p class="title">Información del pedido</p>

                    <table class="table products">
                        <thead>
                            <tr>
                                <th class="thumbnail"></th>
                                <th class="name">Título</th>
                                <th class="price">Precio</th>
                                <th class="qty">Cantidad</th>
                                <th class="total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="thumbnail">
                                        <img src="{{ $product->thumbnail }}" alt="">
                                    </td>
                                    <td class="name">
                                        {!! $product->title !!}
                                    </td>
                                    <td class="price">
                                        {{ COPMoney($product->price) }}
                                    </td>
                                    <td class="qty">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="total">
                                        {{ COPMoney($product->quantity * $product->price) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="totals">
                                <th colspan="4">Precio total del pedido:</th>
                                <td class="total">{{ COPMoney($order->amount) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
            
            <div class="col s12 m12 l8">
                
                <div class="box user-info">
                    <p class="title">Información del usuario:</p>

                    <div class="info">
                        <table class="table">
                            <tr>
                                <th>Nombre completo:</th>
                                <td>{!! $order->address->name !!} {!! $order->address->lastname !!}</td>
                            </tr>

                            <tr>
                                <th>Correo electrónico:</th>
                                <td>{!! $order->address->email !!}</td>
                            </tr>

                            <tr>
                                <th>Teléfono de celular:</th>
                                <td>{!! $order->address->mobile !!}</td>
                            </tr>

                            @if ($order->address->phone !== null)
                                <tr>
                                    <th>Teléfono fijo:</th>
                                    <td>{!! $order->address->phone !!}</td>
                                </tr>
                            @endif

                            <tr>
                                <th>País:</th>
                                <td>{!! $order->address->country !!}</td>
                            </tr>

                            <tr>
                                <th>Ciudad:</th>
                                <td>{!! $order->address->city !!}</td>
                            </tr>

                            <tr>
                                <th>Dirección:</th>
                                <td>{!! $order->address->address !!}</td>
                            </tr>

                            @if ($order->address->postal_code !== null)
                                <tr>
                                    <th>Código postal:</th>
                                    <td>{!! $order->address->postal_code !!}</td>
                                </tr>
                            @endif

                            @if ($order->address->extra_address !== null)
                                <tr>
                                    <th>Dir. extra:</th>
                                    <td>{!! $order->address->extra_address !!}</td>
                                </tr>
                            @endif

                            @if ($order->address->aditionals !== null)
                                <tr>
                                    <th>Notas adicionales:</th>
                                    <td>{!! $order->address->aditionals !!}</td>
                                </tr>
                            @endif

                        </table>
                    </div>
                </div>

            </div>

            <div class="col s12 m12 l4">
                <div class="box order-states">
                    <p class="title">Estado del pedido</p>
                    <p>El estado de este pedido es:</p>
                    <p class="state {{ strtolower($order->state) }}">{!! $state_text !!}</p>
                    <p><a class="button primary modal-trigger" href="#order-modal">Cambiar estado</a></p>
                </div>
            </div>

        </div>

    </form>
@endsection