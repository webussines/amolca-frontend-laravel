@extends('admin.layouts.account')

@section('title', 'Ajustes generales - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/settings/globals.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
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
		<p class="title">Ajustes generales</p>
	</div>
	<div class="col s12 m2 l2 actions"></div>
</div>

<ul class="tabs top-tabs">
    <li class="tab">
        <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
    </li>
    <li class="tab">
        <a href="#country">Información {{env('APP_COUNTRY')}}</a>
    </li>
    <li class="tab">
        <a href="#casa-matriz">Información Casa Matriz</a>
    </li>
</ul>

<div class="error-panel card-panel grey lighten-2">

	<div class="hidde-panel">Ocultar panel</div>
	
	<p id="error-title">
		<b>Exception:</b> <span class="message"></span>
	</p>
	<p id="error-file">
		<b>File:</b> <span class="message"></span>
	</p>
	<p id="error-line">
		<b>Line:</b> <span class="message"></span>
	</p>
	<p id="error-message">
		<b>Message:</b> <span class="message"></span>
	</p>
</div>

<div id="ajustes-basicos" class="content-tabs">

	<table class="settings-table">
		<tbody>
			
			<!--Informacion de AMOLCA PAIS-->
			<tr class="subtitle">
				<td colspan="2">Ajustes básicos del sitio</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="sitename">Título del sitio:</label>
				</td>
				<td class="option_value">
					<input type="text" id="sitename" value="@if(get_option('sitename') !== 'NULL'){{ get_option('sitename') }}@endif" placeholder="Título del sitio...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="sitedescription">Descripción del sitio:</label>
				</td>
				<td class="option_value">
					<input type="text" id="sitedescription" value="@if(get_option('sitedescription') !== 'NULL'){{ get_option('sitedescription') }}@endif" placeholder="Descripción del sitio...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="admin_email">Correo electrónico:</label>
				</td>
				<td class="option_value">
					<input type="text" id="admin_email" value="@if(get_option('admin_email') !== 'NULL'){{ get_option('admin_email') }}@endif" placeholder="Correo electrónico...">
					<span>Esta dirección está siendo utilizada con propósitos administrativos.</span>
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="dateformat">Formato de fecha:</label>
				</td>
				<td class="option_value">
					<input type="text" id="dateformat" value="@if(get_option('dateformat') !== 'NULL'){{ get_option('dateformat') }}@endif" placeholder="Formato de fecha...">
					<span>Por defecto se toma el formato:</span> <code>j F, Y</code>. <b>Vista prevía: </b> @php
						{{ echo Date::now()->format('j F, Y'); }}
					@endphp
				</td>
			</tr>

		</tbody>
	</table>

</div>

<div id="country" class="content-tabs">

	<table class="settings-table">
		<tbody>
			
			<!--Informacion de AMOLCA PAIS-->
			<tr class="subtitle">
				<td colspan="2">Información de Amolca {{ env('APP_COUNTRY') }}</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="amolca_address"><b>Dirección</b> de Amolca <b>{{ env('APP_COUNTRY') }}</b>:</label>
				</td>
				<td class="option_value">
					<input type="text" id="amolca_address" value="@if(get_option('amolca_address') !== 'NULL'){{ get_option('amolca_address') }}@endif" placeholder="Información de Amolca {{ env('APP_COUNTRY') }}...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="amolca_address_link">Link de google maps de Amolca <b>{{ env('APP_COUNTRY') }}</b>:</label>
				</td>
				<td class="option_value">
					<input type="text" id="amolca_address_link" value="@if(get_option('amolca_address_link') !== 'NULL'){{ get_option('amolca_address_link') }}@endif" placeholder="Link de google maps de Amolca {{ env('APP_COUNTRY') }}...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="amolca_phone"><b>Teléfono</b> de Amolca <b>{{ env('APP_COUNTRY') }}</b>:</label>
				</td>
				<td class="option_value">
					<input type="text" id="amolca_phone" value="@if(get_option('amolca_phone') !== 'NULL'){{ get_option('amolca_phone') }}@endif" placeholder="Teléfono de Amolca {{ env('APP_COUNTRY') }}...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="amolca_phone_link">Link de llamada para Amolca <b>{{ env('APP_COUNTRY') }}</b>:</label>
				</td>
				<td class="option_value">
					<input type="text" id="amolca_phone_link" value="@if(get_option('amolca_phone_link') !== 'NULL'){{ get_option('amolca_phone_link') }}@endif" placeholder="Link de llamada para Amolca {{ env('APP_COUNTRY') }}...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="amolca_email"><b>Correo de contacto</b> de Amolca <b>{{ env('APP_COUNTRY') }}</b>:</label>
				</td>
				<td class="option_value">
					<input type="text" id="amolca_email" value="@if(get_option('amolca_email') !== 'NULL'){{ get_option('amolca_email') }}@endif" placeholder="Correo de contacto de Amolca {{ env('APP_COUNTRY') }}...">
				</td>
			</tr>
		</tbody>
	</table>

</div>

<div id="casa-matriz" class="content-tabs">

	<table class="settings-table">
		<tbody>		
			<!--Informacion de CASA MATRIZ-->
			<tr class="subtitle">
				<td colspan="2">Información de Casa Matriz</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="casa_matriz_address"><b>Dirección</b> de casa matriz:</label>
				</td>
				<td class="option_value">
					<input type="text" id="casa_matriz_address" value="@if(get_option('casa_matriz_address') !== 'NULL'){{ get_option('casa_matriz_address') }}@endif" placeholder="Dirección de casa matriz...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="casa_matriz_address_link">Link de google maps de casa matriz:</label>
				</td>
				<td class="option_value">
					<input type="text" id="casa_matriz_address_link" value="@if(get_option('casa_matriz_address_link') !== 'NULL'){{ get_option('casa_matriz_address_link') }}@endif" placeholder="Link de google maps de casa matriz...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="casa_matriz_phone"><b>Teléfono</b> de casa matriz:</label>
				</td>
				<td class="option_value">
					<input type="text" id="casa_matriz_phone" value="@if(get_option('casa_matriz_phone') !== 'NULL'){{ get_option('casa_matriz_phone') }}@endif" placeholder="Teléfono de casa matriz...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="casa_matriz_phone_link">Link de llamada para casa matriz:</label>
				</td>
				<td class="option_value">
					<input type="text" id="casa_matriz_phone_link" value="@if(get_option('casa_matriz_phone_link') !== 'NULL'){{ get_option('casa_matriz_phone_link') }}@endif" placeholder="Link de llamada para casa matriz...">
				</td>
			</tr>

			<tr class="options">
				<td class="option_name">
					<label for="casa_matriz_email"><b>Correo de contacto</b> de casa matriz:</label>
				</td>
				<td class="option_value">
					<input type="text" id="casa_matriz_email" value="@if(get_option('casa_matriz_email') !== 'NULL'){{ get_option('casa_matriz_email') }}@endif" placeholder="Correo de contacto de casa matriz...">
				</td>
			</tr>
		</tbody>
	</table>

</div>

<div class="fixed-bottom-btns">
    <div class="float-right">
    	<input type="hidden" id="_token" value="{{ csrf_token() }}">
    	<a class="btn-navigation green save-btn">Guardar cambios</a>
    </div>
</div>

@endsection