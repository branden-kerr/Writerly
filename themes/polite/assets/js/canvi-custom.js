/* Offcanvas file */

(function($) {

    "use strict";

    jQuery(document).ready(function() {
 	var polite_t = new Canvi({
    content: ".js-canvi-content",
    isDebug: !1,
    //navbar: ".myCanvasNav",
    openButton: ".js-canvi-open-button--left",
    position: "left",
    closeButton: ".canvi-close-button",
    pushContent: !1,
    speed: "0.2s",
    width: "100vw",
    responsiveWidths: [ {
        breakpoint: "600px",
        width: "280px"
    }, {
        breakpoint: "1280px",
        width: "320px"
    }, {
        breakpoint: "1600px",
        width: "380px"
    } ]
})

$('.closebtn').on('click', function(){
        polite_t.close();
    });
})
})(jQuery);