<?php
/**
* Generate code
*
* Generate the draft list code
*
* @package	Artiss-Draft-List
*/

/**
* Draft List shortcode
*
* Display draft list via shortcode
*
* @since	1.5
*
* @param	$paras	   string	Parameters
* @param	$content   string	Content between shortcodes
* @return			   string	Draft list output
*/

function adl_draft_list_shortcode( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'limit' => '', 'type' => '', 'order' => '', 'scheduled' => '', 'icon' => '', 'folder' => '', 'author' => '', 'template' => '', 'date' => '', 'created' => '', 'modified' => '', 'cache' => '' ), $paras ) );

	if ( $template == '' ) { $template = adl_convert_to_template( $icon, $author); }

	return adl_generate_code( $limit, $type, $order, $scheduled, $folder, $date, $created, $modified, $cache, $template );

}
add_shortcode( 'drafts', 'adl_draft_list_shortcode' );

/**
* Draft List Function
*
* Function to output draft list
*
* @since	2.0
*
* @param	$template  string   Template
* @param	$paras	   string	Parameters
*/

function draft_list( $template, $parameters ) {

	$limit = adl_get_parameters( $parameters, 'limit' );
	$type = adl_get_parameters( $parameters, 'type' );
	$order = adl_get_parameters( $parameters, 'order' );
	$scheduled = adl_get_parameters( $parameters, 'scheduled' );
	$folder = adl_get_parameters( $parameters, 'folder' );
	$date = adl_get_parameters( $parameters, 'date' );
	$created = adl_get_parameters( $parameters, 'created' );
	$modified = adl_get_parameters( $parameters, 'modified' );
	$cache = adl_get_parameters( $parameters, 'cache' );

	echo adl_generate_code( $limit, $type, $order, $scheduled, $folder, $date, $created, $modified, $cache, $template );

	return;
}

/**
* Generate draft list
*
* Generate draft list output based on passed parameters
*
* @since	2.0
*
* @param	$list_limit     string	List limit
* @param	$list_type      string	List type
* @param	$list_order     string	List order
* @param	$scheduled      string	Show scheduled posts
* @param	$folder         string	Icon folder
* @param	$date_format    string	Date format to use
* @param	$created        string	Created range
* @param	$modified       string	Modified range
* @param	$template       string	Template
* @return			        string	Draft list output
*/

