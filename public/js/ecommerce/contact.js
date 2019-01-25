jQuery(function($) {
	ResetRequiredErrors();
	SubmitForm();
});

const SubmitForm = () => {

	$('.contact-form').on('submit', function(e) {
		e.preventDefault();

		let flag = true;

		$('.required-field').each(function() {
			let errorId = '#error-' + $(this).attr('id');

			if($(this).val() == '' || $(this).val() == ' ') {
				$(errorId).html('Este campo es obligatorio').css('display', 'block');
				flag = false;
			}
		});

		if(!$('input#terms-conditions').is(':checked')) {
			$('.global-error').html('Debes aceptar los términos y condiciones.').css('display', 'block');
			flag = false;
		}

		if(flag) {
			let items = [
				{
					"item_name": "Nombre",
					"item_value": $('#name').val()
				},
				{
					"item_name": "Número de teléfono / Celular",
					"item_value": $('#phone').val()
				},
				{
					"item_name": "Correo electrónico",
					"item_value": $('#email').val()
				},
				{
					"item_name": "País",
					"item_value": $('#country').val()
				},
				{
					"item_name": "Ciudad",
					"item_value": $('#city').val()
				},
				{
					"item_name": "Asunto del mensaje",
					"item_value": $('#subject').val()
				},
				{
					"item_name": "Mensaje",
					"item_value": $('#message').val()
				}
			]

			if($('#address').val() !== '' && $('#address').val() !== ' ') {
				let address = {
					"item_name": "Dirección de residencia",
					"item_value": $('#address').val()
				}

				items.push(address)
			}

			let email = {
				"title": "contact",
				"country_id": $('#country').val(),
				"name": $('#name').val(),
				"from": $('#email').val(),
				"subject": $('#subject').val(),
				"items": items
			}

			SendFormData(email)
		}
	});
}

const SendFormData = (data) => {
	
	data._token = $('meta[name="csrf-token"]').attr('content');

	console.log(data)

	$.ajax({
		method: "POST",
		url: '/api/forms',
		data: data
	}).done((resp) => {
		console.log(resp)
	}).catch((err) => {
		console.log(err)
	})
}

const ResetRequiredErrors = () => {
	$('.required-field').on('keyup change', function() {
		let errorId = '#error-' + $(this).attr('id');

		if($(this).val() !== '' && $(this).val() !== ' ') {
			$(errorId).css('display', 'none');
		}
	});

	$('input#terms-conditions').on('change', function() {
		if($('input#terms-conditions').is(':checked')) {
			$('.global-error').css('display', 'none');
		}
	});
}