jQuery(($) => {

	LoadCountries();

	if($('#resource_type').val() !== '') {
		setTimeout(function() {
			LoadResources($('#resource_type').val(), true);
		}, 2000);
	}

	$('#resource_id').select2({
		placeholder: 'Seleccione al menos un recurso...'
	});

	$('#resource_type').on('change', function() {
		LoadResources($(this).val(), false);
	});

	$('.save-resource').on('click', SaveBannerInfo)

	ResetFormErrors();

});

const ResetFormErrors = function() {
	$('.required-field').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

			if( $(this).hasClass('select2-normal') ) {
				let parent = $(this).parent();
				$(parent).find('.select2-selection').removeClass('field-error')
			}

			if($(this).hasClass('normal-select')) {
				let parent = $(this).parent();
				$(parent).find('.select-dropdown').removeClass('field-error')
			}

		}

	})
}

const SaveBannerInfo = (e) => {

	e.preventDefault();

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let flag = true;
	let id = $('#id').val();
	let _action = $('#_action').val();
	let _token = $('#_token').val();
	let _user = $('#_user').val();

	let banner = {
		title: $('#title').val(),
		image: $('#image-url').val(),
		resource_type: $('#resource_type').val(),
		resource_id: $('#resource_id').val(),
		country_id: $('#country_id').val()
	};

	if ( $('#image-link').val() !== '' && $('#image-link').val() !== ' ') {
		banner.link = $('#image-link').val()
		banner.target_link = $('#target_link').val()
	}

	let ActionRoute;
	let send;
	
	switch(_action) {
		case 'edit':
		    send = banner;
			ActionRoute = '/am-admin/api-banners/edit/' + id;
		break;

		case 'create':
			ActionRoute = '/am-admin/banner';
			send = [ banner ];
		break;
	}

	$('.required-field').each(function(){
		
		let val = $(this).val();

		if(val === ' ' || val === '' || val === null || val == '0') {
			$(this).addClass('field-error');
			flag = false;

			if( $(this).hasClass('select2-normal') ) {
				let parent = $(this).parent();
				$(parent).find('.select2-selection').addClass('field-error')
			}

			if($(this).hasClass('normal-select')) {
				let parent = $(this).parent();
				$(parent).find('.select-dropdown').addClass('field-error')
			}
		}

	});

	// console.log(send);

	if( flag ) {

		$.ajax({
			method: 'POST',
			url: ActionRoute,
			data: {
				"body": send,
				"_token": _token
			}
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);
			
			if(data.error !== undefined) {
				if (data.error == 'token_expired') {
					window.location.href = '/am-admin/logout';
				}
			}

			if(data.banner !== undefined && data.banner.id !== undefined) {
				
				switch(_action) {
					case 'edit':
						location.reload();
					break;
					case 'create':
						window.location.href = '/am-admin/banner/' + data.banner.id;
					break;
				}

			}
			
			if(data.banners_id !== undefined && data.banners_id.length > 0) {
			    window.location.href = '/am-admin/banner/' + data.banners_id[0];
			}

		}).catch(function(err) {
			console.log(err)
		})

	} else {

		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

		let toastMsg = 'Debes llenar los campos obligatorios.';
		M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});

	}

}

const LoadCountries = (init) => {

	var init = init == undefined ? false : init;

	$.ajax({
		method: 'GET',
		url: '/am-admin/countries/all'
	}).done((resp) => {

		resp = JSON.parse(resp)
		
		//Agregar opciones a la lista 
		for (let i = 0; i < resp.length; i++) {

			let title = '';
			
			title = resp[i].title;

			let o = new Option(title, resp[i].id);

			if(init && $('#country_id').val().length > 0) {
				for (let i = 0; i < $('#country_id').val().length; i++) {
					/// jquerify the DOM object 'o' so we can use the html method
					if($('#country_id').val()[i] !== resp[i].id) {
						$(o).html(title);
						$('#country_id').removeAttr('disabled').append(o);
					}
				}
			}

			if(!init) {
				$(o).html(title);
				$('#country_id').removeAttr('disabled').append(o);
			}

		}

		$('#country_id').select2({
			placeholder: 'Seleccione al menos un recurso...'
		});

	}).catch((err) => {
		console.log(err)
	})

}

