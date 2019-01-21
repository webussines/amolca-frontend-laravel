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
			"country": "COLOMBIA",
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
		//console.log(resp)

		$('#notification-modal #resp-buttons').css('display', 'none');

		$('#notification-modal #resp-text').html(`¡Hola, <b>${resp.address.name} ${resp.address.lastname}</b>!<br/> Recibimos tu pedido exitosamente.`);

		$('#notification-modal #resp-desc').html('En 5 segundos te redirigiremos a la plataforma de pagos...');

		$('#notification-modal').modal();
		$('#notification-modal').modal('open');

		let user = resp.address;
		let order = resp.order;

		RedirectFunction(user, order);

	}).catch(function(err) {
		console.log(err)
	})

}

const RedirectFunction = (user, order) => {

	//Cambiar el valor en el botón del carrito en el header
	$('.top-bar #cart-btn span').html("$0");

	//const service = 'https://demover3-1.tucompra.net/tc/app/inputs/compra.jsp';
	const service = 'https://gateway2.tucompra.com.co/tc/app/inputs/compra.jsp';
	const llave = '2732013cb0ed4531af9d9c02cb1a5a82';
	let d = new Date();
	let h = d.getHours();
	let m = d.getMinutes();
	let hour = h + ':' + m;

	let products = [];
	for (let i = 0; i < order.products.length; i++) {
		products.push(order.products[i].title);
	}

	let usuario = 'usuario=c57l7o3zx0l26u7t';
    let factura = '&factura=' + order.id;
    let valor = '&valor=' + order.amount;
    let descripcionFactura = '&descripcionFactura=Compra de los libros: ' + products.join(', ') + '.';
    let tokenSeguridad = "&tokenSeguridad=4bef434dc8effd38e36a082a898a17d4";
    let tipoDocumento = '&tipoDocumento=CC';
    let nombreComprador = '&nombreComprador=' + user.name;
    let apellidoComprador = '&apellidoComprador=' + user.lastname;
    let correoComprador = '&correoComprador=' + user.email;

	const params = `?${usuario}${factura}${valor}${descripcionFactura}${tokenSeguridad}${tipoDocumento}${nombreComprador}${apellidoComprador}${correoComprador}`;
	const url = service + '?' + params;

	setTimeout(function() {
		$.redirect(service, {'usuario': 'c57l7o3zx0l26u7t', 'factura': order.id, 'valor': order.amount, 'descripcionFactura': 'Compra de los libros: ' + products.join(', ') + '.', 'nombreComprador': user.name, 'apellidoComprador': user.lastname, 'celularComprador': user.mobile, 'correoComprador': user.email,  'ciudadComprador': user.city, 'paisComprador': user.country, 'direccionComprador': user.address});
	}, 5000)

}