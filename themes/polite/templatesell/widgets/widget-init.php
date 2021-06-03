<?php

if ( ! function_exists( 'polite_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function polite_load_widgets() {

        // Highlight Post.
        register_widget( 'Polite_Featured_Post' );

        // Author Widget.
        register_widget( 'Polite_Author_Widget' );
		
		// Social Widget.
        register_widget( 'Polite_Social_Widget' );
    }
endif;
add_action( 'widgets_init', 'polite_load_widgets' );


