jQuery(function($){

	InitTinyMceEditor();
	
	$(document).on('focusin', function(e) {
	    if ($(e.target).closest(".mce-window, .moxman-window").length) {
	        e.stopImmediatePropagation();
	    }
	});

	$('#add-country').on('click', AddNewCountry)

	$('.save-resource').on('click', SaveBookInfo)

	ResetFormErrors();

	$('.select2-normal').select2();
	$('#autores').select2({
		placeholder: 'Seleccione al menos un autor...'
	});

	// Borrar inventario de cada pais al hacer click sobre el botón de "borrar"
	$('.row.row-country .delete-country').on('click', () => {

		let parent = $(this)[0].activeElement;
		let row = $(parent).parent().parent().parent();

		row.remove();

	});

});

const InitTinyMceEditor = function() {
	tinymce.init({
	    selector: "textarea#description",
        theme: "modern",
        height: 200,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})

	tinymce.init({
	    selector: "textarea.common-editor",
        theme: "modern",
        height: 300,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})
}

//Funcion que devuelve un arreglo con las versiones seleccionadas
const GetCheckedVersions = function() {
	let values = [];

	$('#book-edit input[name="version"]:checked').each(function() {
		values.push($(this).val());
	});

	return values;
}

//Funcion que devuelve un arreglo con las especialidades seleccionadas
const GetCheckedSpecialties = function() {
	let values = [];

	$('#book-edit input[name="specialty"]:checked').each(function() {
		values.push($(this).val());
	});

	return values;
}

//Funcion que devuelve un arreglo con los atributos del libro
const GetAttributes = function() {
	let attrs = [];

	$('.row-attr').each(function() {

		let elem = {};

		elem.name = $(this).find('.attr-name').val();
		elem.value = $(this).find('.attr-value').val();

		attrs.push(elem);

	});

	return attrs;
}

//Funcion que devuelve un arreglo con los precios por país
const GetPrices = function() {
	let prices = [];

	$('.row-country').each(function() {

		//Definiendo variables que deben ser tipo "number"
		let price = $(this).find('.country-price').val();
		let quantity = $(this).find('.country-quantity').val();

		//Definiendo elemento recorrido
		let elem = {};
		elem.post_id = $('#id').val();
		elem.country_id = $(this).find('.country-name').val();
		elem.state = $(this).find('.country-state').val();
		elem.price = 0;
		elem.quantity = 0;

		elem.active_offer = $(this).find('.country-active_offer').val();
		elem.offer_price = $(this).find('.country-offer_price').val();

		//Condicional para parsear el "precio" si es una variable tipo "string"
		/*
		if(typeof price == 'string' && price !== '' && price !== ' ') {
			elem.price = parseInt($(this).find('.country-price').val());
		} else if(price == '' || price == ' ') {
			elem.price = 0;
		}
		*/
		elem.price = $(this).find('.country-price').val().replace(/,/gi, ".");

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

//Function de agregar columna para poner precio en un país nuevo
const AddNewCountry = function() {

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

		let newRow = `<div class="row row-country ${rowClass}">
						<div class="col s12 m4">
					        <label for="name"><span class="required">*</span> País:</label>
					        <select class="country-name select2-normal" name="country-name" id="${rowClass}">
					        </select>
					    </div>
					    <div class="col s12 m2">
					        <label for="price"><span class="required">*</span> Precio:</label>
					        <input type="text" class="country-price" id="price" name="price" placeholder="Precio sin espacios ni caracteres especiales...">
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
					            <input type="button" class="button primary delete-country" value="Borrar">
					        </div>
					    </div>
					    <div class="col s4">
                            <label for="active_offer">Activar oferta:</label>
                            <select name="country-active_offer" id="country-active_offer" class="country-active_offer normal-select">
                                <option value="1">Activa</option>
                                <option selected value="0">Inactiva</option>
                            </select>
                        </div>

                        <div class="col s4">
                            <label for="offer_price">Precio en oferta:</label>
                            <input type="text" class="country-offer_price" id="offer_price" name="offer_price" value="0">
                        </div>
					</div>`;

		let lastRow = $('.content-tabs#precios .row-country:last');
		
		if(lastRow.length > 0) {
		    lastRow.after(newRow);
		} else {
		    $('.content-tabs#precios .row').before(newRow);
		}

		//Agregar opciones a la lista 
		for (let i = 0; i < countries.length; i++) {

			let title = countries[i].title.toUpperCase();
			let o = new Option(countries[i].title, countries[i].id);
			let select = `.${rowClass} .country-name`;

			let flag = true;

			for (let j = 0; j < prices.length; j++) {
				if(prices[j].country_name == title) {
					flag = false;
				}
			}

			/// jquerify the DOM object 'o' so we can use the html method
			if(flag) {
				$(o).html(title);
				$(select).append(o);
			}

		}

		$('.normal-select').formSelect();
		$('.select2-normal').select2();
	});

}

const ResetFormErrors = function() {
	$('.required-field').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

		}

	})

	$('#autores').on('change', function() {

		if($(this).val().length > 0) {

			if($('.select2-selection--multiple').hasClass('field-error'))
				$('.select2-selection--multiple').removeClass('field-error')

		}

	});
}

