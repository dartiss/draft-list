<?php
/**
 * Admin Menu Functions
 *
 * Various functions relating to the various administration screens
 * 
 * @package Artiss-Draft-List
 */

/**
 * Add meta to plugin details
 *
 * Add options to plugin meta line
 *
 * @param  string $links  Current links.
 * @param  string $file   File in use.
 * @return string         Links, now with settings added.
 */
function adl_set_plugin_meta( $links, $file ) {

	if ( false !== strpos( $file, 'simple-draft-list.php' ) ) {

		$links = array_merge(
			$links,
			array( '<a href="https://github.com/dartiss/unublished">' . __( 'Github', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/simple-draft-list">' . __( 'Support', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://artiss.blog/donate">' . __( 'Donate', 'simple-draft-list' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/simple-draft-list/reviews/#new-post">' . __( 'Write a Review', 'simple-draft-list' ) . '&nbsp;⭐️⭐️⭐️⭐️⭐️</a>' )
		);
	}

	return $links;
}

add_filter( 'plugin_row_meta', 'adl_set_plugin_meta', 10, 2 );
