jQuery(function($) {

	$(document).ready(function() {

		InitEditorBoxes();
		ResetFormErrors();
		$('.select2-normal').select2();

		$('.save-resource').on('click', SaveUser);

	});

});

//Funcion para inicializar los editores tinymce
const InitEditorBoxes = () => {
	tinymce.init({
	    selector: "textarea#description",
        theme: "modern",
        height: 180,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ]
	})
}

const ResetFormErrors = function() {
	$('.required-field').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

		}

	})
}

const SaveUser = function() {
	let flag = true;
	let _id = $('#_id').val();
	let _action = $('#_action').val();
	let _token = $('#_token').val();

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let name = $('#name').val();
	let lastname = $('#lastname').val();
	let email = $('#email').val();
	let role = $('#role').val();
	let country = $('#country').val();
	let mobile = $('#mobile').val();
	let phone = $('#phone').val();
	let company = $('#company').val();
	let description = tinymce.activeEditor.getContent();
	let image = $('#image-url').val();

	let password = $('#password').val();
	let repassword = $('#repassword').val();

	let dataSend = {
		user: {
			name: name,
			lastname: lastname,
			email: email,
			role: [role],
			country: country,
			mobile: mobile,
			phone: phone,
			company: company,
			description: description,
			image: image,
			password: password
		},
		mailer: {
	        to: email,
	        cc: 'contacto@amolca.com, asistentepresidencia@amolca.us',
	        from: 'Amolca Casa Matriz <ventas@amolca.com.co>',
	        domain: 'www.amolca.com.co'
	    }
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
			data: {
				"body": dataSend,
				"_token": _token
			}
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);

			if(data.user._id !== undefined) {
				
				switch(_action) {
					case 'edit':
					console.log('Hola')
						location.reload();
					break;
					case 'create':
						window.location.href = '/am-admin/usuarios/' + data.user._id;
					break;
				}

			}
		}).catch(function(err) {
			console.log(err)
		})

	}
}