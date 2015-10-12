<?php

function printBreadcrumbs() {
    $breadcrumbsShouldBePrinted = !(is_home() || is_archive() || is_search() || is_404() || is_page_template('template-blog.php') || is_page_template('template-landing.php') ) && is_singular();

    if( $breadcrumbsShouldBePrinted && function_exists( 'yoast_breadcrumb' ) ) {
        yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
    }

}