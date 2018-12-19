$(document).ready(function() {

	InitEditorBoxes();
	SaveAuthor();

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
       ],
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

const SaveAuthor = function() {

	$('.save-resource').on('click', function() {

		if($('.loader').hasClass('hidde'))
			$('.loader').removeClass('hidde')

		let id = $('#_id').val();
		let name = $('#name').val();
		let description = $('#description').val();
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

		//console.log(author)

		$.ajax({
			method: 'POST',
			url: '/am-admin/authors/edit/' + id,
			data: {
				"update": author,
				"_token": $('#_token').val()
			}
		}).done(function(resp) {
			console.log(resp)

			let data = JSON.parse(resp);

			if(data._id !== undefined) {
				location.reload();
			} else {
				switch(data.status) {
				}
			}
		})

	});

}