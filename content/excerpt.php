<?php



// Variable & intelligent excerpt length.
function mlfFilterToMaxCharLength($content, $maxCharLength = -1) {
    if( $maxCharLength == -1 ) {
        return $content;
    }

    $content = strip_shortcodes($content); // optional, recommended
    $content = strip_tags($content, '<p>'); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags

    $content = substr($content,0,$maxCharLength);
    $excerpt = mlfReverseStrrchr($content, '.', 1);
    if( $excerpt ) {
        return apply_filters('the_excerpt',$excerpt);
    } else {
        return apply_filters('the_excerpt',$content);
    }
}

// Returns the portion of haystack which goes until the last occurrence of needle
function mlfReverseStrrchr($haystack, $needle, $trail) {
    return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
}