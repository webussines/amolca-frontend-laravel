jQuery(function($) {

  $.ajax({
    method: 'GET',
    url: '/am-admin/countries/all'
  }).done((resp) => {

    //console.log(resp)
    RedirectFunction(JSON.parse(resp))

  }).catch((err) => {
    console.log(err)
  })

});

const RedirectFunction = (country) => {

  $.get("https://ipinfo.io", function(response) {
    //console.log(response);

    let search = country.filter(c => c.code == response.country);
    let active = search[0].title.toUpperCase();

    $('meta[name="country-active-id"]').attr('content', search[0].id)

    AddCountryToForm(search[0].id, search[0].title);

    switch (active) {
      case 'ARGENTINA':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.ar')
        }
        break;

      case 'PERU':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.pe')
        }
        break;

      /*
      case 'DOMINICAN REPUBLIC':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.do')
        }
        break;
        */

      case 'COLOMBIA':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.co')
        }
        break;

      case 'MEXICO':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.mx')
        }
        break;

      case 'PANAMA':
        if (window.location.href.indexOf("amolca.com.pa") < 1) {
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com.pa')
        }
        return console.log('PANAMA')
        break;

      default:
            window.location.href = RedirectToCountry(window.location.href, window.location.host, 'amolca.com')
        break;
    }

  }, "jsonp").fail(function(jqXHR, exception) {
    $('.books-loop .item .actions, .scroll-info, .main.book .add-to-cart, .price').css('display', 'none');
    return console.log('PANAMA')
  });

};
