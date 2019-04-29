var lba = document.getElementsByClassName("social-share")

function myPopup() {
    window.open(this.href, 'mywin',
            'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
    event.preventDefault();
    return false;
}

for (var i = 0; i < lba.length; i++) {
    lba[i].addEventListener("click", myPopup, false);
}

$(document).ready(function() {
	$('form#big-searcher').on('submit', function(e) {
		e.preventDefault();
		if($('form#big-searcher input[type="text"]').val() !== '' && $('form#big-searcher input[type="text"]').val() !== '') {
			rute = '/buscar?s=' + $('form#big-searcher input[type="text"]').val();
			window.location.href = rute;
		}
	});
})

//Datepicker internationalization
const DatePickerOptions = {
	format: 'yyyy-mm-dd',
	i18n: {
		cancel: 'Cancelar',
		done: 'Seleccionar',
		months: [
			"Enero", "Febrero", "Marzo",
			"Abril", "Mayo", "Junio", "Julio",
			"Agosto", "Septiembre", "Octubre",
			"Noviembre", "Diciembre"
		],
		monthsShort: [
			'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
			'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
		],
		weekdays: [
			'Domingo', 'Lunes', 'Martes', 'Miércoles',
			'Jueves', 'Viernes', 'Sábado'
		],
		weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vier', 'Sab' ],
		weekdaysAbbrev: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ]
	}
}

//Formatting currencies
const FormatMoney = (n, c, d, t, sym, sympos) => {

	let code = '';
	let showcode = true;

	switch ($('meta[name="country-active"]').attr('content')) {
		case 'COLOMBIA':
			sym = '$';
			sympos = 'before';
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c)));
			code = 'COP';
			break;

		case 'PANAMA':
			c = 2;
			sym = '$';
			sympos = 'before';
			code = 'USD';
			d = '.';
			break;

		case 'ARGENTINA':
			c = 2;
			sym = '$';
			sympos = 'before';
			code = 'ARS';
			d = ',';
			break;

		case 'MEXICO':
			c = 2;
			sym = '$';
			sympos = 'before';
			code = 'MXN';
			t = ',';
			d = '.';
			break;

		case 'PERU':
			/*
			c = 2;
			sym = 'S/ ';
			sympos = 'before';
			t = ',';
			d = '.';
			*/
			c = 2;
			sym = '$';
			sympos = 'before';
			code = 'USD';
			d = '.';
			break;

		case 'DOMINICAN REPUBLIC':
			c = 2;
			sym = 'DOP$ ';
			sympos = 'before';
			t = '.';
			d = ',';
			break;

		default:
			c = 2;
			sym = '$';
			sympos = 'before';
			code = 'USD';
			d = '.';
			break;
	}

	var c = isNaN(c = Math.abs(c)) ? 2 : c,
	  	sym = sym == undefined ? "$" : sym,
	  	sympos = sympos == undefined ? "before" : sympos,
	    d = d == undefined ? "," : d,
	    t = t == undefined ? "." : t,
	    s = n < 0 ? "-" : "",
	    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
	    j = (j = i.length) > 3 ? j % 3 : 0;

  let formatted = s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

  switch(sympos) {
  	case 'before':
  		formatted = sym + formatted;
  		break;
  	case 'after':
  		formatted = formatted + sym;
  		break;
  }

  return formatted + ' ' + code;
};

//FormattingDates in javascript
const FormattingDate = (date) => {
	var monthNames = [
		"Enero", "Febrero", "Marzo",
		"Abril", "Mayo", "Junio", "Julio",
		"Agosto", "Septiembre", "Octubre",
		"Noviembre", "Diciembre"
	];

	var day = date.getDate();
	var monthIndex = date.getMonth();
	var year = date.getFullYear();

	return day + ' de ' + monthNames[monthIndex] + ', ' + year;
}

const AddCountryToForm = (id, name) => {

    let id_field = $('#country_id');
	let name_field = $('#country_name');

	if(name_field.length > 0) {
		name_field.val(name)
	}

    if(id_field.length > 0) {
		id_field.val(id)
	}
    
}
