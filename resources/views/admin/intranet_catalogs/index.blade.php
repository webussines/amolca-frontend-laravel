@extends('admin.layouts.account')

@section('title', 'Todos los catalogos - Intranet - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/intranet_catalogs/catalogs.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-intranet-catalogs')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<table class="table data-table catalogs">
		<thead>
			<tr>
				<th class="id">ID.</th>
				<th class="title">Título</th>
				<th class="country">País</th>
				<th class="actions"></th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>

		</tfoot>
	</table>

@endsection
