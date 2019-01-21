$(document).ready(function() {

	InitEditorBoxes();
	SaveAuthor();

	ResetFormErrors();

});

//Funcion para inicializar los editores tinymce
const InitEditorBoxes = () => {
	tinymce.init({
	    selector: "textarea#content",
        theme: "modern",
        height: 180,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ]
	})
}

//Funcion que devuelve un arreglo con las especialidades seleccionadas
const GetCheckedSpecialties = function() {
	let values = [];

	$('#author-form input[name="specialty"]:checked').each(function() {
		values.push($(this).val());
	});

	return values;
}

//Funcion que devuelve el arreglo de las meta etiquetas
const GetMetaTags = function() {

	let tags = $('#meta-tags').val().split(',');

	return tags;

}

const ResetFormErrors = function() {
	$('.required-field').on('keyup change', function() {

		if($(this).val() !== '' && $(this).val() !== ' ') {

			if($(this).hasClass('field-error'))
				$(this).removeClass('field-error')

		}

	})
}

const SaveAuthor = function() {

	$('#title').on('blur', function() {
		let slug = GenerateSlug($('#title').val());

		$('span#slug span').html(slug);
	});

	$('.save-resource').on('click', function() {

		let flag = true;
		let _id = $('#_id').val();
		let _action = $('#_action').val();
		let _token = $('#_token').val();
		let _user = $('#_user').val();

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		let title = $('#title').val();
		let content = tinymce.activeEditor.getContent();
		let thumbnail = $('#image-url').val();
		let specialties = GetCheckedSpecialties();

		let meta_title = $('#meta-title').val();
		let meta_description = $('#meta-description').val();
		let meta_tags = GetMetaTags();

		let author = {
			type: 'author',
			title: title,
			content: content,
			thumbnail: thumbnail
		}

		//Ingresar los datos de las especialidades}
		if(specialties.length > 0) {
			author.taxonomies = specialties;
		}

		// Validar que hayan datos para insertar en la meta data
		if( (meta_title !== '' && meta_title !== ' ') ||
			(meta_description !== '' && meta_description !== ' ') ||
			(meta_tags.length > 0 && meta_tags[0] !== '') ) {
			author.meta = [];
		}

		//Insertar meta informacion 
		if(meta_title !== '' && meta_title !== ' ') {
			author.meta.push({ "key": "meta_title", "value": meta_title });
		}

		if(meta_description !== '' && meta_description !== ' ') {
			author.meta.push({ "key": "meta_description", "value": meta_description });
		}

		if(meta_tags.length > 0 && meta_tags[0] !== '') {
			let elem = { "key": "meta_tags", "value": '[' + meta_tags.join(',') + ']' };
			author.meta.push(elem);
		}

		let ActionRoute;
		let data_send = { "_token": _token }
	
		switch(_action) {
			case 'edit':
				ActionRoute = '/am-admin/authors/edit/' + _id;
				data_send.body = author
			break;

			case 'create':
				ActionRoute = '/am-admin/autores';
				author.slug = GenerateSlug(author.title);
				data_send.body = [author]

			break;
		}

		$('.required-field').each(function(){
			
			let val = $(this).val();

			if(val === ' ' || val === '' || val === null) {
				$(this).addClass('field-error');
				flag = false;
			}

		});

		if(flag) {

			$.ajax({
				method: 'POST',
				url: ActionRoute,
				data: data_send
			}).done(function(resp) {
				console.log(resp)

				let data = JSON.parse(resp);

				if(data.error !== undefined) {
					if (data.error == 'token_expired') {
						window.location.href = '/am-admin/logout?redirect=';
					}
				}

				if(data.status !== undefined) {
					
					switch(_action) {
						case 'edit':
							location.reload();
						break;
						case 'create':
							window.location.href = '/am-admin/autores/' + data.posts_id[0];
						break;
					}

				}
			}).catch(function(err) {
				console.log(err);
			})

		} else {
			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			let toastMsg = 'Debes llenar los campos obligatorios.';
			M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
		}

	});

}