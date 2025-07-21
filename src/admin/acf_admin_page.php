<?php

/**
 * Include ACF into plugin.
 * 
 */

// Create New Menu
if( function_exists('acf_add_options_page') ) {
    
    $args = array(

        'page_title' => 'Scraper Settings',
        'menu_title' => 'Scraper Settings',
        'menu_slug' => 'articlepuller',
        'capability' => 'manage_options',
        'position' => 101,
        'parent_slug' => 'edit.php?post_type=article',
        'icon_url' => 'dashicons-screenoptions',
        'redirect' => true,
        'post_id' => 'options',
        'autoload' => false,
        'update_button'		=> __('Update', 'acf'),
        'updated_message'	=> __("Options Updated", 'acf'),
    );

    /**
     * Create a new options page.
     */
    acf_add_options_sub_page($args);
    
}

// Add the 'puller' admin menu and option page.
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5e12f441dc601',
        'title' => 'Article Puller',
        'fields' => array(
            array(
                'key' => 'field_5e12f4dd9aa8b',
                'label' => 'YouTube API Key',
                'name' => 'youtube_api_key',
                'type' => 'password',
                'instructions' => 'Find in you Google API Console',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '70',
                    'class' => '',
                    'id' => '',
                ),
                'hide_admin' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_5e12f5729aa8c',
                'label' => 'Youtube Trigger',
                'name' => 'youtube_trigger',
                'type' => 'true_false',
                'instructions' => 'Pull from YouTube for new results.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '30',
                    'class' => '',
                    'id' => '',
                ),
                'hide_admin' => 0,
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5e12f8c1d67b9',
                'label' => 'Youtube Playlist ID',
                'name' => 'youtube_playlist_id',
                'type' => 'text',
                'instructions' => 'This is the ID of the playlist you wish to get. The playlist name will become a post category for the articles.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '70',
                    'class' => '',
                    'id' => '',
                ),
                'hide_admin' => 0,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5e12f5729bb8c',
                'label' => 'Youtube Filter',
                'name' => 'youtube_filter',
                'type' => 'true_false',
                'instructions' => 'Filter the titles for hypens or #COL-HEXCODE & description for Markdown.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '30',
                    'class' => '',
                    'id' => '',
                ),
                'hide_admin' => 0,
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'articlepuller',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Pulls videos from YouTube playlists into a CPT.',
    ));
    
    endif;


    // Add colour to taxonomy.
    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_5e1ae78b3997e',
            'title' => 'article Taxonomy Additional Fields',
            'fields' => array(
                array(
                    'key' => 'field_5e1ae7e65c8de',
                    'label' => 'Taxonomy Colour',
                    'name' => 'taxonomy_colour',
                    'type' => 'color_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'hide_admin' => 0,
                    'default_value' => '#70579F',
                ),
                array(
                    'key' => 'field_5e12f8c1d67b3',
                    'label' => 'Youtube Playlist ID',
                    'name' => 'youtube_playlist_id',
                    'type' => 'text',
                    'instructions' => 'This is the ID of the playlist on YouTube',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'hide_admin' => 0,
                    'default_value' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'articlecategory',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
        
        endif;