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

    switch (active) {
      case 'ARGENTINA':
        if (window.location.href.indexOf("amolca.com.do") > 0) {
          window.location.href = window.location.href.replace(window.location.host, 'amolca.com.ar')
        }
        break;

      case 'COLOMBIA':
        if (window.location.href.indexOf("amolca.com.do") > 0) {
          window.location.href = window.location.href.replace(window.location.host, 'amolca.com.co')
        }
        break;

      case 'PANAMA':
        if (window.location.href.indexOf("amolca.com.do") > 0) {
          window.location.href = window.location.href.replace(window.location.host, 'amolca.com.pa')
        }
        break;

      case 'PERU':
        if (window.location.href.indexOf("amolca.com.do") > 0) {
          window.location.href = window.location.href.replace(window.location.host, 'amolca.com.pe')
        }
        break;

      case 'DOMINICAN REPUBLIC':
        if (window.location.href.indexOf("amolca.com.do") < 1) {
          window.location.href = window.location.href.replace(window.location.host, 'amolca.com.do')
        }
        return console.log('DOMINICAN REPUBLIC')
        break;

      default:
         window.location.href = window.location.href.replace(window.location.host, 'amolca.com')
        break;
    }

  }, "jsonp").fail(function(jqXHR, exception) {
    $('.books-loop .item .actions, .scroll-info, .main.book .add-to-cart, .price').css('display', 'none');
    return console.log('REPUBLICA DOMINICANA')
  });

}