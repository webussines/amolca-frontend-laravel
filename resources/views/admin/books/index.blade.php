@extends('admin.layouts.account')

@section('title', 'Todos los libros - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/books/books.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
@endsection

@section('contentClass', 'all-books')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<input type="hidden" id="_token" value="{{ csrf_token() }}">

	<table class="table data-table books">
		<thead>
			<tr>
				<th class="image">Img.</th>
				<th class="title">Título:</th>
				<th class="specialty">Especialidad:</th>
				<th class="isbn">ISBN:</th>
				<th class="state">Estado:</th>
				<th class="actions">Acciones:</th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			
		</tfoot>
	</table>

@endsection