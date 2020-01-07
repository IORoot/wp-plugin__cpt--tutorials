<?php

class youtube {

    /**
     * Load Traits
     */
    // use helpers;
    // use transients;

    /**
     * $options
     *
     * @var undefined
     */
    private $options;


    /**
     * $playtlist
     *
     * @var undefined
     */
    private $playlist;
    private $playlistslug;

    /**
     * $playlistitems
     *
     * @var undefined
     */
    private $playlistitems;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){
        return $this;
    }



    /**
     * get_options_array
     *
     * @return void
     */
    public function get_options(){

        $this->options = array ( 
            'youtube_api_key'   => get_field('youtube_api_key', 'option'),
            'youtube_playlist_id' => get_field('youtube_playlist_id', 'option')
        );

        return $this;
    }



    /**
     * request_playlist
     *
     * @return void
     */
    public function request_playlist() {

        // Check for values.
        if ($this->options['youtube_playlist_id'] == null){ return false; }
        if ($this->options['youtube_api_key'] == null){ return false; }

        // Build URL
        $url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id=".$this->options['youtube_playlist_id']."&maxResults=1&key=".$this->options['youtube_api_key'];

        // Fetch Results
        $this->playlist = json_decode(wp_remote_fopen($url));

        return $this;
    }



    /**
     * request_playlistitems
     *
     * @return void
     */
    public function request_playlistitems() {

        // Check for values.
        if ($this->options['youtube_playlist_id'] == null){ return false; }
        if ($this->options['youtube_api_key'] == null){ return false; }

        // Build URL
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$this->options['youtube_playlist_id']."&maxResults=50&key=".$this->options['youtube_api_key'];

        // Fetch Results
        $this->playlistitems = json_decode(wp_remote_fopen($url));

        return $this;
    }



    /**
     * create_category
     *
     * @return void
     */
    public function create_category() {

        // Checks
        if ($this->playlist == null){ return false; }

        $name = $this->playlist->items[0]->snippet->title;
        $name = str_replace('Tutorial - ','', $name);
        $description = $this->playlist->items[0]->snippet->description;
        $slug = strtolower(str_replace(' ','-', $name));
        $this->playlistslug = $slug;
        $thumbnail = $this->playlist->items[0]->snippet->thumbnails->standard->url;

        // Check all parts exist.
        if ($name == null){         return false; }
        if ($description == null){  return false; }
        if ($slug == null){         return false; }
        if ($thumbnail == null){    return false; }

        // Create Category
        $result = wp_insert_term( 
            $name, 
            'tutorialcategory', 
            array(
                'description' => $description,
                'slug'        => $slug
            )
        );

        return $this;
    }



    /**
     * loop_posts
     *
     * @return void
     */
    public function loop_posts() {

        foreach ($this->playlistitems->items as $key => $item){

            $snippet = $item->snippet;

            // Set the post ID to -1. This sets to no action at moment
            $post_id = -1;

            // set the ITEM slug
            $slug = $this->title_to_slug($snippet->title);

            // check if slug exists already
            $exists = $this->post_exists_by_slug($slug);

            // Get Title
            $title = $this->filter_title($snippet->title);

            // Checks if doen't exists a post with slug 
            if( !$exists ) {
                // Set the post ID
                $post_id = wp_insert_post(
                    array(
                        'comment_status'    =>   'closed',
                        'ping_status'       =>   'closed',
                        'post_author'       =>   1,
                        'post_name'         =>   $slug,
                        'post_title'        =>   $title,
                        'post_content'      =>   $this->filter_description($snippet->description),
                        'post_status'       =>   'publish',
                        'post_type'         =>   'tutorial',
                        'post_date'         =>   $snippet->publishedAt
                    )
                );

                // Add taxonomy
                wp_set_object_terms($post_id, $this->playlistslug, 'tutorialcategory');

                // Add Custom Meta - VideoID
                $this->update_post_meta( $post_id, 'videoId', $snippet->resourceId->videoId );

                // Add Custom Meta - VideoID
                $this->update_post_meta( $post_id, 'playlistOrder', $key+1 );

                // Pick the biggest image thumbnail available.
                if (property_exists($snippet->thumbnails, 'high')){
                    $imageURL = $snippet->thumbnails->high->url;
                }
                if (property_exists($snippet->thumbnails, 'standard')){
                    $imageURL = $snippet->thumbnails->standard->url;
                }
                if (property_exists($snippet->thumbnails, 'maxres')){
                    $imageURL = $snippet->thumbnails->maxres->url;
                }
                
                // Download image and set the featured image.
                // Uses the VideoID as the filename.
                $filename = $slug.'_'.$snippet->resourceId->videoId;
                $postdata['post_title'] = $title;
                $alttext = $this->playlist->items[0]->snippet->title.' - '.$title.'. Parkour Tutorial Video Thumbnail for LondonParkour.com';
                $this->attach_external_image($imageURL, $post_id, true, $filename, $postdata, $alttext);

            } else {
                // Set post_id to -2 because there is a post with this slug.
                $post_id = -2;       
            }

        }

    }



    /**
     * title_to_slug
     *
     * @param mixed $title
     * @return void
     */
    public function title_to_slug($title){
        $slug = str_replace('Tutorial - ','', $title);
        $slug = strtolower(str_replace(' ','-', $slug));
        $slug = str_replace('---','-', $slug);

        return $slug;
    }



    /**
    * post_exists_by_slug
    *
    * @param mixed $post_slug
    * @return void
    */
    public function post_exists_by_slug( $post_slug ) {

        $args_posts = array(
            'post_type'      => 'tutorial',
            'post_status'    => 'any',
            'name'           => $post_slug,
            'posts_per_page' => 1,
        );

        $loop_posts = new WP_Query( $args_posts );

        if ( ! $loop_posts->have_posts() ) {
            return false;
        } else {
            $loop_posts->the_post();
            return $loop_posts->post->ID;
        }
    }



    /**
     * Updates post meta for a post. It also automatically deletes or adds the value to field_name if specified
    *
    * @access     protected
    * @param      integer     The post ID for the post we're updating
    * @param      string      The field we're updating/adding/deleting
    * @param      string      [Optional] The value to update/add for field_name. If left blank, data will be deleted.
    * @return     void
    */
    public function update_post_meta( $post_id, $field_name, $value = '' )
    {
        if ( empty( $value ) OR ! $value )
        {
            delete_post_meta( $post_id, $field_name );
        }
        elseif ( ! get_post_meta( $post_id, $field_name ) )
        {
            add_post_meta( $post_id, $field_name, $value );
        }
        else
        {
            update_post_meta( $post_id, $field_name, $value );
        }

        return;
    }



    /**
     * Download an image from the specified URL and attach it to a post.
     * Modified version of core function media_sideload_image() in /wp-admin/includes/media.php  (which returns an html img tag instead of attachment ID)
     * Additional functionality: ability override actual filename, and to pass $post_data to override values in wp_insert_attachment (original only allowed $desc)
     *
     * @since 1.4 Somatic Framework
     *
     * @param string $url (required) The URL of the image to download
     * @param int $post_id (required) The post ID the media is to be associated with
     * @param bool $thumb (optional) Whether to make this attachment the Featured Image for the post (post_thumbnail)
     * @param string $filename (optional) Replacement filename for the URL filename (do not include extension)
     * @param array $post_data (optional) Array of key => values for wp_posts table (ex: 'post_title' => 'foobar', 'post_status' => 'draft')
     * @return int|object The ID of the attachment or a WP_Error on failure
     */
    function attach_external_image( $url = null, $post_id = null, $thumb = null, $filename = null, $post_data = array(), $alttext) {
        if ( !$url || !$post_id ) return new WP_Error('missing', "Need a valid URL and post ID...");
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $tmp = download_url( $url );

        // If error storing temporarily, unlink
        if ( is_wp_error( $tmp ) ) {
            @unlink($file_array['tmp_name']);   // clean up
            $file_array['tmp_name'] = '';
            return $tmp; // output wp_error
        }

        preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $url, $matches);    // fix file filename for query strings
        $url_filename = basename($matches[0]);                                                  // extract filename from url for title
        $url_type = wp_check_filetype($url_filename);                                           // determine file type (ext and mime/type)

        // override filename if given, reconstruct server path
        if ( !empty( $filename ) ) {
            $filename = sanitize_file_name($filename);
            $tmppath = pathinfo( $tmp );                                                        // extract path parts
            $new = $tmppath['dirname'] . "/". $filename . "." . $tmppath['extension'];          // build new path
            rename($tmp, $new);                                                                 // renames temp file on server
            $tmp = $new;                                                                        // push new filename (in path) to be used in file array later
        }

        // assemble file data (should be built like $_FILES since wp_handle_sideload() will be using)
        $file_array['tmp_name'] = $tmp;                                                         // full server path to temp file

        if ( !empty( $filename ) ) {
            $file_array['name'] = $filename . "." . $url_type['ext'];                           // user given filename for title, add original URL extension
        } else {
            $file_array['name'] = $url_filename;                                                // just use original URL filename
        }

        // set additional wp_posts columns
        if ( empty( $post_data['post_title'] ) ) {
            $post_data['post_title'] = basename($url_filename, "." . $url_type['ext']);         // just use the original filename (no extension)
        }

        // make sure gets tied to parent
        if ( empty( $post_data['post_parent'] ) ) {
            $post_data['post_parent'] = $post_id;
        }

        // required libraries for media_handle_sideload
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // do the validation and storage stuff
        // $post_data can override the items saved to wp_posts table, like post_mime_type, guid, post_parent, post_title, post_content, post_status
        $att_id = media_handle_sideload( $file_array, $post_id, null, $post_data );             
        
        // Set the image Alt-Text
        update_post_meta( $att_id, '_wp_attachment_image_alt', $alttext );

        // If error storing permanently, unlink
        if ( is_wp_error($att_id) ) {
            @unlink($file_array['tmp_name']);   // clean up
            return $att_id; // output wp_error
        }

        // set as post thumbnail if desired
        if ($thumb) {
            set_post_thumbnail($post_id, $att_id);
        }

        return $att_id;
    }




    /**
     * filter_description
     *
     * @param mixed $description
     * @return void
     */
    public function filter_description($description){

        // --- to <hr/>
        $description = preg_replace("/^(\#{2,6})[ ]*(.+[ ]*)\#*\n+/xm", "<h2>$2</h2>", $description);

        // Addresses to Links
        $description = preg_replace("/(http.*)\n/xm", "<a href=\"$1\">$1</a>", $description);

        // Bold
        $description = preg_replace("/\*\*(.*)\*\*/xm", "<strong>$1</strong>", $description);

        // --- to <hr/>
        $description = str_replace('___', '<hr/>', $description);

        // Newlines to paragraphs.
        $description = wpautop($description);

        return $description;
    }



    /**
     * filter_title
     *
     * @param mixed $title
     * @return void
     */
    public function filter_title($title){
        // remove anything (including) before the " - "
        $title = substr(strstr($title, ' - '), strlen(' - '));

        return $title;
    }
}