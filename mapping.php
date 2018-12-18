<?php
/*
 * Plugin Name: US Map Maker
 * Plugin URI: 
 * Description: A plugin that presents a US Map and some related data about states
 * Version: 0.1
 * Author: Robert Rae
 * Author URI: http://ienjoybobby.com
 * Text Domain: 
 * Domain Path: 
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// PHP dependencies (carbon, post type, shortcodes, REST, etc.)
// use Carbon_Fields\Container;
// use Carbon_Fields\Field;

// add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
// function crb_attach_theme_options() {
//     Container::make( 'theme_options', __( 'Map Options', 'crb' ) )
//         ->add_fields( array(
//             Field::make( 'text', 'crb_text', 'Text Field' ),
//         ) );
// }

function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'crb_load' );

require('includes/cpt.php');
require('includes/carbon.php');
require('includes/maps_rest_controller.php');
require('includes/shortcodes.php');
// 
// Include some scripts (Vue.js, etc)

// Include some css (can be overridden by the theme)
