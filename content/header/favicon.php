<?php

add_action('ci_meta', 'ciPrintFavicon');
function ciPrintFavicon() {
    $favicon = esc_url(get_option("favicon", ''));
    if($favicon) { ?>
        <link rel="shortcut icon" href="<?php echo $favicon; ?>"/> <?php
    }

    $touchIcon = esc_url( get_option("touch_icon", '') );
    if($touchIcon) {
        $precomposed = get_option('touch_icon_precomposed', false);
        $precomposedClass = '';
        if($precomposed) {
            $precomposedClass = "-precomposed";
        } ?>
        <link rel="apple-touch-icon<?php echo $precomposedClass; ?>" href="<?php echo $touchIcon; ?>"/> <?php
    }
}