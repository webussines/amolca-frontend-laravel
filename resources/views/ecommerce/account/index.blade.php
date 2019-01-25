@extends('ecommerce.layouts.account')

@section('title', "$user->name: Mi cuenta - Amolca Editorial M&eacute;dica y Odontol&oacute;gica")

@section('information')
<p class="title">&#161;Hola, <span>{{ $user->name }} @if ($user->lastname !== null) {{ $user->lastname }} @endif</span>&#33;</p>

<p>Desde el panel de administraci&oacute;n de tu cuenta puedes ver tus <a>pedidos</a>, administrar tus <a>direcciones de env&iacute;o y facturaci&oacute;n</a> y editar tu <a>contrase&ntilde;a e informaci&oacute;n personal</a>.</p>

<p><a class="button primary" href="/logout">Cerrar sesi&oacute;n</a></p>
@endsection