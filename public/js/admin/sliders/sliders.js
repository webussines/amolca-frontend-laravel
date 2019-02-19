jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});


const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Sliders por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando sliders del _START_ al _END_ de un total de _TOTAL_ sliders",
    "sInfoEmpty":      "Mostrando sliders del 0 al 0 de un total de 0 sliders",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ sliders)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar sliders:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando sliders...",
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
	var table = $('table.sliders').dataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/api-sliders/all',
	    	data: {
	    		"limit": 800,
				"skip": 0
	    	}
	    },
	    columns: [
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "slug",
	    		className: "slug"
	    	},
	    	{ 	
	    		data: "items",
	    		className: "items",
	    		render: function(data, type, JsonResultRow, meta) {
	    			return JsonResultRow.items.length;
	    		}
	    	},
	    	{ 	
	    		data: "country_name",
	    		className: "country"
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
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit" href="/am-admin/sliders/${JsonResultRow.id}">
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
				"filename": "Sliders Amolca",
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

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una autor');
}
