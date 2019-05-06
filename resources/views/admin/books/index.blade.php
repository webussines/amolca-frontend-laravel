@extends('admin.layouts.account')

@if ( isset($page_type) && $page_type == 'books' )
	@section('title', 'Todos los libros - Admin Amolca')
@elseif ( isset($page_type) && $page_type == 'specialties' )
	@section('title', $specialty->title . ' - Todos los libros - Admin Amolca')
@endif

@section('styles')
<link rel="stylesheet" href="{{ asset('libs/datatables/css/jquery.dataTables.min.css') }}">
@endsection

@section('scripts')
	@if ( isset($page_type) && $page_type == 'books' )
		<script src="{{ asset('js/admin/books/books.js') }}"></script>
	@elseif ( isset($page_type) && $page_type == 'specialties' )
		<script src="{{ asset('js/admin/specialties/books.js') }}"></script>
	@endif
<script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/js/jszip.min.js') }}"></script>
@endsection

@section('contentClass', 'all-books')
@section('content')

	@if ( isset($page_type) && $page_type == 'specialties' )
		<input type="hidden" name="specialty_id" id="specialty_id" value="{{ $specialty->id }}">
	@endif

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

	@if ( isset($page_type) && $page_type == 'specialties')
		<div class="fixed-action-btn">
            <a class="btn-navigation red" href="/am-admin/especialidades">
                Regresar a especialidades
            </a>
        </div>
	@endif

@endsection
