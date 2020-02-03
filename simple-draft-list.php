<?php
/*
Plugin Name: Draft List
Plugin URI: https://github.com/dartiss/draft-list
Description: Manage and promote your drafts and scheduled posts and pages.
Version: 2.4
Author: David Artiss
Author URI: http://www.artiss.co.uk
Text Domain: simple-draft-list
*/

/**
* Draft List
*
* Display a list of draft posts
*
* @package  Artiss-Draft-List
* @since    2.0
*/

define( 'ARTISS_DRAFT_LIST_VERSION', '2.4' );

/**
* Code includes
*
* Includes for all the plugin functions
*
* @since    2.0
*/

include_once( plugin_dir_path( __FILE__ ) . 'includes/generate-widget.php' );  // Set-up widget

include_once( plugin_dir_path( __FILE__ ) . 'includes/admin-config.php' );     // Administration config

include_once( plugin_dir_path( __FILE__ ) . 'includes/meta-box.php' );         // Add meta box to editor

include_once( plugin_dir_path( __FILE__ ) . 'includes/shared-functions.php' ); // Get the default options

include_once( plugin_dir_path( __FILE__ ) . 'includes/generate-code.php' );    // Code to output draft list
