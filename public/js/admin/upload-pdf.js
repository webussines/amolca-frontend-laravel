$(document).ready(function(){
	//Pdfs
	ValidatePdf();
	UploadPdf();
});

//Validacion de el pdf en "Peso y formato"
const ValidatePdf = () => {
	$('#pdf').on('change', function() {

		$('#pdf-error').css({ 'display': 'none' });

		let types = [ "pdf" ];
		let fileSize = $(this)[0].files[0].size;
		let fileType = $(this)[0].files[0].type.split('/')[1];
		console.log(fileType)

		//Validar si el archivo pesa más de 25000000 kb (25mb)
		if(fileSize > 25000000 ) {
			$('#pdf-error').html('El archivo excede los 25mb de peso.').css({ 'display': 'block' });
			$(this).val('');

			return false;
		}

		if(types.indexOf(fileType) < 0) {
			$('#pdf-error').html(`Los formatos permitidos son: <b>${types.join(', ')}</b>.`).css({ 'display': 'block' });
			return false;
		}

		ReadPdfUrl($(this)[0]);

		$('.file-upload-wrapper').css({ 'display': 'none' });
		$('#pdf-save-file-btn').css({ 'display': 'block' });
	});
}

//Renderizar pdf y mostrarla al usuario
const ReadPdfUrl = (input) => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#resource-pdf').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

//Subir pdf al servidor
const UploadPdf = () => {

	const _src = $('#_src').val();
	const RouteAuthorsImg = `https://amolca.webussines.com/uploads/${_src}/`;

	$('#pdf-save-file-btn').on('click', function() {

        $('#pdf-save-file-btn').val('Subiendo PDF...').attr('disabled', 'disabled');

		$('#resource-pdf').css({ 'opacity': '0.4' });

		let file = $('#pdf')[0].files[0];
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
			url: 'https://amolca.webussines.com/api/upload',
			data: send
		}).done(function(resp) {
			console.log(resp)

			setTimeout(function() {

				switch(resp.status) {
					case 500:

						//Devolver mensaje si ha ocurrido algun error
						$('#pdf-error')
							.html('Ha ocurrido un error, por favor intentelo de nuevo.')
							.css({ 'display': 'block' })

					break;

					case 409:

						//Devolver mensaje si el archivo ya existe
						$('#pdf-error')
							.html('Ya existe un archivo con este nombre.')
							.css({ 'display': 'block' })

					break;

					case 200:

						//Devolver mensaje si el archivo se subió exitosamente
						$('#pdf-error')
							.html('¡El PDF se subió correctamente!')
							.removeClass('error')
							.addClass('success')
							.css({ 'display': 'block' })

						$('#pdf-url').val(RouteAuthorsImg + resp.fileName).attr('type', 'text')
						localStorage.setItem('fileName', RouteAuthorsImg + resp.fileName);

						setTimeout(function() {
							$('#pdf-error')
								.css({ 'display': 'none' })
								.removeClass('success')
								.addClass('error')
						}, 2000);

					break;
				}

				$('#resource-pdf').css({ 'opacity': '1' });

				$('#pdf-save-file-btn').css({ 'display': 'none', 'background-color': '#4CAF50' }).val('Guardar PDF').removeAttr('disabled')
				$('.file-upload-wrapper').css({ 'display': 'block' });

			}, 1000)

		}).catch(function(err){
		    console.log(err)
		})
	});

}
