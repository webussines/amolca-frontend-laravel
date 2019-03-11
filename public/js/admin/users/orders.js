jQuery(function($){
	$(document).ready(function() {
		createDataTable();

		 $.ajax({
			method: "GET",
			url: '/am-admin/users/' + $('#_id').val() + '/orders',
			data: {
				"cart": 0,
				"_token": $('#_token').val()
			}
		}).done((resp) => {
			console.log(resp)
		}).catch( (err) => {
			console.log(err)
		} )
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
	
	var table = $('table.orders').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/users/' + $('#_id').val() + '/orders',
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
	    ],
	    dom: "Blfrtip",
		buttons: [
			{
				"extend": 'excel',
				"text": 'Exportar a Excel',
				"className": "button primary",
				"filename": "Pedidos Amolca",
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
        var table = $('table.orders').DataTable(); 
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    });

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}