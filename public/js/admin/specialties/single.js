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

	let thumbnail = $('#image-url').val();
	let title = $('#title').val();
	let description = $('#description').val();

	let specialty = {
		title: title,
		description: description,
		thumbnail: thumbnail,
		term_id: 2
	}

	let ApiRoute = '/am-admin/specialties';
	let data_send = {
		"_token": $('#_token').val()
	}

	switch(_action) {

		case 'create':
			specialty.slug = $('#slug').val();
			data_send.body = [specialty];
		break;
		case 'edit':
			data_send.update = specialty;
			ApiRoute += '/edit/' + _id;
		break;

	}

	$.ajax({
		method: 'POST',
		url: ApiRoute,
		data: data_send
	}).done((resp) => {
		console.log(resp)

		let data = JSON.parse(resp);

		if(data.term.id) {
			location.reload();
		}
	}).catch((err) => {
		console.log(err)
	})

}

const TransformResponse = function(resp) {
	console.log(resp)
}