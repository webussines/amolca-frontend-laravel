jQuery(function($){

	$('.select2-normal').select2();

	if($('#affected').val() !== 'ALL') {
		setTimeout(function() {
			GetResourcesData($('#affected').val(), true);
		}, 2000);
	}

	$('.save-resource').on('click', SaveCouponInfo)

	ResetFormErrors();

	$('#affected').on('change', function() {
		 GetResourcesData($(this).val(), false);
	});

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

const GetResourcesData = (src, init) => {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let SrcRoute = '';
	let flag = true;
	var init = init == undefined ? false : init;

	if(src == 'ALL') {
		flag = false;
	}

	switch(src) {
		case 'TAXONOMIE':
			SrcRoute = "/am-admin/specialties"
		break;

		case 'PRODUCT':
			SrcRoute = "/am-admin/books"
		break;

		case 'USER':
			SrcRoute = "/am-admin/users/all"
		break;
	}

	if(flag) {

		if(!init) {
			$('#objects').find('option').remove()
		}

		$.ajax({
			type: "GET",
			url: SrcRoute,
			data: {
				"_token": $('#_token').val()
			}
		}).done((resp) => {
			console.log(SrcRoute)
			console.log(resp)
			//Agregar opciones a la lista
			for (let i = 0; i < resp.data.length; i++) {

				let title = '';

				if(src == 'PRODUCT' || src == 'TAXONOMIE') {
					title = resp.data[i].title;
				} else {
					title = '<b>' + resp.data[i].name + ' ' + resp.data[i].lastname + '</b> - ' + resp.data[i].email;
				}

				let o = new Option(title, resp.data[i].id);

				if(init && $('#objects').val().length > 0) {
					for (let i = 0; i < $('#objects').val().length; i++) {
						/// jquerify the DOM object 'o' so we can use the html method
						if($('#objects').val()[i] !== resp.data[i].id) {
							$(o).html(title);
							$('#objects').removeAttr('disabled').append(o);
						}
					}
				}

				if(!init) {
					$(o).html(title);
					$('#objects').removeAttr('disabled').append(o);
				}

				if(src == 'TAXONOMIE') {
					if(resp.data[i].childs !== undefined) {
						for (let c = 0; c < resp.data[i].childs.length; c++) {

							let co = new Option(resp.data[i].childs[c].title, resp.data[i].childs[c].id);

							if(init && $('#objects').val().length > 0) {
								for (let i = 0; i < $('#objects').val().length; i++) {
									/// jquerify the DOM object 'o' so we can use the html method
									if($('#objects').val()[i] != resp.data[i].childs[c].id) {
										$(co).html(resp.data[i].childs[c].title);
										$('#objects').append(co);
									}
								}
							}

							if(!init) {
								$(co).html(resp.data[i].childs[c].title);
								$('#objects').append(co);
							}
						}
					}
				}

			}

			$('.normal-select').formSelect();
			$('#objects').select2({
				placeholder: 'Seleccione al menos un recurso...'
			});

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

		}).catch((err) => {

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			console.log(err)
		})
	}

}

const SaveCouponInfo = () => {

	let _token = $('#_token').val();
	let _action = $('#_action').val();
	let _id = $('#_id').val();
	let flag = true;

	let coupon = {
		title: $('#title').val(),
		description: $('#description').val(),
		country_id: $('#country_id').val(),
		affected: $('#affected').val(),
		code: $('#code').val(),
		cumulative: $('#cumulative').val(),
		discount_type: $('#discount_type').val(),
		discount_amount: $('#discount_amount').val()
	};

	if($('#start_date').val() !== '' && $('#start_date').val() !== ' ' && $('#start_date').val() !== 0) {
		coupon.start_date = new Date($('#start_date').val()).toISOString().slice(0, 19).replace('T', ' ');
	}

	if($('#expired_date').val() !== '' && $('#expired_date').val() !== ' ' && $('#expired_date').val() !== 0) {
		coupon.expired_date = new Date($('#expired_date').val()).toISOString().slice(0, 19).replace('T', ' ');
	}

	if($('#limit_of_use').val() !== '' && $('#limit_of_use').val() !== ' ' && $('#limit_of_use').val() != '0') {
		coupon.limit_of_use = $('#limit_of_use').val();
	}

	if($('#objects').val() !== '' && $('#objects').val() !== ' ' && $('#objects').val().length > 0) {

		let arr = [];
		for (var i = 0; i < $('#objects').val().length; i++) {
			let obj = {
				'object_id': $('#objects').val()[i],
				'object_type': $('#affected').val()
			}

			arr.push(obj);
		}

		coupon.objects = arr;
	}

	let ActionRoute = '';

	switch (_action) {
		case 'edit':
			ActionRoute = '/am-admin/coupons/edit/' + _id;
			break;
		case 'create':
			ActionRoute = '/am-admin/cupones';
			coupon.slug = GenerateSlug(coupon.title);
			break;
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

	if(flag) {

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		let data_send = {
			body: coupon,
			_token: _token
		}

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

			if(data.id !== undefined) {

				switch(_action) {
					case 'edit':
						location.reload();
					break;

					case 'create':
						window.location.href = '/am-admin/cupones/' + data.id;
					break;
				}

			}
		}).catch(function(err) {

			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			console.log(err);

		})
	}

}
