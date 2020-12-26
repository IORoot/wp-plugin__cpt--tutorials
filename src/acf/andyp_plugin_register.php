<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'Articles - CPT',
        'icon'      => 'post-outline',
        'color'     => '#4A148C',
        'path'      => __FILE__,
    ]);
} );