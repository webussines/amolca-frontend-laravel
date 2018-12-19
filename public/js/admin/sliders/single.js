jQuery(function($) {
	$(document).ready(function() {
		GenerateGrid();

		$('.edit').on('click', EditSlideItem);

	});
});

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

	//Define parent element
	let parent = $(e.target).parent().parent().parent()[0];
	
	//Define slide info
	let imgElement = $(parent).children('.slide-url');
	let image = $(imgElement).val();

	$('#resource-image').attr('src', image);
	$('#image-url').val(image);

	grid.on('move', function (item, event) {
		grid.getItems().forEach(function (item, i) {
			item.getElement().setAttribute('data-id', i);
			item.getElement().querySelector('.order').innerHTML = i;
		});
	});

	console.log(slideIndex)

}