jQuery(($) => {

	//Accion de "click" en el botón de aplicar cupon
	$('.coupon-contain button').on('click', ValidateCouponExists);

	//Desaparecer error en el input de los cupones
	$('.coupon-contain #coupon').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {
			$('#coupon-error').css('display', 'none')
		}

	});

});

// Obtener el id del usuario loggeado
const GetUserId = () => {

	// Transformando la id a un valor numerico
	let id = parseInt($('meta[name="user-id"]').attr('content'));

	return id;

}

// Habilitar el botón y ocultar el loader
const CommonResponseAction = () => {
	$('.coupon-contain button').removeAttr('disabled');

	if(!$('.loader.fixed').hasClass('hidde')) {
		$('.loader.fixed').addClass('hidde');
	}
}

// Validando la existencia del cupon ingresado
const ValidateCouponExists = (e) => {

	e.preventDefault();
	$('.coupon-contain button').attr('disabled', 'disabled');

	if($('.loader.fixed').hasClass('hidde')) {
		$('.loader.fixed').removeClass('hidde');
	}

	let flag = true;

	let coupon = $('.coupon-contain #coupon').val().toUpperCase();

	if(coupon == '' || coupon == ' ') {
		$('#coupon-error').html('Debes ingresar el c&oacute;digo de tu cup&oacute;n').css('display', 'block')
		flag = false;
		CommonResponseAction();
	}

	if(flag) {

		$.ajax({
			method: 'GET',
			url: '/carts/coupons/' + coupon,
			data: {
				"_token": $('meta[name="csrf-token"]').attr('content')
			}
		}).done((resp) => {
			
			if(typeof resp == 'object') {

				return ValidateOrderInfo(resp);

			}

			let json = JSON.parse(resp);

			if(json.status == 404) {
				$('#coupon-error').html('El cup&oacute;n que ingresaste no existe.').css('display', 'block')
			}

			CommonResponseAction();


		}).catch((err) => {
			console.log(err)
		})

	}

}

const ValidateOrderInfo = (coupon) => {

	// console.log(coupon)
	let flag = true;

	switch (coupon.affected) {

		// Realizar acción si el cupon es valido para usuario
		case 'USER':
			
				if(GetUserId() == 0) {
					$('#coupon-error').html('Este cup&oacute;n es v&aacute;lido solo para usuarios registrados. Por favor iniciar sesi&oacute;n.').css('display', 'block')
					flag = false;
				}

				if(coupon.objects[0].id !== GetUserId()) {
					$('#coupon-error').html('Este cup&oacute;n no es v&aacute;lido para su pedido.').css('display', 'block')
					flag = false;
				}

				// Si hay algún error
				if(!flag) {

					CommonResponseAction();

				}

				// Convertir el total del carrito actual a una variable tipo numero
				let total_str = $('.cart-totals #price').html();

				let sc = /[' '’_,.%$#¬|/¡!¿?*=""\/\\( )[\]:;]/gi; // Special chars to replace in str
				let total = total_str.replace(sc, '');

				if(typeof total == 'string') {
					total = parseInt(total);
				}

				// Si no hay errores y el cupon es de tipo FIXED
				if(flag && coupon.discount_type == 'FIXED') {

    				let changed = total - coupon.discount_amount;

					ChangeTotalCart(coupon, changed)

				}

				// Si no hay errores y el cupon es de tipo FIXED
				if(flag && coupon.discount_type == 'PERCENTAGE') {

					let discount = (total * coupon.discount_amount) / 100;
					let changed = total - discount;

					ChangeTotalCart(coupon, changed)

				}

			break;
		default:
			// statements_def
			break;
	}

}

const GetProductsInfo = (id) => {

	$.ajax({
		method: 'GET',
		url: '/books/' + id
	}).done((resp) => {
		console.log('Resp', resp)
	}).catch((err) => {
		console.log('Error', err)
	})

}

const ChangeTotalCart = (coupon, total) => {

	$.ajax({
		method: 'POST',
		url: '/carts/amount',
		data: {
			"coupon": coupon,
			"total": total,
			"_token": $('meta[name="csrf-token"]').attr('content')
		}
	}).done((resp) => {
		console.log(resp)

		if(resp.status !== undefined && resp.status == 209) {
			return ErrorCouponInStorage();
		}

		let amount_converted = FormatMoney(resp.amount, 0, ',', '.', '$', 'before');
		let tmp = DiscountRowTmp(coupon);

		$('.cart-totals tr#total').before(tmp);

		$('.top-bar #cart-btn span').html(amount_converted);
		$('.cart-totals tr#total #price').html(amount_converted);

		// Mostrar mensaje de aplicación correcta

		if($('#coupon-error').hasClass('error')) {
			$('#coupon-error').removeClass('error').addClass('check')
		}
		$('#coupon-error').html('El cup&oacute;n se aplic&oacute; correctamente a tu pedido.').css('display', 'block')

		CommonResponseAction();

		setTimeout(() => {
			if($('#coupon-error').hasClass('check')) {
				$('#coupon-error').removeClass('check').addClass('error').css('display', 'none')
			}
		}, 2500)

	}).catch((err) => {
		console.log('Error', err)
	})

}

const ErrorCouponInStorage = () => {

	$('#coupon-error').html('A este pedido ya se le aplicó un cupón. Los cupones no son acumulables.').css('display', 'block')

	CommonResponseAction();

}