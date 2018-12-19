jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Autores por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando autores del _START_ al _END_ de un total de _TOTAL_ autores",
    "sInfoEmpty":      "Mostrando autores del 0 al 0 de un total de 0 autores",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ autores)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar autores:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando autores...",
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
	var table = $('table.authors').dataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/authors/all',
	    	data: {
	    		"limit": 800,
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
	    		data: "name",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "specialty",
	    		className: "specialty",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.specialty.length > 1) {
	    				return JsonResultRow.specialty[1].title;
	    			} else {
	    				return 'Sin especialidad';
	    			}
	    		}
	    	},
	    	{ 	
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit" href="/am-admin/autores/${JsonResultRow._id}">
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
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una autor');
}