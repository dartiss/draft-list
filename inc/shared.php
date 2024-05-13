<?php
/**
 * Shared Functions
 *
 * A group of functions shared across my plugins, for consistency.
 *
 * @package simple-draft-list
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add meta to plugin details
 *
 * Add options to plugin meta line
 *
 * @version  1.1
 * @param    string $links  Current links.
 * @param    string $file   File in use.
 * @return   string         Links, now with settings added.
 */
function draft_list_plugin_meta( $links, $file ) {

	if ( false !== strpos( $file, 'simple-draft-list.php' ) ) {

		$links = array_merge(
			$links,
			array( '<a href="https://github.com/dartiss/draft-list">' . __( 'Github', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/simple-draft-list">' . __( 'Support', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://artiss.blog/donate">' . __( 'Donate', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/simple-draft-list/reviews/?filter=5" title="' . __( 'Rate the plugin on WordPress.org', 'simple-draft-list' ) . '" style="color: #ffb900">' . str_repeat( '<span class="dashicons dashicons-star-filled" style="font-size: 16px; width:16px; height: 16px"></span>', 5 ) . '</a>' ),
		);
	}

	return $links;
}

add_filter( 'plugin_row_meta', 'draft_list_plugin_meta', 10, 2 );

/**
 * WordPress Fork Check
 *
 * Deactivate the plugin if an unsupported fork of WordPress is detected.
 *
 * @version 1.0
 */
function draft_list_fork_check() {

	// Check for a fork.

	if ( function_exists( 'calmpress_version' ) || function_exists( 'classicpress_version' ) ) {

		// Grab the plugin details.

		$plugins = get_plugins();
		$name    = $plugins[ DRAFT_LIST_PLUGIN_BASE ]['Name'];

		// Deactivate this plugin.

		deactivate_plugins( DRAFT_LIST_PLUGIN_BASE );

		// Set up a message and output it via wp_die.

		/* translators: 1: The plugin name. */
		$message = '<p><b>' . sprintf( __( '%1$s has been deactivated', 'simple-draft-list' ), $name ) . '</b></p><p>' . __( 'Reason:', 'simple-draft-list' ) . '</p>';
		/* translators: 1: The plugin name. */
		$message .= '<ul><li>' . __( 'A fork of WordPress was detected.', 'simple-draft-list' ) . '</li></ul><p>' . sprintf( __( 'The author of %1$s will not provide any support until the above are resolved.', 'simple-draft-list' ), $name ) . '</p>';

		$allowed = array(
			'p'  => array(),
			'b'  => array(),
			'ul' => array(),
			'li' => array(),
		);

		wp_die( wp_kses( $message, $allowed ), '', array( 'back_link' => true ) );
	}
}

add_action( 'admin_init', 'draft_list_fork_check' );

/**
 * Add Dashicons to front-end
 *
 * Will enqueue Dashicons for front-end use.
 */
function draft_list_load_dashicons_front_end() {
	wp_enqueue_style( 'dashicons' );
}

add_action( 'wp_enqueue_scripts', 'draft_list_load_dashicons_front_end' );
