@extends('admin.layouts.account')

@section('title', 'Todos los libros - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/books/books.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
@endsection

@section('contentClass', 'all-books')
@section('content')

<div class="loader top hidde">
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
</div>

<div class="row single section-header valign-wrapper">
	<div class="col s12 m10 l10">
		<p class="title">Ajustes globales</p>
	</div>
	<div class="col s12 m2 l2 actions">
	</div>
</div>

<table class="settings-table">
	<tbody>
		<tr class="subtitle">
			<td colspan="2">Información de Casa Matríz</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="casa_matriz_address"><b>Dirección</b> de casa matriz:</label>
			</td>
			<td class="option_value">
				<input type="text" id="casa_matriz_address" value="@if(get_option('casa_matriz_address') !== 'NULL'){{ get_option('casa_matriz_address') }}@endif">
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="casa_matriz_address_link">Link de google maps de casa matriz:</label>
			</td>
			<td class="option_value">
				<input type="text" id="casa_matriz_address_link" value="@if(get_option('casa_matriz_address_link') !== 'NULL'){{ get_option('casa_matriz_address_link') }}@endif">
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="casa_matriz_phone"><b>Teléfono</b> de casa matriz:</label>
			</td>
			<td class="option_value">
				<input type="text" id="casa_matriz_phone" value="@if(get_option('casa_matriz_phone') !== 'NULL'){{ get_option('casa_matriz_phone') }}@endif">
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="casa_matriz_phone_link">Link de llamada para casa matriz:</label>
			</td>
			<td class="option_value">
				<input type="text" id="casa_matriz_phone_link" value="@if(get_option('casa_matriz_phone_link') !== 'NULL'){{ get_option('casa_matriz_phone_link') }}@endif">
			</td>
		</tr>

		<tr class="options">
			<td class="option_name">
				<label for="casa_matriz_email"><b>Correo de contacto</b> de casa matriz:</label>
			</td>
			<td class="option_value">
				<input type="text" id="casa_matriz_email" value="@if(get_option('casa_matriz_email') !== 'NULL'){{ get_option('casa_matriz_email') }}@endif">
			</td>
		</tr>
	</tbody>
</table>

@endsection