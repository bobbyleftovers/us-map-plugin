<?php

// MAP CPT
function cpt_map() {
	$labels = array(
		'name'                => 'Maps',
		'singular_name'       => 'Map',
		'menu_name'           => 'US Statistic Maps',
		'parent_item_colon'   => 'Parent Item:',
		'all_items'           => 'All Maps',
		'view_item'           => 'View Item',
		'add_new_item'        => 'Add New Map',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Map',
		'update_item'         => 'Update Map',
		'search_items'        => 'Search Maps',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$rewrite = array(
		'slug'                => 'map',
		'with_front'          => false,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => 'Map',
		'description'         => 'Maps at BPC',
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 9,
        'menu_icon'           => '',
		'can_export'          => false,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'rewrite'             => $rewrite,
        'capability_type'     => 'page',
        'show_in_rest'       => true,
	);
	register_post_type( 'map', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cpt_map', 0 );


// Add meta boxes
function maps_add_custom_box()
{
	add_meta_box(
		'map_shortcode_box',		// Unique ID
		'Add to Any Post',			// Box title
		'map_shortcode_box_html',	// Content callback, must be of type callable
		'map'	                   	// Post type
	);
}

add_action('add_meta_boxes', 'maps_add_custom_box');

function map_shortcode_box_html(){
	global $post;?>
	<p>Add this map and its data to any post by copy/pasting the following shortcode:</p>
	<code>[USMap slug="<?=$post->post_name?>"]</code><?php
	return;
}

add_action( 'rest_api_init', 'map_meta_fields' );
 
function map_meta_fields() {
 
	// register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
	register_rest_field( 'map', 'post-meta', array(
		'get_callback' => 'map_post_meta',
		'schema' => null,
		)
	);
}
 
function map_post_meta( $object ) {
	//get the id of the post object array
	$post_id = $object['id'];
 
	//return the post meta
	return get_post_meta( $post_id );	
}