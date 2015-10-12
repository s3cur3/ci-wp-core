<?php


add_action('ci_meta', 'setJavascriptVars');
add_action('admin_head', 'setJavascriptVars');
function setJavascriptVars() { ?>
    <script>
        var templateURL = '<?php echo get_template_directory_uri(); ?>';
    </script> <?php
}