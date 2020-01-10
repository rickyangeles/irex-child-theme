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

function display_custom_post_type(){
    $args = array(
        'post_type' => 'literature-downloads',
        'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'meta_query' => array(
		    array(
		      'key' => 'hide_on_corp',
		      'value' => '1',
		      'compare' => 'NOT EXISTS' // not really needed, this is the default
		    )
		  )
    );

    $string = '';
    $query = new WP_Query( $args );
    if( $query->have_posts() ){
        $string .= '<ul class="literature-list">';
        while( $query->have_posts() ){
            $query->the_post();
			$id = get_the_ID();
			$pdfLink = get_field('file', $id);
            $string .= '<li><a href="'. $pdfLink['url'] . '">' . get_the_title() . '</a></li>';
        }
        $string .= '</ul>';
    }
    wp_reset_postdata();
    return $string;
}


?>
