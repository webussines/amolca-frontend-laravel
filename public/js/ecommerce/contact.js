jQuery(function($) {
	ResetRequiredErrors();
	SubmitForm();
});

const SubmitForm = () => {

	$('.contact-form').on('submit', function(e) {
		e.preventDefault();

		$('.contact-form input[type="submit"]').attr('disabled', 'disabled').val('Enviando...');

		if($('.loader.fixed').hasClass('hidde')) {
			$('.loader.fixed').removeClass('hidde');
		}

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
					"item_value": $('#name').val(),
					"order": 1
				},
				{
					"item_name": "Número de teléfono / Celular",
					"item_value": $('#phone').val(),
					"order": 2
				},
				{
					"item_name": "Correo electrónico",
					"item_value": $('#email').val(),
					"order": 3
				},
				{
					"item_name": "País",
					"item_value": $('#country_name').val(),
					"order": 4
				},
				{
					"item_name": "Ciudad",
					"item_value": $('#city').val(),
					"order": 5
				},
				{
					"item_name": "Asunto del mensaje",
					"item_value": $('#subject').val(),
					"order": 7
				},
				{
					"item_name": "Mensaje",
					"item_value": $('#message').val(),
					"order": 8
				}
			]

			if($('#address').val() !== '' && $('#address').val() !== ' ') {
				let address = {
					"item_name": "Dirección de residencia",
					"item_value": $('#address').val(),
					"order": 6
				}

				items.push(address)
			}

			let email = {
				"title": "contact",
				"country_id": $('#country_id').val(),
				"name": $('#name').val(),
				"from": $('#email').val(),
				"subject": $('#subject').val(),
				"items": items
			}

			SendFormData(email)

		} else {

			if(!$('.loader.fixed').hasClass('hidde')) {
				$('.loader.fixed').addClass('hidde');
			}

			$('.contact-form input[type="submit"]').removeAttr('disabled').val('Enviar formulario');

		}
	});
}

const SendFormData = (data) => {

	//console.log(data)

	let checkIcon = 'icon-check1';
	let errorIcon = 'icon-close1';

	$.ajax({
		method: "POST",
		url: '/api/forms',
		data: data
	}).done((resp) => {
		//console.log(resp)

		if(!$('.loader.fixed').hasClass('hidde')) {
			$('.loader.fixed').addClass('hidde');
		}

		$('#notification-modal .button.primary').css('display', 'none');

		//Agregar el clase al icono de error
		if($('#notification-modal #resp-icon a .icono').hasClass(errorIcon)) {
			$('#notification-modal #resp-icon a .icono').removeClass(errorIcon);
			$('#notification-modal #resp-icon a .icono').addClass(checkIcon);
		}

		//Agregar el color al icono de error
		if($('#notification-modal #resp-icon a').hasClass('error')) {
			$('#notification-modal #resp-icon a').removeClass('error');
			$('#notification-modal #resp-icon a').addClass('check');
		}

		$('#notification-modal #resp-text').html('Su mensaje se ha enviado correctamente. Un asesor se comunicará con usted en la mayor brevedad posible.');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		$('#contact-form')[0].reset();

		$('.contact-form input[type="submit"]').removeAttr('disabled').val('Enviar formulario');

		setTimeout(function() {
			$('#notification-modal').modal('close');
		}, 6000);

	}).catch((err) => {
		console.log(err)

		if(!$('.loader.fixed').hasClass('hidde')) {
			$('.loader.fixed').addClass('hidde');
		}

		$('#notification-modal .button.primary').css('display', 'none');

		//Agregar el color al icono de error
		if($('#notification-modal #resp-icon a').hasClass('check')) {
			$('#notification-modal #resp-icon a').removeClass('check');
			$('#notification-modal #resp-icon a').addClass('error');
		}

		//Agregar el clase al icono de error
		if($('#notification-modal #resp-icon a .icono').hasClass(checkIcon)) {
			$('#notification-modal #resp-icon a .icono').removeClass(checkIcon);
			$('#notification-modal #resp-icon a .icono').addClass(errorIcon);
		}

		$('#notification-modal #resp-text').html('Ha ocurrido un error al enviar su mensaje. Si el error continúa, escriba un mensaje al correo electrónico: <a href="mailto:diseno@webussines.com">diseno@webussines.com</a> ');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		$('.contact-form input[type="submit"]').removeAttr('disabled').val('Enviar formulario');

		setTimeout(function() {
			$('#notification-modal').modal('close');
		}, 8000);
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