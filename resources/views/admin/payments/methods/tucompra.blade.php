@extends('admin.layouts.account')

@section('title', 'Configuración TuCompra - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/settings/globals.js') }}"></script>
@endsection

@section('contentClass', 'all-books')
@section('content')

<div class="loader top hidde">
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
</div>

<div class="loader top hidde">
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
</div>

<div class="row single section-header valign-wrapper">
	<div class="col s12 m10 l10">
		<p class="title">Configuración TuCompra</p>
	</div>
	<div class="col s12 m2 l2 actions"></div>
</div>

<table class="settings-table">
	<tbody>
		
		<tr class="subtitle">
			<td colspan="2">Ajustes básicos</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="payment_method">País activo:</label>
			</td>
			<td class="option_value">
				<select name="payment_method" id="payment_method" class="select2-normal">
					<option disabled selected value="0">Seleccione un medio de pago</option>
					<option @if (get_option('payment_method') == 'TUCOMPRA') selected @endif value="TUCOMPRA">TuCompra</option>
					<option @if (get_option('payment_method') == 'PAYPAL') selected @endif value="PAYPAL">PayPal</option>
				</select>
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="hola">Título del sitio:</label>
			</td>
			<td class="option_value">
				<input type="text" id="hola" value="@if(get_option('hola') !== 'NULL'){!! get_option('hola') !!}@endif" placeholder="Título del sitio...">
			</td>
		</tr>

	</tbody>
</table>

<div class="fixed-bottom-btns">
    <div class="float-right">
    	<input type="hidden" id="_token" value="{{ csrf_token() }}">
    	<a class="btn-navigation green save-btn">Guardar cambios</a>
    </div>
</div>

@endsection