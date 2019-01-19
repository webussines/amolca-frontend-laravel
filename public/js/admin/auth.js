$(function($) {
	loginFormFunction();
});

const loginFormFunction = () => {
	$('#login-form').on('submit', function(e) {
		e.preventDefault();

		let flag = true;
		let username = $('#username').val();
		let password = $('#password').val();
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
			sendLoginData(username, password, token);
		} else {
			$('#global-error')
				.html('Los campos <b>' + errors.join(', ') + '</b> son obligatorios.')
				.css('display', 'block')
		}

	});

	$('#login-form input').on('keyup change', function() {
		$('#global-error')
			.css('display', 'none')
	});
}

const sendLoginData = (username, password, token) => {

	//console.log(username, password, token)

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

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

		if(data.token !== null && data.token !== undefined) {
			return window.location.href = '/am-admin/libros';
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
			default:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
		}

		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

		$('#global-error')
			.html(error.msg)
			.css('display', 'block')

		$('input[type="submit"]').val('Iniciar sesión').removeAttr('disabled')
	}).catch(function(err) {
		console.log(err)
	})
}