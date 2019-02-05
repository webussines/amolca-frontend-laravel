jQuery(function($) {
	$(document).ready(function() {
		GenerateGrid();

		$('.edit').on('click', EditSlideItem);
		$('.cancel').on('click', CancelEditSlideItem);
		$('.save-changes').on('click', SaveItemChanges);
		$('.save-resource').on('click', SaveSlider);

		$('#add-slide').on('click', AddNewItem);
		$('.delete').on('click', function() {
			DeleteItem($(this))
		});

	});
});

var GlobalActiveImage;

const AddNewItem = (e) => {

	e.preventDefault();

	$('#add-slide').attr('disabled', 'disabled');
	$('.save-changes').addClass('new-item');

	$('.buttons').css({ 'display': 'flex' });

}

const DeleteItem = (elem) => {
	let parent = $(elem).parent();
	let index = $(parent).find('.order').html();

	let item = $(elem).parent().parent().parent('.item').removeClass('muuri-item muuri-item-shown').css('display', 'none');
	let grid = new Muuri('.grid');
	
	//return console.log(index)
	grid.remove([index],  {removeElements: true, layout: true});
}

const GenerateGrid = () => {
	const grid = new Muuri('.grid', {
		dragEnabled: true,
		items: '.item',
		layout: function(items, gridWidth, gridHeight) {
		    
		    var layout = {
              // The layout's item slots (left/top coordinates).
              slots: [],
              // The layout's total width.
              width: 0,
              // The layout's total height.
              height: 0,
              // Should Muuri set the grid's width after layout?
              setWidth: true,
              // Should Muuri set the grid's height after layout?
              setHeight: true
            };
            
            // Calculate the slots.
            var item;
            var m;
            
            var y = 0;
            
            var h = 0;
            for (var i = 0; i < items.length; i++) {
                var w = 0;
                var x = 0;
                item = items[i];
                x += w;
                y += h;
                m = item.getMargin();
                w = item.getWidth() + m.left + m.right;
                h = item.getHeight() + m.top + m.bottom;
                layout.slots.push(x, y);
            }
        
            // Calculate the layout's total width and height. 
            layout.width = x + w;
            layout.height = y + h;
            
            for(let i = 0; i < items.length; i++) {
		        console.log(items[i], i)
    			items[i].getElement().setAttribute('data-id', i);
    			items[i].getElement().querySelector('.order').innerHTML = i;
		    }
        
            return layout;
		},
		layoutOnResize: true
	})
	
	/*
	grid.getItems().each(function (item, i) {
    	console.log(item, i)
		item.getElement().setAttribute('data-id', i);
		item.getElement().querySelector('.order').innerHTML = i;
	});
	*/
		
	/*
	grid.on('move', function (item, event) {
		grid.getItems().each(function (item, i) {
		    console.log(item, i)
			item.getElement().setAttribute('data-id', i);
			item.getElement().querySelector('.order').innerHTML = i;
		});
	});
	*/
}

const EditSlideItem = (e) => {

	$('.buttons').css({ 'display': 'flex' });

	//Define parent element
	let parent = $(e.target).parent().parent().parent()[0];
	
	//Define slide info
	let imgLink = $(parent).children('.slide-link');
	console.log($(imgLink).val())
	let imgElement = $(parent).children('.slide-url');
	let image = $(imgElement).val();

	$('#resource-image').attr('src', image);
	$('#image-url').val(image);
	$('#image-link').val($(imgLink).val());

	GlobalActiveImage = image;

}

const CancelEditSlideItem = () => {
	$('#resource-image').attr('src', 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg');
	$('#image-url').val('');
	$('#image-link').val('');

	$('.buttons').css({ 'display': 'none' });

	if($('#add-slide').attr('disabled') == 'disabled') {
		$('#add-slide').removeAttr('disabled');
	}
}

const SaveItemChanges = () => {

	if(!$('.save-changes').hasClass('new-item')) {
		$('.drag-grid .grid .item').each(function(elem) {
			let child = $(this).children().children('.slide-url');
			let link = $(this).children().children('.slide-link');
			let newImg = localStorage.getItem('fileName');

			if(child.val() == GlobalActiveImage) {
				
				if(newImg !== null) {
				    child.val(newImg)
				    $(this).css({ 'background-image': 'url(' + newImg + ')' })
				} else {
				    child.val(GlobalActiveImage)
				    $(this).css({ 'background-image': 'url(' + GlobalActiveImage + ')' })
				}
				link.val($('#image-link').val())

				$('#resource-image').attr('src', 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg');
				$('#image-url').val('');
				$('#image-link').val('');

				$('.buttons').css({ 'display': 'none' });
			}
		});
	} else {
		let order = GetSliderItems().length + 1;
		let tmp = `<div class="item" style="background-image: url('${localStorage.getItem('fileName')}');">
				        <div class="item-content">
				            <input type="hidden" class="slide-link" value="${$('#image-link').val()}">
				            <input type="hidden" class="slide-url" value="${localStorage.getItem('fileName')}">
				            <p class="options">
				                <a class="order">${order}</a>
				                <a class="edit"><span class="icon-mode_edit"></span></a>
				            </p>
				        </div>
				    </div>`;

		$('.drag-grid .grid').append(tmp);
		GenerateGrid();

		$('#resource-image').attr('src', 'https://amolca.webussines.com/uploads/sliders/slider-no-image.jpg');
		$('#image-url').val('');

		$('.buttons').css({ 'display': 'none' });
	}

	if($('#add-slide').attr('disabled') == 'disabled') {
		$('#add-slide').removeAttr('disabled');
	}
}

const GetSliderItems = () => {

	let items = [];

	$('.drag-grid .item.muuri-item-shown').each(function() {

		let elem = {};
    
        elem.link = $(this).find('.slide-link').val();
		elem.image = $(this).find('.slide-url').val();
		elem.order = $(this).find('.order').html();

		if($(this).find('.slide-id').val() !== undefined) {
			elem.id = $(this).find('.slide-id').val();
		}

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

	$.ajax({
		method: 'POST',
		url: '/am-admin/api-sliders/edit/' + _id,
		data: {
			"update": slider,
			"_token": _token
		}
	}).done(function(resp) {
		console.log(resp)

		let data = JSON.parse(resp);

		if(data.error !== undefined) {
			if (data.error == 'token_expired') {
				let toastMsg = 'Su sesi贸n ha expirado, en segundo ser谩 redirigido para iniciar sesi贸n de nuevo.';
				M.toast({html: toastMsg, classes: 'red accent-4 bottom'});
				
				setTimeout(function() {
					window.location.href = '/am-admin/logout?redirect=';
				}, 5000);
			}
		}

		if(data.status !== undefined) {
			location.reload();
		}
	}).catch(function(err) {
		console.log(err)
	})
}