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

	jQuery.fn.dataTableExt.ofnSearch['string'] = function ( data ) {
		return ! data ?
		    '' :
		    typeof data === 'string' ?
		        data
		            .replace( /\n/g, ' ' )
		            .replace( /[áÁàÀâÂäÄãÃåÅæÆ]/g, 'a' )
		            .replace( /é/g, 'e' )
		            .replace( /í/g, 'i' )
		            .replace( /ó/g, 'o' )
		            .replace( /ú/g, 'u' )
		            .replace( /ê/g, 'e' )
		            .replace( /[íÍìÌîÎïÏîĩĨĬĭ]/g, 'i' )
		            .replace( /ô/g, 'o' )
		            .replace( /è/g, 'e' )
		            .replace( /ï/g, 'i' )
		            .replace( /ü/g, 'u' )
		            .replace( /ç/g, 'c' ) :
		        data;
	};

	var table = $('table.specialties').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/specialties',
	    	data: {
				"inventory": 1,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{
	    		data: "thumbnail",
	    		className: "image",
	    		"render": function (data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.thumbnail !== null && JsonResultRow.thumbnail !== undefined) {
                    	return '<img src="'+ JsonResultRow.thumbnail + '">';
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
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit" href="/am-admin/especialidades/${JsonResultRow.id}">
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
				"filename": "Especialidades Amolca",
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
        var table = $('table.specialties').DataTable();
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    });

	DeleteBook('.data-table tbody', table);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una especialidad');
}

const DeleteBook = function(tbody, table) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente la especialidad: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/especialidades/" + data.id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				let json = JSON.parse(resp);

				if(json.error !== undefined) {
					if (json.error == 'token_expired') {
						let toastMsg = 'Su sesión ha expirado, en segundo será redirigido para iniciar sesión de nuevo.';
						M.toast({html: toastMsg, classes: 'red accent-4 bottom'});

						setTimeout(function() {
							window.location.href = '/am-admin/logout?redirect=';
						}, 5000);
					}
				}

				$('.data-table').DataTable().ajax.reload();

				$('table.specialties').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente la especialidad: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}
