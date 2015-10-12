<?php
/**
 * Utility functions
 */
function mlfAddFilters($tags, $function) {
  foreach($tags as $tag) {
    add_filter($tag, $function);
  }
}

function mlfIsElementEmpty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}

/**
 * Strips out an non-numeric characters. Useful for turning a phone number string,
 * like (816) 123-4567 into an href="tel:xxx" link.
 * @param string $string The string to be filtered
 * @return string The same string, but with all non-numeric characters deleted
 */
function ciFilterNumbersOnly($string) {
    return preg_replace( '/[^0-9]/', '', $string );
}


/**
 * Cut the input string down to a specified length, in characters, but don't cut in the
 * middle of sentences.
 * @param string $content The string to chop down to the specified length.
 * @param int $maxCharLength The maximum length of the filtered content, in characters.
 *                           Use -1 for unlimited length.
 * @return string The filtered string.
 */
function ciFilterToMaxCharLength($content, $maxCharLength = -1) {
    if( $maxCharLength == -1 ) {
        return $content;
    }

    $content = strip_shortcodes($content); // optional, recommended
    $content = strip_tags($content, '<p>'); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags

    $content = substr($content,0,intval($maxCharLength));
    $excerpt = ciReverseStrrchr($content, '.', 1);
    if( $excerpt ) {
        return apply_filters('the_excerpt',$excerpt);
    } else {
        return apply_filters('the_excerpt',$content);
    }
}

// Returns the portion of haystack which goes until the last occurrence of needle
function ciReverseStrrchr($haystack, $needle, $trail) {
    return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
}


/**
 * Returns the Bootstrap 3 class you need to add to a container (e.g., a div) to break a row into a
 * particular number of columns. E.g., if you want 4 columns, it returns "col-sm-3"
 * (since the 12-wide grid breaks into four 3-width columns)
 *
 * @param int $numEqualWidthColumns The number of equal-width columns you want to divide your row into
 * @return string The Bootstrap 3 column class to use on each column
 */
function ciGetColumnClass( $numEqualWidthColumns=0 ) {
    $bootstrapColumnClasses = array(
        "", // Zero columns doesn't make sense
        "col-sm-12", // 1 col
        "col-sm-6", // 2 col
        "col-sm-4", // 3 col
        "col-sm-3",
        "",         // 5 columns can't happen in a 12-col grid
        "col-sm-2",
        "",
        "",
        "",
        "",
        "",
        "col-sm-1"
    );

    $numEqualWidthColumns = intval($numEqualWidthColumns);
    if( $numEqualWidthColumns >= 0 && $numEqualWidthColumns <= 12 ) {
        return $bootstrapColumnClasses[$numEqualWidthColumns];
    }
    return "";
}

/**
 * Modified the shortcode attributes array so that empty attributes can be used.
 *
 * For instance, if you want a shortcode like this:
 *      <code>[practiceareas list]</code>
 * WordPress discards the "list" attribute entirely (since it doesn't have a value).
 * This function replaces the "list" with a value of true.
 *
 * @param array $atts Shortcode attributes
 * @return array The "normalized" shortcode attributes
 */
function ciNormalizeShortcodeAtts( $atts ) {
    foreach( $atts as $attribute => $value ) {
        if( is_int( $attribute ) ) {
            $atts[strtolower( $value )] = true;
            unset($atts[$attribute]);
        }
    }

    return $atts;
}

/**
 * Returns only the domain portion of a URL
 * @param string $url The full URL (like "http://www.google.com")
 * @return string The domain (like "google.com")
 */
function ciFilterUrlToDomainOnly($url) {
    $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
    return $domain;
}

function ciGetSiteDomain() {
    return ciFilterUrlToDomainOnly( home_url('/') );
}



/**
 * A wrapper for getting settings created by the Meta Box plugin.
 * @param $fieldID string The ID (sans our theme's prefix) of the meta value you want to retrieve.
 *                         E.g., to get the "show page title" setting, pass in "show_page_title", not
 *                         "mlf_show_page_title".
 * @param $valueIfNotSet mixed Whatever you want to use as the default (in the event the
 *                             requested key is not set for the current post/page)
 * @param int $overridePostID Force us to look up the meta for a post with a specific ID
 * @return mixed The stored meta value, or $valueIfNotSet
 */
if( !function_exists('ciGetNormalizedMeta') ) {
    function ciGetNormalizedMeta($fieldID, $valueIfNotSet, $overridePostID = null)
    {
        if (function_exists('rwmb_meta')) {
            $field = rwmb_meta(CI_THEME_PREFIX . "_{$fieldID}", array(), $overridePostID);
            if ($field === "") {
                $field = $valueIfNotSet;
            }
            return $field;
        } else {
            return $valueIfNotSet;
        }
    }
}

if( !function_exists('ciGetNormalizedMetaMultiple') ) {
    function ciGetNormalizedMetaMultiple($fieldID, $valueIfNotSet, $overridePostID = null)
    {
        if (function_exists('rwmb_meta')) {
            $field = rwmb_meta(CI_THEME_PREFIX . "_{$fieldID}", array('multiple' => true), $overridePostID);
            if ($field === "") {
                $field = $valueIfNotSet;
            }
            return $field;
        } else {
            return $valueIfNotSet;
        }
    }
}