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
			"country": "ARGENTINA",
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

		$('#notification-modal #resp-text').html(`¡Hola, <b>${resp.order.address.name} ${resp.order.address.lastname}</b>!<br/> Recibimos tu pedido exitosamente.`);

		$('#notification-modal #resp-desc').html('En 5 segundos te redirigiremos a la plataforma de pagos...');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		let user = resp.order.address;
		let order = resp.cart;

		MPRedirectFunction(user, order);

	}).catch(function(err) {
		console.log(err)
	})

}

const MPRedirectFunction = (user, order) => {

	//console.log(order);
	if(order.shipping_price !== undefined) {
		let shipping = order.shipping_price / order.products.length;

		for (var i = 0; i < order.products.length; i++) {
			order.products[i].price = order.products[i].price + shipping;
		}
	}

	//Cambiar el valor en el botón del carrito en el header

	$('.top-bar #cart-btn span').html("$0,00 ARS");

	// Get domain for Return and Cancel routes
    let http = 'http://';
    if(window.location.host !== 'laravel.amolca.com') {
    	http = 'https://';
    }
    let url_to_return = http + window.location.host;

	$.ajax({
		method: 'POST',
		url: '/mercado-pago/get-endpoint.php',
		data: {
			"order": order,
			"user": user,
			"url_return": url_to_return,
			"_token": $('meta[name="csrf-token"]').attr('content')
		}
	}).done((resp) => {

		//console.log(resp)
		setTimeout(function() {
			window.location.href= resp;
		}, 5000)

	}).catch((err) => {
		console.log(err)
	})

}
