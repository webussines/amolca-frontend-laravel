jQuery(function($){
	$(document).ready(function() {
		createDataTable();

        $.ajax({
            method: 'GET',
            url: '/am-admin/catalogs',
	    	data: {
				"_token": $('#_token').val()
	    	}
        }).done( (resp) => {
            console.log(resp)
        }).catch( (err)=> {
            console.log(err)
        })
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Catalogos por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando catalogos del _START_ al _END_ de un total de _TOTAL_ catalogos",
    "sInfoEmpty":      "Mostrando catalogos del 0 al 0 de un total de 0 catalogos",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ catalogos)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar catalogos:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando catalogos...",
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

	var table = $('table.catalogs').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todos"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/catalogs',
	    	data: {
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
	    		data: "id",
	    		className: "country",
                "render":  function (data, type, JsonResultRow, meta) {
                        let str = 'Todos';
                        if(JsonResultRow.country_name !== undefined) {
                            str = JsonResultRow.country_name;
                        }
                        return str;
                    }
	    	},
	    	{
	    		data: "id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
                        let str = `<a class="edit" href="/am-admin/catalogos/${JsonResultRow.id}">
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
          "filename": "Catalogos Amolca",
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

  DeleteCoupon('.data-table tbody', table);

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');
}

const DeleteCoupon = function(tbody, table) {

  $(tbody).on('click', '.delete', function() {

    let data = table.row($(this).parents("tr")).data();

    let alerta = confirm('Seguro que deseas eliminar permanentemente el catálogo: ' + data.title);

    if(alerta) {
      if($('.loader').hasClass('hidde'))
        $('.loader').removeClass('hidde')

      $.ajax({
        type: "DELETE",
        url: "/am-admin/catalogos/" + data.id,
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

        $('table.catalogs').DataTable().on('draw', function() {
          if(!$('.loader').hasClass('hidde'))
          $('.loader').addClass('hidde')

          let toastMsg = 'Se elminó exitosamente el catalogo: ' + data.title + '.';
          M.toast({html: toastMsg, classes: 'green accent-4 bottom'});
        })

      }).catch(function(err) {
        console.log(err)
      })
    }

  });

}
