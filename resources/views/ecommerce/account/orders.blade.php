@extends('ecommerce.layouts.account')

@section('title', "$user->name: Mis pedidos - Amolca Editorial Médica y Odontológica")

@section('scripts')
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/ecommerce/account-orders.js') }}"></script>
@endsection

@section('information')
<p class="title">Mis pedidos:</p>

<table class="table data-table orders">
	<thead>
		<tr>
			<th class="id">ID.</th>
			<th class="products"># de productos:</th>
			<th class="state">Estado:</th>
			<th class="total">Total:</th>
			<th class="date">Fecha:</th>
			<th class="actions"></th>
		</tr>
	</thead>

	<tbody>
	</tbody>

	<tfoot>
		
	</tfoot>
</table>

@endsection