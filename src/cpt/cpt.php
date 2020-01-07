<?php

// Register Custom Taxonomy
function tutorialcategory() {

	$labels = array(
		'name'                       => _x( 'Tutorial Category', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Tutorial Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Tutorial Category', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'tutorialcategory', array( 'tutorial' ), $args );
}
add_action( 'init', 'tutorialcategory', 0 );

// Register Custom Post Type
function CPT_tutorials() {

	$labels = array(
		'name'                  => 'Tutorials',
		'singular_name'         => 'Tutorial',
		'menu_name'             => 'Tutorials',
		'name_admin_bar'        => 'Tutorials',
		'archives'              => 'Tutorial Archives',
		'attributes'            => 'Tutorial Attributes',
		'parent_item_colon'     => 'Tutorials :',
		'all_items'             => 'All Tutorials',
		'add_new_item'          => 'Add New Tutorial',
		'add_new'               => 'Add New',
		'new_item'              => 'New Tutorial',
		'edit_item'             => 'Edit Tutorial',
		'update_item'           => 'Update Tutorial',
		'view_item'             => 'View Tutorial',
		'view_items'            => 'View Tutorials',
		'search_items'          => 'Search Tutorial',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into Tutorial',
		'uploaded_to_this_item' => 'Uploaded to this Tutorial',
		'items_list'            => 'Tutorials list',
		'items_list_navigation' => 'Tutorials list navigation',
		'filter_items_list'     => 'Filter Tutorials list',
	);
	$args = array(
		'label'                 => 'Tutorial',
		'description'           => 'Parkour Tutorials, downloads and posts.',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'tutorialcategory' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-video-alt3',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'tutorial', $args );

}
add_action( 'init', 'CPT_tutorials', 0 );
