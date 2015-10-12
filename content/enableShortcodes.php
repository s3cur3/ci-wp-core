<?php

/* Add filters to widgets */
add_filter( 'widget_title', 'do_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );


/* The title may be printed in a million different ways... need to filter all of them. */
add_filter( 'get_the_title', 'do_shortcode', 100 );
add_filter( 'the_title', 'do_shortcode', 100 );
add_filter( 'wp_title', 'do_shortcode', 100 );