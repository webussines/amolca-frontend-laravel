@extends('admin.layouts.account')

@section('title', 'Todos los distribuidores - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/dealers/dealers.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-dealers')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<table class="table data-table dealers">
		<thead>
			<tr>
				<th class="id">ID.</th>
				<th class="title">Nombre de la empresa:</th>
				<th class="code">Contacto:</th>
				<th class="affected">Teléfono:</th>
				<th class="type">Correo:</th>
				<th class="actions"></th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			
		</tfoot>
	</table>

@endsection