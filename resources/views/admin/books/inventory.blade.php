@extends('admin.layouts.account')

@section('title', 'Inventario de libros - Admin Amolca')

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/admin/books/inventory.js') }}"></script>
@endsection

@section('contentClass', 'books-inventory')
@section('content')

	<div class="loader hidde">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>

	<!-- Modal Structure -->
	<div id="book-modal" class="modal">
		<div class="modal-content">
			<h4 id="book-title"></h4>
			<form class="book-form">
				<input type="hidden" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="_id" value="">

				<div class="countries">
					<div class="row-country"></div>
				</div>

				<div class="row">
	                <div class="col s12">
	                    <input type="button" id="add-country" class="button primary" value="Agregar un país">
	                </div>
	            </div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
		</div>
	</div>

	<table class="table data-table inventory">
		<thead>
			<tr>
				<th class="title">Título:</th>
				<th class="isbn">ISBN:</th>
				<th class="countries">Paises con precio:</th>
				<th class="versions">Versiones:</th>
				<th class="actions">Acciones:</th>
			</tr>
		</thead>

		<tbody>
		</tbody>

		<tfoot>
			
		</tfoot>
	</table>

@endsection