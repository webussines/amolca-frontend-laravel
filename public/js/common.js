$(document).ready(function(){
	$('.tooltipped').tooltip();
	$('.collapsible').collapsible();
	$('.dropdown-btn').dropdown();
	$('.tabs').tabs();
	$('.modal').modal();
	$('.normal-select').formSelect();

	//Images
	ValidateImage();
	UploadImage();
});

//Validacion de la imagen en "Peso y formato"
const ValidateImage = () => {
	$('#image').on('change', function() {

		$('#image-error').css({ 'display': 'none' });

		let types = [ "png", "jpg", "jpeg", "gif" ];
		let fileSize = $(this)[0].files[0].size;
		let fileType = $(this)[0].files[0].type.split('/')[1];

		//Validar si el archivo pesa más de 25000000 kb (25mb)
		if(fileSize > 25000000 ) {
			$('#image-error').html('El archivo excede los 25mb de peso.').css({ 'display': 'block' });
			$(this).val('');

			return false;
		}

		if(types.indexOf(fileType) < 1) {
			$('#image-error').html(`Los formatos permitidos son: <b>${types.join(', ')}</b>.`).css({ 'display': 'block' });
			return false;
		}

		ReadImgUrl($(this)[0]);

		$('.file-upload-wrapper').css({ 'display': 'none' });
		$('#save-file-btn').css({ 'display': 'block' });
	});
}

//Renderizar imagen y mostrarla al usuario
const ReadImgUrl = (input) => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#resource-image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

//Subir imagen al servidor
const UploadImage = () => {

	const _src = $('#_src').val();
	const RouteAuthorsImg = `https://amolca.webussines.com/uploads/${_src}/`;
	
	$('#save-file-btn').on('click', function() {

		if(!$('.circle-preloader').hasClass('show'))
			$('.circle-preloader').addClass('show')

		$('#resource-image').css({ 'opacity': '0.4' });

		let file = $('#image')[0].files[0];
		let _token = $('#_token').val();

		var send = new FormData();
		send.append('src', _src);
		send.append('_token', _token);
		send.append('file', file);

		$.ajax({
			method: 'POST',
			contentType: false,
			processData: false,
			enctype: 'multipart/form-data',
			url: '/api/upload',
			data: send
		}).done(function(resp) {
			console.log(resp)

			setTimeout(function() {

				switch(resp.status) {
					case 500:

						//Devolver mensaje si ha ocurrido algun error
						$('#image-error')
							.html('Ha ocurrido un error, por favor intentelo de nuevo.')
							.css({ 'display': 'block' })

					break;

					case 409:

						//Devolver mensaje si el archivo ya existe
						$('#image-error')
							.html('Ya existe un archivo con este nombre.')
							.css({ 'display': 'block' })

					break;

					case 200:

						//Devolver mensaje si el archivo se subió exitosamente
						$('#image-error')
							.html('¡La imagen se subió correctamente!')
							.removeClass('error')
							.addClass('success')
							.css({ 'display': 'block' })

						$('#image-url').val(RouteAuthorsImg + resp.fileName)

						setTimeout(function() {
							$('#image-error')
								.css({ 'display': 'none' })
								.removeClass('success')
								.addClass('error')
						}, 2000);

					break;
				}

				//Devolver botones y textos a su estado natural
				if($('.circle-preloader').hasClass('show'))
					$('.circle-preloader').removeClass('show')

				$('#resource-image').css({ 'opacity': '1' });

				$('#save-file-btn').css({ 'display': 'none' });
				$('.file-upload-wrapper').css({ 'display': 'block' });
				
			}, 1000)

		}).catch(function(err){
		    console.log(err)
		})
	});

}