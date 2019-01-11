jQuery(function($) {

	$(document).ready(function() {

		$('.save-btn').on('click', SendFormSettings);

		$('.error-panel .hidde-panel').on('click', function() {
			$('.error-panel').css('display', 'none');
		});

	});

});

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

		switch(resp.status) {
			case 200:
				location.reload();
				break;
		}

	}).catch(function(err) {

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