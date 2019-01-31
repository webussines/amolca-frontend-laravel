@extends('admin.layouts.account')

@section('title', 'Todos los pedidos - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/orders/orders.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
@endsection

@section('contentClass', 'all-orders')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

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