<?php

//Get Subsidiary Services
function get_services_rest($services) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$services);
	$result=curl_exec($ch);
	$posts = json_decode($result, true);
	echo '<ul>';
	foreach ($posts as $post) {
		echo '<li><a href=' . $post['link'] .'>' . $post['title']['rendered'] . '</a></li>';
	}
	echo '</ul>';
}

function get_services_rest_name($services) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$services);
	$result = curl_exec($ch);
	$posts = json_decode($result, true);
	$serviceArray = [];
	if (is_array($posts) || is_object($posts))
	{
		foreach ($posts as $post) {
			$serviceArray[] = $post['title']['rendered'];
		}
	}
	return $serviceArray;
}

//Get Subsidiary Locations
function get_locations_rest($locations, $title) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$locations);
	$result=curl_exec($ch);
	$result=curl_exec($ch);
	$posts = json_decode($result, true);
	echo '<ul>';
	foreach ($posts as $post) {
		$location = $post['title']['rendered'];
		$branchName = $post['acf']['branch_name'];
		//$locationName = preg_replace("/[^A-Za-z0-9]/","",$locationName);
		echo '<li><a href="' . $post['link'] . '">' . $branchName . '</a></li>';
	}
	echo '</ul>';
}
//Get Sub Logo
function get_logo_rest($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	$result=curl_exec($ch);
	$logoImg = json_decode($result, true);
	foreach ($logoImg as $v) {
		$img = $v['url'];
		echo $img;
	}
}

//Get sub footer about
function get_about_rest($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	$result=curl_exec($ch);
	$aboutField = json_decode($result, true);
	foreach ($aboutField as $v) {
		$about = $v;
		echo $about;
	}
}
//get number of connections
function total_connections($id) {
	$connection_map = get_post_meta( $id, 'dt_connection_map', true );
	$total_connections = 0;
	if ( ! empty( $connection_map['external'] ) ) {
		$total_connections = $total_connections + count( $connection_map['external'] );
	}
	return $total_connections;
}

function get_service_subsidiary($id) {

	$meta = get_post_meta($id, 'dt_connection_map', true);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$id);
	$result=curl_exec($ch);
	$result=curl_exec($ch);
	$subs = json_decode($result, true);
	$post = $meta['external'];
	$idList = array();
	foreach ($post as $key => $value) {
		$idList[] = $value['post_id'];
	}
	return $idList;
}


//Custom limit on content and excerpt function
function excerpt($limit, $id) {
  $excerpt = explode(' ', get_the_excerpt($id), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  $excerpt = wp_strip_all_tags($excerpt);
  return $excerpt;
}



function service_excerpt($id) {
	$content = get_the_excerpt($id);
	$pos = strpos($content, '.');
    return substr($content, 0, $pos+1);
}


function project_excerpt($limit, $id) {
  $excerpt = explode(' ', get_field('project_details', $id), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
   $excerpt = wp_strip_all_tags($excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]>', $content);
  return $content;
}


/*********

		Scheudled the pulling of services located in each location

*********/

add_action( 'wp', 'prefix_setup_schedule' );
/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function prefix_setup_schedule() {
    if ( ! wp_next_scheduled( 'prefix_daily_event' ) ) {
        wp_schedule_event( time(), 'hourly', 'prefix_daily_event');
    }
}
add_action( 'prefix_daily_event', 'get_service_taxonomy' );
/**
 * On the scheduled action hook, run a function.
 */

 function get_service_gallery($pID) {
 	$o_post = get_post_meta($pID, 'dt_original_post_id', true);
 	$o_site = get_post_meta($pID, 'dt_original_site_url', true);
 	$url = $o_site . '/wp-json/acf/v3/service/' . $o_post . '/service_gallery';

 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	curl_setopt($ch, CURLOPT_URL,$url);
 	$result=curl_exec($ch);
 	$logoImg = json_decode($result, true);
 	$count = 0;

 	echo '<div class="swiper-wrapper">';
 	foreach ($logoImg as $v) {
 		foreach ($v as $vv) {
 			echo '<div class="swiper-slide">';
 			echo '<img src="' . $vv['url'] . '" alt="">';
 			if ($vv['caption']) {
 				echo '<div class="slide-caption">' . $vv['caption'] . '</div>';
 			}
 			echo '</div>';
 			$count++;
 		}
 	}
 	echo '</div>';

 	if ( $count > 1) {
 		echo '<div class="nav-wrap">
 			<div class="swiper-pagination"></div>
 			<div class="swiper-button-prev"></div>
 			<div class="swiper-button-next"></div>
 		</div>';
 	}
 }

 function get_project_gallery($pID) {
   $o_post = get_post_meta($pID, 'dt_original_post_id', true);
   $o_site = get_post_meta($pID, 'dt_original_site_url', true);
   $url = $o_site . '/wp-json/acf/v3/project-gallery/' . $o_post . '/project_gallery';
   //echo $url;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_URL,$url);
   $result=curl_exec($ch);
   $logoImg = json_decode($result, true);
   $count = 0;

   echo '<div class="swiper-wrapper">';
   foreach ($logoImg as $v) {
	   foreach ($v as $vv) {
		   echo '<div class="swiper-slide">';
		   echo '<img src="' . $vv['url'] . '" alt="">';
		   if ($vv['caption']) {
			   echo '<div class="slide-caption">' . $vv['caption'] . '</div>';
		   }
		   echo '</div>';
		   $count++;
	   }
   }
   echo '</div>';

   if ( $count > 1) {
	   echo '<div class="nav-wrap">
		   <div class="swiper-pagination"></div>
		   <div class="swiper-button-prev"></div>
		   <div class="swiper-button-next"></div>
	   </div>';
   }
 }

 function get_industry_gallery($pID) {
   $o_post = get_post_meta($pID, 'dt_original_post_id', true);
   $o_site = get_post_meta($pID, 'dt_original_site_url', true);
   $url = $o_site . '/wp-json/acf/v3/industry/' . $o_post . '/industry_gallery';
   //echo $url;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_URL,$url);
   $result=curl_exec($ch);
   $logoImg = json_decode($result, true);
   $count = 0;

   echo '<div class="swiper-wrapper">';
   foreach ($logoImg as $v) {
	  foreach ($v as $vv) {
		  echo '<div class="swiper-slide">';
		  echo '<img src="' . $vv['url'] . '" alt="">';
		  if ($vv['caption']) {
			  echo '<div class="slide-caption">' . $vv['caption'] . '</div>';
		  }
		  echo '</div>';
		  $count++;
	  }
   }
   echo '</div>';

   if ( $count > 1) {
	  echo '<div class="nav-wrap">
		  <div class="swiper-pagination"></div>
		  <div class="swiper-button-prev"></div>
		  <div class="swiper-button-next"></div>
	  </div>';
   }
 }

 ?>
