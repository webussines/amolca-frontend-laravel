jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Pedidos por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando pedidos del _START_ al _END_ de un total de _TOTAL_ pedidos",
    "sInfoEmpty":      "Mostrando pedidos del 0 al 0 de un total de 0 pedidos",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ pedidos)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar pedidos:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando pedidos...",
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

	var table = $('table.orders').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/orders',
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
	    		data: "address",
	    		className: "title",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.address !== undefined) {
	    				return JsonResultRow.address.name + ' ' + JsonResultRow.address.lastname;
	    			} else {
	    				return '';
	    			}
	    		}
	    	},
	    	{ 	
	    		data: "address",
	    		className: "email",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.address !== undefined) {
	    				return JsonResultRow.address.email;
	    			} else {
	    				return '';
	    			}
	    		}
	    	},
	    	{ 	
	    		data: "country_name",
	    		className: "country"
	    	},
	    	{ 	
	    		data: "id",
	    		className: "products",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.products !== undefined) {
	    				return JsonResultRow.products.length;
	    			} else {
	    				return 0;
	    			}
	    		}
	    	},
	    	{ 	
	    		data: "state",
	    		className: "state",
	    		"render": function (data, type, JsonResultRow, meta) {
                  	switch(JsonResultRow.state) {
                  		case 'PENDING':
                  			return 'Pendiente';
                  		break;
                  		case 'QUEUED_PAYMENT':
                  			return 'Pago pendiente';
                  		break;
                  		case 'PROCESSING':
                  			return 'En proceso';
                  		break;
                  		case 'COMPLETED':
                  			return 'Completado';
                  		break;
                  		case 'CANCELLED':
                  			return 'Cancelado';
                  		break;
                  		case 'FAILED':
                  			return 'Fallido';
                  		break;
                  		case 'REFUNDED':
                  			return 'Reembolsado';
                  		break;
                  		case 'FAILED':
                  			return 'Fallido';
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
		            let str = `<a class="see" href="/am-admin/pedidos/${JsonResultRow.id}">
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