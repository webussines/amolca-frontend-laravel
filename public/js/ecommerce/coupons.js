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

	//console.log(coupon)
	let flag = true;
	const sc = /[' '’_,.%$#¬|/¡!¿?*=""\/\\( )[\]:;]/gi; // Special chars to replace in str

	if( $('meta[name="country-active-id"]').attr('content') !== coupon.country_id ) {
		$('#coupon-error').html('Este cup&oacute;n no es v&aacute;lido en tu pa&iacute;s').css('display', 'block')
		flag = false;

		return CommonResponseAction();
	}

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

		// Realizar acción si el cupon es valido para producto
		case 'PRODUCT':

				let productsInCart = [];

				//Get total cart
				let TotalCart = $('.cart-totals #price').html();
				TotalCart = TotalCart.replace(sc, '');

				$('table.cart td.actions .book-id').each(function() {

					let id = $(this).val();
					let parent = $(this).parent('td').parent('tr');

					// Convertir el total del carrito actual a una variable tipo numero
					let total_str = $(parent).find('td.total').html();

					//Recorrer objetos del cupon para saber si hay alguno en el carrito
					for (let i = 0; i < coupon.objects.length; i++) {
						if(id == coupon.objects[i].id) {

							let total = total_str.replace(sc, '');
							total = total.replace(/\s/g, '');

							let obj = { id: id, total: total }

							productsInCart.push(obj);
						}
					}
				});

				// Devolver error si no coinciden los productos del carrito con los del cupon
				if(productsInCart.length < 1) {
					$('#coupon-error').html('Este cup&oacute;n no es v&aacute;lido para su pedido.').css('display', 'block')
					return CommonResponseAction();
				}

				// Si no hay errores y el cupon es de tipo FIXED
				if(coupon.discount_type == 'FIXED') {

					for (let i = 0; i < productsInCart.length; i++) {

						$('table.cart td.actions .book-id').each(function() {

							let id = $(this).val();

							if(id == productsInCart[i].id) {
								let parent = $(this).parent('td').parent('tr');
								let total_column = $(parent).find('td.total');
								let total_normal = $(total_column).find('.normal-price');

								let without_discount = total_normal.html();
								let with_discount = without_discount.replace(sc, '') - coupon.discount_amount;
								with_discount = FormatMoney(with_discount, 0, ',', '.', '$', 'before');

								let tmp = `<span class="normal-price">${with_discount}</span>
											<span class="without-discount">${without_discount}</span>`;

								total_column.html(tmp)
							}

						});

					}

					let changed = 0;

					$('table.cart td.total .normal-price').each(function() {

						let str = $(this).html();
						let number = str.replace(sc, '');

						if(typeof number == 'string') {
							number = parseInt(number);
						}

						changed += number;

					});

					ChangeTotalCart(coupon, changed)

				}

				// Si no hay errores y el cupon es de tipo FIXED
				if(coupon.discount_type == 'PERCENTAGE') {

					for (let i = 0; i < productsInCart.length; i++) {

						$('table.cart td.actions .book-id').each(function() {

							let id = $(this).val();

							if(id == productsInCart[i].id) {
								let parent = $(this).parent('td').parent('tr');
								let total_column = $(parent).find('td.total');
								let total_normal = $(total_column).find('.normal-price');

								let without_discount = total_normal.html();

								let without_discount_number = parseInt(without_discount.replace(sc, ''));
								let discount = ( without_discount_number * coupon.discount_amount ) / 100;
								let with_discount = without_discount_number - discount;

								with_discount = FormatMoney(with_discount, 0, ',', '.', '$', 'before');

								let tmp = `<span class="normal-price">${with_discount}</span>
											<span class="without-discount">${without_discount}</span>`;

								total_column.html(tmp)
							}

						});

					}

					let changed = 0;

					$('table.cart td.total .normal-price').each(function() {

						let str = $(this).html();
						let number = str.replace(sc, '');

						if(typeof number == 'string') {
							number = parseInt(number);
						}

						changed += number;

					});

					ChangeTotalCart(coupon, changed)

				}

			break;

		case 'ALL':
		    // Convertir el total del carrito actual a una variable tipo numero
			let all_total_str = $('.cart-totals #price').html();

			let all_total = all_total_str.replace(sc, '');

			if(typeof all_total == 'string') {
				all_total = parseInt(all_total);
			}

			// Si no hay errores y el cupon es de tipo FIXED
			if(flag && coupon.discount_type == 'FIXED') {

				let all_changed = all_total - coupon.discount_amount;

				ChangeTotalCart(coupon, all_changed)

			}

			// Si no hay errores y el cupon es de tipo FIXED
			if(flag && coupon.discount_type == 'PERCENTAGE') {

				let all_discount = (all_total * coupon.discount_amount) / 100;
				let all_changed = all_total - all_discount;

				ChangeTotalCart(coupon, all_changed)

			}
		    break;

		default:
			console.log('DEFAULT')
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
		$('.coupon-contain #coupon').val('')

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

const DiscountRowTmp = (coupon) => {

	console.log(coupon)

	let amount_converted = '';

	switch (coupon.discount_type) {
		case 'FIXED':
			amount_converted = FormatMoney(coupon.discount_amount, 0, ',', '.', '$', 'before');
			break;
		case 'PERCENTAGE':
			amount_converted = coupon.discount_amount + '%';
			break;
	}

	let str = `<tr id="coupon">
					<th>Descuento:</th>
					<td><b>${amount_converted}</b> - ${coupon.code}</td>
				</tr>`;

	return str;
}

const ErrorCouponInStorage = () => {

	$('#coupon-error').html('A este pedido ya se le aplicó un cupón. Los cupones no son acumulables.').css('display', 'block')

	CommonResponseAction();

}
