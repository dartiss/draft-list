<?php
/**
* Admin Menu Functions
*
* Various functions relating to the various administration screens
*
* @package	Artiss-Draft-List
*/

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function adl_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'simple-draft-list.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="https://github.com/dartiss/draft-list">' . __( 'Github', 'simple-draft-list' ) . '</a>' ) );	

		$links = array_merge( $links, array( '<a href="http://wordpress.org/support/plugin/simple-draft-list">' . __( 'Support', 'simple-draft-list' ) . '</a>' ) );

		$links = array_merge( $links, array( '<a href="https://artiss.blog/donate">' . __( 'Donate', 'simple-draft-list' ) . '</a>' ) );

		$links = array_merge( $links, array( '<a href="https://wordpress.org/support/plugin/simple-draft-list/reviews/#new-post">' . __( 'Write a Review', 'simple-draft-list' ) . '&nbsp;⭐️⭐️⭐️⭐️⭐️</a>' ) );
	}		

	return $links;
}

add_filter( 'plugin_row_meta', 'adl_set_plugin_meta', 10, 2 );

/**
* Admin Screen Initialisation
*
* Set up draft menu options
*
* @since	2.3
*/

function adl_menu_initialise() {

	global $wpdb;
	$author = get_current_user_id();

	// Get total number of draft posts. If more than zero add a sub-menu option

	$all_posts = $wpdb -> get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'draft'" );
	if ( $all_posts > 0 ) {

		add_submenu_page( 'edit.php', '', __( 'All Drafts <span class=\'update-plugins\'><span class=\'update-count\'>' . $all_posts . '</span></span>', 'simple-draft-list' ), 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post' ) );

		// Get total number of draft posts for current user. If more than zero add a sub-menu option

		$your_posts = $wpdb -> get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'draft' AND post_author=" . $author );
		if ( $your_posts > 0 && $your_posts !== $all_posts ) {
			add_submenu_page( 'edit.php', '', __( 'My Drafts <span class=\'update-plugins\'><span class=\'update-count\'>' . $your_posts . '</span></span>', 'simple-draft-list' ), 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post&author=' . $author . '' ) );
		}
	}

	// Get total number of draft pages. If more than zero add a sub-menu option

	$all_pages = $wpdb -> get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'draft'" );
	if ( $all_pages > 0 ) {

		add_submenu_page( 'edit.php?post_type=page', '', __( 'All Drafts <span class=\'update-plugins\'><span class=\'update-count\'>' . $all_pages . '</span></span>', 'simple-draft-list' ), 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page' ) );

		// Get total number of draft pages for current user. If more than zero add a sub-menu option

		$your_pages = $wpdb -> get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'draft' AND post_author=" . $author );
		if ( $your_pages > 0 && $your_pages !== $all_pages ) {
			add_submenu_page( 'edit.php?post_type=page', '', __( 'My Drafts <span class=\'update-plugins\'><span class=\'update-count\'>' . $your_pages . '</span></span>', 'simple-draft-list' ), 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page&author=' . $author . '' ) );
		}
	}

}

add_action( 'admin_menu', 'adl_menu_initialise' );
