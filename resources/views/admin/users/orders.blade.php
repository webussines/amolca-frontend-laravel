@extends('admin.layouts.account')

@section('title', "Todos los pedidos de $user->name $user->lastname - Admin Amolca")

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/users/orders.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-orders')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">
	<input type="hidden" id="_email" value="{{ $user->email }}">
	<input type="hidden" id="_id" value="{{ $user->id }}">

	<table class="table data-table orders">
		<thead>
			<tr>
				<th class="image">ID.</th>
				<th class="user">Nombre completo:</th>
				<th class="email">Correo electr&oacute;nico:</th>
				<th class="country">Pa&iacute;s:</th>
				<th class="products"># de productos:</th>
				<th class="state">Estado:</th>
				<th class="actions"></th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			
		</tfoot>
	</table>

@endsection