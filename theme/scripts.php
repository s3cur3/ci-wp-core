<?php
/**
 * Enqueue scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.min.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.10.2.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr-2.7.0.min.js
 * 3. /theme/assets/js/main.min.js (in footer)
 */
function roots_scripts()
{
    wp_enqueue_style('roots_main', get_template_directory_uri() . '/assets/css/main.min.css', false, 'adcd3dabd4d955588e8913adf6753a85');

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_register_script('roots_scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery'), '379e093478d340ae48d060be265d0c31', true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('roots_scripts');


    wp_register_script('page-resizer', get_template_directory_uri() . '/assets/js/fullWidthLayout.js', array('jquery'), null, false);
    wp_enqueue_script('page-resizer');

    if(get_option('mlf_demo_site')) {
        wp_register_script('style-switcher', get_template_directory_uri() . '/assets/js/styleSwitcher.js', array(), null, true);
        wp_enqueue_script('style-switcher');
    }
}

add_action('wp_enqueue_scripts', 'roots_scripts', 90);




function roots_admin_scripts() {
    // Scripts
    wp_register_script('bootstrap-admin', get_template_directory_uri() . '/assets/js/admin/bootstrap-custom.min.js');
    wp_enqueue_script('bootstrap-admin');
    wp_register_script('font-selection', get_template_directory_uri() . '/assets/js/admin/fontSelection.js');
    wp_enqueue_script('font-selection');

    // Styles
    wp_register_style('bootstrap-admin', get_template_directory_uri() . '/assets/css/admin/bootstrap-custom.min.css');
    wp_enqueue_style('bootstrap-admin');
    wp_register_style('bootstrap-admin-colors', get_template_directory_uri() . '/assets/css/admin/bootstrap-theme.min.css');
    wp_enqueue_style('bootstrap-admin-colors');
    wp_register_style('admin-custom', get_template_directory_uri() . '/assets/css/admin/admin.css');
    wp_enqueue_style('admin-custom');
}
add_action( 'admin_enqueue_scripts', 'roots_admin_scripts' );

function roots_customize_admin_scripts() {
    wp_enqueue_script('theme-customizer', get_template_directory_uri() .'/assets/js/admin/customizer.js');
    wp_register_style('customizer-css', get_template_directory_uri() . '/assets/css/admin/customizer.css');
    wp_enqueue_style('customizer-css');
}
add_action('customize_controls_enqueue_scripts', 'roots_customize_admin_scripts');

// http://wordpress.stackexchange.com/a/12450
function roots_jquery_local_fallback($src, $handle = null)
{
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.10.2.min.js"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
        $add_jquery_fallback = true;
    }

    return $src;
}

add_action('wp_head', 'roots_jquery_local_fallback');

function roots_google_analytics() { ?>
    <script>
        (function (b, o, i, l, e, r) {
            b.GoogleAnalyticsObject = l;
            b[l] || (b[l] =
                function () {
                    (b[l].q = b[l].q || []).push(arguments)
                });
            b[l].l = +new Date;
            e = o.createElement(i);
            r = o.getElementsByTagName(i)[0];
            e.src = '//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e, r)
        }(window, document, 'script', 'ga'));
        ga('create', '<?php echo get_option('analytics_id', "''"); ?>');
        ga('send', 'pageview');
    </script> <?php
}

if( get_option('analytics_id', false) && !current_user_can('manage_options') ) {
    add_action('wp_footer', 'roots_google_analytics', 20);
}
