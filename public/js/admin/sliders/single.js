jQuery(function($) {
	$(document).ready(function() {
		GenerateGrid();

		$('.edit').on('click', EditSlideItem);
		$('.cancel').on('click', CancelEditSlideItem);
		$('.save-changes').on('click', SaveItemChanges);
		$('.save-resource').on('click', SaveSlider);

	});
});

var GlobalActiveImage;

const GenerateGrid = () => {
	const grid = new Muuri('.grid', {
		dragEnabled: true,
		items: '.item'
	});

	grid.on('move', function (item, event) {
		grid.getItems().forEach(function (item, i) {
			item.getElement().setAttribute('data-id', i);
			item.getElement().querySelector('.order').innerHTML = i;
		});
	});
}

const EditSlideItem = (e) => {

	$('.buttons').css({ 'display': 'flex' });

	//Define parent element
	let parent = $(e.target).parent().parent().parent()[0];
	
	//Define slide info
	let imgElement = $(parent).children('.slide-url');
	let image = $(imgElement).val();

	$('#resource-image').attr('src', image);
	$('#image-url').val(image);

	GlobalActiveImage = image;

}

const CancelEditSlideItem = () => {
	$('#resource-image').attr('src', 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg');
	$('#image-url').val('');

	$('.buttons').css({ 'display': 'none' });
}

const SaveItemChanges = () => {
	
	$('.drag-grid .grid .item').each(function(elem) {
		let child = $(this).children().children('.slide-url');
		let newImg = localStorage.getItem('fileName');

		if(child.val() == GlobalActiveImage) {
			child.val(newImg)
			$(this).css({ 'background-image': 'url(' + newImg + ')' })

			$('#resource-image').attr('src', 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg');
			$('#image-url').val('');

			$('.save-changes').css({ 'display': 'none' });
		}
	});

}

const GetSliderItems = () => {

	let items = [];

	$('.drag-grid .item').each(function() {

		let elem = {};

		elem.image = $(this).find('.slide-url').val();
		elem.order = $(this).find('.order').html();

		if(typeof elem.order == 'string') {
			elem.order = parseInt(elem.order)
		}

		items.push(elem);

	});

	return items;

}

const SaveSlider = () => {

	if($('.loader').hasClass('hidde'))
		$('.loader').removeClass('hidde')

	let _id = $('#id').val();
	let _token = $('#_token').val();

	let slider = {
		title: $('#title').val(),
		items: GetSliderItems()
	}

	console.log(_id)

	$.ajax({
		method: 'POST',
		url: '/am-admin/sliders/edit/' + _id,
		data: {
			"update": slider,
			"_token": _token
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
	}).catch(function(err) {
		console.log(err)
	})
}