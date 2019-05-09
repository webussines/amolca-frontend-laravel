@extends('ecommerce.layouts.site')

@php
	$telefono = ( session('user') ) ? session('user')->phone : '';
	$correo = ( session('user') ) ? session('user')->email : '';
	$nombre = ( session('user') ) ? session('user')->name . ' ' . session('user')->lastname : '';
@endphp

@section('fbPixel')
fbq('track', 'Lead');
fbq('track', 'Contact');
@endsection

@section('title', 'Contáctenos - Amolca Editorial Médica y Odontológica')

@section('scripts')
<script src="{{ asset('js/ecommerce/contact.js') }}"></script>
@endsection

@section('contentClass', 'page-container contact')
@section('content')
<div class="section-title">
	<h2>Contacto</h2>
</div>

<div class="content-container">

	<form id="contact-form" class="contact-form">
		<div class="row">

			<div class="form-group col s12 m6 l4">
				<label for="name"><span class="required">*</span> Nombre completo:</label>
				<input type="text" id="name" class="required-field" name="name" placeholder="Nombre completo..." value="{!! $nombre !!}">
				<p id="error-name" class="error"></p>
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="phone"><span class="required">*</span> Número de teléfono / Celular:</label>
				<input type="text" id="phone" class="required-field" name="phone" placeholder="Número de teléfono / Celular..." value="{!! $telefono !!}">
				<p id="error-phone" class="error"></p>
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="email"><span class="required">*</span> Correo eléctronico:</label>
				<input type="text" id="email" class="required-field" name="email" placeholder="Correo eléctronico..." value="{!! $correo !!}">
				<p id="error-email" class="error"></p>
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="city"><span class="required">*</span> Ciudad:</label>
				<input type="text" id="city" class="required-field" name="city" placeholder="Ciudad...">
				<p id="error-city" class="error"></p>
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="address">Dirección de residencia:</label>
				<input type="text" id="address" name="address" placeholder="Dirección de residencia...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="subject"><span class="required">*</span> Asunto del mensaje:</label>
				<input type="text" id="subject" class="required-field" name="subject" placeholder="Asunto del mensaje...">
				<p id="error-subject" class="error"></p>
			</div>

			<div class="form-group col s12 m12">
				<label for="message"><span class="required">*</span> Mensaje:</label>
				<textarea type="text" id="message" class="required-field" name="message" placeholder="Escribe aquí tu mensaje..."></textarea>
				<p id="error-message" class="error"></p>
			</div>

			<!--Terms and conditions column-->
			<div class="col s12 m12 l12 terms-condition">
				<label>
					<input id="terms-conditions" name="terms-conditions" type="checkbox" />
					<span>He leído y acepto los <a href="/terminos-y-condiciones">Términos y condiciones y Políticas de privacidad</a></span>
				</label>
				<p class="global-error error"></p>
			</div>

			<div class="form-group col s12 btns-column">
				<input type="hidden" id="country_name" name="country_name" value="">
				<input type="hidden" id="country_id" name="country_id" value="48">
				<input class="button primary" type="submit" value="Enviar formulario">
				<input type="reset" class="button" value="Limpiar">
			</div>

		</div>
	</form>

</div>


@endsection
