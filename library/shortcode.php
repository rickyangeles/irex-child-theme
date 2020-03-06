<?php

//Shortcode for site name
add_shortcode('bloginfo', function($atts) {

   $atts = shortcode_atts(array('filter'=>'', 'info'=>''), $atts, 'bloginfo');

   $infos = array(
     'name', 'description',
     'wpurl', 'url', 'pingback_url',
     'admin_email', 'charset', 'version', 'html_type', 'language',
     'atom_url', 'rdf_url','rss_url', 'rss2_url',
     'comments_atom_url', 'comments_rss2_url',
   );

   $filter = in_array(strtolower($atts['filter']), array('raw', 'display'), true)
     ? strtolower($atts['filter'])
     : 'display';

   return in_array($atts['info'], $infos, true) ? get_bloginfo($atts['info'], $filter) : '';
});

//Enabling shortcodes to be used in excerpts
add_filter('acf/format_value/type=textarea', 'do_shortcode');
add_filter('acf/format_value/type=text', 'do_shortcode');
add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');


//Literatre download shortcode
add_shortcode( 'literature-download', 'display_custom_post_type' );


// function display_custom_post_type(){
//     $args = array(
//         'post_type' => 'literature-downloads',
//         'post_status' => 'publish',
// 		'orderby' => 'title',
// 		'order' => 'ASC',
// 		'posts_per_page' => -1,
// 		'meta_query' => array(
// 		    array(
// 		      'key' => 'hide_on_corp',
// 		      'value' => '1',
// 		      'compare' => 'NOT EXISTS' // not really needed, this is the default
// 		    )
// 		  )
//     );
//
//     $string = '';
//     $query = new WP_Query( $args );
//     if( $query->have_posts() ){
//         $string .= '<ul class="literature-list">';
//         while( $query->have_posts() ){
//             $query->the_post();
// 			$id = get_the_ID();
//             $meta = get_post_meta(get_the_ID(), 'dt_original_post_id', true);
//             $json = 'https://www.irexcontracting.com/wp-json/acf/v3/resource/' . $meta . '/file/';
//             $obj = json_decode(file_get_contents($json), true);
//             $pdfLink = $obj['file']['url'];
//             $string .= '<li><a href="'. $pdfLink . '">' . get_the_title() . '</a></li>';
//         }
//         $string .= '</ul>';
//     }
//     wp_reset_postdata();
//     return $string;
// }

function display_custom_post_type(){
    $args = array(
        'post_type' => 'literature-downloads',
        //'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC',
		'posts_per_page' => -1,

    );

    $query = new WP_Query( $args );
    if( $query->have_posts() ){
        echo '<ul class="literature-list">';
        while( $query->have_posts() ){
            $query->the_post();
			$id = get_the_ID();


            //New stuff
            $og_file_id = get_post_meta(get_the_ID(), 'dt_original_post_id', true); //Getting original ID
            $og_site = get_post_meta(get_the_ID(), 'dt_original_site_url', true);
            $restLink = $og_site . '/wp-json/wp/v2/resource/' . $og_file_id;
            $file = json_decode($restLink);
            $data = file_get_contents($restLink); // put the contents of the file into a variable
            $fileArray = json_decode($data); // decode the JSON feed
            $fileLink = $fileArray->acf->file->url;
            $fileSlug = $fileArray->slug;
            $fileTitle = $fileArray->title->rendered;
            $fileName = basename($fileLink);
            //echo $fileSlug;


            $attachments = get_posts(array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'post_status' =>'any',
                'post_parent' => $id
            ));
            //echo $fileSlug;
            if ($attachments) {
                foreach ( $attachments as $attachment ) {

                    //echo $attachment->post_name . ' - ' . $fileSlug;
                    $fileSlug = $fileSlug . '-2';
                    //echo $fileSlug;
                    if ( $fileSlug != $attachment->post_name || empty($attachment->post_name) ) {

                    }
                }
            } else {
                $upload_file = wp_upload_bits($fileName, null, file_get_contents($fileLink));
                if (!$upload_file['error']) {
                    $wp_filetype = wp_check_filetype($filename, null );
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_parent' => $id,
                        'post_title' => $fileTitle,
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $id );
                    if (!is_wp_error($attachment_id)) {
                        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                        wp_update_attachment_metadata( $attachment_id,  $attachment_data );
                        //update_meta(get_the_ID(), 'file', $attachment_id);
                    }
                }
            }

            if ($attachments) {
                foreach ( $attachments as $attachment ) {
                    //echo '<li>' . the_attachment_link( $attachment->ID , false ) . '</li>';
					echo '<li>' . wp_get_attachment_link( $attachment->ID , false ) . '</li>';
                }
            } else {
                $meta = get_post_meta(get_the_ID(), 'dt_original_post_id', true);
                $json = 'https://www.irexcontracting.com/wp-json/acf/v3/resource/' . $meta . '/file/';
                $obj = json_decode(file_get_contents($json), true);
                $pdfLink = $obj['file']['url'];
                //echo $pdfLink;
                //echo '<li><a href="' . $fileLink . '">' . get_the_title(get_the_ID()) . '</a></li>';
            }
        }

        echo '</ul>';
    }
    wp_reset_postdata();
    return $string;
}

?>
