<?php
/**
 * Draft List
 *
 * @package           simple-draft-list
 * @author            David Artiss
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       Draft List
 * Plugin URI:        https://wordpress.org/plugins/simple-draft-list/
 * Description:       //WordPress plugin to manage and promote your unpublished content.
 * Version:           2.6
 * Requires at least: 4.6
 * Requires PHP:      7.4
 * Author:            David Artiss
 * Author URI:        https://artiss.blog
 * Text Domain:       simple-draft-list
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define global to hold the plugin base file name.

if ( ! defined( 'DRAFT_LIST_PLUGIN_BASE' ) ) {
	define( 'DRAFT_LIST_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}

// Require the various code components - all held within the inc folder.

require_once plugin_dir_path( __FILE__ ) . 'inc/shared.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/metabox.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/class-draftlistwidget.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/widget.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/create-lists.php';
