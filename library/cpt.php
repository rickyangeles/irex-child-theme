<?php
add_action( 'init', 'cptui_register_my_cpts' );
//Adding CPTs
function cptui_register_my_cpts() {

	/**
	 * Post Type: Testimonials.
	 */

	$labels = array(
		"name" => __( "Testimonials", "understrap" ),
		"singular_name" => __( "Testimonial", "understrap" ),
		"menu_name" => __( "Testimonials", "understrap" ),
		"all_items" => __( "All Testimonials", "understrap" ),
		"add_new" => __( "Add Testimonial", "understrap" ),
		"add_new_item" => __( "Add New Testimonial", "understrap" ),
		"edit_item" => __( "Edit Testimonial", "understrap" ),
		"new_item" => __( "New Testimonial", "understrap" ),
		"view_item" => __( "View Testimonial", "understrap" ),
		"view_items" => __( "View Testimonials", "understrap" ),
		"search_items" => __( "Search Testimonial", "understrap" ),
		"not_found" => __( "No Testimonials Found", "understrap" ),
		"not_found_in_trash" => __( "No Testimonials found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Testimonial", "understrap" ),
		"featured_image" => __( "Featured image for this Testimonial", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Testimonial", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Testimonial", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Testimonial", "understrap" ),
		"archives" => __( "Industry Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Testimonial", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Testimonial", "understrap" ),
		"filter_items_list" => __( "Filter Testimonials List", "understrap" ),
		"items_list_navigation" => __( "Testimonials list navigation", "understrap" ),
		"items_list" => __( "Testimonials List", "understrap" ),
		"attributes" => __( "Testimonial Attributes", "understrap" ),
		"name_admin_bar" => __( "Testimonial", "understrap" ),
		"parent_item_colon" => __( "Parent Testimonial", "understrap" ),
	);

	$args = array(
		"label" => __( "Testimonials", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display testimonials.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "testimonial",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "testimonial", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 11,
		"menu_icon" => "dashicons-star-filled",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "testimonial", $args );

	/**
	 * Post Type: Industriess.
	 */

	$labels = array(
		"name" => __( "Industries", "understrap" ),
		"singular_name" => __( "Industry", "understrap" ),
		"menu_name" => __( "Industries", "understrap" ),
		"all_items" => __( "All Industries", "understrap" ),
		"add_new" => __( "Add Industry", "understrap" ),
		"add_new_item" => __( "Add New Industry", "understrap" ),
		"edit_item" => __( "Edit Industry", "understrap" ),
		"new_item" => __( "New Industry", "understrap" ),
		"view_item" => __( "View Industry", "understrap" ),
		"view_items" => __( "View Industries", "understrap" ),
		"search_items" => __( "Search Industry", "understrap" ),
		"not_found" => __( "No Industries Found", "understrap" ),
		"not_found_in_trash" => __( "No Industries found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Industry", "understrap" ),
		"featured_image" => __( "Featured image for this Industry", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Industry", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Industry", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Industry", "understrap" ),
		"archives" => __( "Industry Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Industry", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Industry", "understrap" ),
		"filter_items_list" => __( "Filter Industries List", "understrap" ),
		"items_list_navigation" => __( "Industries list navigation", "understrap" ),
		"items_list" => __( "Industries List", "understrap" ),
		"attributes" => __( "Industries Attributes", "understrap" ),
		"name_admin_bar" => __( "Industry", "understrap" ),
		"parent_item_colon" => __( "Parent Industry", "understrap" ),
	);

	$args = array(
		"label" => __( "Industries", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display industries.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "industry",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "industries", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 8,
		"menu_icon" => "dashicons-building",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "industry", $args );

	/**
	 * Post Type: Sevices.
	 */

	$labels = array(
		"name" => __( "Services", "understrap" ),
		"singular_name" => __( "Service", "understrap" ),
		"menu_name" => __( "Services", "understrap" ),
		"all_items" => __( "All Services", "understrap" ),
		"add_new" => __( "Add Service", "understrap" ),
		"add_new_item" => __( "Add New Service", "understrap" ),
		"edit_item" => __( "Edit Service", "understrap" ),
		"new_item" => __( "New Service", "understrap" ),
		"view_item" => __( "View Service", "understrap" ),
		"view_items" => __( "View Services", "understrap" ),
		"search_items" => __( "Search Service", "understrap" ),
		"not_found" => __( "No Services Found", "understrap" ),
		"not_found_in_trash" => __( "No Services found in Trash", "understrap" ),
		"parent_item_colon" => __( "Parent Service", "understrap" ),
		"featured_image" => __( "Featured image for this service", "understrap" ),
		"set_featured_image" => __( "Set featured image for this service", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this service", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this service", "understrap" ),
		"archives" => __( "Service Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Service", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this service", "understrap" ),
		"filter_items_list" => __( "Filter Services List", "understrap" ),
		"items_list_navigation" => __( "Services list navigation", "understrap" ),
		"items_list" => __( "Services List", "understrap" ),
		"attributes" => __( "Services Attributes", "understrap" ),
		"name_admin_bar" => __( "Service", "understrap" ),
		"parent_item_colon" => __( "Parent Service", "understrap" ),
	);

	$args = array(
		"label" => __( "Services", "understrap" ),
		"labels" => $labels,
		"description" => "Post type used to display services.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "service",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "services", "with_front" => false ),
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-admin-generic",
		"supports" => array( "title", "editor", "thumbnail", "revisions", "page-attributes" ),
	);

	register_post_type( "service", $args );

	/**
	 * Post Type: Locations.
	 */

	$labels = array(
		"name" => __( "Locations", "understrap" ),
		"singular_name" => __( "Location", "understrap" ),
		"menu_name" => __( "Locations", "understrap" ),
		"all_items" => __( "All Locations", "understrap" ),
		"add_new" => __( "Add Location", "understrap" ),
		"add_new_item" => __( "Add New Location", "understrap" ),
		"edit_item" => __( "Edit Location", "understrap" ),
		"new_item" => __( "New Location", "understrap" ),
		"view_item" => __( "View Location", "understrap" ),
		"view_items" => __( "View Locations", "understrap" ),
		"search_items" => __( "Search Location", "understrap" ),
		"not_found" => __( "No Location Found", "understrap" ),
		"not_found_in_trash" => __( "No Locations found in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Location", "understrap" ),
		"featured_image" => __( "Featured image for this location", "understrap" ),
		"set_featured_image" => __( "Set featured image for this location", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this location", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this location", "understrap" ),
		"archives" => __( "Location Archives", "understrap" ),
		"insert_into_item" => __( "Insert into location", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this location", "understrap" ),
		"filter_items_list" => __( "Filter location list", "understrap" ),
		"items_list_navigation" => __( "Locations list navigation", "understrap" ),
		"items_list" => __( "Locations list", "understrap" ),
		"attributes" => __( "Locations Atrributes", "understrap" ),
		"name_admin_bar" => __( "Location", "understrap" ),
		"parent_item_colon" => __( "Parent Location", "understrap" ),
	);

	$args = array(
		"label" => __( "Locations", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "location",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "locations", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 6,
		"menu_icon" => "dashicons-location-alt",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "location", $args );

	/**
	 * Post Type: Resources.
	 */

	$labels = array(
		"name" => __( "Literature Downloads", "understrap" ),
		"singular_name" => __( "Literature Download", "understrap" ),
		"menu_name" => __( "Literature Download", "understrap" ),
		"all_items" => __( "All Literature Downloads", "understrap" ),
		"add_new" => __( "Add Literature Download", "understrap" ),
		"add_new_item" => __( "Add New Literature Download", "understrap" ),
		"edit_item" => __( "Edit Literature Download", "understrap" ),
		"new_item" => __( "New Literature Download", "understrap" ),
		"view_item" => __( "View Literature Download", "understrap" ),
		"view_items" => __( "View Literature Downloads", "understrap" ),
		"search_items" => __( "Search Literature Download", "understrap" ),
		"not_found" => __( "No resources found", "understrap" ),
		"not_found_in_trash" => __( "No Literature Downloads in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Literature Download", "understrap" ),
		"featured_image" => __( "Featured image for this Literature Download", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Literature Download", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Literature Download", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Literature Download", "understrap" ),
		"archives" => __( "Literature Download Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Literature Download", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Literature Download", "understrap" ),
		"filter_items_list" => __( "Filter Literature Download list", "understrap" ),
		"items_list_navigation" => __( "Literature Download list navigation", "understrap" ),
		"items_list" => __( "Literature Downloads List", "understrap" ),
		"attributes" => __( "Literature Downloads Attributes", "understrap" ),
		"name_admin_bar" => __( "Literature Download", "understrap" ),
		"parent_item_colon" => __( "Parent Literature Download", "understrap" ),
	);

	$args = array(
		"label" => __( "Resources", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "resource",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "resource", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 9,
		"menu_icon" => "dashicons-book",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "literature-downloads", $args );

	/**
	 * Post Type: Project Gallery.
	 */

	$labels = array(
		"name" => __( "Projects", "understrap" ),
		"singular_name" => __( "Project", "understrap" ),
		"menu_name" => __( "Project", "understrap" ),
		"all_items" => __( "All Projects", "understrap" ),
		"add_new" => __( "Add Project", "understrap" ),
		"add_new_item" => __( "Add New Projec", "understrap" ),
		"edit_item" => __( "Edit Project", "understrap" ),
		"new_item" => __( "New Project", "understrap" ),
		"view_item" => __( "View Project", "understrap" ),
		"view_items" => __( "View Projects", "understrap" ),
		"search_items" => __( "Search Project", "understrap" ),
		"not_found" => __( "No galleries found", "understrap" ),
		"not_found_in_trash" => __( "No Projects in trash", "understrap" ),
		"parent_item_colon" => __( "Parent Project", "understrap" ),
		"featured_image" => __( "Featured image for this Project", "understrap" ),
		"set_featured_image" => __( "Set featured image for this Project", "understrap" ),
		"remove_featured_image" => __( "Remove featured image from this Project", "understrap" ),
		"use_featured_image" => __( "Use as featured image for this Project", "understrap" ),
		"archives" => __( "Project Archives", "understrap" ),
		"insert_into_item" => __( "Insert into Project", "understrap" ),
		"uploaded_to_this_item" => __( "Uploaded to this Project", "understrap" ),
		"filter_items_list" => __( "Filter Project list", "understrap" ),
		"items_list_navigation" => __( "Project list navigation", "understrap" ),
		"items_list" => __( "Projects List", "understrap" ),
		"attributes" => __( "Projects Attributes", "understrap" ),
		"name_admin_bar" => __( "Project", "understrap" ),
		"parent_item_colon" => __( "Parent Project", "understrap" ),
	);

	$args = array(
		"label" => __( "Project Gallery", "understrap" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "project-gallery",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "project-gallery", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 7,
		"menu_icon" => "dashicons-images-alt2",
		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	);

	register_post_type( "project_gallery", $args );
	//
	// 	/**
	// 	 * Post Type: Gallery.
	// 	 */
	//
	// 	$labels = array(
	// 		"name" => __( "Gallery", "understrap" ),
	// 		"singular_name" => __( "Gallery", "understrap" ),
	// 		"menu_name" => __( "Gallery", "understrap" ),
	// 		"all_items" => __( "All Galleries", "understrap" ),
	// 		"add_new" => __( "Add Gallery", "understrap" ),
	// 		"add_new_item" => __( "Add New Gallery", "understrap" ),
	// 		"edit_item" => __( "Edit Gallery", "understrap" ),
	// 		"new_item" => __( "New Gallery", "understrap" ),
	// 		"view_item" => __( "View Gallery", "understrap" ),
	// 		"view_items" => __( "View Galleries", "understrap" ),
	// 		"search_items" => __( "Search Gallery", "understrap" ),
	// 		"not_found" => __( "No galleries found", "understrap" ),
	// 		"not_found_in_trash" => __( "No Galleries in trash", "understrap" ),
	// 		"parent_item_colon" => __( "Parent Gallery", "understrap" ),
	// 		"featured_image" => __( "Featured image for this Gallery", "understrap" ),
	// 		"set_featured_image" => __( "Set featured image for this Gallery", "understrap" ),
	// 		"remove_featured_image" => __( "Remove featured image from this Gallery", "understrap" ),
	// 		"use_featured_image" => __( "Use as featured image for this Gallery", "understrap" ),
	// 		"archives" => __( "Gallery Archives", "understrap" ),
	// 		"insert_into_item" => __( "Insert into Gallery", "understrap" ),
	// 		"uploaded_to_this_item" => __( "Uploaded to this Gallery", "understrap" ),
	// 		"filter_items_list" => __( "Filter Gallery list", "understrap" ),
	// 		"items_list_navigation" => __( "Gallery list navigation", "understrap" ),
	// 		"items_list" => __( "Galleries List", "understrap" ),
	// 		"attributes" => __( "Galleries Attributes", "understrap" ),
	// 		"name_admin_bar" => __( "Gallery", "understrap" ),
	// 		"parent_item_colon" => __( "Parent Gallery", "understrap" ),
	// 	);
	//
	// 	$args = array(
	// 		"label" => __( "Gallery", "understrap" ),
	// 		"labels" => $labels,
	// 		"description" => "",
	// 		"public" => true,
	// 		"publicly_queryable" => true,
	// 		"show_ui" => true,
	// 		"delete_with_user" => false,
	// 		"show_in_rest" => true,
	// 		"rest_base" => "gallery",
	// 		"rest_controller_class" => "WP_REST_Posts_Controller",
	// 		"has_archive" => false,
	// 		"show_in_menu" => true,
	// 		"show_in_nav_menus" => true,
	// 		"exclude_from_search" => false,
	// 		"capability_type" => "post",
	// 		"map_meta_cap" => true,
	// 		"hierarchical" => false,
	// 		"rewrite" => array( "slug" => "gallery", "with_front" => true ),
	// 		"query_var" => true,
	// 		"menu_position" => 7,
	// 		"menu_icon" => "dashicons-slides",
	// 		"supports" => array( "title", "editor", "thumbnail", "revisions" ),
	// 	);
	//
	// register_post_type( "gallery", $args );

		/**
		 * Post Type: Partners.
		 */

		$labels = array(
			"name" => __( "Partners", "understrap" ),
			"singular_name" => __( "Partner", "understrap" ),
			"menu_name" => __( "Partner", "understrap" ),
			"all_items" => __( "All Partners", "understrap" ),
			"add_new" => __( "Add Partner", "understrap" ),
			"add_new_item" => __( "Add New Partner", "understrap" ),
			"edit_item" => __( "Edit Partner", "understrap" ),
			"new_item" => __( "New Partner", "understrap" ),
			"view_item" => __( "View Partner", "understrap" ),
			"view_items" => __( "View Partners", "understrap" ),
			"search_items" => __( "Search Partner", "understrap" ),
			"not_found" => __( "No galleries found", "understrap" ),
			"not_found_in_trash" => __( "No Partners in trash", "understrap" ),
			"parent_item_colon" => __( "Parent Partner", "understrap" ),
			"featured_image" => __( "Featured image for this Partner", "understrap" ),
			"set_featured_image" => __( "Set featured image for this Partner", "understrap" ),
			"remove_featured_image" => __( "Remove featured image from this Partner", "understrap" ),
			"use_featured_image" => __( "Use as featured image for this Partner", "understrap" ),
			"archives" => __( "Partner Archives", "understrap" ),
			"insert_into_item" => __( "Insert into Partner", "understrap" ),
			"uploaded_to_this_item" => __( "Uploaded to this Partner", "understrap" ),
			"filter_items_list" => __( "Filter Partner list", "understrap" ),
			"items_list_navigation" => __( "Partner list navigation", "understrap" ),
			"items_list" => __( "Partners List", "understrap" ),
			"attributes" => __( "Partners Attributes", "understrap" ),
			"name_admin_bar" => __( "Partner", "understrap" ),
			"parent_item_colon" => __( "Parent Partner", "understrap" ),
		);

		$args = array(
			"label" => __( "Partners", "understrap" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => true,
			"rest_base" => "partner",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => true,
			"rewrite" => array( "slug" => "partners", "with_front" => true ),
			"query_var" => true,
			"menu_position" => 10,
			"menu_icon" => "dashicons-admin-users",
			"supports" => array( "title", "editor", "thumbnail", "revisions" ),
		);

	register_post_type( "partner", $args );
}



/* Registering Custom Taxonomies */
add_action('init', 'add_custom_taxonomy');
function add_custom_taxonomy() {
	register_taxonomy( 'subsidiary_tax', array('gallery', 'subsidiary', 'service', 'location', 'post', 'project_gallery', 'literature-downloads'), array( 'hierarchical' => true, 'label' => 'Subsidiary' ) );
	register_taxonomy( 'location_tax', array('location'), array( 'hierarchical' => true, 'label' => 'Location' ) );
	register_taxonomy( 'service_tax', array('location'), array( 'hierarchical' => false, 'label' => 'Services', 'meta_box_cb' => true ) );
}

// Register Industry Taxonomy
function industry_tax() {

	$labels = array(
		'name'                       => _x( 'Industries', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Industry', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Industry', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
		'rest_base'                  => 'industry_tax',
	);
	register_taxonomy( 'industry_tax', array( 'service', 'project_gallery', 'testimonial' ), $args );

}
add_action( 'init', 'industry_tax', 0 );
 ?>
