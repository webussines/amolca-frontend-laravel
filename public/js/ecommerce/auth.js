$(function($) {
	$('#login-form').on('submit', Login);

	ResetRequiredFields();
});

const ResetRequiredFields = () => {
	$('#login-form input').on('keyup change', function() {
		$('#login-form .global-error')
			.css('display', 'none')
	});

	$('#register-form input').on('keyup change', function() {
		$('#register-form .global-error')
			.css('display', 'none')
	});
}

const Login = (e) => {
	e.preventDefault();

	let flag = true;
	let username = $('#login-username').val();
	let password = $('#login-password').val();
	let token = $('#_token').val();
	let errors = [];

	if(username === ' ' || username === '') {
		errors.push("Nombre");
		flag = false;
	}

	if(password === ' ' || password === '') {
		errors.push("Contraseña");
		flag = false;
	}

	//console.log(errors)

	if(flag) {
		UserLogin(username, password, token);
	} else {
		$('.global-error')
			.html('Los campos <b>' + errors.join(', ') + '</b> son obligatorios.')
			.css('display', 'block')
	}
}

const UserLogin = (username, password, token) => {

	//console.log(username, password, token)

	if($('#login .loader').hasClass('hidde'))
		$('#login .loader').removeClass('hidde')

	$('input[type="submit"]').val('Iniciando sesión...').attr('disabled', 'disabled')

	$.ajax({
		method: "GET",
    	url: '/am-admin/login',
    	data: {
    		"username": username,
    		"password": password,
			"_token": token
    	}
	}).done(function(resp) {
		console.log(resp)
		let data = JSON.parse(resp);
		let error = { show: false, msg: '' };

		switch (data.status) {
			case 500:
					error.msg = 'Ha ocurrido un error, por favor intentelo más tarde.';
					error.show = true;
				break;
			case 404:
					error.msg = 'Este usuario no existe.';
					error.show = true;
				break;
			case 403:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
			case 200:
					return window.location.href = '/mi-cuenta';
				break;
			default:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
		}

		if(!$('#login .loader').hasClass('hidde'))
			$('#login .loader').addClass('hidde')

		$('#login-form .global-error')
			.html(error.msg)
			.css('display', 'block')

		$('#login-form input[type="submit"]')
			.val('Iniciar sesión')
			.removeAttr('disabled')

	}).catch(function(err) {
		console.log(err)
	})
}