const LoadResources = (src, init) => {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let url = '';
	let ajax_req = true;
	var init = init == undefined ? false : init;

	switch (src) {
		case 'BOOK':
			url = '/am-admin/books'
			break;
		case 'SPECIALTY':
			url = '/am-admin/specialties';
			break;
		case 'AUTHOR':
			url = '/am-admin/authors/all';
			break;
		case 'BLOG':
			url = '/am-admin/blogs';
			break;
		case 'PAGE':
			ajax_req = false;
			break;
	}

	if (ajax_req) {

		$.ajax({
			method: 'GET',
			url: url
		}).done((resp) => {

			if(!init) {
				$('#resource_id').find('option').remove()
			}
			
			//Agregar opciones a la lista 
			for (let i = 0; i < resp.data.length; i++) {

				let title = '';
				
				title = resp.data[i].title;

				let o = new Option(title, resp.data[i].id);

				if(init && $('#resource_id').val().length > 0) {
					for (let i = 0; i < $('#resource_id').val().length; i++) {
						/// jquerify the DOM object 'o' so we can use the html method
						if($('#resource_id').val() !== resp.data[i].id) {
							$(o).html(title);
							$('#resource_id').removeAttr('disabled').append(o);
						}
					}
				}

				if(!init) {
					$(o).html(title);
					$('#resource_id').removeAttr('disabled').append(o);
				}

				if(src == 'SPECIALTY') {
					if(resp.data[i].childs !== undefined) {
						for (let c = 0; c < resp.data[i].childs.length; c++) {

							let co = new Option(resp.data[i].childs[c].title, resp.data[i].childs[c].id);

							if(init && $('#resource_id').val().length > 0) {
								/// jquerify the DOM object 'o' so we can use the html method
								if($('#resource_id').val() != resp.data[i].childs[c].id) {
									$(co).html(resp.data[i].childs[c].title);
									$('#resource_id').append(co);
								}
							}

							if(!init) {
								$(co).html(resp.data[i].childs[c].title);
								$('#resource_id').append(co);
							}
						}
					}
				}

			}

			$('.normal-select').formSelect();
			$('#resource_id').select2({
				placeholder: 'Seleccione al menos un recurso...'
			});

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

		}).catch((err) => {

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			console.log(err)
		})

	} else {

		let pages = [
			{
				'title': 'Carrito de compras',
				'id': 1
			},
			{
				'title': 'Finalizar compra',
				'id': 2
			},
			{
				'title': 'Términos y condiciones',
				'id': 3
			},
			{
				'title': 'Contacto',
				'id': 4
			},
			{
				'title': 'Página de todos los blogs',
				'id': 5
			},
			{
				'title': 'Página de todos los autores',
				'id': 6
			},
			{
				'title': 'Página de novedades médicas',
				'id': 7
			},
			{
				'title': 'Página de novedades odontológicas',
				'id': 8
			}
		];

		if(!init) {
			$('#resource_id').find('option').remove()
		}
		
		//Agregar opciones a la lista 
		for (let i = 0; i < pages.length; i++) {

			let title = '';
			
			title = pages[i].title;

			let o = new Option(title, pages[i].id);

			if(init && $('#resource_id').val().length > 0) {
				for (let i = 0; i < $('#resource_id').val().length; i++) {
					/// jquerify the DOM object 'o' so we can use the html method
					if($('#resource_id').val()[i] !== pages[i].id) {
						$(o).html(title);
						$('#resource_id').removeAttr('disabled').append(o);
					}
				}
			}

			if(!init) {
				$(o).html(title);
				$('#resource_id').removeAttr('disabled').append(o);
			}

			if(src == 'SPECIALTY') {
				if(pages[i].childs !== undefined) {
					for (let c = 0; c < resp.data[i].childs.length; c++) {

						let co = new Option(resp.data[i].childs[c].title, resp.data[i].childs[c].id);

						if(init && $('#resource_id').val().length > 0) {
							for (let i = 0; i < $('#resource_id').val().length; i++) {
								/// jquerify the DOM object 'o' so we can use the html method
								if($('#resource_id').val()[i] != resp.data[i].childs[c].id) {
									$(co).html(resp.data[i].childs[c].title);
									$('#resource_id').append(co);
								}
							}
						}

						if(!init) {
							$(co).html(resp.data[i].childs[c].title);
							$('#resource_id').append(co);
						}
					}
				}
			}

		}

		$('.normal-select').formSelect();
		$('#resource_id').select2({
			placeholder: 'Seleccione al menos un recurso...'
		});

		if(!$('.loader').hasClass('hidde'))
			$('.loader').addClass('hidde')

	}
}