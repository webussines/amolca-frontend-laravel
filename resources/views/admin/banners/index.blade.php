@extends('admin.layouts.account')

@section('title', 'Banners - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/banners/banners.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-banners')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<table class="table data-table banners">
		<thead>
			<tr>
				<th class="title">Link de la imagen:</th>
				<th class="slug">Slug:</th>
				<th class="country">País:</th>
				<th class="specialty">Estado:</th>
				<th class="actions">Acciones:</th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			
		</tfoot>
	</table>

@endsection