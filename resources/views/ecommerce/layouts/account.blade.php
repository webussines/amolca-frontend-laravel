@extends('ecommerce.layouts.site')

<!--Add single books styles-->
@section('styles')
<link rel="stylesheet" href="{{ asset('css/ecommerce/account.css') }}">
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('contentClass', 'page-container my-account')
@section('content')

<div class="content-container">
	<div class="row">
		<div class="col s12 m12 l3 vmenu">
			@include('ecommerce.layouts.partials.account-menu')
		</div>
		<div class="col s12 m12 l9 information">
			<input type="hidden" id="user_id" value="{{$user->id}}">
			@yield('information')
		</div>
	</div>
</div>
@endsection
