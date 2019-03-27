jQuery(function($){
	$(document).ready(function() {
		createDataTable();

		$('.book-form #add-country').on('click', function() {
			AddNewCountry();
		});

		$('.modal').modal({
			onCloseEnd: function() {
				let html = '<div class="last-row-country"></div>';
				$('.book-form .countries').html(html);
				$('.book-form #ficha').html('');
				$('#book-title').html('');

				if(!$('.loader').hasClass('hidde'))
					$('.loader').addClass('hidde')
			},
			onOpenEnd: function() {
				$('#book-modal').removeAttr('tabindex');
			}
		});

		$('.save-resource').on('click', function() {
			SaveBookInfo();
		});
	});
});

const language = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Libros por pagina _MENU_",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando libros del _START_ al _END_ de un total de _TOTAL_ libros",
    "sInfoEmpty":      "Mostrando libros del 0 al 0 de un total de 0 libros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ libros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar libros:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando libros...",
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

	var table = $('table.inventory').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "GET",
	    	url: '/am-admin/books',
	    	data: {
	    		"limit": 1200,
	    		"inventory": 1,
				"_token": $('#_token').val()
	    	}
	    },
	    columns: [
	    	{ 	
	    		data: "title",
	    		className: "title"
	    	},
	    	{ 	
	    		data: "isbn",
	    		className: "isbn"
	    	},
	    	{ 	
	    		data: "inventory",
	    		className: "countries",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.inventory.length > 0) {
	    				let titles = [];

	    				for (let i = 0; i < JsonResultRow.inventory.length; i++) {
	    					let title = JsonResultRow.inventory[i].country_name;
	    					title = title.charAt(0).toUpperCase() + title.slice(1);

	    					titles.push(title);
	    				}

	    				return titles.join();
	    			} else {
	    				return 0;
	    			}
	    		}
	    	},
	    	{ 	
	    		data: "versions",
	    		className: "versions",
	    		"render": function (data, type, JsonResultRow, meta) {
	    			let versions = [];

                  	for(let i = 0; i < JsonResultRow.version.length; i++) {
                  		switch(JsonResultRow.version[i]) {
                  			case 'VIDEO':
	                  			versions.push("Vídeo");
	                  		break;
	                  		case 'PAPER':
	                  			versions.push("Papel");
	                  		break;
	                  		case 'EBOOK':
	                  			versions.push("Ebook");
	                  		break;
                  		}
                  	}

                  	return versions.join(', ');
                } 
	    	},
	    	{ 	
	    		data: "_id",
	    		className: "actions",
	    		"render":  function (data, type, JsonResultRow, meta) {
	    			let str = `<a class="edit edit-book">
				                    <span class="icon-mode_edit"></span>
				                </a>`;
                  	return str;
                }
	    	},
	    ]
	});

	// Remove accented character from search input as well
    $('.dataTables_filter input[type=search]').keyup( function () {
        var table = $('table.inventory').DataTable(); 
        table.search(
            jQuery.fn.DataTable.ext.type.search.html(this.value)
        ).draw();
    });

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');

	UpdateBook('.data-table tbody', table);
}

