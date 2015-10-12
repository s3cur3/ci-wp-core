<?php

require_once 'theme/constants.php';
require_once 'utils.php'; // Misc utility functions
require_once 'meta-box/meta-box.php'; // "Plugin" for page/post meta boxes

// PAGE SETUP
require_once 'theme/init.php'; // Roots initial theme setup and constants
require_once 'theme/wrapper.php'; // Roots theme wrapper class
require_once 'content/sidebar/sidebar.php'; // Roots sidebar class
require_once 'theme/config.php'; // Roots configuration
require_once 'content/titles.php'; // Page titles
require_once 'theme/cleanup.php'; // Misc page cleanup
require_once 'theme/relative-urls.php'; // Root relative URLs
require_once 'theme/scripts.php'; // Scripts and stylesheets
require_once 'admin/plugin-recommender.php'; // The plugin recommender system

// PAGE HEADER
require_once 'content/header/favicon.php'; // Custom favicon
require_once 'appearance/customCSS.php'; // Add the user's custom CSS to the page <head>
require_once 'content/header/javascriptVars.php'; // Variables needed by the Javascript
require_once 'content/header/nav.php'; // Custom nav walker

// BODY CONTENT
require_once 'content/header/breadbrumbs.php'; // Breadcrumbs in the page headers
require_once 'content/gallery.php'; // Custom [gallery] modifications
require_once 'content/comments.php'; // Custom comments modifications
require_once 'content/sidebar/widgets.php'; // Sidebars and widgets
require_once 'content/responsive-shortcodes.php'; // Misc utils for responsive designs
require_once 'content/blog.php'; // Blog configuration
require_once 'content/excerpt.php'; // Custom excerpt function
require_once 'content/featured-image-attribution/featured-image-attribution.php'; // The Featured Image attribution box
require_once 'content/enableShortcodes.php'; // Enables shortcode use in places they aren't normally allowed

// FOOTER
require_once 'content/footer/credit.php'; // Print credits for the theme
require_once 'content/footer/disclaimer.php'; // Prints a disclaimer
require_once 'content/footer/footer-widgets.php'; // Modifies widgets as needed


//Initialize the update checker.
require_once 'theme/theme-updates/theme-update-checker.php';
$update_checker = new ThemeUpdateChecker(
    'ci-modern-accounting-firm',
    'http://cisandbox.mystagingwebsite.com/wp-content/themes/brewery-base_version_metadata.json',
    true
);

/** Allow SVG files to be uploaded */
function ciAllowSVGUploads( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'ciAllowSVGUploads' );

// Disable extra columns for Yoast SEO plugin
add_filter( 'wpseo_use_page_analysis', '__return_false' );





