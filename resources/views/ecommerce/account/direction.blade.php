@extends('ecommerce.layouts.account')

@section('title', "$user->name: Mi dirección - Amolca Editorial Médica y Odontológica")

@section('information')
<p class="title">Información para envíos y facturación:</p>

<form >
	<div class="row">
		<div class="col s12 m6 l6">
			<label for="email">Correo electrónico:</label>
			<input id="email" name="email" placeholder="Correo electrónico..." type="text">
		</div>
		<div class="col s12 m6 l6">
			<label for="phone">Número de teléfono:</label>
			<input id="phone" name="phone" placeholder="Número de teléfono..." type="text">
		</div>
		<div class="col s12 m6 l6">
			<label for="country">País:</label>
			<input id="country" name="country" placeholder="País..." type="text">
		</div>
		<div class="col s12 m6 l6">
			<label for="state">Ciudad:</label>
			<input id="state" name="state" placeholder="Ciudad..." type="text">
		</div>
		<div class="col s12 m6 l6">
			<label for="address">Dirección:</label>
			<input id="address" name="address" placeholder="Dirección de envío..." type="text">
		</div>
		<div class="col s12 m6 l6">
			<label for="postalCode">Código postal:</label>
			<input id="postalCode" name="postalCode" placeholder="Código postal..." type="text">
		</div>
		<div class="col s12 m12 l12">
			<input class="button primary" type="submit" value="Guardar">
		</div>

	</div>
</form>

@endsection