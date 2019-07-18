jQuery(function($) {

	//Button loop function
	$('.cart-btn').on('click', function() {

		if($(this).attr('disabled') !== 'disabled') {
			$(this).attr('disabled', 'disabled');

			let parent = $($(this)).parent('.btns');

			//Boook info
			let add = {
				"quantity": 1,
				"object_id": $(parent).find('.book-id').val(),
				"price": $(parent).find('.book-price').val(),
				"_token": $('meta[name="csrf-token"]').attr('content'),
				"action": "add"
			}

			AddCartProdut(add, 'global');
		}

	});

	// Change quantity en cart page
	$('input.qty').on('change', function() {

		let row = $(this).parent().parent();
		let col = row.find('td.actions');

		let item = {
			"object_id": col.find('.book-id').val(),
			"quantity": $(this).val(),
			"price": col.find('.book-price').val(),
			"_token": $('meta[name="csrf-token"]').attr('content'),
			"action": "update"
		};

		if($(this).val() >= 1){
			AddCartProdut(item, 'cart', $(row.parent()).find('.actions'));
		} else if($(this).val() < 1) {
			item.action = 'delete';
			DeleteCartProduct(item, 'cart');
		}

	});

	// Button delete product in cart page
	$('button.delete').on('click', function() {

		if($(this).attr('disabled') !== 'disabled') {
			$(this).attr('disabled', 'disabled');

			let parent = $(this).parent();

			let item = {
				"object_id": parent.find('.book-id').val(),
				"quantity": $(this).val(),
				"price": parent.find('.book-price').val(),
				"_token": $('meta[name="csrf-token"]').attr('content'),
				"action": "delete"
			};

			DeleteCartProduct(item, 'cart');
		}
	});

	$('.add-to-cart .quantity').on('change', function() {
		if($(this).val() !== '' && $(this).val() > 0) {
			$('.error-cart').css('display', 'none');
		}
	});

	// Change quantity en cart page
	$('.add-to-cart .add-btn').on('click', function(e) {

		e.preventDefault();

		if($('.add-to-cart .quantity').val() == '') {
			$('.error-cart').html('El campo de cantidad no puede estar vacío.');
			$('.error-cart').css('display', 'block');

			return false;
		}

		if($('.add-to-cart .quantity').val() < 1) {
			$('.error-cart').html('El campo de cantidad debe ser mayor a 0.');
			$('.error-cart').css('display', 'block');

			return false;
		}

		let parent = $(this).parent();

		let item = {
			"object_id": parent.find('.book-id').val(),
			"quantity": parent.find('.quantity').val(),
			"price": parent.find('.book-price').val(),
			"_token": $('meta[name="csrf-token"]').attr('content'),
			"action": "update_book_page"
		};

		AddCartProdut(item, 'book');

	});

});

const AddCartProdut = (added, page, actions = null) => {

	// console.log(added)
	if(typeof fbq === 'function') {
		fbq('track', 'AddToCart');
	}

	if($('.loader.fixed').hasClass('hidde')) {
		$('.loader.fixed').removeClass('hidde');
	}

	$.ajax({
		method: "POST",
		url: '/carts',
		data: added
	}).done(function(resp) {

		console.log('order', resp)

		let amount_converted = FormatMoney(resp.amount, 0, ',', '.', '$', 'before');
		let subtotal_converted = FormatMoney(resp.amount, 0, ',', '.', '$', 'before');

		if(resp.subtotal !== undefined && resp.subtotal !== null) {
			subtotal_converted = FormatMoney(resp.subtotal, 0, ',', '.', '$', 'before');
		} else {
			$('table.cart-totals #coupon').remove();
		}

		$('.top-bar #cart-btn span').html(amount_converted);
		$('.cart-btn').removeAttr('disabled');

		if(page == 'cart') {
			$('.cart-totals tr#subtotal td').html(subtotal_converted);
			$('.cart-totals tr#total #price').html(amount_converted);

			if(resp.shipping_price !== null && resp.shipping_price !== undefined) {
				let shipping_price = FormatMoney(resp.shipping_price, 0, ',', '.', '$', 'before');
				let tr_tmp = `<tr id="shipping">
								<th>Envío:</th>
								<td>${shipping_price}</td>
							  </tr>`

				if($('.cart-totals tr#shipping').length < 1) {
  					$('.cart-totals tr#subtotal').after(tr_tmp);
  				}
			}

			$('table.cart tbody tr td.actions').each(function() {

				let row = actions;

				let book_id = actions.find('.book-id').val();
				let result = resp.products.filter(product => product.object_id == added.object_id);

				let price = FormatMoney(result[0].price, 0, ',', '.', '$', 'before');

				let get_total = result[0].price * result[0].quantity;
				let total = FormatMoney(get_total, 0, ',', '.', '$', 'before');

				let price_col = $('tr#' + result[0].object_id).find('td.price');
				let total_col = $('tr#' + result[0].object_id).find('td.total');

				let total_tmp = `<span class="normal-price">${total}</span>`;

				if(result[0].discount !== undefined && result[0].discount !== null) {

					let with_discount = FormatMoney(result[0].discount, 0, ',', '.', '$', 'before');;

					total_tmp = `<span class="normal-price">${with_discount}</span>
									<span class="without-discount">${total}</span>`;

				}

				$(price_col).html(price);
				$(total_col).html(total_tmp);

			});
		} else {
			let itemNotification = resp.products.filter(product => product.object_id == added.object_id);
			let message = `El libro <b>${itemNotification[0].title}</b>, se agregó exitosamente a tu carrito de compras.`;

			ShowModalResponse('check', message);
		}

		if(!$('.loader.fixed').hasClass('hidde')) {
			$('.loader.fixed').addClass('hidde');
		}


	}).catch(function(err){
		console.log(err)
	})

}

