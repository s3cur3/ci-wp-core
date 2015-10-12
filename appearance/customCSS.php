<?php


function printCustomCSS() {
    $css = get_option('custom_css');

    if($css) {
        echo "\n\n<!-- Custom styles from the theme's Customize admin menu -->\n<style>\n";
        echo html_entity_decode($css);
        echo "</style>\n\n";
    }
}

add_action('ci_styles', 'printCustomCSS');




 