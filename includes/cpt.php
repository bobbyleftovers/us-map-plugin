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
	global $post;
	if($post->post_name){?>
		<p>Add this map and its data to any post by copy/pasting the following shortcode:</p>
		<code>[USMap id="<?=$post->ID?>"]</code><?php
	} else {
		echo 'Save the map to see your shortcode here';
	}
	return;
}

add_action( 'rest_api_init', 'map_meta_fields' );
 
function map_meta_fields() {
 
	// register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
	register_rest_field( 'map', 'map_meta', array(
		'get_callback' => 'map_post_meta',
		'schema' => null,
		)
	);
}
 
function map_post_meta( $object ) {
	//get the id of the post object array
	$post_id = $object['id'];

	$meta = [];
	$style = [];
	
	// Color, etc
	$style['map']['inactive'] = carbon_get_post_meta($post_id, 'state_inactive_color');
	$style['map']['initial'] = carbon_get_post_meta($post_id, 'state_fill_color');
	$style['map']['hover'] = carbon_get_post_meta($post_id, 'state_hover_color');
	$style['map']['clicked'] = carbon_get_post_meta($post_id, 'state_selected_color');
	$style['map']['borders'] = carbon_get_post_meta($post_id, 'state_border_color');
	$style['dataViewer']['placeholderHeading'] = carbon_get_post_meta($post_id, 'data_empty_heading');
	$style['dataViewer']['data_label_color'] = carbon_get_post_meta($post_id, 'data_label_color');
	$style['dataViewer']['data_border_color'] = carbon_get_post_meta($post_id, 'data_border_color');
	$meta['style'] = $style;

	// data
	$meta['states_array'] = carbon_get_post_meta( $post_id, 'states_array' );
	$meta['show_dc'] = carbon_get_post_meta($post_id, 'show_dc');
	$meta['show_small_state_icons'] = carbon_get_post_meta($post_id, 'show_small_state_icons');
	$meta['has_csv'] = carbon_get_post_meta($post_id, 'has_csv');
	$meta['map_csv'] = carbon_get_post_meta($post_id, 'map_csv');
	$meta['has_downloads'] = carbon_get_post_meta($post_id, 'has_downloads');
	$meta['show_inactive'] = carbon_get_post_meta($post_id, 'show_inactive');
	$meta['post_meta'] = get_post_meta($post_id);
 
	//return the post meta
	return $meta;	
}