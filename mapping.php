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

// Start Carbon Fields
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'crb_load' );

require('includes/cpt.php');
require('includes/carbon.php');
// require('includes/maps_rest_controller.php');
require('includes/shortcodes.php');

// Include dist scripts (Vue.js, etc)
wp_enqueue_script('map_vue_js',site_url().'/wp-content/plugins/Mapping/dist/bundle.js', [], false, true);

// Include some css (can be overridden by the theme)
