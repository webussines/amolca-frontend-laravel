$(function($) {
	$('#register-form').on('submit', Register);

	ResetRequiredFields();
});

const ResetRequiredFields = () => {
	$('#login-form input').on('keyup change', function() {
		$('#login-form .global-error')
			.css('display', 'none')
	});

	$('#register-form .required-field').on('keyup change', function() {
		let errorId = '#error-' + $(this).attr('id');

		if($(this).val() !== '' && $(this).val() !== ' ') {
			$(errorId).css('display', 'none');
		}

		$('#register-form .global-error').css('display', 'none');
	});

	$('#register-form #password, #register-form #repassword').on('keyup change', function() {
		if($(this).val() !== '' && $(this).val() !== ' ') {
			$('#error-repassword').css('display', 'none');
		}
	});

	$('input#tersm-condition').on('change', function() {
		if($('input#tersm-condition').is(':checked')) {
			$('.global-error').css('display', 'none');
		}
	});
}

const Register = (e) => {

	e.preventDefault();

	let flag = true;
	let msgError = '';

	let name = $('#register-form #name').val();
	let lastname = $('#register-form #lastname').val();
	let email = $('#register-form #email').val();
	let password = $('#register-form #password').val();
	let token = $('#_token').val();
	let errors = [];

	$('#register-form .required-field').each(function() {

		let errorId = '#error-' + $(this).attr('id');

		if($(this).val() == '' || $(this).val() == ' ') {
			$(errorId).html('Este campo es obligatorio.').css('display', 'block');
			flag = false;
		}

	});

	if(!$('input#tersm-condition').is(':checked')) {
		$('.global-error').html('Debes aceptar los términos y condiciones.').css('display', 'block');
		flag = false;
	}

	if(flag) {
		if($('#register-form #password').val() !== $('#register-form #repassword').val()) {
			$('#error-repassword').html('Las contraseñas no coinciden.').css('display', 'block');
			return false;
		}

		let user = {
			name: name,
			lastname: lastname,
			email: email,
			role: 'CLIENT',
			country: $('meta[name="country-active-id"]').attr('content'),
			password: password,
			document_id: Math.floor((Math.random() * 10000) + 1),
			_token: $('#_token').val()
		}

		if($('#register .loader').hasClass('hidde'))
			$('#register .loader').removeClass('hidde')

		$('#register input[type="submit"]').val('Creando cuenta...').attr('disabled', 'disabled')

		UserRegister(user)
	}

	//console.log(errors)
}

const UserRegister = (user) => {

	console.log(user)

	$.ajax({
		method: 'POST',
    	url: '/am-admin/register',
    	data: user
	}).done(function(resp) {

		if(typeof fbq === 'function') {
			fbq('track', 'CompleteRegistration');
		}
		
		console.log(resp)
		let data = JSON.parse(resp);
		let error = { show: false, msg: '' };

		if(data.token !== null && data.token !== undefined) {
			return window.location.href = '/mi-cuenta';
		}

		switch (data.status) {
			case 500:
					error.msg = 'Ha ocurrido un error, por favor intentelo más tarde.';
					error.show = true;
				break;
			case 404:
					error.msg = 'Este usuario no existe.';
					error.show = true;
				break;
			case 401:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
			case 400:
					error.msg = 'Ya existse un usuario con el mismo correo electrónico.';
					error.show = true;
				break;
			default:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
		}

		if(!$('#login .loader').hasClass('hidde'))
			$('#login .loader').addClass('hidde')

		$('#register-form .global-error')
			.html(error.msg)
			.css('display', 'block')

		$('#register-form input[type="submit"]')
			.val('Crear cuenta')
			.removeAttr('disabled')

	}).catch(function(err) {
		console.log(err)
		if(!$('#login .loader').hasClass('hidde'))
			$('#login .loader').addClass('hidde')
	})
}
