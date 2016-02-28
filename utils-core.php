<?php

function ciAddShortcode($name, $args) {
    add_shortcode($name, $args);
}

function ciRemoveShortcode($name) {
    remove_shortcode($name, $args);
}