const UpdateBook = function(tbody, table) {

	$(tbody).on('click', '.edit-book', function() {

		let data = table.row($(this).parents("tr")).data();

		let user = {
			id: $('#user_id').val(),
			role: $('#user_role').val(),
			country: $('#user_country').val()
		}

		//console.log(data)

		var _id = $('#_id').val(data.id);
		var title = $('#book-title').html(data.title);
		var country = data.inventory;
			
		let prices = GetPrices();

		for (let c = 0; c < country.length; c++) {

			let number = $('.row-country').length + 1;
			let rowClass = 'country-' + number;
			let co = country[c];
			let state = {};

			if(co.state !== undefined && co.state !== null) {

				switch (co.state) {
					case 'STOCK':
							state.stock = 'selected';
						break;
					case 'RESERVED':
							state.reserved = 'selected';
						break;
					case 'SPENT':
							state.spent = 'selected';
						break;
					default:
						state.stock = '';
						state.reserved = '';
						state.spent = '';
						break;
				}

			}

			let data_tmp = {
				row_class: rowClass,
				ud: co.country_id,
				name: co.country_name,
				state_stock: state.stock,
				state_reserved: state.reserved,
				state_spent: state.spent,
				post_id: co.post_id,
				quantity: co.quantity
			}

			let newRow = `<div class="row row-country ${rowClass}">
						<div class="col s12 m4">
					        <label for="name"><span class="required">*</span> País:</label>
					        <input type="hidden" readonly name="country-id" class="country-id" id="country-id" value="${co.country_id}">
					        <input type="text" readonly name="country-name" class="country-name" id="country-name" value="${co.country_name}">
					    </div>
					    <div class="col s12 m3">
					        <label for="price"><span class="required">*</span> Precio:</label>
					        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales..."  value="${co.price}">
					    </div>
					    <div class="col s12 m3">
					        <label for="country-state">Estado:</label>
					        <select class="country-state normal-select" name="country-state" id="country-state">
	                            <option value="STOCK" ${state.stock}>Disponible</option>
				                <option value="RESERVED" ${state.reserved}>Reservado</option>
				                <option value="SPENT" ${state.spent}>Agotado</option>
	                        </select>
					    </div>
					    <div class="col s12 m2">
					        <label for="quantity">Cantidad:</label>
					        <input type="hidden" readonly name="post-id" class="post-id" id="post-id" value="${co.post_id}">
					        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="${co.quantity}">
					    </div>
					</div>`;

			let lastRow = $('.book-form .countries .last-row-country');

			if(user.role != 'SUPERADMIN') {
				if(user.country == co.country_id) {
					//console.log(co.country_name.toUpperCase())
					lastRow.after(newRow);
				}
			} else {
				lastRow.after(newRow);
			}
		}

		/*
		if(country.length < 1) {

			let newRow = CountryRowTemplate(data_tmp);

			let lastRow = $('.book-form .countries .last-row-country');
		}
		*/

		$('.modal').modal('open');
		$('.normal-select').formSelect();
		$('.select2-normal').select2();

	});
}

const CountryRowTemplate = function (data) {
	let tmp = `<div class="row row-country ${data.row_class}">
					<div class="col s12 m4">
				        <label for="name"><span class="required">*</span> País:</label>
				        <input type="hidden" readonly name="country-id" class="country-id" id="country-id" value="${data.country_id}">
				        <input type="text" readonly name="country-name" class="country-name" id="country-name" value="${data.country_name}">
				    </div>
				    <div class="col s12 m3">
				        <label for="price"><span class="required">*</span> Precio:</label>
				        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales..."  value="${data.price}">
				    </div>
				    <div class="col s12 m3">
				        <label for="country-state">Estado:</label>
				        <select class="country-state normal-select" name="country-state" id="country-state">
			                <option value="STOCK" ${data.state_stock}>Disponible</option>
			                <option value="RESERVED" ${data.state_reserved}>Reservado</option>
			                <option value="SPENT" ${data.state_spent}>Agotado</option>
			            </select>
				    </div>
				    <div class="col s12 m2">
				        <label for="quantity">Cantidad:</label>
				        <input type="hidden" readonly name="post-id" class="post-id" id="post-id" value="${data.post_id}">
				        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="${data.quantity}">
				    </div>
				</div>`;

	return tmp;
}

