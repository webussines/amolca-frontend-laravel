@extends('ecommerce.layouts.site')

@section('title', 'Iniciar sesión - Amolca Editorial Médica y Odontológica')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/ecommerce/auth.js') }}"></script>
@endsection

@section('contentClass', 'page-container auth')
@section('content')

<div class="auth-container">

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<div class="content">
		<ul class="tabs tabs-fixed-width">
	        <li class="tab">
	            <a class="active" href="#login">Iniciar sesión</a>
	        </li>
	        <li class="tab">
	            <a href="#register">Registrarse</a>
	        </li>
	    </ul>

	    <div id="login" class="content-tabs">
	    	<div class="loader hidde">
			    <div class="progress">
			        <div class="indeterminate"></div>
			    </div>
			</div>
			<form id="login-form">
				<div class="row">
					<div class="col s12 m12 l12">
						<label for="login-username">Correo electrónico:</label>
						<input id="login-username" autocomplete="off" placeholder="Escribe tu correo electrónico" type="email">
					</div>
					<div class="col s12 m12 l12">
						<label for="login-password">Contraseña:</label>
						<input id="login-password" placeholder="Escribe tu contraseña" type="password">
					</div>
					<div class="col s12 m12 l12">
						<p class="error global-error">Error</p>
					</div>
					<div class="col s12 m12 l12">
						<input class="button primary" type="submit" value="Iniciar sesión">
					</div>
				</div>
			</form>
		</div>

		<div id="register" class="content-tabs">
			<form id="register-form">
				<div class="row">
					<div class="col s12 m6 l6">
						<label for="name">Nombres:</label>
						<input autocomplete="off" id="name" placeholder="Escribe tu nombre..." type="text">
					</div>
					<div class="col s12 m6 l6">
						<label for="lastname">Apellidos:</label>
						<input autocomplete="off" id="lastname" placeholder="Escribe tu apellido..." type="text">
					</div>
					<div class="col s12 m12 l12">
						<label for="email">Correo electrónico:</label>
						<input autocomplete="off" id="email" placeholder="Escribe tu correo electrónico..." type="email">
					</div>
					<div class="col s12 m12 l12">
						<label for="password">Contraseña:</label>
						<input id="password" placeholder="Escribe tu contraseña..." type="password">
					</div>
					<div class="col s12 m12 l12">
						<label for="repassword">Confirmar contraseña:</label>
						<input id="repassword" placeholder="Confirma tu contraseña..." type="password">
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