function adl_generate_code( $list_limit = '', $list_type = '', $list_order = '', $scheduled = '', $icon_folder = '', $date_format = '', $created = '', $modified = '', $cache_time = '', $template = '' ) {

	// Check and valid cache details
	// If invalid, assign a value to it that will ensure no cache is fetched and it drops through to the error checking

	$cache_time = strtolower( $cache_time );
	if ( $cache_time == '' ) { $cache_time = 0.5; }
	if ( ( $cache_time != 'no' ) && ( !is_numeric( $cache_time ) ) ) { $cache_time = 'error'; }

	// Validate the list type as this will determine the cache key

	if ( ( $list_type != 'post' ) && ( $list_type != 'page' ) && ( $list_type != '' ) ) { $list_type = 'error'; }

	// Check for cache

	if ( ( $cache_time == 'no' ) or ( $cache_time == 'error' ) or ( $list_type == 'error' ) ) {
		$code = false;
	} else {

		// Build an item of the cache key based on current privilages - this ensures that
		// editors have their own cache

		if ( ( current_user_can( 'edit_posts' ) ) && ( ( $list_type == 'post' ) or ( $list_type == '' ) ) ) { $editor = "Y"; } else { $editor = "N"; }
		if ( ( current_user_can( 'edit_pages' ) ) && ( ( $list_type == 'page' ) or ( $list_type == '' ) ) ) { $editor .= "Y"; } else { $editor .= "N"; }

		// Build cache key & attempt to get cache

		$cache_key = 'adl_' . md5( $list_limit . $list_type . $list_order . $scheduled . $icon_folder . $date_format . $created . $modified . $cache_time . $editor . $template );
		$code = get_transient( $cache_key );
	}

	if ( !$code ) {

		$plugin_name = 'Draft List';
		$code = "\n<!-- " . $plugin_name . " v" . artiss_draft_list_version . " -->\n";

		// Convert appropriate parameters

		$list_type = strtolower( $list_type );
		$list_order = strtolower( $list_order );
		$scheduled = strtolower( $scheduled );
		$template = html_entity_decode( $template );

		// Set default values

		if ( $list_limit == '' ) { $list_limit = 0; }
		if ( $list_order == '' ) { $list_order = 'da'; }
		if ( $scheduled == '' ) { $scheduled = 'yes'; }
		if ( $date_format == '' ) { $date_format = 'F j, Y, g:i a'; }
		if ( $template == '' ) { $template = '%ul%%draft%'; }

		// Define order of the results

		$first_char = substr( $list_order, 0, 1 );
		$second_char = substr( $list_order, 1, 1 );
		$sort_field = '';
		$sort_sequence = '';

		if ( ( $first_char == 'd' ) or ( $first_char == 'm' ) ) { $sort_field =  'post_modified'; }
		if ( $first_char == 'c' ) { $sort_field =  'post_date'; }
		if ( $first_char == 't' ) { $sort_field =  'post_title'; }
		if ( $second_char == 'a' ) { $sort_sequence = ' ASC'; }
		if ( $second_char == 'd' ) { $sort_sequence = ' DESC'; }

		$order = $sort_field . $sort_sequence;

		// Perform validation of passed parameters

		$error = false;
		if ( !is_numeric( $list_limit ) ) { $code .= adl_report_error( __( 'The limit is invalid - it must be a number', 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		if ( ( $sort_field == '' ) or ( $sort_sequence == '' ) ) { $code .= adl_report_error( __( 'The order is invalid - please view the instructions for valid combinations', 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		if ( ( $list_type != 'post' ) && ( $list_type != 'page' ) && ( $list_type != '' ) ) { $code .= adl_report_error( __( "The list type is invalid - it must be blank, 'post' or 'page'.", 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		if ( ( $scheduled != 'no' ) && ( $scheduled != 'yes' ) ) { $code .= adl_report_error( __( "The scheduled parameter must be either 'Yes' or 'No'", 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		if ( ( $cache_time != 'no' ) && ( !is_numeric( $cache_time ) ) ) { $code .= adl_report_error( __( "The cache time is invalid - it should either be a number or 'No'", 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		if ( strpos( $template, '%draft%' ) === false ) { $code .= adl_report_error( __( 'The template must include the %draft% tag', 'simple-draft-list' ), $plugin_name, false ); $error = true; }

		// Calculate created and modified dates to compare with

		$far_past = '2 January 1970';

		if ( $created != '' ) { $created = '-' . $created; } else { $created = $far_past; }
		$created = strtotime( $created );
		if ( ( $created == -1 ) or ( !$created ) ) { $code .= adl_report_error( __( 'The created parameter is invalid', 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		$created = date( 'Y-m-d H:i:s', $created );

		if ( $modified != '' ) { $modified = '-' . $modified; } else { $modified = $far_past; }
		$modified = strtotime( $modified );
		if ( ( $modified == -1 ) or ( !$modified ) ) { $code .= adl_report_error( __( 'The modified parameter is invalid', 'simple-draft-list' ), $plugin_name, false ); $error = true; }
		$modified = date( 'Y-m-d H:i:s', $modified );

		if ( !$error ) {

			// Define the type of list required

			if ( ( $list_type == 'post' ) or ( $list_type == 'page' ) ) {
				$type = " AND post_type = '" . $list_type . "'";
			} else {
				$type = " AND (post_type = 'post' OR post_type = 'page')";
			}
			if ( $scheduled != 'no' ) { $status = " OR post_status = 'future'";} else { $status = ''; }

			// Define icon folder

			if ( $icon_folder == '' ) {
				$icon_folder = plugins_url( 'images/', dirname(__FILE__) );
			} else {
				$icon_folder = get_bloginfo( 'template_url' ) . '/' . $icon_folder . '/';
			}

			// Has a word or character count been requested?

			if ( ( strpos( $template, '%words%' ) !== false ) or ( strpos( $template, '%chars%' ) !== false ) or ( strpos( $template, '%chars+space%' ) !== false ) ) {
				$sql_content = ', post_content';
				$count = true;
			} else {
				$sql_content = '';
				$count = false;
			}

			// Extract drafts from database based on parameters

			global $wpdb;
			$drafts = $wpdb -> get_results( "SELECT A.id, post_type, post_title, post_status, display_name, user_url, post_date, post_modified" . $sql_content . " FROM $wpdb->posts A, $wpdb->users B WHERE B.ID = A.post_author AND (post_status = 'draft'" . $status . ") AND post_title NOT LIKE '!%'" . $type . " ORDER BY " . $order );

			// Loop through and output results

			if ( $drafts ) {

				// If template contains list tags at beginning, wrap these around output

				$list = false;
				if ( ( ( substr( $template, 0, 4 ) == '%ol%' ) or ( substr( $template, 0, 4 ) == '%ul%' ) ) && ( $list_limit != 1 ) ) {
					$list_type = substr( $template, 1, 2 );
					$code .= '<' . $list_type . ">\n";
					$list = true;

					// Remove any OL and UL tags

					$template = str_replace( '%' . $list_type . '%', '', $template );
				}

				$valid_draft = 1;
				foreach ( $drafts as $draft_data ) {

					// Extract fields from MySQL results

					$post_id = $draft_data -> id;
					$post_type = $draft_data -> post_type;
					$draft_title = $draft_data -> post_title;
					$post_created = $draft_data -> post_date;
					$post_modified = $draft_data -> post_modified;

					// Does the current user have editor privileges for the current post type

					if ( ( ( current_user_can( 'edit_posts' ) ) && ( $post_type == 'post' ) ) or ( ( current_user_can( 'edit_pages' ) ) && ( $post_type == 'page' ) ) ) { $can_edit = true; } else { $can_edit = false; }

					// If the current user can edit then allow a blank title

					if ( ( $draft_title == '' ) && ( $can_edit ) ) { $draft_title = __( '[No Title]', 'simple-draft-list' ); }

					// Work out whether created and/or modified date is acceptable

					if ( ( $post_created > $created ) && ( $post_modified > $modified ) ) { $date_accept = true; } else { $date_accept = false; }

					// Only output if the meta isn't set to exclude it, the limit hasn't been reached,
					// the dates are fine and the title isn't blank

					if ( ( $date_accept ) && ( $draft_title != '' ) && ( strtolower( get_post_meta( $post_id, 'draft_hide', true ) ) != 'yes' ) && ( ( $list_limit == 0 ) or ( $valid_draft <= $list_limit ) ) ) {

						$post_status = $draft_data -> post_status;
						$author = $draft_data -> display_name;
						$author_url = $draft_data -> user_url;

						if ( $count ) { $post_content = $draft_data -> post_content; }

						// Build line

						if ( $list ) { $this_line = "\t<li>"; } else { $this_line = ''; }
						$this_line .= $template;
						if ( $list ) { $this_line .= '</li>'; }

						// Replace the icon tag

						$alt_title = __( 'Scheduled', 'simple-draft-list' );
						if ( $post_status == 'future' ) { $icon_url = '<img src="' . $icon_folder . 'scheduled.png" alt="' . $alt_title . '" title="' . $alt_title . '">'; } else { $icon_url = ''; }
						$this_line = str_replace( '%icon%', $icon_url, $this_line );

						// Replace the author tag

					   $this_line = str_replace( '%author%', $author, $this_line );
					   if ( $author_url != '' ) { $author_link = '<a href="' . $author_url . '">' . $author . '</a>'; } else { $author_link = $author; }
					   $this_line = str_replace( '%author+link%', $author_link, $this_line );

						// Replace the draft tag

						if ( $draft_title != '' ) { $draft = $draft_title; } else { $draft = __( '(no title)', 'simple-draft-list' ); }
						if ( $can_edit ) { $draft = '<a href="' . home_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit" rel="nofollow">' . $draft . '</a>'; }
						$this_line = str_replace( '%draft%', $draft, $this_line );

						// Replace the created date

						$created_date = date( $date_format, strtotime( $post_created ) );
						$this_line = str_replace( '%created%', $created_date, $this_line );

						// Replace the modified date

						$modified_date = date( $date_format, strtotime( $post_modified ) );
						$this_line = str_replace( '%modified%', $modified_date, $this_line );

						// Replace the word and character counts

						if ( $count ) {
							if ( strpos( $this_line, '%words%' ) !== false ) { $this_line = str_replace( '%words%', number_format( str_word_count( $post_content, 0 ) ), $this_line ); }
							if ( strpos( $this_line, '%chars%' ) !== false ) { $this_line = str_replace( '%chars%', number_format( strlen( $post_content ) - substr_count( $post_content, ' ' ) ), $this_line ); }
							if ( strpos( $this_line, '%chars+space%' ) !== false ) { $this_line = str_replace( '%chars+space%', number_format( strlen( $post_content ) ), $this_line ); }
						}

						// Replace the category

						$category = get_the_category( $post_id );
						$category = $category[ 0 ] -> cat_name;
						if ( $category == 'Uncategorized' ) { $category = ''; }
						$this_line = str_replace( '%category%', $category, $this_line );

						// Replace the categories

						$category_list = '';
						foreach( ( get_the_category( $post_id ) ) as $category ) {
							if ( $category -> cat_name != 'Uncategorized' ) { $category_list .= ', ' . $category -> cat_name; }
						}
						if ( $category_list != '' ) { $category_list = substr( $category_list, 2 ); }

						$this_line = str_replace( '%categories%', $category_list, $this_line );

						// Now add the current line to the overall code output

						$code .= $this_line . "\n";
						$valid_draft++;
					}
				}

				if ( $list ) { $code .= '</' . $list_type . '>'; }
			}

		}

		$code .= "\n<!-- End of " . $plugin_name . " -->\n";

		// Saving resulting output to cache

		if ( ( $cache_key != 'no' ) && ( !$error ) ) { set_transient( $cache_key, $code, 3600 * $cache_time ); }
	}

	return $code;
}
?>