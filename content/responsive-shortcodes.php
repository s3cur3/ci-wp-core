<?php

function ciGetAvailabilityArray($atts) {
    $xs = false; // Defined for the sake of the IDE's error-checking
    $sm = false;
    $md = false;
    $lg = false;
    extract(
        shortcode_atts(
            array(
                'xs' => false,
                'sm' => false,
                'md' => false,
                'lg' => false
            ), ciNormalizeShortcodeAtts($atts) ), EXTR_OVERWRITE /* overwrite existing vars */ );
    $arr = array();
    if($xs) $arr[] = "xs";
    if($sm) $arr[] = "sm";
    if($md) $arr[] = "md";
    if($lg) $arr[] = "lg";

    return $arr;
}


if(!function_exists('ciAddVisibilityBlockShortcode')) {
    function ciAddVisibilityBlockShortcode($atts, $content="") {
        $availableSizes = ciGetAvailabilityArray($atts);
        $class = "";
        foreach($availableSizes as $size) {
            $class .= "visible-{$size}";
        }

        return "<div class=\"{$class}\">" . do_shortcode($content) . "</div>";
    }
}

// WP.org doesn't allow shortcodes
//add_shortcode('visibleatsize', 'ciAddVisibilityBlockShortcode');




if(!function_exists('ciAddHiddenBlockShortcode')) {
    function ciAddHiddenBlockShortcode($atts, $content="") {
        $availableSizes = ciGetAvailabilityArray($atts);
        $class = "";
        foreach($availableSizes as $size) {
            $class .= "hidden-{$size}";
        }

        return "<div class=\"{$class}\">" . do_shortcode($content) . "</div>";
    }
}

// WP.org doesn't allow shortcodes
//add_shortcode('hiddenatsize', 'ciAddHiddenBlockShortcode');


