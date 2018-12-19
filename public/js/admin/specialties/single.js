jQuery(function($) {
	InitTinyMceEditor();

	$('.save-resource').on('click', function() {
		SaveSpecialtyInfo();
	});
});

const InitTinyMceEditor = function() {
	tinymce.init({
	    selector: "textarea#description",
        theme: "modern",
        height: 200,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})

	tinymce.init({
	    selector: "textarea.common-editor",
        theme: "modern",
        height: 300,
        plugins: [
             "code link image imagetools visualblocks visualchars advcode",
             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
             "save contextmenu directionality emoticons template paste textcolor"
       ],
	})
}

const SaveSpecialtyInfo = function() {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let _action = $('#_action').val();
	let _token = $('#_token').val();
	let _id = $('#_id').val();

	let image = $('#image-url').val();
	let title = $('#title').val();
	let description = $('#description').val();
	let metaTitle = $('#meta-title').val();
	let metaDescription = $('#meta-description').val();
	let metaTags = $('#meta-tags').val();

	let specialty = {
		title: title,
		description: description,
		image: image,
		metaTitle: metaTitle,
		metaDescription: metaDescription,
		metaTags: metaTags
	}

	const ApiRoute = '/am-admin/specialties';

	switch(_action) {

		case 'create':
			$.ajax({
				method: 'POST',
				url: ApiRoute + '/create',
				data: {
					"body": specialty,
					"_token": $('#_token').val()
				}
			}).done(function(resp) {
				console.log(resp)

				let data = JSON.parse(resp);

				if(data.status == 200) {
					location.reload();
				} else {
					TransformResponse(data)
				}
			})
		break;
		case 'edit':

			$.ajax({
				method: 'POST',
				url: ApiRoute + '/edit/' + _id,
				data: {
					"update": specialty,
					"_token": $('#_token').val()
				}
			}).done(function(resp) {
				console.log(resp)

				let data = JSON.parse(resp);

				if(data._id !== undefined) {
					location.reload();
				} else {
					TransformResponse(data)
				}
			})

		break;

	}

}

const TransformResponse = function(resp) {
	console.log(resp)
}