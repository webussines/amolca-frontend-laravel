@extends('ecommerce.layouts.account')

@section('title', "$user->name: Mi información - Amolca Editorial Médica y Odontológica")

@section('information')
<p class="title">Información personal:</p>

<form>
	<div class="row">
		<div class="col s12 m6 l6">
			<label for="name">Nombre:</label>
			<input id="name" placeholder="Nombre..." type="text" value="{{$user->name}}">
		</div>
		<div class="col s12 m6 l6">
			<label for="lastname">Apellidos:</label>
			<input id="lastname" placeholder="Apellidos..." type="text" value="{{$user->lastname}}">
		</div>
		<div class="col s12 m12 l12">
			<label for="email">Correo electrónico:</label>
			<input id="email" placeholder="Correo electrónico..." type="text" value="{{$user->email}}">
		</div>
		<div class="col s12 m6 l6">
			<label for="mobile">Teléfono celular:</label>
			<input id="mobile" placeholder="Teléfono celular..." type="text" value="{{$user->mobile}}">
		</div>
		<div class="col s12 m6 l6">
			<label for="phone">Número de teléfono:</label>
			<input id="phone" placeholder="Número de teléfono..." type="text" value="{{$user->phone}}">
		</div>
		<div class="col s12 m12 l12">
			<input class="button primary account" type="submit" value="Guardar cambios">
		</div>
	</div>
</form>

@endsection