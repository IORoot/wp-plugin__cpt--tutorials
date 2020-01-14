<?php

/**
 * On save of options page, create the category.
 */
function save_options() {

    $screen = get_current_screen();
	if (strpos($screen->id, "articlepuller") == false) { return; }
        
    if (get_field('youtube_trigger', 'option') == true){ 
        // Create new object.
        $yt = new youtube();
    
        // Get option page values
        $yt->get_options();
        
        // Make a request for a playlist to youtube.
        // Create a category if already not there.
        $yt->request_playlist()->create_category();

        // Make a request for a playlistItems to youtube.
        // Create posts for each item that is found.
        $yt->request_playlistitems()->loop_posts();
    
    }

	return;
}

// MUST be in a hook, otherwise it wiull run BEFORE the 
// taxonomy is registered and then not work.
add_action('acf/save_post', 'save_options', 20);