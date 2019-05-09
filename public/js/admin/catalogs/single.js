jQuery(function($){

	$('.save-resource').on('click', SaveCouponInfo)

	ResetFormErrors();

	$('.select2-normal').select2();
	$('#objects').select2({
		placeholder: 'Seleccione al menos un recurso...'
	});

});

const ResetFormErrors = () => {
	$('.required-field').on('keyup change', function() {
		if($(this).val() !== '' && $(this).val() !== ' ') {

			let errorId = '#' + $(this).attr('id') + '-error';

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

			$(errorId).css('display', 'none')

		}
	})
}

const SaveCouponInfo = () => {

	let _token = $('#_token').val();
	let _action = $('#_action').val();
	let _id = $('#_id').val();
	let flag = true;

	let catalog = {
		title: $('#title').val(),
		thumbnail: $('#image-url').val(),
		type: 'catalog',
		meta: [
			{ 'key': 'catalog_country_id', 'value': $('#country').val() },
			{ 'key': 'catalog_specialty', 'value': $('#specialty').val() }
		]
	};

	if( $('#pdf-url').val() !== '' &&  $('#pdf-url').val() !== ' ' ) {
		catalog.meta.push({ 'key': 'catalog_pdf_url', 'value': $('#pdf-url').val() })
	}

	// Recorres campos requeridos para validar el formulario
	$('.required-field').each(function(){

		let val = $(this).val();
		if(val === ' ' || val === '' || val === null) {

			let errorId = '#' + $(this).attr('id') + '-error';

			$(this).addClass('field-error');
			$(errorId).html('Este campo es obligatorio.').css('display', 'block')

			flag = false;
		}

	});

	let ActionRoute = '';
	let send;

	switch (_action) {
		case 'edit':
			ActionRoute = '/am-admin/catalogs/edit/' + _id;
			send = catalog;
			break;
		case 'create':
			ActionRoute = '/am-admin/catalogos';
			catalog.slug = 'catalogo-' + GenerateSlug(catalog.title);
			send = [ catalog ];
			break;
	}

	if(flag) {

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		let data_send = {
			body: send,
			_token: _token
		}

		//return console.log(data_send);

		$.ajax({
			method: 'POST',
			url: ActionRoute,
			data: data_send
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);

			if(data.error !== undefined) {
				if (data.error == 'token_expired') {
					window.location.href = '/am-admin/logout?redirect=';
				}
			}

			if(data.post !== undefined && data.post.id !== undefined) {

				switch(_action) {
					case 'edit':
						location.reload();
					break;
					case 'create':
						window.location.href = '/am-admin/catalogos/' + data.post.id;
					break;
				}

			}

			if(data.posts_id !== undefined && data.posts_id.length > 0) {
			    window.location.href = '/am-admin/catalogos/' + data.posts_id[0];
			}
		}).catch(function(err) {

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			console.log(err);

		})
	}

}
