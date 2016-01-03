<?php

function ci_get_logo_html() {
    $name = get_bloginfo('name');
    $brandHTML = $name;
    $imgURL = get_option('company_logo', false);
    $svgURL = get_option('svg_logo', false);
    $width = get_option('logo_width');
    $height = get_option('logo_height');
    if($imgURL && strpos($imgURL, '.') !== false) {
        if($svgURL) {
            $brandHTML = "<img src=\"{$svgURL}\" onerror=\"this.onerror=null; this.src='{$imgURL}'\" width=\"{$width}\" height=\"{$height}\" alt=\"{$name}\">";
        } else { // just a bitmap, no SVG version
            $brandHTML = "<img src=\"{$imgURL}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$name}\">";
        }
    } elseif($svgURL) { // just an SVG, no bitmap
        $brandHTML = "<img src=\"{$svgURL}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$name}\">";
    }
    return $brandHTML;
}