const SaveBookInfo = function() {

	let flag = true;
	let _action = $('#_action').val();
	let _token = $('#_token').val();
	let _user = $('#_user').val();

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	//Unique values
	let id = $('#id').val();
	let title = $('#title').val();
	let thumbnail = $('#image-url').val();
	let isbn = $('#isbn').val();
	let state = $('#state').val();
	let publication = $('#publication-year').val();
	let pages = $('#number-pages').val();
	let volumes = $('#number-volumes').val();
	let description = tinyMCE.get('description').getContent().replace(/"/gi, "'");
	let index = tinyMCE.get('index').getContent().replace(/"/gi, "'");
	let keyPoints = tinyMCE.get('key-points').getContent().replace(/"/gi, "'");
	let author = $('#autores').val();

	//Multiple values
	let versions = GetCheckedVersions();
	let attributes = GetAttributes();
	let specialties = GetCheckedSpecialties(); 
	let countries = GetPrices();

	if(typeof volumes == 'string') {
		volumes = parseInt(volumes);
	}

	if(typeof publication == 'string') {
		publication = parseInt(publication);
	}

	let book = {
		title: title,
		state: state,
		content: description,
		thumbnail: thumbnail,
		taxonomies: specialties,
		inventory: countries,
		user_id: _user,
		type: 'book',
		meta: [
			{
				"key": "isbn",
				"value": isbn
			},
			{
				"key": "index",
				"value": index
			},
			{
				"key": "key_points",
				"value": keyPoints
			},
			{
				"key": "publication_year",
				"value": publication
			},
			{
				"key": "number_pages",
				"value": pages
			},
			{
				"key": "volumes",
				"value": volumes
			},
			{
				"key": "impresion",
				"value": $('#impresion').val()
			},
			{
				"key": "formato",
				"value": $('#formato').val()
			},
			{
				"key": "tapa",
				"value": $('#tapa').val()
			},
			{
				"key": "author",
				"value": '[' + author.join(',') + ']'
			},
			{
				"key": "version",
				"value": '[' + versions.join(',') + ']'
			},
			{
				"key": "interest",
				"value": '[' + specialties.join(',') + ']'
			}
		]
	}

	let ActionRoute;
	let send;
	
	switch(_action) {
		case 'edit':
		    send = book;
			ActionRoute = '/am-admin/books/edit/' + id;
		break;

		case 'create':
			ActionRoute = '/am-admin/libros';
			book.slug = GenerateSlug(book.title);
			send = [ book ];
		break;
	}

	$('.required-field').each(function(){
		
		let val = $(this).val();

		if(val === ' ' || val === '' || val === null) {
			$(this).addClass('field-error');
			flag = false;
		}

	});

	if($('#autores').val().length < 1) {
		$('.select2-selection--multiple').addClass('field-error');
		flag = false;
	}

	console.log(send);

	if(flag) {
		$.ajax({
			method: 'POST',
			url: ActionRoute,
			data: {
				"body": send,
				"_token": _token
			}
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);
			
			if(data.error !== undefined) {
				if (data.error == 'token_expired') {
					window.location.href = '/am-admin/logout';
				}
			}

			if(data.post !== undefined && data.post.id !== undefined) {
				
				switch(_action) {
					case 'edit':
						location.reload();
					break;
					case 'create':
						window.location.href = '/am-admin/libros/' + data.post.id;
					break;
				}

			}
			
			if(data.posts_id !== undefined && data.posts_id.length > 0) {
			    window.location.href = '/am-admin/libros/' + data.posts_id[0];
			}
		}).catch(function(err) {
			console.log(err)
		})
	} else {

		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

		let toastMsg = 'Debes llenar los campos obligatorios.';
		M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
	}

}