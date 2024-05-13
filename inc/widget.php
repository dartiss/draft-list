<?php
/**
 * Widgets
 *
 * Create and display widgets
 *
 * @package simple-draft-list
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Widget
 *
 * Register widget when loading the WP core
 */
function draft_list_register_widgets() {
	register_widget( 'DraftListWidget' );
}

add_action( 'widgets_init', 'draft_list_register_widgets' );

/**
 * Widget defaults
 *
 * Return default values for the widget
 */
function draft_list_load_widget_defaults() {
	return array(
		'title'     => __( 'Coming Soon', 'simple-draft-list' ),
		'limit'     => '0',
		'type'      => '',
		'order'     => '',
		'scheduled' => 'yes',
		'pending'   => 'no',
		'folder'    => '',
		'date'      => 'F j, Y, g:i a',
		'created'   => '',
		'modified'  => '',
		'template'  => '{{ol}}{{draft}} {{icon}}',
	);
}
