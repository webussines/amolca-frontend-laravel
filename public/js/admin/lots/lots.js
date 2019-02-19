jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Lotes por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando lotes del _START_ al _END_ de un total de _TOTAL_ lotes",
    "sInfoEmpty":      "Mostrando lotes del 0 al 0 de un total de 0 lotes",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ lotes)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar lotes:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando lotes...",
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

	var table = $('table.lots').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/lots',
	    	data: {
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "id",
	    		className: "image"
            },
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "arriva_date",
	    		className: "arrival_date",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            if(JsonResultRow.arrival_date !== null) {
		            	let date = new Date(JsonResultRow.arrival_date);
		            	return FormattingDate(date);
		            } else {
		            	return 'Sin fecha.';
		            }
                }
	    	},
	    	{ 	
	    		data: "start_sales",
	    		className: "start_sales",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            if(JsonResultRow.start_sales !== null) {
		            	let date = new Date(JsonResultRow.start_sales);
		            	return FormattingDate(date);
		            } else {
		            	return 'Sin fecha.';
		            }
                }
	    	},
	    	{ 	
	    		data: "books",
	    		className: "books",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            return JsonResultRow.books.length;
                }
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            let str = `<a class="edit" href="/am-admin/lotes/${JsonResultRow.id}">
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
				"filename": "Lotes Amolca",
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

	DeleteLot('.data-table tbody', table, SortColumn);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}

const DeleteLot = function(tbody, table, sort) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente el lote: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/lotes/" + data.id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				$('.data-table').DataTable().ajax.reload();

				$('table.lots').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente el lote: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}