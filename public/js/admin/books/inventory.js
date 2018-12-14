jQuery(function($){
	$(document).ready(function() {
		createDataTable();
		GetMoreBooks();

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

		//console.log(data)
		var _id = $('#_id').val(data._id);
		var title = $('#book-title').html(data.title);
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
						        <input type="text" readonly name="country-name" class="country-name" id="country-name" value="${co.name}">
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
						        <input type="text" class="country-quantity" id="quantity" name="quantity" placeholder="Escriba la cantidad de libros que hay disponibles" value="${co.quantity}">
						    </div>
						</div>`;

				let lastRow = $('.book-form .countries .last-row-country');

				lastRow.after(newRow);
			}

			$('#ficha').html(SetDataSheet(data));

			$('.modal').modal('open');
			$('.normal-select').formSelect();
			$('.select2-normal').select2();
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

const SetDataSheet = function(data) {
	//Agregar "Ficha tecnica"
	let publication = 0;
	let pages = 0;
	let volumes = 0;

	if(data.publicationYear) {
		publication = data.publicationYear;
	}

	if(data.numberPages) {
		pages = data.numberPages;
	}

	if(data.volume) {
		volumes = data.volume;
	}

	let version = {};

	if(data.version == 'VIDEO') {
		version.video = 'checked="checked"';
	} else {
		version.video = '';
	}

	if(data.version == 'PAPER') {
		version.paper = 'checked="checked"';
	} else {
		version.paper = '';
	}

	if(data.version == 'EBOOK') {
		version.ebook = 'checked="checked"';
	} else {
		version.ebook = '';
	}

	let datasheet = `<div class="row">
						<div class="col s12 col-versions">
				            <div class="version">
				                <p>Versiones:</p>
				            </div>

				            <div class="version">
				                <label for="version-paper">
				                    <input type="checkbox" name="version" id="version-paper" ${version.paper} value="PAPER">
				                    <span>Papel</span>
				                </label>
				            </div>

				            <div class="version">
				                <label for="version-video">
				                    <input type="checkbox" name="version" id="version-video" ${version.video} value="VIDEO">
				                    <span>Vídeo</span>
				                </label>
				            </div>

				            <div class="version">
				                <label for="version-ebook">
				                    <input type="checkbox" name="version" id="version-ebook" ${version.ebook} value="EBOOK">
				                    <span>Ebook</span>
				                </label>
				            </div>
				        </div>
				    </div>`;

	datasheet += `<div class="row">
		                <div class="col s6">
		                    <label for="publication-year"><span class="required">*</span> Año de publicación:</label>
		                    <input type="text" readonly id="publication-year-name" name="publication-year-name" value="Año de publicación">
		                </div>
		                <div class="col s6">
		                    <label for="publication-year"><span class="required">*</span> Valor:</label>
		                    <input type="number" id="publication-year" name="publication-year" value="${publication}">
		                </div>
		            </div>
		            
		            <div class="row">
		                <div class="col s6">
		                    <label for="number-pages"><span class="required">*</span> Número de páginas:</label>
		                    <input type="text" readonly id="number-pages-name" name="number-pages-name" value="Número de páginas">
		                </div>
		                <div class="col s6">
		                    <label for="number-pages"><span class="required">*</span> Valor:</label>
		                    <input type="number" id="number-pages" name="number-pages" value="${pages}">
		                </div>
		            </div>

		            <div class="row">
		                <div class="col s6">
		                    <label for="number-volumes"><span class="required">*</span> Número de tomos:</label>
		                    <input type="text" readonly id="volumes-name" name="volumes-name" value="Número de tomos">
		                </div>
		                <div class="col s6">
		                    <label for="number-volumes"><span class="required">*</span> Valor:</label>
		                    <input type="number" id="number-volumes" name="number-volumes" value="${volumes}">
		                </div>
		            </div>`;

		return datasheet;
}

const SetAttributes = function(data) {

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
						"publicationYear": el.publicationYear,
						"numberPages": el.numberPages,
						"volume": el.volume,
						"actions": actionStr,
						"_id": el._id,
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

const SaveBookInfo = function() {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	//Unique values
	let id = $('#_id').val();
	let publication = $('#publication-year').val();
	let pages = $('#number-pages').val();
	let volumes = $('#number-volumes').val();

	//Multiple values
	let versions = GetCheckedVersions();
	let countries = GetPrices();

	//Formateando valores numericos
	if(typeof pages == 'string') {
		pages = parseInt(pages);
	}

	if(typeof volumes == 'string') {
		volumes = parseInt(volumes);
	}

	if(typeof publication == 'string') {
		publication = parseInt(publication);
	}

	let book = {
		version: versions,
		countries: countries,
		publicationYear: publication,
		numberPages: pages,
		volume: volumes
	}

	$.ajax({
		method: 'POST',
		url: '/am-admin/books/edit/' + id,
		data: {
			"update": book,
			"_token": $('#_token').val()
		}
	}).done(function(resp) {
		console.log(resp)

		let data = JSON.parse(resp);
		//console.log(data)

		if(data._id !== undefined) {

			$('.modal').modal('close');

			let toastMsg = 'Se realizaron los cambios correctamente.';
			M.toast({html: toastMsg, classes: 'green accent-4 bottom'});

			setTimeout(function(){
				location.reload();
			}, 1000);

		} else {
		}
	})
}