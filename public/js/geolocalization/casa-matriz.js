jQuery(function($) {

  let country = AllCountries();

  $.get("https://ipinfo.io", function(response) {
      //console.log(response);

      let search = country.filter(c => c.code == response.country);
      let active = search[0].name.toUpperCase();

      switch (active) {
        case 'PERU':
          if (window.location.href.indexOf("amolca.com.pe") < 1) {
            window.location.href = 'http://www.amolca.com.pe'
          }
          break;

        case 'DOMINICAN REPUBLIC':
          if (window.location.href.indexOf("amolca.com.do") < 1) {
            window.location.href = 'http://www.amolca.com.do'
          }
          break;

        case 'COLOMBIA':
          if (window.location.href.indexOf("amolca.com.co") < 1) {
            window.location.href = 'http://www.amolca.com.co'
          }
          break;

        case 'PANAMA':
          if (window.location.href.indexOf("amolca.com.pa") < 1) {
            window.location.href = 'http://www.amolca.com.pa'
          }
          break;

        case 'ARGENTINA':
          if (window.location.href.indexOf("amolca.com.ar") < 1) {
            window.location.href = 'http://www.amolca.com.ar'
          }
          break;

        default:
          if (window.location.href.indexOf("amolca.com") < 1) {
            window.location.href = 'http://www.amolca.com';
          }
          return console.log('CASA MATRIZ')
          break;
      }

    }, "jsonp").fail(function(jqXHR, exception) {
      if (window.location.href.indexOf("amolca.com") < 1) {
        window.location.href = 'http://www.amolca.com';
      }
      return console.log('CASA MATRIZ')
    });

});