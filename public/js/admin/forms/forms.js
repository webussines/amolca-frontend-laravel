jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Formularios por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando formularios del _START_ al _END_ de un total de _TOTAL_ formularios",
    "sInfoEmpty":      "Mostrando formularios del 0 al 0 de un total de 0 formularios",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ formularios)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar formularios:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando formularios...",
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

	var table = $('table.forms').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/forms',
	    	data: {
	    		"cart": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "id",
	    		className: "image"
            },
	    	{ 	
	    		data: "id",
	    		className: "from",
	    		render: function(data, type, JsonResultRow, meta) {
	    			return `${JsonResultRow.name} < ${JsonResultRow.from} >`;
	    		}
	    	},
	    	{ 	
	    		data: "created_at",
	    		className: "date",
	    		render: function(data, type, JsonResultRow, meta) {
	    			return JsonResultRow.created_at;
	    		}
	    	},
	    	{ 	
	    		data: "to",
	    		className: "to"
	    	},
	    	{ 	
	    		data: "country_id",
	    		className: "country"
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            let str = `<a class="see" href="/am-admin/formularios/${JsonResultRow.id}">
				                    Ver
				                </a>
		                  	`;
                  	return str;
                }
	    	},
	    ]
	});

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}