jQuery(function($) {

	$(document).ready(function() {

		$('.save-btn').on('click', SendFormSettings);

		$('.error-panel .hidde-panel').on('click', function() {
			$('.error-panel').css('display', 'none');
		});

	});

	$('.select2-normal').select2();
	GetCountriesData();

});

const GetCountriesData = () => {

	if ($('#sitecountry')) {
		$('#sitecountry').on('change', () => {

			let url = '/am-admin/countries/title/' + $('#sitecountry').val().toLowerCase();

			console.log(url)

			$.ajax({
				method: 'GET',
				url: url
			}).done( (resp) => {

				console.log(resp)

				resp = JSON.parse(resp);
				let country_id = resp.id;
				$('#sitecountry_id').val(country_id);

			}).catch( (err) => {
				console.log(err)
			})

		});
	}

	$.ajax({
		method: "GET",
		url: '/am-admin/countries/all',
		data: {
			"_token": $('#_token').val()
		}
	}).done((resp) => {

		//console.log(resp)

		let countries = JSON.parse(resp);
		let selected = $('#sitecountry').val();

		//Agregar opciones a la lista 
		for (let i = 0; i < countries.length; i++) {

			let title = countries[i].title.toUpperCase();
			let o = new Option(countries[i].title, title);

			/// jquerify the DOM object 'o' so we can use the html method
			if(title !== selected) {
				$(o).html(title);
				$('#sitecountry').append(o);
			}

		}

		$('.select2-normal').select2();
	}).catch((err) => {
		console.log(err)
	})
}

const SendFormSettings = () => {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let send = {
		"body": GetFormFields(),
		"_token": $('#_token').val()
	}

	$.ajax({
		method: 'PUT',
		url: '/api/options',
		data: send
	}).done(function(resp) {

		//console.log(resp)

		switch(resp.status) {
			case 200:
				location.reload();
				break;
		}

	}).catch(function(err) {

		//console.log(err)

		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

		window.scrollTo(0,0)

		$('.error-panel').css('display', 'block');
		$('.error-panel #error-title .message').html(err.responseJSON.exception);
		$('.error-panel #error-file .message').html(err.responseJSON.file);
		$('.error-panel #error-line .message').html(err.responseJSON.line);
		$('.error-panel #error-message .message').html(err.responseJSON.message);

	})

}

// Obtener todos los campos del formulario
const GetFormFields = () => {

	let fields = [];

	$('tr.options').each(function() {

		let column = $(this).find('.option_value');
		let input = $(column).find('input');

		if (input.length < 1) {
			input = $(column).find('select')
		}

		let key = $(input).attr('id');
		let val = $(input).val();

		// Si el campo de la opción está vacío, lo nombramos como "NULL"
		if(val == '' || val == ' ') {
			val = 'NULL';
		}

		let option = { "option_name": key, "option_value": val };

		fields.push(option);

	});

	return fields;

}