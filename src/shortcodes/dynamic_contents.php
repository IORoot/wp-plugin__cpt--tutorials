<?php

function dynamic_contents($atts, $content = null){

    //  ┌──────────────────────────────────────┐
    //  │           Shortcode output           │
    //  └──────────────────────────────────────┘   

    // Current post object.
    global $post;

    // parse content for all H2 tags & add anchors
    $list = h2_to_contents($post->post_content);

    $output = '<div class="sticky"><div class="dynamic_contents">';

    if (!empty($list[0])){ $output .= '<div class="dynamic_contents__header">Contents</div>'; }
    
        $output .= '<ul class="dynamic_contents__list">';
        foreach ($list[1] as $index=>$h2_item){
            $output .= '<li class="dynamic_contents__list-item">';
                $output .= '<a href="#h2_anchor_'.$index.'">';
                    $output .= $h2_item;
                $output .= '</a>';
            $output .= '</li>';
        }
        $output .= '</ul>';
        
    $output .= '</div></div>';

    return $output;
}



function h2_to_contents($content){

    $regex = '/<h2>([\s\S]*?)<\/h2>/';
    preg_match_all($regex, $content, $matches);

    // Create anchors next to each H2.
    add_h2_anchors($matches[0], $content);

    return $matches;
}



function add_h2_anchors($h2_list, $content){

    foreach($h2_list as $index=>$h2_item){

        // Check if any anchors have already been added.
        if (preg_match('/h2_anchor_'.$index.'/',$content)){ continue; }

        // Replace the H2
        $post->post_content = str_replace($h2_item, '<div id="h2_anchor_'.$index.'"></div>'.$h2_item, $content);

    }

    if (isset($post)){
        wp_update_post($post);
    }   

    return;
};


add_shortcode( 'dynamic_contents', 'dynamic_contents' );