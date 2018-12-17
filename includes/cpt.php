<?php
namespace Mapping\CPT;

// PERSON CPT
function cpt_map() {
	$labels = array(
		'name'                => 'Maps',
		'singular_name'       => 'Map',
		'menu_name'           => 'Maps',
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
		'supports'            => array( 'title', 'custom-fields' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 9,
        'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
        'capability_type'     => 'page',
        'show_in_rest'       => true,
  		'rest_base'          => 'books-api',
  		'rest_controller_class' => 'WP_REST_Maps_Controller',
	);
	register_post_type( 'map', $args );
}
// Hook into the 'init' action
add_action( 'init', 'Mapping\CPT\cpt_map', 0 );