jQuery(function($){
	$(document).ready(function() {
		createDataTable();
		$('.book-form #add-country').on('click', function() {
			AddNewCountry();
		});
		GetMoreBooks();

		$('.modal').modal({
			onCloseEnd: function() {
				let html = '<div class="row-country"></div>';
				$('.book-form .countries').html(html);
			}
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
	var table = $('table.inventory').DataTable( {
		language: language,
		lengthMenu: [[50, 100, 300, -1], [50, 100, 300, "Todas"]],
	    ajax: {
	    	method: "POST",
	    	url: '/am-admin/books/all',
	    	data: {
	    		"limit": 300,
				"skip": 0,
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
	    		data: "countries",
	    		className: "countries",
	    		render: function(data, type, JsonResultRow, meta) {
	    			if(JsonResultRow.countries.length > 0) {
	    				let names = [];

	    				for (let i = 0; i < JsonResultRow.countries.length; i++) {
	    					let name = JsonResultRow.countries[i].name;
	    					name = name.charAt(0).toUpperCase() + name.slice(1);

	    					names.push(name);
	    				}

	    				return names.join();
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

	$('#DataTables_Table_0_length select').formSelect();
	$('.dataTables_filter input[type="search"]').attr('placeholder', 'Escribe una palabra clave para encontrar un libro');

	let btnLoadMore = `<div class="cont-btn-load-more">
							<label>Cargar más libros:</label>
							<div>
								<input id="btn-load-more" class="button primary" disabled="disabled" value="Cargar 300 libros más">
							</div>
						</div>`;

	$('#DataTables_Table_0_length').before(btnLoadMore);

	$('table.inventory').DataTable().on('draw', function() {
		$('#btn-load-more').removeAttr('disabled');
	});

	UpdateBook('.data-table tbody', table);
}

const UpdateBook = function(tbody, table) {

	$(tbody).on('click', '.edit-book', function() {

		var data = table.row($(this).parents("tr")).data();
		var _id = $('#_id').val(data._id);
		var country = data.countries;

		let number = $('.row-country').length + 1;
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

			for (let c = 0; c < country.length; c++) {
				let co = country[c];
				console.log(co)

				let state = {};

				if(co.state == 'STOCK') {
					state.stock = 'selected';
				} else {
					state.stock = '';
				}

				if(co.state == 'RESERVED') {
					state.reserved = 'selected';
				} else {
					state.reserved = '';
				}

				if(co.state == 'SPENT') {
					state.spent = 'selected';
				} else {
					state.spent = '';
				}

				let newRow = `<div class="row row-country ${rowClass}">
							<div class="col s12 m4">
						        <label for="name"><span class="required">*</span> País:</label>
						        <input type="text" readonly name="country-name" id="country-name" value="${co.name}">
						    </div>
						    <div class="col s12 m2">
						        <label for="price"><span class="required">*</span> Precio:</label>
						        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales..."  value="${co.price}">
						    </div>
						    <div class="col s12 m2">
						        <label for="country-state">Estado:</label>
						        <select class="country-state normal-select" name="country-state" id="country-state">
		                            <option value="STOCK" ${state.stock}>Disponible</option>
					                <option value="RESERVED" ${state.reserved}>Reservado</option>
					                <option value="SPENT" ${state.spent}>Agotado</option>
		                        </select>
						    </div>
						    <div class="col s12 m2">
						        <label for="quantity">Cantidad:</label>
						        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="${co.quantity}">
						    </div>
						    <div class="col s12 m2">
						        <label>Acciones:</label>
						        <div>
						            <button class="button primary delete-attribute">Borrar</button>
						        </div>
						    </div>
						</div>`;

				let lastRow = $('.book-form .countries .row-country');

				lastRow.after(newRow);
			}

			$('.normal-select').formSelect();
			$('.select2-normal').select2();
			$('.modal').modal('open');
		});

	});
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

		let newRow = `<div class="row row-country ${rowClass}">
						<div class="col s12 m4">
					        <label for="name"><span class="required">*</span> País:</label>
					        <select class="country-name select2-normal" name="country-name" id="${rowClass}">
					        </select>
					    </div>
					    <div class="col s12 m2">
					        <label for="price"><span class="required">*</span> Precio:</label>
					        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales..."  value="0">
					    </div>
					    <div class="col s12 m2">
					        <label for="country-state">Estado:</label>
					        <select class="country-state normal-select" name="country-state" id="country-state">
	                            <option value="STOCK" selected>Disponible</option>
				                <option value="RESERVED">Reservado</option>
				                <option value="SPENT">Agotado</option>
	                        </select>
					    </div>
					    <div class="col s12 m2">
					        <label for="quantity">Cantidad:</label>
					        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="0">
					    </div>
					    <div class="col s12 m2">
					        <label>Acciones:</label>
					        <div>
					            <button class="button primary delete-attribute">Borrar</button>
					        </div>
					    </div>
					</div>`;

		let lastRow = $('.book-form .countries .row-country:last');

		lastRow.after(newRow);

		//Agregar opciones a la lista 
		for (let i = 0; i < countries.length; i++) {

			let name = countries[i].name.toUpperCase();
			let o = new Option(name, name);
			let select = `.${rowClass} .country-name`;

			let flag = true;

			for (let j = 0; j < prices.length; j++) {
				if(prices[j].name == name) {
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

//Funcion que devuelve un arreglo con los precios por país
const GetPrices = function() {
	let prices = [];

	$('.countries .row-country').each(function() {

		//Definiendo variables que deben ser tipo "number"
		let price = $(this).find('.country-price').val();
		let quantity = $(this).find('.country-quantity').val();

		//Definiendo elemento recorrido
		let elem = {};
		elem.name = $(this).find('.country-name').val();
		elem.state = $(this).find('.country-state').val();
		elem.price = 0;
		elem.quantity = 0;

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

const GetMoreBooks = function() {

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

					let actionStr = `<a class="edit" href="/am-admin/libros/${el._id}">
					                    <span class="icon-mode_edit"></span>
					                </a>`;

					$('.table').DataTable().row.add({
						"title": el.title,
						"isbn": el.isbn,
						"countries": el.countries,
						"version": el.version,
						"actions": actionStr,
					}).draw();
				}

				$('#btn-load-more').removeAttr('disabled');

				let toastMsg = 'Se agregaron ' + resp.data.length + ' libros más.';
				M.toast({html: toastMsg, classes: 'green accent-4 bottom'});

			} else {

				let toastMsg = 'Ya se cargaron todos los libros.';
				M.toast({html: toastMsg, classes: 'amber accent-4 bottom'});

			}
				
		});


	});

}