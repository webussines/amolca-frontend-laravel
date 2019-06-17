@extends('ecommerce.layouts.account')

@section('title', "$user->name: Mi información - Amolca Editorial Médica y Odontológica")

@section('information')
<div id="change-password-modal" class="modal">
	<div class="loader hidde fixed">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>
	<div class="modal-content">
		<div class="modal-description">
			<h3 class="title">¡Hola! <span class="user">Marlon Lopez</span></h3>
			<p class="text-md">Ingrese su nueva contraseña:</p>
			<div class="form-group">
				<input type="password" id="new-password" placeholder="Escriba su nueva contraseña aquí...">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="button" id="change-password-button" class="button primary" value="Cambiar">
		<a class="modal-close button danger">Cancelar</a>
	</div>
</div>

<p class="title">Información personal:</p>

<form>
	<div class="row">
		<div class="col s12 m6 l6">
			<label for="name">Nombre:</label>
			<input id="name" placeholder="Nombre..." type="text" value="{!! $user->name !!}">
		</div>
		<div class="col s12 m6 l6">
			<label for="lastname">Apellidos:</label>
			<input id="lastname" placeholder="Apellidos..." type="text" value="{!! $user->lastname !!}">
		</div>
		<div class="col s12 m12 l12">
			<label for="email">Correo electrónico:</label>
			<input id="email" placeholder="Correo electrónico..." type="text" value="{!! $user->email !!}">
		</div>
		<div class="col s12 m6 l6">
			<label for="mobile">Teléfono celular:</label>
			<input id="mobile" placeholder="Teléfono celular..." type="text" value="{!! $user->mobile !!}">
		</div>
		<div class="col s12 m6 l6">
			<label for="phone">Número de teléfono:</label>
			<input id="phone" placeholder="Número de teléfono..." type="text" value="{!! $user->phone !!}">
		</div>
		<div class="col s12 m12 l12">
			<input class="button primary account" type="submit" value="Guardar cambios"> <input class="button green" type="button" id="open-modal" value="Cambiar contraseña">
		</div>
	</div>
</form>

@endsection

@section('scripts')
<script src="{{ asset('js/ecommerce/account-change-password.js') }}"></script>
@endsection
