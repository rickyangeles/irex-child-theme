<?php
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
				$serviceList .= 'and ' . $page->post_title . ".";
			}
		}
	}

	return $serviceList;
	wp_reset_postdata();
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
	wp_reset_postdata();

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
	$industries = get_the_terms($pID, 'industry_tax');
	$len = count($industries);
	$description = '';
	$i = 0;

	if ( empty($industries) ) {
		$description .= 'for various industries.';
	} elseif ( $len == 1 ) {
		foreach ( $industries as $industry) {
			$description .= 'for various industries, including ' . $industry->name . '.';
		}
	} elseif ( $len == 2 ) {
		foreach ( $industries as $industry) {
			$i++;
			if ( $i == 1 ) {
				$description .= 'for various industries, including ' . $industry->name;
			} else {
				$description .= ' and ' . $industry->name . '.';
			}
		}
	} elseif ( $len > 2 ) {
		foreach ( $industries as $industry ) {
			$i++;
			if ( $i == 1 ) {
				$description .= 'for various industries, including ' . $industry->name . ', ';
			} elseif ( $i == 2 ) {
				$description .= $industry->name;
			} elseif ( $i == 3 ) {
				$description .= ', and ' . $industry->name . '.';
			}
		}
	}

	return $description;
	wp_reset_postdata();

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
	wp_reset_postdata();

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
    $post_slug = $post->post_name;
	$pages = get_posts(
		array(
			'post_type' => 'service',
			'orderby' => 'title',
			'order' => 'ASC',
			'numberposts' => 3,
			'tax_query' => array(
				array (
					'taxonomy' => 'industry_tax',
					'field' => 'slug',
					'terms' => $post_slug,
				)
			),
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
	wp_reset_postdata();

}
// define the action for register yoast_variable replacments
function register_industry_single_yoast_variables() {
    wpseo_register_var_replacement( '%%singleindustry%%', 'get_single_industry', 'advanced', 'industry pulls the first 3 child services, if any' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_industry_single_yoast_variables');


?>
