jQuery(function($) {

	CreateDataTable();

});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Pedidos por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando Pedidos del _START_ al _END_ de un total de _TOTAL_ Pedidos",
    "sInfoEmpty":      "Mostrando Pedidos del 0 al 0 de un total de 0 Pedidos",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ Pedidos)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar Pedidos:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando Pedidos...",
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

const CreateDataTable = () => {

	let user_id = $('#user_id').val();

	let SortColumn = { column: 'id', order: -1};

	var table = $('table.orders').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/carts/' + user_id
	    },
	    columns: [
	    	{ 
	    		data: "id",
	    		className: "id",
	    		"render": function (data, type, JsonResultRow, meta) {
            return '#'+ JsonResultRow.id;
          }
        },
	    	{ 	
	    		data: "products",
	    		className: "products",
	    		"render": function (data, type, JsonResultRow, meta) {
              return JsonResultRow.products.length;
          } 
	    	},
	    	{ 	
	    		data: "state",
	    		className: "state",
	    		"render": function (data, type, JsonResultRow, meta) {
            	switch(JsonResultRow.state) {
            		case 'CART':
            			return 'Carrito';
            		break;
            		case 'PENDING':
            			return 'Pendiente';
            		break;
            		case 'QUEUED_PAYMENT':
            			return 'Pago en espera';
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
            		case 'EXPIRED':
            			return 'Expirado';
            		break;
            	}
          } 
	    	},
	    	{ 	
	    		data: "created_at",
	    		className: "date",
	    		"render": function (data, type, JsonResultRow, meta) {
              return JsonResultRow.created_at;
          } 
	    	},
	    	{ 	
	    		data: "amountstring",
	    		className: "amount"
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
            let str = `<a class="edit">
	                    <span class="icon-mode_edit"></span>
	                </a>`;
	                
            return str;
          }
	    	},
	    ]
	});

}