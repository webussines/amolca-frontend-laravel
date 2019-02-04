jQuery(function($){
	$(document).ready(function() {
		createDataTable();
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Cupones por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando cupones del _START_ al _END_ de un total de _TOTAL_ cupones",
    "sInfoEmpty":      "Mostrando cupones del 0 al 0 de un total de 0 cupones",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ cupones)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar cupones:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando cupones...",
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

	var table = $('table.coupons').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/coupons',
	    	data: {
	    		"cart": 0,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 
	    		data: "id",
	    		className: "id"
            },
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "code",
	    		className: "code"
	    	},
	    	{ 	
	    		data: "affected",
	    		className: "affected",
	    		render: function (data, type, JsonResultRow, meta) {
		            switch(JsonResultRow.affected) {
                  		case 'ALL':
                  			return 'Todo';
                  		break;
                  		case 'TAXONOMIE':
                  			return 'Especialidades';
                  		break;
                  		case 'PRODUCT':
                  			return 'Productos';
                  		break;
                      case 'USER':
                        return 'Usuarios';
                      break;
                  		default:
                  			return 'Todo';
                  		break;
                  	}
                }
	    	},
	    	{ 	
	    		data: "discount_type",
	    		className: "type",
	    		render: function (data, type, JsonResultRow, meta) {
		            switch(JsonResultRow.discount_type) {
                  		case 'FIXED':
                  			return 'Fijo en dinero';
                  		break;
                  		case 'PERCENTAJE':
                  			return 'Porcentaje';
                  		break;
                  		default:
                  			return 'Porcentaje';
                  		break;
                  	}
                }
	    	},
	    	{ 	
	    		data: "id",
	    		className: "amount",
	    		render: function (data, type, JsonResultRow, meta) {
	    			switch(JsonResultRow.discount_type) {
                  		case 'FIXED':
                  			return FormatMoney(JsonResultRow.discount_amount, 0, ',', '.', '$', 'before');
                  		break;
                  		case 'PERCENTAGE':
                  			return JsonResultRow.discount_amount + '%';
                  		break;
                  		default:
                  			return FormatMoney(JsonResultRow.discount_amount, 0, ',', '.', '$', 'before');
                  		break;
                  	}
	    		}
	    	},
	    	{ 	
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
            let str = `<a class="edit" href="/am-admin/cupones/${JsonResultRow.id}">
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

  DeleteCoupon('.data-table tbody', table);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}

const DeleteCoupon = function(tbody, table) {

  $(tbody).on('click', '.delete', function() {

    let data = table.row($(this).parents("tr")).data();

    let alerta = confirm('Seguro que deseas eliminar permanentemente el cupón: ' + data.title);

    if(alerta) {
      if($('.loader').hasClass('hidde'))
        $('.loader').removeClass('hidde')

      $.ajax({
        type: "DELETE",
        url: "/am-admin/cupones/" + data.id,
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

        $('table.coupons').DataTable().on('draw', function() {
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