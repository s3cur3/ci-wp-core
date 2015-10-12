<?php
add_action('init', 'ciSetBlogOptions');
function ciSetBlogOptions() {
    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( CI_FULL_WIDTH_WITH_SIDEBAR_IMG, 690, 9999 );
        add_image_size( CI_THUMBNAIL_IMG, 275, 9999 );
    }
}

add_filter('the_content_more_link', 'ciModifyReadMoreLink');
function ciModifyReadMoreLink() {
    return "<p><a class=\"more-link btn btn-primary mt0\" href=\"" . get_permalink() . "\">Continue Reading</a></p>";
}