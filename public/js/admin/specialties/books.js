jQuery(function($){
	$(document).ready(function() {
		createDataTable();
		getMoreBooks();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Libros por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando libros del _START_ al _END_ de un total de _TOTAL_ libros",
    "sInfoEmpty":      "Mostrando libros del 0 al 0 de un total de 0 libros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ libros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar libros:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando libros...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

const createDataTable = function() {
	let SortColumn = { column: 'title', order: -1};

	var _div = document.createElement('div');
	jQuery.fn.dataTable.ext.type.search.html = function(data) {
		_div.innerHTML = data;
		return _div.textContent ?
			_div.textContent
				.replace(/[áÁàÀâÂäÄãÃåÅæÆ]/g, 'a')
				.replace(/[çÇ]/g, 'c')
				.replace(/[éÉèÈêÊëË]/g, 'e')
				.replace(/[íÍìÌîÎïÏîĩĨĬĭ]/g, 'i')
				.replace(/[ñÑ]/g, 'n')
				.replace(/[óÓòÒôÔöÖœŒ]/g, 'o')
				.replace(/[ß]/g, 's')
				.replace(/[úÚùÙûÛüÜ]/g, 'u')
				.replace(/[ýÝŷŶŸÿ]/g, 'n') :
			_div.innerText.replace(/[üÜ]/g, 'u')
				.replace(/[áÁàÀâÂäÄãÃåÅæÆ]/g, 'a')
				.replace(/[çÇ]/g, 'c')
				.replace(/[éÉèÈêÊëË]/g, 'e')
				.replace(/[íÍìÌîÎïÏîĩĨĬĭ]/g, 'i')
				.replace(/[ñÑ]/g, 'n')
				.replace(/[óÓòÒôÔöÖœŒ]/g, 'o')
				.replace(/[ß]/g, 's')
				.replace(/[úÚùÙûÛüÜ]/g, 'u')
				.replace(/[ýÝŷŶŸÿ]/g, 'n');
	};

	jQuery.fn.dataTableExt.ofnSearch['string'] = function ( data ) {
		return ! data ?
		    '' :
		    typeof data === 'string' ?
		        data
		            .replace( /\n/g, ' ' )
		            .replace( /[áÁàÀâÂäÄãÃåÅæÆ]/g, 'a' )
		            .replace( /é/g, 'e' )
		            .replace( /í/g, 'i' )
		            .replace( /ó/g, 'o' )
		            .replace( /ú/g, 'u' )
		            .replace( /ê/g, 'e' )
		            .replace( /[íÍìÌîÎïÏîĩĨĬĭ]/g, 'i' )
		            .replace( /ô/g, 'o' )
		            .replace( /è/g, 'e' )
		            .replace( /ï/g, 'i' )
		            .replace( /ü/g, 'u' )
		            .replace( /ç/g, 'c' ) :
		        data;
	};

    let _spe_id = $('#specialty_id').val();

	var table = $('table.books').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/specialties/' + _spe_id + '/books',
	    	data: {
	    		"limit": 1000,
	    		"inventory": 1,
				"_token": $('#_token').val()
	    	}
	    },
	    fnDrawCallback: function(e, dt) {
		    let direction = e.aaSorting[0][1];
		    let columnIndex = e.aaSorting[0][0];
		    let columnName = e.aoColumns[columnIndex].sTitle;

		    columnName = columnName.toLowerCase().replace(/:/gi, '').replace(/\./gi, '');

		    if(columnName !== 'img') {
		    	switch (columnName) {
		    		case 'título':
		    			SortColumn.column = 'title';
		    			break;
		    		case 'especialidad':
		    			SortColumn.column = 'taxonomies.title';
		    			break;
		    		case 'isbn':
		    			SortColumn.column = 'isbn';
		    			break;
		    		case 'estado':
		    			SortColumn.column = 'state';
		    			break;
		    	}

		    	switch (direction) {
			    	case 'asc':
			    		SortColumn.order = 1;
			    		break;
			    	case 'desc':
			    		SortColumn.order = -1;
			    		break;
			    }
		    }
		},
	    columns: [
	    	{
	    		data: "thumbnail",
	    		className: "image",
	    		"render": function (data, type, JsonResultRow, meta) {
                    return '<img src="'+ JsonResultRow.thumbnail + '">';
                }
            },
	    	{
	    		data: "title",
	    		className: "title"
	    	},
	    	{
	    		data: "taxonomies",
	    		className: "specialty",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.taxonomies !== undefined && JsonResultRow.taxonomies.length > 0) {
	    				return JsonResultRow.taxonomies[0].title;
					} else {
	    			    return 'Sin especialidad';
	    			}

	    		}
	    	},
	    	{
	    		data: "isbn",
	    		className: "isbn",
				"render": function (data, type, JsonResultRow, meta) {
					for ( var i in JsonResultRow.datasheet ) {
						if(i == 'isbn') {
							return JsonResultRow.datasheet[i]
						}
					}

					return 'Sin ISBN';
                }
	    	},
	    	{
	    		data: "state",
	    		className: "state",
	    		"render": function (data, type, JsonResultRow, meta) {
                  	switch(JsonResultRow.state) {
                  		case 'PUBLISHED':
                  			return 'Publicado';
                  		break;
                  		case 'DRAFT':
                  			return 'Borrador';
                  		break;
                  		case 'TRASH':
                  			return 'En papelera';
                  		break;
                  		default:
                  			return 'Publicado';
                  		break;
                  	}
                }
	    	},
	    	{
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			//console.log(JsonResultRow)
	    			let str = `<a class="edit" href="/am-admin/especialidades/${_spe_id}/libros/${JsonResultRow.id}?tax=${_spe_id}">
				                    <span class="icon-mode_edit"></span>
				                </a>

				                <a class="delete">
				                    <span class="icon-trash"></span>
				                </a>
		                  	`;
                  	return str;
                }
	    	},
	    ],
	    dom: "Blfrtip",
		buttons: [
			{
				"extend": 'excel',
				"text": 'Exportar a Excel',
				"className": "button primary",
				"filename": "Libros Amolca",
				"exportOptions": {
					"modifier": {
						"order":  'current',
						"page":   'all',
						"search": 'none',
					}
				}
            }
		]
	});

	// Remove accented character from search input as well
    $('.dataTables_filter input[type=search]').keyup( function () {
        var table = $('table.books').DataTable();
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    });

	DeleteBook('.data-table tbody', table, SortColumn);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}

