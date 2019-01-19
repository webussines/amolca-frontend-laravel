jQuery(function($) {

	//Button loop function
	$('.cart-btn').on('click', function() {
		let parent = $($(this)).parent('.btns');

		//Boook info
		let elemt = {
			"quantity": 1,
			"object_id": $(parent).find('.book-id').val(),
			"price": $(parent).find('.book-price').val(),
			"_token": $('meta[name="csrf-token"]').attr('content')
		}

		AddCartProdut(elemt);

	});

});

const AddCartProdut = (added) => {

	console.log(added)

	$.ajax({
		method: "POST",
		url: '/carts',
		data: added,
		dataType: 'json'
	}).done(function(resp) {

		console.log(resp)
		//let json = JSON.parse(resp);

	}).catch(function(err){
		console.log(err)
	})

}