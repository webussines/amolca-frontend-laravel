@extends('admin.layouts.auth')

@section('title', 'Amolca Editorial Médica y Odontológica')

@section('contentClass', 'auth')
@section('content')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/auth.css') }}">
@endsection

@section('content')
<div class="loader hidde">
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
</div>

<img src="{{ asset('/img/admin/logo.png') }}" alt="Iniciar sesión" class="logo">
<form id="login-form" class="login-form">
  <div class="form-group">
    <label for="username">Usuario / Correo electrónico</label>
    <input type="text" name="username" id="username" placeholder="Escribe tu correo electrónico...">
  </div>

  <div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" placeholder="Escribe tu contraseña...">
  </div>

  <div *ngIf="error.show" class="form-group">
    <p id="global-error" class="error">error</p>
  </div>

  <div class="form-group">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="submit" class="button primary" value="Iniciar sesión">
  </div>

  <div class="form-group link">
    <p><a href="/recover-password">¿Olvidaste tu contraseña?</a></p>
  </div>

</form>
@endsection