const DeleteBook = function(tbody, table, sort) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente el libro: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/libros/" + data.id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				$('.data-table').DataTable().ajax.reload();

				$('table.books').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente el libro: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}

const getMoreBooks = function() {

	$('#btn-load-more').on('click', function() {

		$('#btn-load-more').attr('disabled', 'disabled');

		let table = $('.table').DataTable();

		let skip = table.rows().count();

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		$.ajax({
			type: "POST",
			url: "/am-admin/books/all",
			data: {
				"limit": 300,
				"skip": skip,
				"_token": $('#_token').val()
			}
		}).done(function(resp) {
			//console.log(resp.data)

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			if(resp.data.length > 0) {

				for (var i = 0; i < resp.data.length; i++) {
					let el = resp.data[i];
					let state = 'Publicado';

					if(el.state == 'PUBLISHED')
						state = 'Publicado';

					if(el.state == 'DRAFT')
						state = 'Borrador';

					if(el.state == 'TRASH')
						state = 'En papelera';

					let actionStr = `<a class="edit" href="/am-admin/libros/${el._id}">
					                    <span class="icon-mode_edit"></span>
					                </a>
					                <a class="delete">
					                    <span class="icon-trash"></span>
					                </a>`;

					$('.table').DataTable().row.add({
						"image": el.image,
						"title": el.title,
						"specialty": el.specialty,
						"isbn": el.isbn,
						"state": el.state,
						"_id": el._id,
					}).draw();
				}

				$('#btn-load-more').removeAttr('disabled');

				let toastMsg = 'Se agregaron ' + resp.data.length + ' libros más.';
				M.toast({html: toastMsg, classes: 'green accent-4 bottom'});

			} else {

				let toastMsg = 'Ya se cargaron todos los libros.';
				M.toast({html: toastMsg, classes: 'amber accent-4 bottom'});

			}

		});


	});

}
