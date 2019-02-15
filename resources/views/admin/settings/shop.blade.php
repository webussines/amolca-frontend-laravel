@extends('admin.layouts.account')

@section('title', 'Configuración de la tienda - Admin Amolca')

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
		<p class="title">Configuración de la tienda</p>
	</div>
	<div class="col s12 m2 l2 actions"></div>
</div>

<table class="settings-table">
	<tbody>
		
		<!--Informacion de AMOLCA PAIS-->
		<tr class="subtitle">
			<td colspan="2">Ajustes básicos de la tienda</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="shop_catalog_mode">Tienda en modo catálogo:</label>
			</td>
			<td class="option_value">
				<select name="shop_catalog_mode" id="shop_catalog_mode" class="select2-normal">
					<option disabled selected value="0">Seleccione una opción</option>
					<option @if (get_option('shop_catalog_mode') == 'SI') selected @endif value="SI">SÍ</option>
					<option @if (get_option('shop_catalog_mode') == 'NO') selected @endif value="NO">NO</option>
				</select>
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="shop_show_prices">Mostrar precios:</label>
			</td>
			<td class="option_value">
				<select name="shop_show_prices" id="shop_show_prices" class="select2-normal">
					<option disabled selected value="0">Seleccione una opción</option>
					<option @if (get_option('shop_show_prices') == 'SI') selected @endif value="SI">SÍ</option>
					<option @if (get_option('shop_show_prices') == 'NO') selected @endif value="NO">NO</option>
				</select>
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="show_top_cart_btn">Mostrar botón de carrito en el <i>"cabezote"</i>:</label>
			</td>
			<td class="option_value">
				<select name="show_top_cart_btn" id="show_top_cart_btn" class="select2-normal">
					<option disabled selected value="0">Seleccione una opción</option>
					<option @if (get_option('show_top_cart_btn') == 'SI') selected @endif value="SI">SÍ</option>
					<option @if (get_option('show_top_cart_btn') == 'NO') selected @endif value="NO">NO</option>
				</select>
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