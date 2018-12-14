@extends('admin.layouts.account')

@section('title', 'Mi cuenta - Admin Amolca')

@section('contentClass', 'dashboard')
@section('content')
	{{ session('user')->_id }}
@endsection