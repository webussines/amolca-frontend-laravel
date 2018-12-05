jQuery(function($) {
	ScrollInteraction();

	$('.collapsible').collapsible({
		onOpenStart: function(e) {
			ScrollInteractionFunction();
		},
		onOpenEnd: function(e) {
			ScrollInteractionFunction();
		},
		onCloseStart: function(e) {
			ScrollInteractionFunction();
		},
		onCloseEnd: function(e) {
			ScrollInteractionFunction();
		}
	});
});

const ScrollInteraction = () => {
	//Function al hacer scroll
	$(window).scroll(function() {
		ScrollInteractionFunction();		
	});
}

const ScrollInteractionFunction = () => {

	//Variables
	let ContenedorFoto = $('#image-container');

	//Variables de distancias
	let DistanciaScroll = $(window).scrollTop();
	let ContenedorPrincipal = $('#single-book').offset().top;
	let LibrosRelacionados = $('.related-products').offset().top;

	//Variables de altura
	let AlturaImagenFija = ContenedorFoto.height();
	let AlturaCabezote = $('.header').height() + $('.top-bar').height();
	let AlturaContenidoFijo = AlturaImagenFija + AlturaCabezote;
	let MaximoDeScroll = LibrosRelacionados - AlturaContenidoFijo - 40;

	if(DistanciaScroll < ContenedorPrincipal) {

		//Si el contenedor tiene la clase "waiting" removerla
		if(ContenedorFoto.hasClass('scroll-waiting'))
			ContenedorFoto.removeClass('scroll-waiting');

		//Si el contenedor tiene la clase "fixed" removerla
		if(ContenedorFoto.hasClass('scroll-fixed'))
			ContenedorFoto.removeClass('scroll-fixed');

	} else if(DistanciaScroll > ContenedorPrincipal && DistanciaScroll < MaximoDeScroll) {

		//Si el contenedor tiene la clase "waiting" removerla
		if(ContenedorFoto.hasClass('scroll-waiting'))
			ContenedorFoto.removeClass('scroll-waiting');

		//Si el contenedor no tiene la clase "fixed" agregarla
		if(!ContenedorFoto.hasClass('scroll-fixed'))
			ContenedorFoto.addClass('scroll-fixed');

	} else if(DistanciaScroll > ContenedorPrincipal && DistanciaScroll > MaximoDeScroll) {

		//Si el contenedor tiene la clase "fixed" removerla
		if(ContenedorFoto.hasClass('scroll-fixed'))
			ContenedorFoto.removeClass('scroll-fixed');

		//Si el contenedor no tiene la clase "waiting" agregarla
		if(!ContenedorFoto.hasClass('scroll-waiting'))
			ContenedorFoto.addClass('scroll-waiting');

	}
}