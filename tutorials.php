<?php

/*
 * @package   ANDYP - Custom Post Type - Tutorials
 * @author    Andy Pearson <andy@londonparkour.com>
 * @copyright 2020 LondonParkour
 * 
 * @wordpress-plugin
 * Plugin Name:       _ANDYP - CPT - Tutorials
 * Plugin URI:        http://londonparkour.com
 * Description:       Creates a new CPT for Tutorials
 * Version:           1.0.0
 * Author:            Andy Pearson
 * Author URI:        https://londonparkour.com
 * Domain Path:       /languages
 */

//  ┌─────────────────────────────────────────────────────────────────────────┐
//  │                              The CPT                                    │
//  └─────────────────────────────────────────────────────────────────────────┘
require __DIR__.'/src/cpt/cpt.php';

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


// ACF turns off the custom-fields metabox for speed. Switch it back on!
add_filter('acf/settings/remove_wp_meta_box', '__return_false');