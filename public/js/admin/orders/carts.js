jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Carritos por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando carritos del _START_ al _END_ de un total de _TOTAL_ carritos",
    "sInfoEmpty":      "Mostrando carritos del 0 al 0 de un total de 0 carritos",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ carritos)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar carritos:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando carritos...",
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

	var table = $('table.carts').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/orders/carts',
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
	    		data: "created_at",
	    		className: "state",
	    		"render": function (data, type, JsonResultRow, meta) {
	    			let date = new Date(JsonResultRow.created_at);
                  	return FormattingDate(date);
                } 
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            let str = `<a class="see" href="/am-admin/carritos/${JsonResultRow.id}">
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