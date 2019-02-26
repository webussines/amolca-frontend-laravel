jQuery(function($) {

	$(document).ready(function() {

		ResetFormErrors();
		$('.select2-normal').select2();

		$('.save-resource').on('click', SaveDealer);

	});

});

const ResetFormErrors = function() {
	$('.required-field').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

		}

	})
}

const SaveDealer = function() {
	let flag = true;
	let _id = $('#_id').val();
	let _action = $('#_action').val();
	let _token = $('#_token').val();

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let title = $('#title').val();
	let contact_person = $('#contact').val();
	let email = $('#email').val();
	let country = $('#country').val();
	let phone = $('#phone').val();
	let thumbnail = $('#image-url').val();

	let password = $('#password').val();
	let repassword = $('#repassword').val();

	let dealer = {
		title: title,
	}

	let ActionRoute;

	switch(_action) {
		case 'edit':
			ActionRoute = '/am-admin/users/edit/' + _id;
		break;

		case 'create':
			ActionRoute = '/am-admin/usuarios';
		break;
	}

	$('.required-field').each(function(){
		
		let val = $(this).val();

		if(val === ' ' || val === '' || val === null) {
			$(this).addClass('field-error');
			flag = false;
		}

	});

	if(flag){
		if(password !== repassword) {
			$('#password').addClass('field-error');
			$('#repassword').addClass('field-error');

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')
			
			let msg = 'Las contraseñas no coinciden.';
			M.toast({html: msg, classes: 'red accent-4 bottom left'});

			flag = false;
		}
	} else {
		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

		let toastMsg = 'Debes llenar los campos obligatorios.';
		M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
	}

	if(flag) {

		$.ajax({
			method: 'POST',
			url: ActionRoute,
			data: user
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);
			if(data.token !== null && data.token !== undefined) {
				switch(_action) {
					case 'edit':
						//console.log('Hola')
						location.reload();
					break;
					case 'create':
						window.location.href = '/am-admin/usuarios/' + data.user.id;
					break;
				}
			}

			if(data.id !== null && data.id !== undefined) {
				switch(_action) {
					case 'edit':
						location.reload();
					break;
				}
			}

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')
		}).catch(function(err) {
			console.log(err)
			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')
		})

	}
}