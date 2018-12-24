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
	var table = $('table.users').dataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/users/all',
	    	data: {
	    		"limit": 1000,
				"skip": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 	
	    		data: "name",
	    		className: "name",
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
	    		className: "role"
	    	},
	    	{ 	
	    		data: "country",
	    		className: "country"
	    	},
	    	{ 	
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit" href="/am-admin/usuarios/${JsonResultRow._id}">
				                    <span class="icon-mode_edit"></span>
				                </a>

				                <a class="delete">
				                    <span class="icon-trash"></span>
				                </a>
		                  	`;
                  	return str;
                }
	    	}
	    ]
	})

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un usuario');
}
