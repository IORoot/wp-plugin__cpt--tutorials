<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'CPT - Tutorials',
        'icon'      => 'post-outline',
        'color'     => '#f44336',
        'path'      => __FILE__,
    ]);
} );