jQuery(($) => {

	$(document).ready(() => {
		$('#order-modal').modal({
			onOpenStart: function() {
				$('#order-modal #notes-state').val('').css('display', 'none')
				$('#order-modal #add-notes').prop('checked', false);
			}
		});
	});

	$('#order-modal #add-notes').on('change', function() {
		if($(this).is(':checked')) {
			$('#order-modal textarea').css('display', 'block');
		} else {
			$('#order-modal textarea').css('display', 'none');
			$('#order-modal #notes-state-error').css('display', 'none')
		}
	});

	$('#order-modal #notes-state').on('keyup', () => {
		if($('#order-modal #notes-state').val() !== '' && $('#order-modal #notes-state').val() !== ' ') {
			$('#order-modal #notes-state').removeClass('field-error');
			$('#order-modal #notes-state-error').css('display', 'none')
		}
	});

	$('#order-modal .change-state').on('click', ChangeOrderState);

});

const ChangeOrderState = () => {

	if($('#order-modal .loader').hasClass('hidde'))
		$('#order-modal .loader').removeClass('hidde')

	let OrderId = $('#_id').val(),
		token = $('#_token').val(),
		flag = true;

	let update = {
		state: $('#order-state').val(),
		active: 1
	}

	if($('#order-modal #add-notes').is(':checked')) {

		if($('#order-modal #notes-state').val() == '' || $('#order-modal #notes-state').val() == ' ') {

			$('#order-modal #notes-state').addClass('field-error');

			$('#order-modal #notes-state-error')
				.html('Debes escribir alguna nota para el cambio de estado.')
				.css('display', 'block')

			flag = false;

		} else {

			update.notes = $('#order-modal #notes-state').val()

		}

	}

	if(flag) {

		let data_send = {
			"body": update,
			"_token": token
		}

		$.ajax({
			method: 'POST',
			url: '/am-admin/orders/' + OrderId + '/states/store',
			data: data_send
		}).done((resp) => {
			//return console.log(resp)

			let json = JSON.parse(resp);
			//return console.log(json)

			if(resp.id !== null) {
				location.reload();
			}

		}).catch((err) => {
			console.log(err)
		})

	}

}