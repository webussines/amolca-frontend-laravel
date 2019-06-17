$(function($) {

	$('#change-password-button').on('click', () => {
		if( $('input#new-password').val() !== '' && $('input#new-password').val() !== ' ' ) {
			return ChangePassword();
		}
	});

	$('#open-modal').on('click', () => {
		$('#change-password-button').css('display', 'inline-block');

		let user_name = $('input#name').val() + ' ' + $('input#lastname').val();
		$('#change-password-modal .title .user').html(user_name)
		
		$('#change-password-modal').modal('open')
	});

});

const ChangePassword = () => {

	if($('#change-password-modal .loader').hasClass('hidde'))
		$('#change-password-modal .loader').removeClass('hidde')

	$('#change-password-button').attr('disabled', 'disabled');

	let email = $('input#email').val()
	let new_password = $('input#new-password').val()

	$.ajax({
		method: 'GET',
		url: '/am-admin/restore-password',
		data: {
			email: email,
			new_password: new_password,
			send_mail: 'false'
		}
	}).done( (resp) => {
		setTimeout(() => {
			console.log(resp)
			return PasswordChangedResponse();
		}, 2000)
	}).catch( (err) => {
		console.log(err.responseJSON)
	})
}

const PasswordChangedResponse = () => {

	if(!$('#change-password-modal .loader').hasClass('hidde'))
		$('#change-password-modal .loader').addClass('hidde')

	$('#change-password-modal').modal('close');

	$('#notification-modal #resp-buttons .button.primary').css('display', 'none');
	$('#notification-modal #resp-buttons .modal-close').css('width', 'auto');

	let user_name = $('input#name').val() + ' ' + $('input#lastname').val();

	$('#notification-modal #resp-text').html(`¡Hola, <b>${user_name}</b>!<br/> Su contraseña se cambió correctamente.`);
	$('#notification-modal #resp-desc').css('display', 'none');

	$('#notification-modal').modal();
	$('#notification-modal').modal('open');

	$('#change-password-button').removeAttr('disabled');
}
