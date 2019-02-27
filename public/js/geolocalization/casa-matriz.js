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
      case 'PERU':
        if (window.location.href.indexOf("amolca.com.pe") < 1) {
          return window.location.href = 'http://www.amolca.com.pe'
        }
        break;

      case 'DOMINICAN REPUBLIC':
        if (window.location.href.indexOf("amolca.com.do") < 1) {
          return window.location.href = 'http://www.amolca.com.do'
        }
        break;

      case 'COLOMBIA1':
        if (window.location.href.indexOf("amolca.com.co") < 1) {
          return window.location.href = 'http://www.amolca.com.co'
        }
        break;

      case 'PANAMA':
        if (window.location.href.indexOf("amolca.com.pa") < 1) {
          return window.location.href = 'http://www.amolca.com.pa'
        }
        break;

      case 'ARGENTINA':
        if (window.location.href.indexOf("amolca.com.ar") < 1) {
          return window.location.href = 'http://www.amolca.com.ar'
        }
        break;

      default:
        if (window.location.href.indexOf("amolca.com") < 1) {
          return window.location.href = 'http://www.amolca.com';
        }

        ShowDealersModal(search[0].id, search[0].title);

        return console.log('CASA MATRIZ', active)
        break;
    }

  }, "jsonp").fail(function(jqXHR, exception) {
    if (window.location.href.indexOf("amolca.com") < 1) {
      window.location.href = 'http://www.amolca.com';
    }
    return console.log('CASA MATRIZ')
  });
}

const ShowDealersModal = (id, country) => {

  $('#dealers-modal .modal-description .country').html(country);

  $.ajax({
    method: 'GET',
    url: '/am-admin/dealers/country/' + id
  }).done((resp) => {

    for (let i = 0; i < resp.length; i++) {

      let tmp = DealerTmp(resp[i]);
      
      $('.modal-dealers').append(tmp);

    }
    
  }).catch((err) => {
    console.log(err)
  })

  $(document).ready(() => {
    $('#dealers-modal').modal('open');
  });

}

const DealerTmp = (data) => {

  let address = 'Sin dirección.';
  let contact = 'Sin contacto.';
  let phone = 'Sin teléfono.';
  let email = 'Sin correo electrónico.';

  for (let i = 0; i < data.meta.length; i++) {
    switch (data.meta[i].meta_key) {
      case 'phone':
        phone = data.meta[i].meta_value;
        break;
      case 'address':
        address = data.meta[i].meta_value;
        break;
      case 'contact_person':
        contact = data.meta[i].meta_value;
        break;
      case 'email':
        email = data.meta[i].meta_value;
        break;
    }
  }

  let html = `<tr>
                <td class="name">${data.title}</td>
                <td class="contact">${contact}</td>
                <td class="address">${address}</td>
                <td class="phone">${phone}</td>
                <td class="email">${email}</td>
              </tr>`;

  return html;

}