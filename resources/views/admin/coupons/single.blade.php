@extends('admin.layouts.account')

@php

    $id = (isset($coupon->id)) ? $coupon->id : '';
    $title = (isset($coupon->title)) ? $coupon->title : '';
    $slug = (isset($coupon->slug)) ? $coupon->slug : '';
    $code = (isset($coupon->code)) ? $coupon->code : '';
    $description = (isset($coupon->description)) ? $coupon->description : '';
    $start_date = (isset($coupon->start_date)) ? $coupon->start_date : '';
    $expired_date = (isset($coupon->expired_date)) ? $coupon->expired_date : '';
    $limit_of_use = (isset($coupon->limit_of_use)) ? $coupon->limit_of_use : 0;
    $used_count = (isset($coupon->used_count)) ? $coupon->used_count : '';
    $cumulative = (isset($coupon->cumulative)) ? $coupon->cumulative : '';
    $discount_type = (isset($coupon->discount_type)) ? $coupon->discount_type : '';
    $discount_amount = (isset($coupon->discount_amount)) ? $coupon->discount_amount : 0;
    $affected = (isset($coupon->affected)) ? $coupon->affected : '';
    $objects = (isset($coupon->objects)) ? $coupon->objects : [];
    $country_id = (isset($coupon->country_id)) ? $coupon->country_id : '0';
    $country_name = (isset($coupon->country_name)) ? $coupon->country_name : 'Seleccione una opción';

    if( $user_country_name !== '' && $user_country_name !== ' ' ) {
        $country_name = $user_country_name;
    }

    if( $user_country_id !== '' && $user_country_id !== ' ' ) {
        $country_id = $user_country_id;
    }

@endphp

@if ($title !== '')
    @section('title', 'Cupón: ' . $title . ' - Admin Amolca')
@else
    @section('title', 'Creando cupón nuevo - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/single-coupon.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/slug-generator.js') }}"></script>
