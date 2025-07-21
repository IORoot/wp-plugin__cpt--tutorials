<?php

function latest_articles($atts, $content = null){

    //  ┌──────────────────────────────────────┐
    //  │         Shortcode parameters         │
    //  └──────────────────────────────────────┘
    extract(
        shortcode_atts(
            array(
                // Menu Name
                'mobile' => null,
            ),
            $atts
        )
    );

    // Get Posts
    $articles = get_posts([
        'post_type'         => 'article',
        'post_status'       => 'publish',
        'numberposts'       => 3,
        'order'             => 'DESC',
        'has_password'      => FALSE
    ]);

    //  ┌──────────────────────────────────────┐
    //  │           Shortcode output           │
    //  └──────────────────────────────────────┘   

    $output = '<ul class="articlelatest-list">';

        // Check if any term exists
        if ( ! empty( $articles ) && is_array( $articles ) ) {

            // Reverse order, otherwise list will display the latest post last.
            $articles = array_reverse($articles);

            foreach ( $articles as $article ) {
                $output .= '<li class="articlelatest-list__listitem liftup" >';
                    $output .= '<a href="' . esc_url( get_post_permalink($article->ID) ) . '">';

                        // Top Image / Colour
                        $output .= '<div class="articlelatest-list__hero">'.get_the_post_thumbnail($article->ID, 'large').'</div>';

                        // Category name
                        $output .= '<div class="articlelatest-list__title">'.$article->post_title.'</div>';

                        // Category description
                        $desc = preg_replace('/\[(.*?)\]/', '', $article->post_content); // remove shortcodes
                        $desc = preg_replace('/\<(.*?)\>/', '', $desc); // remove tags
                        $output .= '<div class="articlelatest-list__description">'.wp_trim_words($desc,20).'</div>';

                        // Post date
                        $output .= '<div class="articlelatest-list__date">'.human_time_diff( get_the_time( 'U', $article->ID ), current_time( 'timestamp' ) ).' ago.</div>';

                        // Play Icon
                        $output .= '<div class="articlelatest-list__arrow"><i class="mdi mdi-book-open mdi--lavender"></i></div>'; 

                    $output .= '</a>';
                $output .= '</li>';
            }
        }
        
        $output .= '</ul>';

    return $output;
}


add_shortcode( 'latest_articles', 'latest_articles' );