<?php
/**
Plugin Name: To Be Published
Plugin URI: https://wordpress.org/plugins/simple-draft-list/
Description: Manage and promote your drafts and scheduled posts and pages.
Version: 3.0
Author: David Artiss
Author URI: http://artiss.blog
Text Domain: simple-draft-list

@package  Artiss-Draft-List
 */

/**
 * Code includes
 *
 * Includes for all the plugin functions
 */

require_once plugin_dir_path( __FILE__ ) . 'inc/widget.php';       // Set-up widget.

require_once plugin_dir_path( __FILE__ ) . 'inc/setup.php';        // Administration config.

require_once plugin_dir_path( __FILE__ ) . 'inc/metabox.php';      // Add meta box to editor.

require_once plugin_dir_path( __FILE__ ) . 'inc/shared.php';       // Get the default options.

require_once plugin_dir_path( __FILE__ ) . 'inc/create-lists.php'; // Code to output draft list.