//Function de agregar columna para poner precio en un país nuevo
const AddNewCountry = function() {

	let number = $('.countries .row-country').length + 1;
	let rowClass = 'country-' + number;

	$.ajax({
		method: "GET",
		url: '/am-admin/countries/all',
		data: {
			"_token": $('#_token').val()
		}
	}).done(function(resp) {
		//console.log(resp)
		let countries = JSON.parse(resp);
		let prices = GetPrices();
		let postId = $('#_id').val();
		console.log(postId)

		let newRow = `<div class="row row-country ${rowClass}">
						<div class="col s12 m4">
					        <label for="name"><span class="required">*</span> País:</label>
					        <select class="country-name select2-normal" name="country-name" id="${rowClass}">
					        </select>
					    </div>
					    <div class="col s12 m3">
					        <label for="price"><span class="required">*</span> Precio:</label>
					        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales..."  value="0">
					    </div>
					    <div class="col s12 m3">
					        <label for="country-state">Estado:</label>
					        <select class="country-state normal-select" name="country-state" id="country-state">
	                            <option value="STOCK" selected>Disponible</option>
				                <option value="RESERVED">Reservado</option>
				                <option value="SPENT">Agotado</option>
	                        </select>
					    </div>
					    <div class="col s12 m2">
					        <label for="quantity">Cantidad:</label>
					        <input type="hidden" readonly name="post-id" class="post-id" id="post-id" value="${postId}">
					        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="0">
					    </div>
					</div>`;

		let lastRow = '';
		if($('.countries .row-country').length > 0) {
			lastRow = $('.book-form .countries .row-country:last');
		} else {
			lastRow = $('.book-form .countries .last-row-country');
		}

		lastRow.after(newRow);

		//Agregar opciones a la lista 
		for (let i = 0; i < countries.length; i++) {

			let name = countries[i].title.toUpperCase();
			let o = new Option(name, countries[i].id);
			let select = `.${rowClass} .country-name`;

			let flag = true;

			for (let j = 0; j < prices.length; j++) {
				if(prices[j].country_id == countries[i].id) {
					flag = false;
				}
			}

			/// jquerify the DOM object 'o' so we can use the html method
			if(flag) {
				$(o).html(name);
				$(select).append(o);
			}

		}

		$('.normal-select').formSelect();
		$('.select2-normal').select2();
	});

}

//Funcion que devuelve un arreglo con las versiones seleccionadas
const GetCheckedVersions = function() {
	let values = [];

	$('#book-modal input[name="version"]:checked').each(function() {
		values.push($(this).val());
	});

	return values;
}

//Funcion que devuelve un arreglo con los precios por país
const GetPrices = function() {
	let prices = [];

	$('.countries .row-country').each(function() {

		//Definiendo variables que deben ser tipo "number"
		let price = $(this).find('.country-price').val();
		let quantity = $(this).find('.country-quantity').val();

		//Definiendo elemento recorrido
		let elem = {};
		elem.post_id = $(this).find('.post-id').val();
		elem.country_name = $(this).find('.country-name').val();
		elem.country_id = $(this).find('.country-id').val();
		elem.state = $(this).find('.country-state').val();
		elem.price = 0;
		elem.quantity = 0;

		if(elem.country_id === undefined) {
			elem.country_id = $(this).find('.country-name').val();
		}

		//Condicional para parsear el "precio" si es una variable tipo "string"
		if(typeof price == 'string' && price !== '' && price !== ' ') {
			elem.price = parseInt($(this).find('.country-price').val());
		} else if(price == '' || price == ' ') {
			elem.price = 0;
		} else {
			elem.price = $(this).find('.country-price').val();
		}

		//Condicional para parsear el "cantidad" si es una variable tipo "string"
		if(typeof quantity == 'string' && quantity !== '' && quantity !== ' ') {
			elem.quantity = parseInt($(this).find('.country-quantity').val());
		} else if(quantity == '' || quantity == ' ') {
			elem.quantity = 0;
		} else {
			elem.quantity = $(this).find('.country-quantity').val();
		}

		prices.push(elem);

	});

	return prices;
}

const SaveBookInfo = function() {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	//Unique values
	let id = $('#_id').val();

	let countries = GetPrices();

	let inventory = countries;

	//return console.log(inventory);

	$.ajax({
		method: 'POST',
		url: '/am-admin/books/inventory',
		data: {
			"body": inventory,
			"_token": $('#_token').val()
		}
	}).done((resp) => {
		console.log(resp)

		let data = JSON.parse(resp);
		//console.log(data)

		if(data.createds !== undefined) {

			$('.modal').modal('close');

			let toastMsg = 'Se realizaron los cambios correctamente.';
			M.toast({html: toastMsg, classes: 'green accent-4 bottom'});

			setTimeout(function(){
				location.reload();
			}, 1000);

		} else {
		}
	}).catch((err) => {
		console.log(err)
	})
}