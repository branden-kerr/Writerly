jQuery(window).on('load', function($){    
//masonry start
    var $grid = jQuery('#masonry-loop').imagesLoaded( function() {
    $grid.masonry({
    // options
    itemSelector: '.masonry-post, .one-column, .two-column'
    });
});  
//masonry end
});