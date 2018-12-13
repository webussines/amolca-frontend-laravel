@extends('admin.layouts.account')

@section('title', 'Dashboard - Admin Amolca')

@section('contentClass', 'dashboard')
@section('content')

	<form action="/api/upload" method="POST" enctype="multipart/form-data">
		{{ csrf_token() }}

		<input type="file" name="file" id="file">
		<input type="hidden" name="src" id="src" value="authors">

		<input type="submit" value="enviar">
	</form>

@endsection