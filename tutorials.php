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