@extends('admin.layouts.account')

@php
    $id = (isset($user->id)) ? $user->id : '';
    $name = (isset($user->name)) ? $user->name : '';
    $lastname = (isset($user->lastname)) ? $user->lastname : '';
    $fullName = $name . ' ' . $lastname;

    $email = (isset($user->email)) ? $user->email : '';
    $role = (isset($user->role)) ? $user->role : '';
    $country = (isset($user->country)) ? $user->country : '';

    $mobile = (isset($user->mobile)) ? $user->mobile : '';
    $phone = (isset($user->phone)) ? $user->phone : '';
    $company = (isset($user->company)) ? $user->company : '';

    $avatar = (isset($user->avatar)) ? $user->avatar : 'https://amolca.webussines.com/uploads/images/no-image.jpg';
    $description = (isset($user->description)) ? $user->description : ' ';

@endphp

@if ($name !== '')
    @section('title', 'Usuario: ' . $fullName . ' - Admin Amolca')
@else
    @section('title', 'Crear nuevo usuario - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=1icfygu7db6ym5ibmufjkk2myppelx6v827sc9rq8xt1eo2n'></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/admin/users/single.js') }}"></script>
@endsection

@section('contentClass', 'single single-author')
@section('content')

    <div class="loader top hidde">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green save-resource">
            <span class="icon-save1"></span>
        </a>
        <a class="btn-floating btn-large red go-all-resources" href="/am-admin/usuarios">
            <span class="icon-cross"></span>
        </a>
    </div>

    <div class="row single section-header valign-wrapper">
		<div class="col s12 m10 l10">
			<p class="title">@if ($name !== '') {{$fullName}} @else Creando nuevo usuario @endif</p>
		</div>
		<div class="col s12 m2 l2 actions">
            <a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="btn-floating btn-large red go-all-resources" href="/am-admin/usuarios">
                <span class="icon-cross"></span>
            </a>
		</div>
	</div>

    <form class="author-form" id="author-form" enctype="multipart/form-data">

        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_action" value="{{ $action }}">
        <input type="hidden" id="_id" value="{{ $id }}">
        <input type="hidden" id="_src" value="users">

        <ul class="tabs top-tabs">
            <li class="tab">
                <a class="active" href="#ajustes-basicos">Ajustes básicos</a>
            </li>
        </ul>

        <div id="ajustes-basicos" class="content-tabs">

            <div class="row">

                <div class="col s12 m5 col-image">

                    <div class="image-wrap">
                        <img id="resource-image" src="{{ $avatar }}" alt="">
                        <label for="image-url">Foto de perfil:</label>
                        <input type="text" id="image-url" name="image-url" placeholder="URL de la imagen..." value="{{ $avatar }}">
                    </div>

                </div>

                <div class="col s12 m7">

                    <div class="form-group col s6 m6">
                        <label for="name"><span class="required">*</span> Nombre del usuario:</label>
                        <input type="text" name="name" id="name" class="required-field" placeholder="Nombre del usuario..." value="{{ $name }}">
                    </div>

                    <div class="form-group col s6 m6">
                        <label for="lastname"><span class="required">*</span> Apellidos del usuario:</label>
                        <input type="text" name="lastname" id="lastname" class="required-field" placeholder="Apellidos del usuario..." value="{{ $lastname }}">
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="email"><span class="required">*</span> Correo electrónico:</label>
                        <input type="text" name="email" id="email" class="required-field" placeholder="Correo electrónico..." value="{{ $email }}">
                    </div>

                    <div class="form-group col s6 m6">
                        <label for="role"><span class="required">*</span> Rol de usuario:</label>
                        <select name="role" id="role" class="normal-select">

                            @php
                                $superadmin = false;
                                $admin = false;
                                $vendedor = false;
                                $autor = false;
                                $editor = false;
                                $cliente = false;

                                switch ($role) {
                                    case 'SUPERADMIN':
                                        $superadmin = true;
                                        break;
                                    
                                    case 'ADMIN':
                                        $admin = true;
                                        break;

                                    case 'SELLER':
                                        $vendedor = true;
                                        break;

                                    case 'AUTHOR':
                                        $autor = true;
                                        break;

                                    case 'EDITOR':
                                        $editor = true;
                                        break;

                                    case 'CLIENT':
                                        $cliente = true;
                                        break;
                                }
                            @endphp

                            <option @if ($superadmin) selected="selected" @endif value="SUPERADMIN">Superadmin</option>
                            <option @if ($admin) selected="selected" @endif value="ADMIN">Admin</option>
                            <option @if ($vendedor) selected="selected" @endif value="SELLER">Vendedor</option>
                            <option @if ($autor) selected="selected" @endif value="AUTHOR">Autor</option>
                            <option @if ($editor) selected="selected" @endif value="EDITOR">Editor</option>
                            <option @if ($cliente) selected="selected" @endif value="CLIENT">Cliente</option>
                        </select>
                    </div>

                    <div class="form-group col s6 m6">
                        <label for="country"><span class="required">*</span> País:</label>
                        <select name="country" id="country" class="select2-normal">
                            @foreach ($countries as $pais)
                                <option value="{{ $pais['title'] }}" @if ($country == strtoupper($pais['title'])) selected="selected" @endif>{{ $pais['title'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($action == 'create')
                        <div class="form-group col s6 m6">
                            <label for="password"><span class="required">*</span> Escriba una contraseña:</label>
                            <input type="password" name="password" id="password" class="required-field" placeholder="Escriba una contraseña...">
                        </div>

                        <div class="form-group col s6 m6">
                            <label for="repassword"><span class="required">*</span> Confirmar contraseña:</label>
                            <input type="password" name="repassword" id="repassword" class="required-field" placeholder="Confirmar contraseña...">
                        </div>
                    @endif

                    <div class="form-group col s6 m6">
                        <label for="mobile">Número de celular:</label>
                        <input type="text" name="mobile" id="mobile" placeholder="Número de celular..." value="{{ $mobile }}">
                    </div>

                    <div class="form-group col s6 m6">
                        <label for="phone">Teléfono fijo:</label>
                        <input type="text" name="phone" id="phone" placeholder="Teléfono fijo..." value="{{ $phone }}">
                    </div>

                    <div class="form-group col s12 m12">
                        <label for="company">Empresa dónde trabaja:</label>
                        <input type="text" name="company" id="company" placeholder="Empresa dónde trabaja..." value="{{ $company }}">
                    </div>

                </div>

                <div class="form-group col s12 m12">
                    <label for="description">Descripción:</label>
                    <textarea name="description" id="description" placeholder="Descripción del usuario...">{{ $description }}</textarea>
                </div>
                
            </div>

        </div>

    </form>
@endsection