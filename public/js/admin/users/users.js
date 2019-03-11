jQuery(function($){
	$(document).ready(function() {

		createDataTable();

	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Usuarios por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
    "sInfoEmpty":      "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ usuarios)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar usuarios:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando usuarios...",
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

	let src = $('#_src').val();
	let route = '/am-admin/users/all';

	switch (src) {
		case 'clients':
			route = '/am-admin/users/clients';
			break;
	}

	$.fn.dataTable.ext.errMode = (e, textStatus, errorThrown) => {
		console.log(e.jqXHR.responseJSON)
		if( typeof e.jqXHR.responseJSON.data !== 'object') {
			let error = JSON.parse(e.jqXHR.responseJSON.data);

	        if(error.error !== undefined) {
	        	switch (error.error) {
	        		case 'token_expired':
	        			window.location.href = '/logout';
	        			break;
	        		default:
	        			window.location.href = '/logout';
	        			break;
	        	}
	        }
		}
    }

	var table = $('table.users').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: route
	    },
	    columns: [
	    	{ 	
	    		data: "name",
	    		className: "title",
	    		"render": function (data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.lastname !== null) {
                    	return JsonResultRow.name + ' ' + JsonResultRow.lastname;
                    } else {
                    	return JsonResultRow.name;
                    }
                }
	    	},
	    	{ 	
	    		data: "email",
	    		className: "email"
	    	},
	    	{ 	
	    		data: "role",
	    		className: "role",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			switch (JsonResultRow.role) {
	    				case 'CLIENT':
	    					return 'Cliente';
	    					break;
	    				default:
	    					return JsonResultRow.role;
	    					break;
	    			}
                }
	    	},
	    	{ 	
	    		data: "country_name",
	    		className: "country"
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="see" href="/am-admin/usuarios/${JsonResultRow.id}">
				                    <span class="icon-mode_edit"></span>
				                </a>`;

				    if(src == 'clients') {
				    	str += `<a class="see" href="/am-admin/usuarios/${JsonResultRow.id}/pedidos">
				                    Historial
				                </a>`;
				    }

                  	return str;
                }
	    	}
	    ],
	    dom: "Blfrtip",
		buttons: [
			{
				"extend": 'excel',
				"text": 'Exportar a Excel',
				"className": "button primary",
				"filename": "Usuarios - Amolca",
				"exportOptions": {
					"modifier": {
						"order":  'current',
						"page":   'all',
						"search": 'none',
					}
				}
            }
		]
	})

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un usuario');
}
