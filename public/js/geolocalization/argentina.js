jQuery(function($) {

  let country = AllCountries();

  $.get("https://ipinfo.io", function(response) {
      //console.log(response);

      let search = country.filter(c => c.code == response.country);
      let active = search[0].name.toUpperCase();

      switch (active) {
        case 'PERU':
          if (window.location.href.indexOf("amolca.com.ar") > 0) {
            window.location.href = 'http://www.amolca.com.pe'
          }
          break;

        case 'DOMINICAN REPUBLIC':
          if (window.location.href.indexOf("amolca.com.ar") > 0) {
            window.location.href = 'http://www.amolca.com.do'
          }
          break;

        case 'COLOMBIA':
          if (window.location.href.indexOf("amolca.com.ar") > 0) {
            window.location.href = 'http://www.amolca.com.co'
          }
          break;

        case 'PANAMA':
          if (window.location.href.indexOf("amolca.com.ar") > 0) {
            window.location.href = 'http://www.amolca.com.ar'
          }
          break;

        case 'ARGENTINA':
          if (window.location.href.indexOf("amolca.com.ar") < 1) {
            window.location.href = 'http://www.amolca.com.ar'
          }
          return console.log('ARGENTINA')
          break;

        default:
          window.location.href = 'http://www.amolca.com';
          break;
      }

    }, "jsonp").fail(function(jqXHR, exception) {
      if (window.location.href.indexOf("amolca.com.ar") < 1) {
        window.location.href = 'http://www.amolca.com';
      }
      return console.log('ARGENTINA')
    });

});