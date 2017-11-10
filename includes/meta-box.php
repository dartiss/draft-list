<?php
/**
* Add meta box to editor
*
* Add a meta box to the page/post editor
*
* @package	Artiss-Draft-List
*/

/**
* Add a custom meta box
*
* Action to define a new meta box for post and page editor
*
* @since	2.0
*/

function adl_add_custom_box() {

	$box_title = __( 'Draft List', 'simple-draft-list' );

	add_meta_box( 'adl_metaid', __( $box_title ), 'adl_custom_box', 'post' );

	add_meta_box( 'adl_metaid', __( $box_title ), 'adl_custom_box', 'page' );

}

add_action( 'admin_init', 'adl_add_custom_box', 1 );  // backwards compatible (before WP 3.0)

/**
* Display custom meta box
*
* Display the customer meta box in the editor
*
* @since	2.0
*
* @param	$post	   string	Post details
*/

function adl_custom_box( $post ) {

	// Use nonce for verification

	wp_nonce_field( plugin_basename( __FILE__ ), 'artiss_draft_list_noncename' );

	// Now request the information

	echo '<label for="adl_hide">' . __( 'Hide from Draft List?', 'simple-draft-list' ) . '&nbsp;</label> ';
	echo '<input type="checkbox" id="adl_hide" name="adl_hide" value="Yes"';
	if ( strtolower( get_post_meta( $post->ID, 'draft_hide', true ) ) == 'yes' ) { echo ' checked="checked"'; }
	echo ' />';

}

/**
* Save meta data
*
* Save the entered meta data
*
* @since	2.0
*
* @param	$post_id   string	Post ID
*/

function adl_save_postdata( $post_id ) {

	// If this is an auto save routine and the form has not been submitted then
	// don't do anything

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

	// Verify this came from the correct meta box and with proper authorization

	if ( isset( $_POST[ 'artiss_draft_list_noncename' ] ) ) {
		if ( !wp_verify_nonce( $_POST[ 'artiss_draft_list_noncename' ], plugin_basename( __FILE__ ) ) ) { return; }
	}

	// Check permissions

	if ( isset( $_POST[ 'post_hide' ] ) ) {
		if ( $_POST[ 'post_type' ] == 'page' ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) { return; }
		} else {
			if ( !current_user_can( 'edit_post', $post_id ) ) { return; }
		}
	}

	// Save the data

	if ( isset( $_POST[ 'adl_hide' ] ) ) {
		$data = sanitize_text_field( $_POST[ 'adl_hide' ] );
	} else {
		$data = '';
	}
	update_post_meta( $post_id, 'draft_hide', $data );

	// Whenever a post is saved, delete any cached draft list

	global $wpdb;
	$wpdb -> query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%transient_adl_%'" );

}

add_action( 'save_post', 'adl_save_postdata' );
?>