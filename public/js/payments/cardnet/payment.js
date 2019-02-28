jQuery(function($) {

	$('#checkoutform').on('submit', ValidateForm);

	$('#checkoutform .required-field').on('keyup change', function() {
		if($(this).val() !== '' && $(this).val() !== ' ') {

			let errorId = '#error-' + $(this).attr('id');
			$(errorId).css('display', 'none');

		}
	});

	$('#checkoutform input#terms').on('change', function() {
		if($('input#terms').is(':checked')) {
			$('.global-error').css('display', 'none');
		}
	});

});

const ValidateForm = (e) => {

	e.preventDefault();

	let flag = true;

	$('#checkoutform .required-field').each(function() {
		
		if($(this).val() == '' || $(this).val() == ' ') {

			let errorId = '#error-' + $(this).attr('id');
			$(errorId).html('*Este campo es obligatorio.').css('display', 'block');
			flag = false;

		}

	});

	if(!$('input#terms').is(':checked')) {
		$('.global-error').html('Para realizar la compra debes aceptar los términos y condiciones.').css('display', 'block');
		flag = false;
	}

	if(flag) {
		let info = {
			"name": $('#checkoutform #name').val(),
			"lastname": $('#checkoutform #lastname').val(),
			"email": $('#checkoutform #email').val(),
			"mobile": $('#checkoutform #mobile').val(),
			"country": "REPUBLICA DOMINICANA",
			"city": $('#checkoutform #city').val(),
			"address": $('#checkoutform #address').val(),
			"_token": $('meta[name="csrf-token"]').attr('content'),
		}

		if($('#checkoutform #phone').val() !== '' && $('#checkoutform #phone').val() !== ' ') {
			info.phone = $('#checkoutform #phone').val()
		}

		if($('#checkoutform #extra_address').val() !== '' && $('#checkoutform #extra_address').val() !== ' ') {
			info.extra_address = $('#checkoutform #extra_address').val()
		}

		if($('#checkoutform #postal_code').val() !== '' && $('#checkoutform #postal_code').val() !== ' ') {
			info.postal_code = $('#checkoutform #postal_code').val()
		}

		if($('#checkoutform #aditionals').val() !== '' && $('#checkoutform #aditionals').val() !== ' ') {
			info.aditionals = $('#checkoutform #aditionals').val()
		}

		//console.log(info)
		UpdateOrder(info);
	}

}

const UpdateOrder = (data) => {

	if($('.loader.fixed').hasClass('hidde')) {
		$('.loader.fixed').removeClass('hidde');
	}

	$.ajax({
		method: "POST",
		url: '/carts/checkout',
		data: data
	}).done(function(resp) {
		//console.log(resp)

		$('#notification-modal #resp-buttons').css('display', 'none');

		$('#notification-modal #resp-text').html(`¡Hola, <b>${resp.address.name} ${resp.address.lastname}</b>!<br/> Recibimos tu pedido exitosamente.`);

		$('#notification-modal #resp-desc').html('En 5 segundos te redirigiremos a la plataforma de pagos...');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		let user = resp.address;
		let order = resp.order;

		CardnetRedirectFunction(user, order);

	}).catch(function(err) {
		console.log(err)
	})

}

const CardnetRedirectFunction = (user, order) => {

	//Cambiar el valor en el botón del carrito en el header
	$('.top-bar #cart-btn span').html("DOP$ 0");

	const service = 'https://lab.cardnet.com.do/authorize';
	//const service = 'https://ecommerce.cardnet.com.do/authorize';
	const numero_comercio = 349000000;
	const terminal_id = 58585858;
	const categoria_comercio = 7997;
	const tipo_transaccion = 200;

    // Get domain for Return and Cancel routes
    let http = 'http://';
    if(window.location.host !== 'laravel.amolca.com') {
    	http = 'https://';
    }

    let url_to_return = http + window.location.host + '/checkout/response';

    // Get date for transaction ID
    let d = new Date();
	let h = d.getHours();
	let m = d.getMinutes();
	let y = d.getFullYear();
	let date = '' + h + m + y;

    // Get total order
    let total_arr = $('#total-amount').val().split('.');
    let total = total_arr[0];

    if(total_arr.length > 1) {
    	total += total_arr[1];
    } else {
    	total += '00';
    }

    // Set all params to send for transaction
	let params = {
		TransactionType: tipo_transaccion,
		CurrencyCode: 214,
		AcquiringInstitutionCode: 349,
		MerchantType: 7997,
		MerchantNumber: numero_comercio,
		MerchantTerminal: terminal_id,
		ReturnUrl: url_to_return,
		CancelUrl: url_to_return,
		PageLanguaje: 'ESP',
		OrdenId: order.id,
		TransactionId: order.id + date,
		Amount: '0000000' + total,
		Tax: '00000001523',
		MerchantName: 'COMERCIO PARA REALIZAR PRUEBAS DO',
		KeyEncriptionKey: '1fc500b127d04b532f759d183944b057',
		loteid: '001',
		seqid: '001'
	}

	setTimeout(function() {
		$.redirect(service, params);
	}, 5000)

}