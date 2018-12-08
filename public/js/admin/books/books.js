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
	var table = $('table.books').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/books/all',
	    	data: {
	    		"limit": 300,
				"skip": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "image",
	    		className: "image",
	    		"render": function (data, type, JsonResultRow, meta) {
                    return '<img src="'+ JsonResultRow.image + '">';
                } 
            },
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "specialty",
	    		className: "specialty",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.specialty.length > 1) {
	    				return JsonResultRow.specialty[1].title;
	    			} else {
	    				return JsonResultRow.specialty[0].title;
	    			}

	    		}
	    	},
	    	{ 	
	    		data: "isbn",
	    		className: "isbn"
	    	},
	    	{ 	
	    		data: "author[0].name",
	    		className: "author",
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
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			//console.log(JsonResultRow)
	    			let str = `<a class="edit" href="/am-admin/libros/${JsonResultRow._id}">
				                    <span class="icon-mode_edit"></span>
				                </a>

				                <a class="delete">
				                    <span class="icon-trash"></span>
				                </a>
		                  	`;
                  	return str;
                }
	    	},
	    ]
	});

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');

	let btnLoadMore = `<div class="cont-btn-load-more">
							<label>Cargar más libros:</label>
							<div>
								<input id="btn-load-more" class="button primary" disabled="disabled" value="Cargar 300 libros más">
							</div>
						</div>`;

	$('#DataTables_Table_0_length').before(btnLoadMore);

	$('table.books').DataTable().on('draw', function() {
		$('#btn-load-more').removeAttr('disabled');
	})
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