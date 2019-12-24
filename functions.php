<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once( 'library/blocks.php' );
require_once( 'library/cpt.php' );
require_once( 'library/rest.php' );

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
	wp_enqueue_script( 'google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDhavbTbMkRVDucZhx7ohIgdxgLv5D0RxI', null, null, true); // Add in your key
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


//Search and Filter Query Mod
function sf_filter_query_args( $query_args, $sfid ) {
  if($sfid==5438) {}
  return $query_args;
}
add_filter( 'sf_edit_query_args', 'sf_filter_query_args', 10, 2 );



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

//Literatre download shortcode
add_shortcode( 'literature-download', 'display_custom_post_type' );

function display_custom_post_type(){
    $args = array(
        'post_type' => 'literature-downloads',
        'post_status' => 'publish',
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



/* Custom Yoast template tags */
// Archive Service Tag
function get_archive_services() {
	global $post;
	$pages = get_posts(
		array(
			'post_type' => 'service',
			'orderby' => 'title',
			'order' => 'ASC',
			'numberposts' => 4,
			'post_parent' => 0,
		)
	);
	$len = count($pages);
	$serviceList = '';
	$i = 0;

	if ( $len == 1 ) {
		foreach ( $pages as $page ) {
			$serviceList .= 'including ' . $page->post_title . ' and more for various industries';
		}
	} elseif ( $len == 2 ) {
		$serviceList .= 'including ';
		foreach ( $pages as $page ) {
			if ( $i == 0 ) {
				$serviceList .= $page->post_title;
			} elseif ($i == 1 ) {
				$serviceList .= ' and ' . $page->post_title;
			}
			$i++;
		}
	} elseif ( $len >= 3 ) {
		$serviceList .= 'including ';
		foreach ( $pages as $page ) {
			$i++;
			if ( $i < $len ) {
				$serviceList .= $page->post_title . ", ";
			} else {
				$serviceList .= $page->post_title . ".";
			}
		}
	}

	return $serviceList;
}
// define the action for register yoast_variable replacments
function register_service_archive_yoast_variables() {
    wpseo_register_var_replacement( '%%archiveservices%%', 'get_archive_services', 'advanced', 'pulls the first 3 child services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_service_archive_yoast_variables');


// Single Service Page
function get_services() {
	global $post;
	$serviceID = get_the_ID($post);
	$serviceName = get_the_title($serviceID);
	$pages = get_posts(
		array(
			'post_type' => 'service',
			'orderby' => 'title',
			'order' => 'ASC',
			'numberposts' => 3,
			'post_parent' => $post->ID,

		)
	);
	$description = '';
	$len = count($pages);
	$i = 0;
	$description .= $serviceName;

	if ( is_single() ) {
		if ( $len == 0 ) {
			$description .= '';
		} elseif ( $len == 1 ) {
			foreach ( $pages as $page ) {
				$description .= ' including ' . $page->post_title;
			}
		} elseif ( $len == 2 ) {
			foreach ($pages as $page) {
				$i++;
				if ( $i < $len ) {
					$description .= ', including ' . $page->post_title;
				} elseif ( $i == $len ) {
					$description .= ' and ' . $page->post_title;
				}
			}
		} elseif ( $len > 2 ) {
			$description .= ', including ';
			foreach ($pages as $page) {
				$i++;
				if ( $i < $len ) {
					$description .= $page->post_title . ', ';
				} elseif ( $i >= $len - 1) {
					$description .= 'and ' . $page->post_title;
				}
			}
		}
	}
	return $description;

}
// define the action for register yoast_variable replacments
function register_service_single_yoast_variables() {
    wpseo_register_var_replacement( '%%services%%', 'get_services', 'advanced', 'pulls all services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_service_single_yoast_variables');


// Single Service Industry Page
function get_service_industry() {
	global $post;

	$pID = $post->ID;
	$industries = get_field('service_industries', $pID);
	$len = count($industries);
	$description = '';
	$i = 0;

	if ( empty($industries) ) {
		$description .= 'for various industries.';
	} elseif ( $len == 1 ) {
		foreach ( $industries as $industry) {
			$description .= 'for various industries, including ' . get_the_title($industry) . '.';
		}
	} elseif ( $len == 2 ) {
		foreach ( $industries as $industry) {
			$i++;
			if ( $i == 1 ) {
				$description .= 'for various industries, including ' . get_the_title($industry);
			} else {
				$description .= ' and ' . get_the_title($industry) . '.';
			}
		}
	} elseif ( $len > 2 ) {
		foreach ( $industries as $industry ) {
			$i++;
			if ( $i == 1 ) {
				$description .= 'for various industries, including ' . get_the_title($industry) . ', ';
			} elseif ( $i == 2 ) {
				$description .= get_the_title($industry);
			} elseif ( $i == 3 ) {
				$description .= ', and ' . get_the_title($industry) . '.';
			}
		}
	}

	return $description;

}
// define the action for register yoast_variable replacments
function register_service_indutry_yoast_variables() {
    wpseo_register_var_replacement( '%%service_industry%%', 'get_service_industry', 'advanced', 'pulls all services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_service_indutry_yoast_variables');



// Archive Industry Tag
function get_archive_industry() {
	global $post;
	$pages = get_posts(
		array(
			'post_type' => 'industry',
			'orderby' => 'title',
			'order' => 'ASC',
			'numberposts' => 4
		)
	);
	$description = '';
	$i = 0;
	$len = count($pages);

	if ( $len == 1 ) {
		$description .= $pages[0]->post_title . " industry";
	} elseif ( $len == 2 ) {
		$description .= $pages[0]->post_title . ' and ' . $pages[1]->post_title;
	} elseif ( $len > 2 ) {
		$description .= $pages[0]->post_title . ', ' . $pages[1]->post_title . ', and ' . $pages[2]->post_title . ' industries';
	}

	return $description;

}
// define the action for register yoast_variable replacments
function register_industry_archive_yoast_variables() {
    wpseo_register_var_replacement( '%%archiveindustry%%', 'get_archive_industry', 'advanced', 'industry pulls the first 3 child services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_industry_archive_yoast_variables');

// Single Industry Tag
function get_single_industry() {
	global $post;
	$industyName = get_the_title($post->ID);
	$pages = get_posts(
		array(
			'post_type' => 'service',
			'orderby' => 'title',
			'order' => 'ASC',
			'numberposts' => 3,
			'meta_query' => array(
				array(
					'key' => 'service_industries',
					'value' => '"'. $post->ID . '"',
					'compare' => 'LIKE'
				)
			)
		)
	);

	$serviceList = '';
	$i = 0;
	$len = count($pages);

	if ( $len == 0 ) {
		$description = '';
	} elseif ($len == 1 ) {
		$description = $pages[0]->post_title;
	} elseif ( $len == 2 ) {
		$description = $pages[0]->post_title . ' and ' . $pages[1]->post_title;
	} elseif ( $len == 3 ) {
		$description = $pages[0]->post_title . ', ' . $pages[1]->post_title . ', ' . $pages[2]->post_title . ' and more';
	}

	if ( $len == 1 ) {
		foreach ($pages as $page) {
			$serviceList .= $page->post_title;
		}
	} elseif ( $len == 2 ) {
		foreach ($pages as $page) {
			if ( $i == 0 ) {
				$serviceList .= $page->post_title . " and ";
			} else {
				$serviceList .= $page->post_title . ".";
			}
			$i++;
		}
	} elseif ( $len >= 3 ) {
		foreach ($pages as $page) {
			if ( $i == 0 ) {
				$serviceList .= $page->post_title . ", ";
			} elseif ( $i == $len - 2 ) {
				$serviceList .= $page->post_title . ", and ";
			} else {
				$serviceList .= $page->post_title . '.';
			}
			$i++;
		}
	}

	return $description;

}
// define the action for register yoast_variable replacments
function register_industry_single_yoast_variables() {
    wpseo_register_var_replacement( '%%singleindustry%%', 'get_single_industry', 'advanced', 'industry pulls the first 3 child services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_industry_single_yoast_variables');



// function remove_seo_meta_data_services() {
// 	$allservices = get_posts( 'numberposts=-1&post_type=service' );
//
// 	foreach ( $allservices as $services ) {
// 		delete_post_meta( $services->ID, '_yoast_wpseo_metadesc' );
// 		delete_post_meta( $services->ID, '_yoast_wpseo_title' );
//
// 		wp_update_post( array( 'ID' => $services->ID ) );
// 	}
// }
// add_action('init', 'remove_seo_meta_data_services');

//
//
// //Turn ACF Gallery into a repeater field
// function convert_gallery_acf() {
// 	$posts = get_post($post->ID);
//     foreach ( $posts as $post ) {
// 		$field_key = "field_5ddd47ea444e7"; //New Gallery Field
// 		$value = get_field($field_key, $post->ID);
// 		$serviceSlideshow = get_field('service_gallery', $post->ID);//Old Gallery Field
//         // Run a loop and update every meta data
// 		if ($serviceSlideshow ) {
// 			foreach ($serviceSlideshow as $image) {
// 				if( $image ) {
// 					$value[] = array("image" => $image['url'], "caption" => $image['caption']);
// 				}
// 			}
// 			update_field( $field_key, $value, $post->ID);
// 		}
//     }
//
// }
// add_action('acf/save_post','convert_gallery_acf');
