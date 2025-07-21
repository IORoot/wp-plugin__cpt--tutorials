<?php

//  ┌─────────────────────────────────────────────────────────────────────────┐ 
//  │                                                                         │░
//  │                                                                         │░
//  │                        Search form for Articles                         │░
//  │                                                                         │░
//  │                                                                         │░
//  └─────────────────────────────────────────────────────────────────────────┘░
//   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

function search_template_chooser($template)   
{    
    global $wp_query;   
    
    $post_type = get_query_var('post_type');
    
	if( $wp_query->is_search && $post_type == 'article' )   
	{
		return locate_template('search-article.php');
    }   
	return $template;   
}

add_filter('template_include', 'search_template_chooser');   