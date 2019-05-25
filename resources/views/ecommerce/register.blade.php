@extends('ecommerce.layouts.site')

@section('title', 'Registrarse - Amolca Editorial Médica y Odontológica')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/ecommerce/register.js') }}"></script>
@endsection

@section('contentClass', 'page-container auth register')
@section('content')

<div class="auth-container">

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<div class="content">
		<ul class="tabs-menu">
	        <li class="tab">
	            <a href="/iniciar-sesion">Iniciar sesión</a>
	        </li>
	        <li class="tab">
	            <a class="active" href="/registrarse">Registrarse</a>
	        </li>
	    </ul>

		<div id="register" class="content-tabs">
			<div class="loader hidde">
			    <div class="progress">
			        <div class="indeterminate"></div>
			    </div>
			</div>
			<form id="register-form">
				<div class="row">
					<div class="col s12 m6 l6">
						<label for="name">Nombres:</label>
						<input autocomplete="off" class="required-field" id="name" placeholder="Escribe tu nombre..." type="text">
						<p id="error-name" class="error"></p>
					</div>
					<div class="col s12 m6 l6">
						<label for="lastname">Apellidos:</label>
						<input autocomplete="off" class="required-field" id="lastname" placeholder="Escribe tu apellido..." type="text">
						<p id="error-lastname" class="error"></p>
					</div>
					<div class="col s12 m12 l12">
						<label for="email">Correo electrónico:</label>
						<input autocomplete="off" class="required-field" id="email" placeholder="Escribe tu correo electrónico..." type="email">
						<p id="error-email" class="error"></p>
					</div>
					<div class="col s12 m12 l12">
						<label for="password">Contraseña:</label>
						<input id="password" class="required-field" placeholder="Escribe tu contraseña..." type="password">
						<p id="error-password" class="error"></p>
					</div>
					<div class="col s12 m12 l12">
						<label for="repassword">Confirmar contraseña:</label>
						<input id="repassword" class="required-field" placeholder="Confirma tu contraseña..." type="password">
						<p id="error-repassword" class="error"></p>
					</div>
					<div class="col s12 m12 l12 terms-condition">
						<label>
					        <input type="checkbox" id="tersm-condition" class="required" />
					        <span>Acepto los <a href="/terminos-y-condiciones">Términos y condiciones</a></span>
					    </label>
					</div>
					<div class="col s12 m12 l12">
						<p class="error global-error">Error</p>
					</div>
					<div class="col s12 m12 l12">
						<input class="button primary" type="submit" value="Crear cuenta">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
