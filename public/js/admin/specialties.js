jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Especialidades por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando especialidades del _START_ al _END_ de un total de _TOTAL_ especialidades",
    "sInfoEmpty":      "Mostrando especialidades del 0 al 0 de un total de 0 especialidades",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ especialidades)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar especialidades:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando especialidades...",
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
	var table = $('table.specialties').dataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/specialties/all',
	    	data: {
	    		"limit": 300,
				"skip": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "image",
	    		className: "image",
	    		"render": function (data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.image !== null && JsonResultRow.image !== undefined) {
                    	return '<img src="'+ JsonResultRow.image + '">';
                    } else {
                    	return '<img src="https://amolca.webussines.com/uploads/images/no-image.jpg">';
                    }
                } 
            },
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "slug",
	    		className: "slug"
	    	},
	    	{ 	
	    		data: "specialty",
	    		className: "specialty",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.parent !== undefined && JsonResultRow.parent !== null) {
	    				return JsonResultRow.parent.title;
	    			} else {
	    				return 'Sin padre';
	    			}

	    		}
	    	},
	    	{ 	
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit" href="/am-admin/especialidades/${JsonResultRow._id}">
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

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una especialidad');
}
