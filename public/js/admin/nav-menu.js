jQuery(function($) {

  subMenuInteraction();

});


const subMenuInteraction = function() {

    $('.vmenu > li > a').on('click', function(e) {

      let name = $(this).data('id');
      let navMenu = document.getElementById('nav-menu');
      let parent = $(e.target).parents('a');

      if(!navMenu.classList.contains('menu-hidden')) {

        jQuery('.submenu').each(function() {
          if(jQuery(this).is(':visible')) {

            //Remove clase "actived" al item
            if(parent.length > 0) {
              if($(parent[0]).hasClass('actived'))
                $(parent[0]).removeClass('actived');
            }

            jQuery(this).slideUp();
          }

          if(jQuery(this).data('menu') == name && jQuery(this).is(':hidden')) {

            $('.vmenu > li > a').each(function(){
              if($(this).hasClass('actived')) {
                $(this).removeClass('actived');
              }
            })

            //Remove clase "actived" al item
            if(parent.length > 0) {
              console.log($(parent[0]))
              if(!$(parent[0]).hasClass('actived'))
                $(parent[0]).addClass('actived');
            }

            jQuery(this).slideToggle();
            jQuery(this).toggleClass('active');
          }
        });
        
      }
    });

}