<?php
/*
Plugin Name: Draft List
Plugin URI: https://wordpress.org/plugins/simple-draft-list/
Description: Manage and promote your drafts and scheduled posts and pages.
Version: 2.3.3
Author: David Artiss
Author URI: http://www.artiss.co.uk
Text Domain: simple-draft-list
*/

/**
* Draft List
*
* Display a list of draft posts
*
* @package	Artiss-Draft-List
* @since	2.0
*/

define( 'artiss_draft_list_version', '2.3.3' );

/**
* Code includes
*
* Includes for all the plugin functions
*
* @since	2.0
*/

$functions_dir = plugin_dir_path( __FILE__ ) . 'includes/';

include_once( $functions_dir . 'generate-widget.php' );				// Set-up widget

include_once( $functions_dir . 'admin-config.php' );				// Administration config

include_once( $functions_dir . 'meta-box.php' );					// Add meta box to editor

include_once( $functions_dir . 'shared-functions.php' );			// Get the default options

include_once( $functions_dir . 'generate-code.php' );				// Code to output draft list
?>