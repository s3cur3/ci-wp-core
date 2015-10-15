<?php


add_action('ci_meta', 'ciSetJavascriptVars');
add_action('admin_head', 'ciSetJavascriptVars');
function ciSetJavascriptVars() { ?>
    <script>
        var templateURL = '<?php echo get_template_directory_uri(); ?>';
    </script> <?php
}