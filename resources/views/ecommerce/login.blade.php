@extends('ecommerce.layouts.site')

@section('title', 'Iniciar sesión - Amolca Editorial Médica y Odontológica')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/auth.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/ecommerce/login.js') }}"></script>
@endsection

@section('contentClass', 'page-container auth login')
@section('content')

<div class="auth-container">

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<div class="content">
		<ul class="tabs-menu">
	        <li class="tab">
	            <a class="active" href="/iniciar-sesion">Iniciar sesión</a>
	        </li>
	        <li class="tab">
	            <a href="/registrarse">Registrarse</a>
	        </li>
	    </ul>

	    <div id="login" class="content-tabs">
	    	<div class="loader hidde">
			    <div class="progress">
			        <div class="indeterminate"></div>
			    </div>
			</div>
			<form id="login-form">
				<div id="tab-email" class="steps active">
					<p class="title">Iniciar sesión</p>
					<div class="row">
						<div class="col s12 m12 l12">
							<label for="login-username">Correo electrónico:</label>
							<input id="login-username" placeholder="Escribe tu correo electrónico" type="email">
						</div>
						<div class="col s12 m12 l12">
							<p class="error email-error">Error</p>
						</div>
						<div class="col s12 m12 l12">
							<p class="remember-info">
								<a href="#">¿Olvidaste el correo electrónico?</a>
								<a href="/registrarse">Crear una cuenta</a>
							</p>
						</div>
						<div class="col s12 m12 l12">
							<input class="button primary" type="button" id="next-btn" value="Siguiente">
						</div>
					</div>
				</div>

				<div id="tab-password" class="steps">
					<p class="title" id="user-fullname">Stiven Lopez</p>
					<div class="email-sent">
						<div id="user-avatar">M</div>
						<span id="user-email-sent">mstiven013@gmail.com</span>
					</div>
					<div class="col s12 m12 l12">
						<label for="login-password">Contraseña:</label>
						<input id="login-password" placeholder="Escribe tu contraseña" type="password">
					</div>
					<div class="col s12 m12 l12">
						<p class="error password-error">Error</p>
					</div>
					<div class="col s12 m12 l12">
						<p class="remember-info">
							<a href="#">¿Olvidaste tu contraseña?</a>
							<a id="return-to-email">Ingresar otro correo</a>
						</p>
					</div>
					<div class="col s12 m12 l12">

						<!--Form fields for register user from SWS-->
						<input type="hidden" id="register-name" name="name" value="">
						<input type="hidden" id="register-lastname" name="lastname" value="">
						<input type="hidden" id="register-email" name="email" value="">
						<input type="hidden" id="register-role" name="role" value="CLIENT">
						<input type="hidden" id="action-form" name="action-form" value="login">
						<!--End SWS form fields-->

						<input class="button primary" type="submit" value="Iniciar sesión">
					</div>
				</div>

			</form>
		</div>

	</div>
</div>

@endsection
