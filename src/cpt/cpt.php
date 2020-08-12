<?php

// Register Custom Taxonomy
function articlecategory() {

	$labels = array(
		'name'                       => _x( 'Article Category', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Article Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Article Category', 'text_domain' ),
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
		'rewrite'                    => array('slug' => 'articles', 'with_front' => false)
	);
	register_taxonomy( 'articlecategory', array( 'articles' ), $args );
}
add_action( 'init', 'articlecategory', 0 );

// Register Custom Tags
function articletags() {

	$labels = array(
		'name'                       => _x( 'Article Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Article Tag', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Article Tags', 'text_domain' ),
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
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'articletags', array( 'articles' ), $args );
}
add_action( 'init', 'articletags', 0 );

// Register Custom Post Type
function CPT_articles() {

	$labels = array(
		'name'                  => 'Articles',
		'singular_name'         => 'Article',
		'menu_name'             => 'Articles',
		'name_admin_bar'        => 'Articles',
		'archives'              => 'Article Archives',
		'attributes'            => 'Article Attributes',
		'parent_item_colon'     => 'Articles :',
		'all_items'             => 'All Articles',
		'add_new_item'          => 'Add New article',
		'add_new'               => 'Add New',
		'new_item'              => 'New article',
		'edit_item'             => 'Edit article',
		'update_item'           => 'Update article',
		'view_item'             => 'View article',
		'view_items'            => 'View Articles',
		'search_items'          => 'Search article',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into article',
		'uploaded_to_this_item' => 'Uploaded to this article',
		'items_list'            => 'Articles list',
		'items_list_navigation' => 'Articles list navigation',
		'filter_items_list'     => 'Filter Articles list',
	);
	$args = array(
		'label'                 => 'Article',
		'description'           => 'Parkour articles, downloads and posts.',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
		'taxonomies'            => array( 'articlecategory', 'articletags' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-widgets-menus',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive' 			=> 'article',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'               => array('slug' => 'article', 'with_front' => false),
	);
	register_post_type( 'article', $args );

}
add_action( 'init', 'CPT_articles', 0 );


// Run filter to replace the 'rewrite' %article% with the article category.
// see: https://wordpress.stackexchange.com/questions/108642/permalinks-custom-post-type-custom-taxonomy-post
function article_post_link( $post_link, $id = 0 ){
    $post = get_post($id);  
    if ( is_object( $post ) ){
        $terms = wp_get_object_terms( $post->ID, 'articlecategory' );
        if( $terms ){
            return str_replace( '%articlecategory%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;  
}
add_filter( 'post_type_link', 'article_post_link', 1, 3 );


// Using Wordpress Pre-Get filter to order the custom taxonomy by playlistOrder
// This is so the order isn't by published date.
function customize_articlecategory_archive_display ( $query ) {
	if (($query->is_main_query()) && (is_tax('articlecategory'))){
		$query->set( 'post_type', 'article' );                 
		$query->set( 'posts_per_page', '-1' );
		$query->set( 'order', 'ASC' );
	}	
}
add_action( 'pre_get_posts', 'customize_articlecategory_archive_display' );