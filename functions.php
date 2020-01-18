<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once( 'library/blocks.php' );
require_once( 'library/cpt.php' );
require_once( 'library/rest.php' );
require_once( 'library/seo.php' );
require_once( 'library/shortcode.php' );

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css');
	$custom_css = theme_get_customizer_css();
  	wp_add_inline_style( 'child-understrap-styles', $custom_css );
	wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/css/swiper.css');
	wp_enqueue_style( 'add_google_fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,700|Montserrat:400,500,700&display=swap', false );

    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
	wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/js/swiper.min.js');
	wp_enqueue_script( 'folding', get_stylesheet_directory_uri() . '/js/folding-content.min.js');
	wp_enqueue_script( 'google-map', get_stylesheet_directory_uri() . '/js/maps.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCcRP1OtaUHqk51hp-OimSv0r9jPRg1FAA', null, null, true);
	//wp_enqueue_script( 'google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDhavbTbMkRVDucZhx7ohIgdxgLv5D0RxI', null, null, true); // Add in your key
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js');
	wp_enqueue_script( 'squeezebox', get_stylesheet_directory_uri() . '/js/squeezebox.min.js');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}



function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

//Theme Update Class
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/rickyangeles/irex-child-theme',
	__FILE__,
	'irex-child-theme'
);
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

//Adding project thumbnail size
add_theme_support('post-thumbnails');
add_image_size( 'featured-project', 400, 400, array( 'center', 'center' ) ); // Hard crop left top
add_image_size( 'page-banner', 1500, 320);
add_image_size( 'service-archive-banner', 1127, 203);
add_image_size( 'service-slideshow', 757, 482, array( 'center', 'center' ) );
add_image_size( 'slideshow', 757, 482, array( 'center', 'center' ) );
add_image_size( 'post-archive-thumbnail', 370, 240, array( 'center', 'center' ) );

//Registering new menu locations
add_action( 'after_setup_theme', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'top-menu', __( 'Top Menu', 'understrap' ) );
  register_nav_menu( 'footer-menu', __( 'Footer Menu', 'understrap' ) );
  register_nav_menu( 'site-link-menu', __( 'Site Link Menu', 'understrap' ) );
}

//Adding Option Pages
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-feedback'
	));
	acf_add_options_page(array(
		'page_title' 	=> 'Global Content',
		'menu_title'	=> 'Global Content',
		'menu_slug'	=> 'global-content',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-edit'
	));
}



function theme_customize_register( $wp_customize ) {
  // Primary color
  $wp_customize->add_setting( 'primary_color', array(
	'default'   => '',
	'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Primary color', 'understrap' ),
  ) ) );

  // Seconadary color
  $wp_customize->add_setting( 'secondary_color', array(
	'default'   => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Secondary color', 'understrap' ),
  ) ) );

  // Dark color
  $wp_customize->add_setting( 'dark_color', array(
	'default'   => '',
	'transport' => 'refresh',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dark_color', array(
	'section' => 'colors',
	'label'   => esc_html__( 'Dark color', 'understrap' ),
  ) ) );
}

add_action( 'customize_register', 'theme_customize_register' );


//Brighter/Darker Hex color
function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}


//Change order of news posts from youngest to oldest
add_action( 'pre_get_posts', 'my_change_sort_order');
function my_change_sort_order($query){
    if(is_home()):
     //If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
       //Set the order ASC or DESC
       $query->set( 'order', 'ASC' );
       //Set the orderby
       $query->set( 'orderby', 'date' );
    endif;
};


function my_acf_load_value( $value, $post_id, $field ) {
    $value = get_the_title();
    return $value;
}
add_filter('acf/load_value/name=subsidiary_name', 'my_acf_load_value', 10, 3);

//Getting the first sentence of the post content
function excerpt_sentence( $excerpt ) {

  if ( ( $pos = mb_strrpos( $excerpt, '.' ) ) !== false ) {
    $excerpt = substr( $excerpt, 0, $pos + 1 );
  }

  return $excerpt;
}
add_filter( 'the_excerpt', 'excerpt_sentence' );


//getting services assigned to Locations
add_action( 'save_post_location', 'service_tax_location', 10, 3);

function service_tax_location() {
	// query for your post type
 	$args = array( 'post_type' => 'location', 'posts_per_page' => -1);
 	$loop = new WP_Query( $args );

 	while ( $loop->have_posts() ) : $loop->the_post();
 		$id = get_the_ID();
 		$meta = get_post_meta($id, 'dt_connection_map', false);
 		$term = get_field('services', $id);
 		$title = get_the_title();

 		foreach ($meta as $k => $v) {
 			foreach ($v as $kk => $vv) {
 				if ($kk == 'external') {
 					reset($vv);
 					$t = key($vv);
 				}
 			}
 		}

 		$url = get_post_meta($t, 'dt_external_connection_url', true);
 		$services = $url . "/wp/v2/service?&per_page=70";

 		$serviceList = get_services_rest_name($services);
 		$array = array_values($serviceList);
		$services = array();

 		foreach ( $array as $serviceName => $v) {
 			//Create if it doesnt exsists
			$services[] .= $v;
 		}
		$list = implode(', ', $services);
		wp_set_post_terms($id, $list, 'service_tax');

 	endwhile;
}



function my_page_columns($columns)
{
    $columns = array(
        'cb'         => '<input type="checkbox" />',
        'title'     => 'Last Name',
        'first'     => 'First Name',
        'date'        =>    'Date',
    );
    return $columns;
}

function my_custom_columns($column)
{
    global $post;

    if ($column == 'first') {
        echo get_field( "first_name", $post->ID );
    }
    else {
         echo '';
    }
}

add_action("manage_post_location_posts_custom_column", "my_custom_columns");
add_filter("manage_post_location_posts_columns", "my_page_columns");


//DONT DELETE
// function set_location_service() {
//
// 	if ( is_singular('location') {
// 		$location_title = get_the_title();
//
// 		$args = array('post_type' => 'location', 's' => $location_title, 'posts_per_page' => -1);
// 		    $the_query = new WP_Query( $args );
//
// 		    if ( $the_query->have_posts() ) {
// 		        while ( $the_query->have_posts() ) {
// 		            $the_query->the_post();
// 		            //whatever you want to do with each post
// 		            $location_id = get_the_ID();
// 		            $service_title = get_the_title($main_ID);
// 		            //echo $service_title . ' -> ' . $location_id;
// 		            $field_key = "field_5da9ce7f6e4aa";
//
// 		            $service_list = array();
//
// 		            array_push($service_list, $service_title);
//
// 		            //update_field( $field_key, $service_title, $location_id);
// 		        }
//
// 		        var_dump($service_list);
// 		    } else {
// 		         // no posts found
// 		    }
//
// 		}
//
//
// 		print_r($meta_t);
// 		print_r(array_keys($meta_t));
// 		$dist_post_id = key($meta_t);
// 		$logo = get_title($dist_post_id);
//
// 	}
// }
