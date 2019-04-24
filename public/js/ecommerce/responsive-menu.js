jQuery(function($) {

	$('#mobile-btn').on('click', MobileMenu);

	$('#hmenu > li').on('click', function() {
		ShowSubmenuItem($(this))
	});

});


//Mobile button function
const MobileMenu = () => {

	//Remove router link to parent item
	let parentItem = $('.hmenu > li');
	parentItem.each(function() {
	  if($(this).children('ul').length > 0) {
	    $(this).children('a').removeAttr('href');
	  }
	});

	let btn = document.getElementById('mobile-btn');
	let menu = document.getElementById('hmenu');

	//Button "add" & "remove" class
	if(btn.classList.contains('active')) {
	  btn.classList.remove('active')
	} else {
	  btn.classList.add('active')
	}

	//Menu "add" & "remove" class
	if(menu.classList.contains('active')) {
	  menu.classList.remove('active')
	} else {
	  menu.classList.add('active')
	}

}

//Show submenu's
const ShowSubmenuItem = (elem) => {

	let id = $(elem).attr('id');
	let windowWidth = $(window).width();
	let submenuId = `#submenu-${id}`;

	if(windowWidth <= 1280) {
	  $(submenuId).slideToggle('slow', function() {
	    //Change display "block" for "flex"
	    if($(this).is(':visible')) {
	    	$(this).css('display', 'flex')
	    }
	  });
  } else if(windowWidth <= 480) {
	  $(submenuId).slideToggle('slow', function() {
	    //Change display "block" for "flex"
	    if($(this).is(':visible')) {
	    	$(this).css('display', 'block')
	    }
	  });
  }
}
