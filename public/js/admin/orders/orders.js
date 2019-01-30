jQuery(function($){
	$(document).ready(function() {
		createDataTable();

		$.ajax({
			method: 'GET',
			url: '/am-admin/orders',
			data: { 'cart': 0 }
		}).done((resp) => {
			console.log(resp)
		}).catch((err) => {
			console.log(err)
		})
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
	    		data: "products",
	    		className: "products",
	    		render: function(data, type, JsonResultRow, meta) {
	    			return JsonResultRow.products.length;
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

	SingleBookRedirect('.data-table tbody', table, SortColumn);
	DeleteBook('.data-table tbody', table, SortColumn);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}

const SingleBookRedirect = function(tbody, table, sort) {

	$(tbody).on('click', '.edit', function() {
		let data = table.row($(this).parents("tr")).data();

		let ItemIndex = table.row($(this).parents("tr")).index();
		let TableIndexes = table.rows().indexes();
		let IndexArrayKeys = TableIndexes.indexOf(ItemIndex);

		let previous = TableIndexes[IndexArrayKeys - 1];
		let next = TableIndexes[IndexArrayKeys + 1];

		let PreviousRow = table.row(previous).data();
		let NextRow = table.row(next).data();

		let PreviousParam = '?';
		let NextParam = '';
		let SortParam = '';

		if(data._id !== PreviousRow._id) {
			PreviousParam = '?previous=' + PreviousRow._id
		}

		if(data._id !== NextRow._id && PreviousParam !== '?') {
			NextParam = '&next=' + NextRow._id
		} else if(data._id !== NextRow._id && PreviousParam == '?') {
			NextParam = 'next=' + NextRow._id
		}

		if(PreviousParam !== '?' || NextParam !== '') {
			SortParam = '&orderby=' + sort.column + '&order=' + sort.order;
		}

		let RedirectRoute = '/am-admin/pedidos/' + data.id + PreviousParam + NextParam + SortParam;

		window.location.href = RedirectRoute;
	});

}

const DeleteBook = function(tbody, table, sort) {

	$(tbody).on('click', '.delete', function() {

		let data = table.row($(this).parents("tr")).data();

		let alerta = confirm('Seguro que deseas eliminar permanentemente el libro: ' + data.title);

		if(alerta) {
			if($('.loader').hasClass('hidde'))
				$('.loader').removeClass('hidde')

			$.ajax({
				type: "DELETE",
				url: "/am-admin/pedidos/" + data._id,
				data: { "_token": $('#_token').val() }
			}).done(function(resp) {
				console.log(resp)

				$('.data-table').DataTable().ajax.reload();

				$('table.books').DataTable().on('draw', function() {
					if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')

					let toastMsg = 'Se elminó exitosamente el libro: ' + data.title + '.';
					M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
				})

			}).catch(function(err) {
				console.log(err)
			})
		}

	});

}

const getMoreBooks = function() {

	$('#btn-load-more').on('click', function() {
		
		$('#btn-load-more').attr('disabled', 'disabled');

		let table = $('.table').DataTable();

		let skip = table.rows().count();

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		$.ajax({
			type: "POST",
			url: "/am-admin/books/all",
			data: {
				"limit": 300,
				"skip": skip,
				"_token": $('#_token').val()
			}
		}).done(function(resp) {
			//console.log(resp.data)

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')
			
			if(resp.data.length > 0) {

				for (var i = 0; i < resp.data.length; i++) {
					let el = resp.data[i];
					let state = 'Publicado';

					if(el.state == 'PUBLISHED') 
						state = 'Publicado';

					if(el.state == 'DRAFT')
						state = 'Borrador';

					if(el.state == 'TRASH') 
						state = 'En papelera';

					let actionStr = `<a class="edit" href="/am-admin/pedidos/${el._id}">
					                    <span class="icon-mode_edit"></span>
					                </a>
					                <a class="delete">
					                    <span class="icon-trash"></span>
					                </a>`;

					$('.table').DataTable().row.add({
						"image": el.image,
						"title": el.title,
						"specialty": el.specialty,
						"isbn": el.isbn,
						"state": el.state,
						"_id": el._id,
					}).draw();
				}

				$('#btn-load-more').removeAttr('disabled');

				let toastMsg = 'Se agregaron ' + resp.data.length + ' pedidos más.';
				M.toast({html: toastMsg, classes: 'green accent-4 bottom'});

			} else {

				let toastMsg = 'Ya se cargaron todos los pedidos.';
				M.toast({html: toastMsg, classes: 'amber accent-4 bottom'});

			}
				
		});


	});

}