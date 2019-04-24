jQuery(function($){
	$(document).ready(function() {

		createDataTable();

	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Eventos por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando eventos del _START_ al _END_ de un total de _TOTAL_ eventos",
    "sInfoEmpty":      "Mostrando eventos del 0 al 0 de un total de 0 eventos",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ eventos)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar eventos:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando eventos...",
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

	var table = $('table.events').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/events',
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
                    return '<img src="'+ JsonResultRow.thumbnail + '">';
                }
            },
	    	{
	    		data: "title",
	    		className: "title"
	    	},
	    	{
	    		data: "event_date",
	    		className: "date",
	    		render: function (data, type, JsonResultRow, meta) {

	    			let event_date = '';

	    			JsonResultRow.meta.forEach( function(element, index) {
	    				if(element.key == 'event_date') {
	    					event_date = element.value;
	    				}
	    			});

	    			let date = new Date(event_date);

                  	return FormattingDate(date);
                }
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
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
		            let str = `<a class="edit" href="blog/${JsonResultRow.id}">
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
				"filename": "Eventos - Amolca",
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
        var table = $('table.blog').DataTable();
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    });

	DeletePost('.data-table tbody', table, SortColumn);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar una publicacion');
}

const DeletePost = function(tbody, table, sort) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente el evento: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/eventos/" + data.id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				$('.data-table').DataTable().ajax.reload();

				$('table.events').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente el evento: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}
