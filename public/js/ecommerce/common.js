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