@extends('ecommerce.layouts.site')

@section('title', 'Contáctenos - Amolca Editorial Médica y Odontológica')

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
				<input type="text" id="name" name="name" placeholder="Nombre completo...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="phone"><span class="required">*</span> Número de teléfono / Celular:</label>
				<input type="text" id="phone" name="phone" placeholder="Número de teléfono / Celular...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="email"><span class="required">*</span> Correo eléctronico:</label>
				<input type="text" id="email" name="email" placeholder="Correo eléctronico...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="city"><span class="required">*</span> Ciudad:</label>
				<input type="text" id="city" name="city" placeholder="Ciudad...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="address">Dirección de residencia:</label>
				<input type="text" id="address" name="address" placeholder="Dirección de residencia...">
			</div>

			<div class="form-group col s12 m6 l4">
				<label for="subject"><span class="required">*</span> Asunto del mensaje:</label>
				<input type="text" id="subject" name="subject" placeholder="Asunto del mensaje...">
			</div>

			<div class="form-group col s12 m12">
				<label for="message"><span class="required">*</span> Mensaje:</label>
				<textarea type="text" id="message" name="message" placeholder="Escribe aquí tu mensaje..."></textarea>
			</div>

			<!--Terms and conditions column-->
			<div class="col s12 m12 l12 terms-condition">
				<label>
					<input id="terms-conditions" name="terms-conditions" type="checkbox" />
					<span>He leído y acepto los <a href="/terminos-y-condiciones">Términos y condiciones y Políticas de privacidad</a></span>
				</label>
			</div>

			<div class="form-group col s12 btns-column">
				<input class="button primary" type="submit" value="Enviar formulario">
				<input type="reset" class="button" value="Limpiar">
			</div>

		</div>
	</form>

</div>


@endsection