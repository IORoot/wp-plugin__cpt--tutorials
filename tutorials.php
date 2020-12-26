<?php

/*
 * @wordpress-plugin
 * Plugin Name:       _ANDYP - Articles - Custom Post Type
 * Plugin URI:        http://londonparkour.com
 * Description:       <strong>📬CPT</strong> | <em>Articles & Scraper</em> | Creates a new CPT for Articles. Has a YouTube API Scraper for playlists.
 * Version:           1.0.0
 * Author:            Andy Pearson
 * Author URI:        https://londonparkour.com
 * Domain Path:       /languages
 */

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                    Register with ANDYP Plugins                          │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/acf/andyp_plugin_register.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                              The CPT                                    │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/cpt/cpt.php';
require __DIR__.'/src/cpt/search.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                              The ACF                                    │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/admin/acf_admin_page.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                        The YouTube API Class                            │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/api/youtube_api.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                             The Puller                                  │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/puller.php';

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                            The Shortcodes                               │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/shortcodes/latest_articles.php';
require __DIR__.'/src/shortcodes/dynamic_contents.php';


// ACF turns off the custom-fields metabox for speed. Switch it back on!
add_filter('acf/settings/remove_wp_meta_box', '__return_false');