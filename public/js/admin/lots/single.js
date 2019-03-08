jQuery(function($){
	$('.save-resource').on('click', SaveLotInfo)

	ResetFormErrors();

	$('.select2-normal').select2();
	$('#books').select2({
		placeholder: 'Seleccione al menos un libro...'
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

const SaveLotInfo = () => {
	
	let flag = true,
		LotId = $('#_id').val(),
		_action = $('#_action').val(),
		_token = $('#_token').val();

	let lote = {
		title: $('#title').val(),
		state: $('#state').val()
	};

	// Agregar libros al lote si hay al menos uno seleccionado
	let books_selecteds = $('#books').val();
	let books = [];

	for(let i = 0; i < books_selecteds.length; i++) {
		let obj = { 'object_id': books_selecteds[i] }
		books.push(obj);
	}

	if(books.length > 0) {
		lote.books = books;
	}

	// Agregar fecha de llegada si este campo no está vacío
	if($('#arrival_date').val() !== '' && $('#arrival_date').val() !== ' ') {
		lote.arrival_date = new Date($('#arrival_date').val()).toISOString().slice(0, 19).replace('T', ' ');
	}

	// Agregar fecha de inicio de ventas si este campo no está vacío
	if($('#start_sales').val() !== '' && $('#start_sales').val() !== ' ') {
		lote.start_sales = new Date($('#start_sales').val()).toISOString().slice(0, 19).replace('T', ' ');
	}

	let ActionRoute = '';

	switch (_action) {
		case 'edit':
			ActionRoute = '/am-admin/lots/edit/' + LotId;
			break;
		case 'create':
			ActionRoute = '/am-admin/lotes';
			lote.slug = GenerateSlug(lote.title);
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
			body: lote,
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

			if(data.status !== undefined) {
				switch(_action) {
					case 'edit':
						location.reload();
					break;
				}
			}

			if(data.id !== undefined) {
				
				switch(_action) {
					case 'create':
						window.location.href = '/am-admin/lotes/' + data.id;
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