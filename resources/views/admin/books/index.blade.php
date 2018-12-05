@extends('admin.layouts.account')

@section('title', 'Todos los libros - Admin Amolca')

@section('scripts')
<script src="{{ asset('js/admin/books.js') }}"></script>
@endsection

@section('contentClass', 'all-books')
@section('content')

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

			@foreach ($books as $book)
				<tr>
					<td class="image">
						<img src="{{$book->image}}" alt="{{$book->title}}">
					</td>
					<td class="title">
						{{$book->title}}
					</td>
					<td class="specialty">
						{{$book->specialty[1]->title}}
					</td>
					<td class="isbn">
						{{$book->isbn}}
					</td>
					<td class="state">
						@if ($book->state == 'PUBLISHED')
							Publicado
						@endif

						@if ($book->state == 'DRAFT')
							Borrador
						@endif

						@if ($book->state == 'TRASH')
							En papelera
						@endif
					</td>
					<td class="actions">
						<a class="edit" href="/am-admin/libros/{{$book->_id}}">
		                    <span class="icon-mode_edit"></span>
		                </a>

		                <a class="actions">
		                    <span class="icon-trash"></span>
		                </a>
					</td>
				</tr>
			@endforeach

		</tbody>

		<tfoot>
			<tr>
				<td colspan="6">
					<div class="loader hidde">
						<div class="progress">
							<div class="indeterminate"></div>
						</div>
					</div>
					<a id="btn-load-more" class="button primary">Cargar más libros</a>
				</td>
			</tr>
		</tfoot>
	</table>

@endsection