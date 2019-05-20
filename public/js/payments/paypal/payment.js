jQuery(($) => {

  CreateOrderPayPal();

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

const CreateOrderPayPal = () => {
  paypal.Buttons({

    createOrder: function(data, actions) {

      if($('.loader.fixed').hasClass('hidde')) {
        $('.loader.fixed').removeClass('hidde');
      }

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

      let info = {
        "name": $('#checkoutform #name').val(),
        "lastname": $('#checkoutform #lastname').val(),
        "email": $('#checkoutform #email').val(),
        "mobile": $('#checkoutform #mobile').val(),
        "country": $('meta[name="country-active"]').attr('content'),
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

      let cont = true;

      // Set up the transaction
      if(!flag) {
        if(!$('.loader.fixed').hasClass('hidde')) {
          $('.loader.fixed').addClass('hidde');
        }
      } else {

        $.ajax({
          method: "POST",
          url: '/carts/checkout',
          data: info
        }).done(function(resp) {
          //console.log(resp)

          cont = true;

        }).catch(function(err) {
          if(!$('.loader.fixed').hasClass('hidde')) {
            $('.loader.fixed').addClass('hidde');
          }
          cont = false;
          console.log(err)
        })
      }

      if(flag && cont) {
        return actions.order.create({
          payer: {
              name: {
                given_name: $('#name').val(),
                surname: $('#lastname').val()
              },
              email_address: $('#email').val(),
              phone: {
                phone_type: 'MOBILE',
                phone_number: {
                  national_number: $('#mobile').val()
                }
              },
              address: {
                address_line_1: $('#address').val(),
                admin_area_2: $('#city').val(),
                postal_code: $('#postal_code').val(),
                country_code: 'PA'
              }
            },
            purchase_units: [{
              amount: {
                currency_code: 'USD',
                value: $('#total-amount').val()
              }
            }]
        });
      }
    }

  }).render('#paypal-button-container');
}
