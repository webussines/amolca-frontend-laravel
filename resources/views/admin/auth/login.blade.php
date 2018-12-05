@extends('admin.layouts.auth')

@section('title', 'Amolca Editorial Médica y Odontológica')

@section('contentClass', 'auth')
@section('content')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/auth.css') }}">
@endsection

@section('content')
<img src="{{ asset('/img/admin/logo.png') }}" alt="Iniciar sesión" class="logo">
<form id="login-form" class="login-form">
  <div class="form-group">
    <label for="user">Usuario / Correo electrónico</label>
    <input type="text" name="user" id="user" autocomplete="off" placeholder="Escribe tu correo electrónico...">
  </div>

  <div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" placeholder="Escribe tu contraseña...">
  </div>

  <div *ngIf="error.show" class="form-group">
    <p class="error">error</p>
  </div>

  <div class="form-group">
    <input type="submit" class="button primary" value="Iniciar sesión">
  </div>
  
  <div class="form-group link">
    <p><a href="/recover-password">¿Olvidaste tu contraseña?</a></p>
  </div>
  
</form>
@endsection