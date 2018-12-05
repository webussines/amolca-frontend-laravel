jQuery(function($){

	$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window, .moxman-window").length) {
        e.stopImmediatePropagation();
    }
});

	$(document).ready(function(){
		tinymce.init({
		    selector: "textarea#description",
	        theme: "modern",
	        //width: 400,
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
	        //width: 400,
	        height: 300,
	        plugins: [
	             "code link image imagetools visualblocks visualchars advcode",
	             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
	             "save contextmenu directionality emoticons template paste textcolor"
	       ],
		})
	});
});