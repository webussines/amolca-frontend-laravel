jQuery(function($){
	$(document).ready(function() {
		
		createDataTable();

	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Publicaciones por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando publicaciones del _START_ al _END_ de un total de _TOTAL_ publicaciones",
    "sInfoEmpty":      "Mostrando publicaciones del 0 al 0 de un total de 0 publicaciones",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ publicaciones)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar publicaciones:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando publicaciones...",
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

	var table = $('table.blog').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/blogs',
	    	data: {
	    		"inventory": 1,
				"_token": $('#_token').val()
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
		            let str = `<a class="edit" href="blog/${JsonResultRow.id}">
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

	DeletePost('.data-table tbody', table, SortColumn);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una publicacion');
}

const DeletePost = function(tbody, table, sort) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente la publicacion: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/blog/" + data.id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				$('.data-table').DataTable().ajax.reload();

				$('table.blog').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente la publicacion: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}