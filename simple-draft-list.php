<?php
/**
 * To Be Published
 *
 * @package           Artiss-Draft-List
 * @author            David Artiss
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       To Be Published
 * Plugin URI:        https://wordpress.org/plugins/simple-draft-list/
 * Description:       📝W ordPress plugin to manage and promote your unpublished content.
 * Version:           3.0
 * Requires at least: 4.6
 * Requires PHP:      5.3
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

// Require the various code components - all held within the inc folder.

require_once plugin_dir_path( __FILE__ ) . 'inc/setup.php';        // Administration config.

require_once plugin_dir_path( __FILE__ ) . 'inc/metabox.php';      // Add meta box to editor.

require_once plugin_dir_path( __FILE__ ) . 'inc/widget.php';       // Set-up widget.

require_once plugin_dir_path( __FILE__ ) . 'inc/create-lists.php'; // Code to output draft list.
