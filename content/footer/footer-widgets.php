<?php

function ciAddClassToFooterWidgets($params)
{
    if( $params[0]["id"] === "sidebar-footer" ) {
        // col-sm-3 >> make this 1/4 width
        $cols = intval(get_option('footer_columns', 4));
        $width = 12/$cols;

        $params[0]['before_widget'] = preg_replace('/class="/', "class=\"col-sm-{$width} ", $params[0]['before_widget'], 1);
    }
    return $params;
}

add_filter('dynamic_sidebar_params', 'ciAddClassToFooterWidgets');