<script src="{{ asset('js/admin/coupons/single.js') }}"></script>
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
            Guardar cupón
        </a>
        <a class="btn-navigation red previous" href="/am-admin/cupones">
            Ver todos los cupones
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
        <div class="col s12 m7 l7">
            <p class="title"> @if ($title !== '') {!! $title !!} @else Creando nuevo cupón @endif  </p>
        </div>
        <div class="col s12 m5 l5 actions">
            <a class="btn-navigation green save-resource">
                Guardar cupón
            </a>
            <a class="btn-navigation red previous" href="/am-admin/cupones">
                Ver todos los cupones
            </a>
        </div>
    </div>

    <form class="coupon-form" id="coupon-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_user" value="{{ session('user')->id }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_src" value="forms">

        <div class="row">

            <div class="col s12 m12 l10 offset-l1">

                <div class="form-group col s6 m6">
                    <label for="title"><span class="required">*</span> Título del cupón:</label>
                    <input type="text" name="title" id="title" class="required-field" placeholder="Título del cupón..." value="{!! $title !!}">
                    <p id="title-error" class="error"></p>
                </div>

                <div class="form-group col s6 m6">
                    <label for="code"><span class="required">*</span> Código del cupón:</label>
                    <input type="text" name="code" id="code" class="required-field" placeholder="Código del cupón..." value="{{ $code }}">
                    <p id="code-error" class="error"></p>
                </div>

                <div class="form-group col s12 m12">
                    <label for="description"><span class="required">*</span> Descripción del cupón:</label>
                    <textarea name="description" id="description" class="required-field" placeholder="Descripción del cupón...">{{ $description }}</textarea>
                    <p id="description-error" class="error"></p>
                </div>

                <div class="form-group col s6 m6">
                    <label for="country"><span class="required">*</span> País donde estará activo el cupón:</label>

                    @if( session('user')->role == 'SUPERADMIN')
                        <select name="country_id" id="country_id" class="select2-normal required-field">
                            @foreach ($countries as $pais)
                                <option value="{!! $pais->id !!}" @if ($country_id == strtoupper($pais->id)) selected="selected" @endif>{!! $pais->title !!}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" disabled name="country" id="country_name" value="{!! $country_name !!}">
                        <input type="hidden" name="country_id" id="country_id" value="{!! $country_id !!}">
                    @endif
                    <p id="country-error" class="error"></p>
                </div>

                <div class="form-group col s6 m6">
                    <label for="limit_of_use">Limite de uso:</label>
                    <input type="number" name="limit_of_use" id="limit_of_use" class="required-field" placeholder="Limite de uso..." value="{{ $limit_of_use }}">
                    <p class="error"></p>
                </div>

                <div class="form-group col s6 m6">
                    <label for="affected"><span class="required">*</span> Cupón disponible para:</label>
                    <select name="affected" id="affected" class="normal-select">
                        @php
                            $selected = '';
                            $all = '';
                            $taxonomie = '';
                            $product = '';
                            $user = '';

                            switch ($affected) {
                                case 'TAXONOMIE':
                                    $taxonomie = "selected='selected'";
                                    break;
                                case 'PRODUCT':
                                    $product = "selected='selected'";
                                    break;
                                case 'USER':
                                    $user = "selected='selected'";
                                    break;
                                case 'ALL':
                                    $all = "selected='selected'";
                                    break;
                            }
                        @endphp

                        <option {{ $all }} value="ALL">Todo</option>
                        <option {{ $taxonomie }} value="TAXONOMIE">Especialidad</option>
                        <option {{ $product }} value="PRODUCT">Producto</option>
                        <option {{ $user }} value="USER">Usuario</option>
                    </select>
                    <p id="affected-error" class="error"></p>
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="cumulative">Cupón acumulable:</label>
                    <select name="cumulative" id="cumulative" class="normal-select">
                        @php
                            $selected = '';
                            $yes = '';
                            $no = '';

                            switch ($discount_type) {
                                case '0':
                                    $no = "selected='selected'";
                                    break;
                                case '1':
                                    $yes = "selected='selected'";
                                    break;
                            }
                        @endphp

                        <option {{ $no }} value="0">No acumulable</option>
                        <option {{ $yes }} value="1">Acumulable</option>
                    </select>
                    <p id="cumulative-error" class="error"></p>
                </div>

                <div class="col s12 m12 l12">
                    <label for="objects">Recursos que tendrán el cupón:</label>
                    <select name="objects" id="objects" multiple="multiple" @if (count($objects) < 1) disabled="" @endif>
                        @if (count($objects) > 0)
                            @foreach ($objects as $obj)
                                <option value="{{ $obj->id }}" selected="">@if ($affected == 'USER') {!! $obj->name !!} {!! $obj->lastname !!} - {!! $obj->email !!} @else {!! $obj->title !!} @endif</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="discount_type"><span class="required">*</span>Tipo de descuento:</label>
                    <select name="discount_type" id="discount_type" class="normal-select required-field">
                        @php
                            $selected = '';
                            $fixed = '';
                            $percentage = '';
                            $product = '';

                            switch ($discount_type) {
                                case 'FIXED':
                                    $fixed = "selected='selected'";
                                    break;
                                case 'PERCENTAGE':
                                    $percentage = "selected='selected'";
                                    break;
                            }
                        @endphp

                        <option {{ $fixed }} value="FIXED">Monto fijo</option>
                        <option {{ $percentage }} value="PERCENTAGE">Porcentaje</option>
                    </select>
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="discount_amount"><span class="required">*</span>Monto del cupón:</label>
                    <input type="number" name="discount_amount" id="discount_amount" class="required-field" placeholder="Fecha de expiración del cupón..." value="{{ $discount_amount }}">
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="start_date">Fecha de inicio de uso del cupón:</label>
                    <input type="text" name="start_date" id="start_date" class="datepicker" placeholder="Fecha de inicio de uso del cupón..." value="{{ $start_date }}">
                </div>

                <div class="form-group col s12 m12 l6">
                    <label for="expired_date">Fecha de expiración del cupón:</label>
                    <input type="text" name="expired_date" id="expired_date" class="datepicker" placeholder="Fecha de expiración del cupón..." value="{{ $expired_date }}">
                </div>

            </div>

        </div>

    </form>
@endsection
