<?php
namespace Mapping;

use Mapping\CPT;
use Mapping\Carbbon;
use Mapping\RESTController;
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

// PHP dependencies (carbon)

// Create post type
require('includes/cpt.php');
require('includes/carbon.php');
require('includes/maps_rest_controller.php');

// Include some scripts (Vue.js, etc)

// Include some css (can be overridden by the theme)