const DeleteCartProduct = (deleted, page) => {
	//console.log(deleted)

	if($('.loader.fixed').hasClass('hidde')) {
		$('.loader.fixed').removeClass('hidde');
	}

	$.ajax({
		method: "POST",
		url: '/carts',
		data: deleted
	}).done(function(resp) {

		//console.log(resp)

		if(resp.products === undefined || resp.products === null || resp.products.length < 1) {
		    //console.log('reload')
		    $('.top-bar #cart-btn span').html(0);
			return window.location.href = window.location.href;
		}

		let amount_converted = FormatMoney(resp.amount, 0, ',', '.', '$', 'before');
		let subtotal_converted = FormatMoney(resp.amount, 0, ',', '.', '$', 'before');

		if(resp.subtotal !== undefined && resp.subtotal !== null) {
			subtotal_converted = FormatMoney(resp.subtotal, 0, ',', '.', '$', 'before');
		}

		$('.top-bar #cart-btn span').html(amount_converted);

		switch (page) {
			case 'cart':

				if(resp.subtotal == undefined || resp.subtotal == null) {
					$('.cart-totals tr#coupon').remove();
				}

				$('.cart-totals tr#subtotal td').html(subtotal_converted);
				$('.cart-totals tr#total #price').html(amount_converted);
				$('tr#' + deleted.object_id).remove();

				break;
		}

		$('button.delete').removeAttr('disabled');
		if(!$('.loader.fixed').hasClass('hidde')) {
			$('.loader.fixed').addClass('hidde');
		}

	}).catch(function(err){
		console.log(err)

		let checkIcon = 'icon-check1';
		let errorIcon = 'icon-close1';

		//Agregar el clase al icono de error
		if($('#notification-modal #resp-icon a .icono').hasClass(checkIcon)) {
			$('#notification-modal #resp-icon a .icono').removeClass(checkIcon);
			$('#notification-modal #resp-icon a .icono').addClass(errorIcon);
		}

		//Agregar el color al icono de error
		if($('#notification-modal #resp-icon a').hasClass('check')) {
			$('#notification-modal #resp-icon a').removeClass('check');
			$('#notification-modal #resp-icon a').addClass('error');
		}
	})
}

const ShowModalResponse = (action, msg) => {

	let checkIcon = 'icon-check1';
	let errorIcon = 'icon-close1';

	switch (action) {
		case 'error':

			//Agregar el clase al icono de error
			if($('#notification-modal #resp-icon a .icono').hasClass(checkIcon)) {
				$('#notification-modal #resp-icon a .icono').removeClass(checkIcon);
				$('#notification-modal #resp-icon a .icono').addClass(errorIcon);
			}

			//Agregar el color al icono de error
			if($('#notification-modal #resp-icon a').hasClass('check')) {
				$('#notification-modal #resp-icon a').removeClass('check');
				$('#notification-modal #resp-icon a').addClass('error');
			}
			break;

		case 'check':

			//Agregar el clase al icono de error
			if($('#notification-modal #resp-icon a .icono').hasClass(errorIcon)) {
				$('#notification-modal #resp-icon a .icono').removeClass(errorIcon);
				$('#notification-modal #resp-icon a .icono').addClass(checkIcon);
			}

			//Agregar el color al icono de error
			if($('#notification-modal #resp-icon a').hasClass('error')) {
				$('#notification-modal #resp-icon a').removeClass('error');
				$('#notification-modal #resp-icon a').addClass('check');
			}
			break;
	}

	$('#notification-modal #resp-text').html(msg);

	$('#notification-modal').modal();
	$('#notification-modal').modal('open');

	setTimeout(function() {
		$('#notification-modal').modal('close');
	}, 6000);
}
