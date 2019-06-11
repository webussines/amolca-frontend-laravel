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
			"country": "MEXICO",
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
		//return console.log(resp)

		$('#notification-modal #resp-buttons').css('display', 'none');

		$('#notification-modal #resp-text').html(`¡Hola, <b>${resp.order.address.name} ${resp.order.address.lastname}</b>!<br/> Recibimos tu pedido exitosamente.`);

		$('#notification-modal #resp-desc').html('En 5 segundos te redirigiremos a la plataforma de pagos...');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		let user = resp.order.address;
		let order = resp.cart;

		PayURedirection(user, order);

	}).catch(function(err) {
		console.log(err)
	})

}

const PayURedirection = (user, order) => {

	console.log(user)

	//Cambiar el valor en el botón del carrito en el header
	$('.top-bar #cart-btn span').html("$0 MXN");

	let products = [];
	for (let i = 0; i < order.products.length; i++) {
		products.push(order.products[i].title);
	}

	// Get domain for Return and Cancel routes
    let http = 'http://';
    if(window.location.host !== 'laravel.amolca.com') {
    	http = 'https://';
    }
    let url_to_return = http + window.location.host;

	//let test_mode = 1;
	let test_mode = 0;

	//const service = 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/';
	const service = 'https://checkout.payulatam.com/ppp-web-gateway-payu/';

    const params = {
        "merchantId": $('#merchantId').val(),
        "accountId": $('#accountId').val(),
        "description": 'Compra de los libros: ' + products.join(', ') + '.',
        "referenceCode": order.id,
        "amount": order.amount,
        "tax": "0",
        "taxReturnBase": "0",
        "currency": $('#currency').val(),
        "signature": $('#signature').val(),
        "test": test_mode,
		"buyerFullName": user.name + ' ' + user.lastname,
        "buyerEmail": user.email,
        "responseUrl": url_to_return,
        "confirmationUrl": url_to_return
    };

	setTimeout(function() {
		$.redirect(service, params);
	}, 5000)

}
