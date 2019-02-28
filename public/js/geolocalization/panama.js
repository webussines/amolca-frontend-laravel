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
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
          window.location.href = 'http://www.amolca.com.ar'
        }
        break;

      case 'PERU':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
          window.location.href = 'http://www.amolca.com.pe'
        }
        break;

      case 'DOMINICAN REPUBLIC':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
          window.location.href = 'http://www.amolca.com.do'
        }
        break;

      case 'COLOMBIA':
        if (window.location.href.indexOf("amolca.com.pa") > 0) {
          window.location.href = 'http://www.amolca.com.co'
        }
        break;

      case 'PANAMA':
        if (window.location.href.indexOf("amolca.com.pa") < 1) {
          window.location.href = 'http://www.amolca.com.pa'
        }
        return console.log('PANAMA')
        break;

      default:
        window.location.href = 'http://www.amolca.com';
        break;
    }

  }, "jsonp").fail(function(jqXHR, exception) {
    if (window.location.href.indexOf("amolca.com.pa") < 1) {
      window.location.href = 'http://www.amolca.com'
    }
    return console.log('PANAMA')
  });

};