$(document).ready(function() {

	InitEditorBoxes();
	SaveAuthor();

	ResetFormErrors();

});

//Funcion para inicializar los editores tinymce
const InitEditorBoxes = () => {
	tinymce.init({
	    selector: "textarea#description",
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

	$('.save-resource').on('click', function() {

		let flag = true;
		let _id = $('#_id').val();
		let _action = $('#_action').val();
		let _token = $('#_token').val();
		let _user = $('#_user').val();

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		let name = $('#name').val();
		let description = tinymce.activeEditor.getContent();
		let image = $('#image-url').val();
		let specialties = GetCheckedSpecialties();

		let metaTitle = $('#meta-title').val();
		let metaDescription = $('#meta-description').val();
		let metaTags = GetMetaTags();

		let author = {
			name: name,
			description: description,
			image: image,
			specialty: specialties,
			metaTitle: metaTitle,
			metaDescription: metaDescription,
			metaTags: metaTags
		}

		let ActionRoute;
	
		switch(_action) {
			case 'edit':
				ActionRoute = '/am-admin/authors/edit/' + _id;
			break;

			case 'create':
				ActionRoute = '/am-admin/autores';
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
				data: {
					"body": author,
					"_token": _token
				}
			}).done(function(resp) {
				console.log(resp)

				let data = JSON.parse(resp);

				if(data._id !== undefined) {
					
					switch(_action) {
						case 'edit':
							location.reload();
						break;
						case 'create':
							window.location.href = '/am-admin/autores/' + data._id;
						break;
					}

				}
			}).catch(function(err) {
				console.log(err)
			})

		} else {
			if(!$('.loader').hasClass('hidde'))
				$('.loader').addClass('hidde')

			let toastMsg = 'Debes llenar los campos obligatorios.';
			M.toast({html: toastMsg, classes: 'red accent-4 bottom left'});
		}

	});

}