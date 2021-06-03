/* Custom JS File */

(function($) {

	"use strict";

	jQuery(document).ready(function() {
    	

    //infinite pagination
    /*new pagination style*/
    var paged = parseInt(polite_ajax.paged) + 1;
    var max_num_pages = parseInt(polite_ajax.max_num_pages);
    var next_posts = polite_ajax.next_posts;

    $(document).on( 'click', '.show-more', function( event ) {
      event.preventDefault();
        var show_more = $(this);
        var click = show_more.attr('data-click');
        if( (paged-1) >= max_num_pages){
            show_more.html(polite_ajax.no_more_posts)
        }
        if( click == 0 || (paged-1) >= max_num_pages){
            return false;
        }
        show_more.html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
        show_more.attr("data-click", 0);
        var page = parseInt( show_more.attr('data-number') );

        $('#free-temp-post').load(next_posts + ' article.post', function() {
            /*http://stackoverflow.com/questions/17780515/append-ajax-items-to-masonry-with-infinite-scroll*/
            paged++;/*next page number*/
            next_posts = next_posts.replace(/(\/?)page(\/|d=)[0-9]+/, '$1page$2'+ paged);
            var html = $('#free-temp-post').html();
            $('#free-temp-post').html('');

            // Make jQuery object from HTML string
            var $moreBlocks = $( html ).filter('.masonry-post, .one-column, .two-column  ');
            // Append new blocks to container
            $('#masonry-loop').append( $moreBlocks ).imagesLoaded(function(){
                // Have Masonry position new blocks
                $('#masonry-loop').masonry( 'appended', $moreBlocks );
            });

            show_more.attr("data-number", page+1);
            show_more.attr("data-click", 1);
            show_more.html("<i class='fa fa-refresh'></i>"+polite_ajax.show_more)
        });
        return false;
    });
    
    var maxHeight = 0;
    jQuery('.two-column article.two-column').each(function(){
        if(jQuery(this).height() > maxHeight) {
            maxHeight = jQuery(this).height();
        }
    });
    jQuery('.two-column article.two-column').height(maxHeight);
	//end pagination
	});

})(jQuery);

