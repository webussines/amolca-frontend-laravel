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

	<!-- Modal Structure -->
	<div id="book-modal" class="modal modal-fixed-footer">
		<div class="modal-content">
			<div class="loader hidde">
				<div class="progress">
					<div class="indeterminate"></div>
				</div>
			</div>
			<div class="single section-header">
				<p id="book-title" class="title"></p>
			</div>
			<form class="book-form">
				<input type="hidden" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="_id" value="">

				<ul class="tabs top-tabs">
		            <li class="tab">
		                <a class="active" href="#precios">Precios</a>
		            </li>
		            <li class="tab">
		                <a href="#ficha">Ficha técnica</a>
		            </li>
		        </ul>

		        <div id="precios" class="content-tabs">

					<div class="countries">
						<div class="last-row-country"></div>
					</div>

					<div class="row">
		                <div class="col s12">
		                    <input type="button" id="add-country" class="button primary" value="Agregar un país">
		                </div>
		            </div>

		        </div>

		        <div id="ficha" class="content-tabs">
		        </div>

			</form>
		</div>
		<div class="modal-footer">
			<a class="btn-floating btn-large green save-resource">
                <span class="icon-save1"></span>
            </a>
            <a class="modal-close btn-floating btn-large red go-all-resources">
                <span class="icon-cross"></span>
            </a>
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