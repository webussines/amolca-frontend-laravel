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
			"country": "PERÚ",
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

		let user = resp.order.address;
		let order = resp.cart;

		GetVisaNetToken(user, order);

	}).catch(function(err) {
		console.log(err)
	})

}

const GetVisaNetToken = (user, order) => {
    $.ajax({
        method: 'POST',
        url: 'https://apitestenv.vnforapps.com/api.security/v1/security',
        dataType: 'text/plain',
        headers: {
            "Authorization": "Basic " + btoa('integraciones.visanet@necomplus.com:d5e7nk$M'),
            "Accept": 'text/plain'
        }
    }).done((resp) => {
        console.log(resp)
    }).catch((err) => {
        if(err.status == 201) {
            CreateSession(err.responseText, user, order)
        } else {
            console.log('Error')
        }
    })
};

const CreateSession = (token, user, order) => {

    //console.log(token)

    let data = {
        "amount": order.amount,
        "antifraud":{
            "clientIp":"186.86.30.127",
            "merchantDefineData":{
                "MDD1": "1",
                "MDD2": "2",
                "MDD3": "3"
            }
        },
        "channel":"web"
    }

    $.ajax({
        method: 'POST',
        url: 'https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/342062522',
        headers: {
            "Authorization": token,
            "Content-Type": "application/json"
        },
        data: JSON.stringify(data)
    }).done((resp) => {
        //console.log(resp)
        SetScriptData(resp, token, user, order)
    }).catch((err) => {
        console.log(err)
    })

}

const SetScriptData = (session, token, user, order) => {

    let merchantid = '342062522';
    let sessiontoken = session.sessionKey;
    let channel = 'web';
    let merchantlogo = 'https://amolca.com/img/common/logo.png';
    let formbuttoncolor = '#00396f';
    let purchasenumber = order.id;
    let amount = order.amount;
    let expirationminutes = '5';
    let timeouturl = 'timeout.html';

    let visanet_script = document.createElement('script');

    visanet_script.setAttribute('src','https://static-content-qas.vnforapps.com/v2/js/checkout.js');
    visanet_script.setAttribute('data-sessiontoken', sessiontoken);
    visanet_script.setAttribute('data-channel', channel);
    visanet_script.setAttribute('data-merchantid', merchantid);
    visanet_script.setAttribute('data-merchantlogo', merchantlogo);
    visanet_script.setAttribute('data-formbuttoncolor', formbuttoncolor);
    visanet_script.setAttribute('data-purchasenumber', purchasenumber);
    visanet_script.setAttribute('data-amount', amount);
    visanet_script.setAttribute('data-expirationminutes', expirationminutes);
    visanet_script.setAttribute('data-timeouturl', timeouturl);

    visanet_script.setAttribute('data-cardholdername', user.name);
    visanet_script.setAttribute('data-cardholderlastname', user.lastname);
    visanet_script.setAttribute('data-cardholderemail', user.email);

    document.getElementById('visanet-payment-form').appendChild(visanet_script);

    $('#notification-modal #resp-desc').remove();
    $('#notification-modal #resp-buttons .button').remove();

    $('#notification-modal #resp-buttons').css('display', 'none');

    $('#notification-modal #resp-text').html(`¡Hola, <b>${user.name} ${user.lastname}</b>!<br/> Recibimos tu pedido exitosamente.`);

    $('#notification-modal').modal('open');

}
