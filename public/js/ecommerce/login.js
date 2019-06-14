$(function($) {

	$('#change-password-button').on('click', () => {
		return ChangePassword();
	});

	$('#open-modal').on('click', () => {
		$('#change-password-button').css('display', 'inline-block');
		$('#login-modal').modal('open');
	});

	$('#next-btn').on('click', ValidateEmailWB);
	$('#login-form').on('submit', Login);

	$('#return-to-email').on('click', function() {
		 ChangeTabContent('#tab-password', '#tab-email')

		 $('#login-password').val('');
		 $('.password-error').css('display', 'none');

		 $('#login-form #next-btn')
	 		.val('Siguiente')
	 		.removeAttr('disabled')
	});

	ResetRequiredFields();
});

const ValidateEmailWB = () => {
	let flag = true;
	let email = $('#login-username').val();
	let token = $('#_token').val();

	if(email == '' || email == ' ' || email == '0') {
		flag = false;
	}

	if (flag) {
		if($('#login .loader').hasClass('hidde')) {
			$('#login .loader').removeClass('hidde')
		}

		$('#login-form #next-btn').val('Validando usuario...').attr('disabled', 'disabled');

		$.ajax({
			method: "GET",
	    	url: '/validate-wb',
	    	data: {
	    		"email": email,
				"_token": token
	    	}
		}).done(function(resp) {
			//console.log(resp)
			let data = JSON.parse(resp);
			let error = { show: false, msg: '' };

			switch (data.status) {
				case 500:
						error.msg = 'Ha ocurrido un error, por favor intentelo más tarde.';
						error.show = true;
					break;
				case 404:
						return ValidateEmailSws(email);
					break;
				case 401:
						error.msg = 'El usuario y la contraseña no coinciden.';
						error.show = true;
					break;
				case "200":
						$('#tab-password #user-fullname').html(data.user_name)

						if(data.user_avatar !== null) {
							$('#tab-password #user-avatar img').html(`<img src="${data.user_avatar}" alt="">`);
						} else {
							$('#tab-password #user-avatar').html(data.user_name[0]);
						}

						$('#tab-password #user-email-sent').html(email)
						return ChangeTabContent('#tab-email', '#tab-password');
					break;
				default:
						error.msg = 'El usuario y la contraseña no coinciden.';
						error.show = true;
					break;
			}

			return UserNotExists(error);

		}).catch(function(err) {
			console.log(err)
		})
	} else {
		$('.email-error')
			.html('Debes escribir tu correo electrónico.')
			.css('display', 'block')
	}
}

const ChangeTabContent = (inactive, active) => {
	$(inactive).removeClass('active');
	$(active).addClass('active');

	$('.email-error, .password-error')
		.css('display', 'none')

	if(!$('#login .loader').hasClass('hidde'))
		$('#login .loader').addClass('hidde')
}

const UserNotExists = (error) => {
	if(!$('#login .loader').hasClass('hidde'))
		$('#login .loader').addClass('hidde')

	$('#login-form .email-error')
		.html(error.msg)
		.css('display', 'block')

	$('#login-form #next-btn')
		.val('Siguiente')
		.removeAttr('disabled')
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
		$('.password-error').html('Debes ingresar tu contraseña.')
		flag = false;
	}

	//console.log(errors)

	if(flag) {
		//console.log('holix')

		let action_form = $('#tab-password #action-form').val();

		switch (action_form) {
			case 'login':

					return UserLogin(username, password, token);

				break;
			case 'register':

					let user = {
						name: $('#tab-password #register-name').val(),
						lastname: $('#tab-password #register-lastname').val(),
						email: $('#tab-password #register-email').val(),
						role: 'CLIENT',
						country: $('meta[name="country-active-id"]').attr('content'),
						password: password,
						document_id: Math.floor((Math.random() * 10000) + 1),
						_token: $('#_token').val()
					}
					return UserSwsRegister(user);

				break;
		}

	} else {
		$('.password-error')
			.css('display', 'block')
	}
}

const UserLogin = (username, password, token) => {

	console.log(username, password, token)

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
			default:
					error.msg = 'El usuario y la contraseña no coinciden.';
					error.show = true;
				break;
		}

		if(!$('#login .loader').hasClass('hidde'))
			$('#login .loader').addClass('hidde')

		$('#login-form .password-error')
			.html(error.msg)
			.css('display', 'block')

		$('#login-form input[type="submit"]')
			.val('Iniciar sesión')
			.removeAttr('disabled')

	}).catch(function(err) {
		console.log(err)
	})
}

const ValidateEmailSws = (email) => {
	$.ajax({
		method: "GET",
		url: 'https://mailsws.com.ve/amolca/web/api/user',
		data: {
			"user_email": email
		}
	}).done(function(resp) {
		//console.log(resp)
		let user = resp.user;
		let error = { show: false, msg: '' };

		if(user.length < 1) {
			error.msg = 'El usuario que ingresaste no existe.';
			error.show = true;

			return UserNotExists(error);
		} else {

			$('#tab-password #user-avatar').html(user.name[0]);
			$('#tab-password #user-fullname').html(user.name + ' ' + user.last_name)
			$('#tab-password #user-email-sent').html(email)

			$('#tab-password #register-name').val(user.name);
			$('#tab-password #register-lastname').val(user.last_name);
			$('#tab-password #register-email').val(email);
			$('#tab-password #action-form').val('register');

			return ChangeTabContent('#tab-email', '#tab-password');

		}

	}).catch(function(err) {
		console.log(err)
	})
}

const UserSwsRegister = (user) => {
	console.log(user)

	$.ajax({
		method: 'POST',
    	url: '/am-admin/register',
    	data: user
	}).done(function(resp) {
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

		$('#login-form .password-error')
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

const ResetRequiredFields = () => {
	$('#login-form #login-username').on('keyup change', function() {
		$('#login-form .email-error')
			.css('display', 'none')
	});

	$('#login-form #login-password').on('keyup change', function() {
		$('#login-form .password-error')
			.css('display', 'none')
	});
}

const ChangePassword = () => {
	let email = $('span#user-email-sent').html()

	$.ajax({
		method: 'GET',
		url: '/am-admin/restore-password',
		data: {
			email: email,
			send_mail: false
		}
	}).done( (resp) => {
		console.log(resp)
	}).catch( (err) => {
		console.log(err)
	})
}
