/* Custom JS File */

(function($) {

	"use strict";

	jQuery(document).ready(function() {
    	
	     
		//sticky sidebar
		var at_body = $("body");
		var at_window = $(window);
		if(at_body.hasClass('at-sticky-sidebar')){
			if(at_body.hasClass('right-sidebar left-sidebar')){
				$('#secondary, #primary').theiaStickySidebar();
			}
			else{
				$('#secondary, #primary').theiaStickySidebar();
			}
		}

	});
})(jQuery);

