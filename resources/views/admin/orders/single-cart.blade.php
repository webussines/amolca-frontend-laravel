@extends('admin.layouts.account')

@php
    $date_created = new Date($order->created_at);
@endphp

@if ($order->id !== '')
    @section('title', 'Carrito #' . $order->id . ' - Admin Amolca')
@else
    @section('title', 'Crear nuevo carrito - Admin Amolca')
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

    <div class="fixed-action-btn">
        <a class="btn-navigation red previous" href="/am-admin/carritos">
            Ver todos los carritos
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m9 l9">
            <p class="title">Carrito #{{ $order->id }} - Creado el <span>{{ $date_created->format('j F, Y') }}</span></p>
        </div>
        <div class="col s12 m3 l3 actions">
            <a class="btn-navigation red previous" href="/am-admin/carritos">
                Ver todos los carritos
            </a>
        </div>
    </div>

    <form class="order-form" id="order-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $order->id }}">
        <input type="hidden" id="_src" value="authors">

        <div class="row">

            @if (isset($user))
            <div class="col s12 m12 l6">
                <p class="title">Información del usuario</p>

                <table class="table cart-info">
                    <tbody>
                        
                        <tr>
                            <th>Nombre completo:</th>
                            <td>{{ $user->name }} {{ $user->lastname }}</td>
                        </tr>

                        <tr>
                            <th>Correo electrónico:</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        @if ($user->mobile !== null)
                        <tr>
                            <th>Teléfono celular:</th>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        @endif

                        @if ($user->phone !== null)
                        <tr>
                            <th>Teléfono fijo:</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>País de residencia:</th>
                            <td>{{ $user->country }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            @endif

            <div class="col s12 m12 @if (isset($user)) l6 @else l12 @endif">

                <p class="title">Información general del carrito</p>

                <table class="table cart-info">
                    <tbody>
                        
                        <tr>
                            <th>Fecha de creación:</th>
                            <td>{{ $date_created->format('j F, Y') }}</td>
                        </tr>

                        <tr>
                            <th>País desde donde se creó:</th>
                            <td>{{ $order->country_name }}</td>
                        </tr>

                        @if (isset($order->amount))
                            <tr>
                                <th>Precio total del carrito:</th>
                                <td>{{ COPMoney($order->amount) }}</td>
                            </tr>
                        @endif

                        @if (!isset($user))
                            <tr class="important-note">
                                <td colspan="2"><b>Importante:</b> Este carrito lo creó un usuario que no se registró ni dejó sus datos. Por lo tanto no apareceran nombres, números telefonicos, direcciones fisicas o de correo electrónico, etc.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>

            </div>

            <div class="col s12 m12">
                
                <div class="order-info">

                    @if (isset($order->products))

                        <p class="title">Productos</p>

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
                    @endif

                </div>

            </div>

        </div>

    </form>
@endsection