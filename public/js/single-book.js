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

		ContenedorFoto.css({
          opacity: 1,
          position: 'absolute',
          left: 0,
          top: 0,
          bottom: 'auto'
        }).removeClass('scroll-fixed').removeClass('scroll-waiting')

        jQuery('.scroll-info').fadeOut();

	} else if(DistanciaScroll > ContenedorPrincipal) {

		ContenedorFoto.css({
          opacity: 1,
          position: 'fixed',
          left: '5%',
          top: '160px',
          bottom: '0px'
        }).removeClass('scroll-waiting').addClass('scroll-fixed')

        jQuery('.scroll-info').fadeIn();

	}
}