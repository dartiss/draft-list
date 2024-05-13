<?php
/**
 * Generate code
 *
 * Generate the draft list code
 *
 * @package simple-draft-list
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Draft List shortcode
 *
 * Display draft list via shortcode
 *
 * @param  string $paras   Parameters.
 * @return string          Draft list output.
 */
function draft_list_shortcode( $paras = '' ) {

	// Set default parameter values.

	$limit     = '';
	$type      = '';
	$order     = '';
	$scheduled = '';
	$icon      = '';
	$folder    = '';
	$author    = '';
	$template  = '';
	$date      = '';
	$created   = '';
	$modified  = '';
	$words     = '';
	$pending   = '';

	// Assign to variable, if found in array.

	if ( array_key_exists( 'limit', $paras ) ) {
		$limit = $paras['limit'];
	}
	if ( array_key_exists( 'type', $paras ) ) {
		$type = $paras['type'];
	}
	if ( array_key_exists( 'order', $paras ) ) {
		$order = $paras['order'];
	}
	if ( array_key_exists( 'scheduled', $paras ) ) {
		$scheduled = $paras['scheduled'];
	}
	if ( array_key_exists( 'icon', $paras ) ) {
		$icon = $paras['icon'];
	}
	if ( array_key_exists( 'folder', $paras ) ) {
		$folder = $paras['folder'];
	}
	if ( array_key_exists( 'author', $paras ) ) {
		$author = $paras['author'];
	}
	if ( array_key_exists( 'template', $paras ) ) {
		$template = $paras['template'];
	}
	if ( array_key_exists( 'date', $paras ) ) {
		$date = $paras['date'];
	}
	if ( array_key_exists( 'created', $paras ) ) {
		$created = $paras['created'];
	}
	if ( array_key_exists( 'modified', $paras ) ) {
		$modified = $paras['modified'];
	}
	if ( array_key_exists( 'words', $paras ) ) {
		$words = $paras['words'];
	}
	if ( array_key_exists( 'pending', $paras ) ) {
		$pending = $paras['pending'];
	}

	// If there's no template, create a default one.

	if ( '' === $template ) {
		$template = draft_list_convert_to_template( $icon, $author );
	}

	// Generate the output.

	return draft_list_generate_code( $limit, $type, $order, $scheduled, $folder, $date, $created, $modified, $template, $words, $pending );
}

add_shortcode( 'drafts', 'draft_list_shortcode' );

/**
 * Generate draft list
 *
 * Generate draft list output based on passed parameters
 *
 * @param  string $list_limit   List limit.
 * @param  string $list_type    List type.
 * @param  string $list_order   List order.
 * @param  string $scheduled    Show scheduled posts.
 * @param  string $icon_folder  Icon folder.
 * @param  string $date_format  Date format to use.
 * @param  string $created      Created range.
 * @param  string $modified     Modified range.
 * @param  string $template     Template.
 * @param  string $words        Number of words.
 * @param  string $pending      Whether to show pending posts.
 * @return string               Draft list output.
 */
function draft_list_generate_code( $list_limit = '', $list_type = '', $list_order = '', $scheduled = '', $icon_folder = '', $date_format = '', $created = '', $modified = '', $template = '', $words = '', $pending = '' ) {

	// Validate the list type.
	if ( ( 'post' !== $list_type ) && ( 'page' !== $list_type ) && ( '' !== $list_type ) ) {
		$list_type = 'error';
	}

	$plugin_name = 'Draft List';
	$code        = '';

	// Convert appropriate parameters.
	$list_type  = strtolower( $list_type );
	$list_order = strtolower( $list_order );
	$scheduled  = strtolower( $scheduled );
	$pending    = strtolower( $pending );
	$template   = html_entity_decode( $template );

	// Set default values.
	if ( '' === $list_limit ) {
		$list_limit = 0;
	}
	if ( '' === $words ) {
		$words = 0;
	}
	if ( '' === $list_order ) {
		$list_order = 'da';
	}
	if ( '' === $scheduled ) {
		$scheduled = 'yes';
	}
	if ( '' === $pending ) {
		$pending = 'no';
	}
	if ( '' === $date_format ) {
		$date_format = 'F j, Y, g:i a';
	}
	if ( '' === $template ) {
		$template = '{{ul}}{{draft}}';
	}

	// Define order of the results.
	$first_char    = substr( $list_order, 0, 1 );
	$second_char   = substr( $list_order, 1, 1 );
	$sort_field    = '';
	$sort_sequence = '';

	if ( ( 'd' === $first_char ) || ( 'm' === $first_char ) ) {
		$sort_field = 'post_modified';
	}
	if ( 'c' === $first_char ) {
		$sort_field = 'post_date';
	}
	if ( 't' === $first_char ) {
		$sort_field = 'post_title';
	}
	if ( 'a' === $second_char ) {
		$sort_sequence = ' ASC';
	}
	if ( 'd' === $second_char ) {
		$sort_sequence = ' DESC';
	}

	// Perform validation of passed parameters.
	$error = false;
	if ( ! is_numeric( $list_limit ) ) {
		$code .= draft_list_report_error( __( 'The limit is invalid - it must be a number', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	if ( ! is_numeric( $words ) ) {
		$code .= draft_list_report_error( __( 'The minimum number of words is invalid - it must be a number', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	if ( ( '' === $sort_field ) || ( '' === $sort_sequence ) ) {
		$code .= draft_list_report_error( __( 'The order is invalid - please view the instructions for valid combinations', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	if ( ( 'post' !== $list_type ) && ( 'page' !== $list_type ) && ( '' !== $list_type ) ) {
		$code .= draft_list_report_error( __( "The list type is invalid - it must be blank, 'post' or 'page'.", 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	if ( ( 'no' !== $scheduled ) && ( 'yes' !== $scheduled ) ) {
		$code .= draft_list_report_error( __( "The scheduled parameter must be either 'Yes' or 'No'", 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	if ( strpos( $template, '%draft%' ) === false && strpos( $template, '{{draft}}' ) === false ) {
		$code .= draft_list_report_error( __( 'The template must include the {{draft}} tag', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}

	// Calculate created and modified dates to compare with.
	$far_past = '2 January 1970';

	if ( '' !== $created ) {
		$created = '-' . $created;
	} else {
		$created = $far_past;
	}
	$created = strtotime( $created );
	if ( ( -1 === $created ) || ( ! $created ) ) {
		$code .= draft_list_report_error( __( 'The created parameter is invalid', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	$created = gmdate( 'Y-m-d H:i:s', $created );

	if ( '' !== $modified ) {
		$modified = '-' . $modified;
	} else {
		$modified = $far_past;
	}
	$modified = strtotime( $modified );
	if ( ( -1 === $modified ) || ( ! $modified ) ) {
		$code .= draft_list_report_error( __( 'The modified parameter is invalid', 'simple-draft-list' ), $plugin_name, false );
		$error = true;
	}
	$modified = gmdate( 'Y-m-d H:i:s', $modified );

	if ( ! $error ) {

		// Define the type of list required.
		$type = array( 'post', 'page' );
		if ( ( 'post' === $list_type ) || ( 'page' === $list_type ) ) {
			$type = $list_type;
		}

		$status = array( 'draft' );

		if ( true === $scheduled || 'true' === $scheduled || 'yes' === $scheduled ) {
			array_push( $status, 'future' );
		}
		if ( true === $pending || 'true' === $pending || 'yes' === $pending ) {
			array_push( $status, 'pending' );
		}

		// Has a word or character count been requested?
		if ( ( $words > 0 ) || ( strpos( $template, '%words%' ) !== false ) || ( strpos( $template, '{{words}}' ) !== false ) || ( strpos( $template, '%chars%' ) !== false ) || ( strpos( $template, '%chars+space%' ) !== false ) || ( strpos( $template, '{{chars+space}}' ) !== false ) ) {
			$sql_content = ', post_content';
			$count       = true;
		} else {
			$sql_content = '';
			$count       = false;
		}

		// Extract drafts from database based on parameters.
		$args = array(
			'post_status' => $status,
			'post_type'   => $type,
			'numberposts' => 99,
			'orderby'     => $sort_field,
			'sort_order'  => $sort_sequence,
		);

		$drafts = get_posts( $args );

		// If template contains list tags at beginning, wrap these around output.
		$list = false;
		if ( ( ( '%ol%' === substr( $template, 0, 4 ) ) || ( '%ul%' === substr( $template, 0, 4 ) ) ) && ( 1 !== $list_limit ) ) {
			$list_type = substr( $template, 1, 2 );
			$code     .= '<' . $list_type . ">\n";
			$list      = true;

			// Remove any OL and UL tags.
			$template = str_replace( '%' . $list_type . '%', '', $template );
		}

		if ( ( ( '{{ol}}' === substr( $template, 0, 6 ) ) || ( '{{ul}}' === substr( $template, 0, 6 ) ) ) && ( 1 !== $list_limit ) ) {
			$list_type = substr( $template, 2, 2 );
			$code     .= '<' . $list_type . ">\n";
			$list      = true;

			// Remove any OL and UL tags.
			$template = str_replace( '{{' . $list_type . '}}', '', $template );
		}

		$valid_draft = 1;
		foreach ( $drafts as $draft_data ) {

			// Skip the post if the title beings with an exclamation mark.
			$post_title = $draft_data->post_title;

			if ( '!' !== substr( $post_title, 0, 1 ) ) {

				// Extract fields from MySQL results.
				$post_id       = $draft_data->ID;
				$post_type     = $draft_data->post_type;
				$draft_title   = $draft_data->post_title;
				$post_created  = $draft_data->post_date;
				$post_modified = $draft_data->post_modified;
				if ( $count ) {
					$post_content = $draft_data->post_content;
					$post_length  = str_word_count( $post_content );
				}

				// Check if the post has enough words in it.
				if ( $count && $post_length <= $words ) {
					$enough_words = false;
				} else {
					$enough_words = true;
				}

				// Does the current user have editor privileges for the current post type.
				if ( ( ( current_user_can( 'edit_posts' ) ) && ( 'post' === $post_type ) ) || ( ( current_user_can( 'edit_pages' ) ) && ( 'page' === $post_type ) ) ) {
					$can_edit = true;
				} else {
					$can_edit = false;
				}

				// If the current user can edit then allow a blank title.
				if ( ( '' === $draft_title ) && ( $can_edit ) ) {
					$draft_title = __( '[No Title]', 'simple-draft-list' );
				}

				// Work out whether created and/or modified date is acceptable.
				if ( ( $post_created > $created ) && ( $post_modified > $modified ) ) {
					$date_accept = true;
				} else {
					$date_accept = false;
				}

				// Only output if the meta isn't set to exclude it, the limit hasn't been reached,
				// there are enough words in the post, the dates are fine and the title isn't blank.
				if ( ( $date_accept ) && ( $enough_words ) && ( '' !== $draft_title ) && ( 'yes' !== strtolower( get_post_meta( $post_id, 'draft_hide', true ) ) ) && ( ( 0 === $list_limit ) || ( '0' === $list_limit ) || ( $valid_draft <= $list_limit ) ) ) {

					$post_status = $draft_data->post_status;
					$author      = $draft_data->display_name;
					$author_url  = $draft_data->user_url;

					if ( $count ) {
						$post_content = $draft_data->post_content;
					}

					// Build line.
					if ( $list ) {
						$this_line = "\t<li>";
					} else {
						$this_line = '';
					}
					$this_line .= $template;
					if ( $list ) {
						$this_line .= '</li>';
					}

					// Replace the icon tag.
					$alt_title = __( 'Scheduled', 'simple-draft-list' );
					if ( 'future' === $post_status ) {
						if ( '' !== $icon_folder ) {
							$icon_folder = get_bloginfo( 'template_url' ) . '/' . $icon_folder . '/';
							$icon_url    = '<img src="' . $icon_folder . 'scheduled.png" alt="' . $alt_title . '" title="' . $alt_title . '">';
						} else {
							$icon_url = '<span class="dashicons dashicons-clock"></span>';
						}
					} else {
						$icon_url = '';
					}

					$this_line = str_replace( '{{icon}}', $icon_url, $this_line );

					// Replace the author tag.
					$this_line = str_replace( '{{author}}', $author, $this_line );

					if ( '' !== $author_url ) {
						$author_link = '<a href="' . $author_url . '">' . $author . '</a>';
					} else {
						$author_link = $author;
					}
					$this_line = str_replace( '{{author+link}}', $author_link, $this_line );

					// Replace the draft tag.
					if ( '' !== $draft_title ) {
						$draft = $draft_title;
					} else {
						$draft = __( '(no title)', 'simple-draft-list' );
					}
					if ( $can_edit ) {
						$draft = '<a href="' . home_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit" rel="nofollow">' . $draft . '</a>';
					}
					$this_line = str_replace( '{{draft}}', $draft, $this_line );

					// Replace the created date.
					$created_date = gmdate( $date_format, strtotime( $post_created ) );
					$this_line    = str_replace( '{{created}}', $created_date, $this_line );

					// Replace the modified date.
					$modified_date = gmdate( $date_format, strtotime( $post_modified ) );
					$this_line     = str_replace( '{{modified}}', $modified_date, $this_line );

					// Replace the word and character counts.
					if ( $count ) {
						if ( strpos( $this_line, '{{words}}' ) !== false ) {
							$this_line = str_replace( '{{words}}', number_format( $word_count ), $this_line );
						}
						if ( strpos( $this_line, '{{chars}}' ) !== false ) {
							$this_line = str_replace( '{{chars}}', number_format( strlen( $post_content ) - substr_count( $post_content, ' ' ) ), $this_line );
						}
						if ( strpos( $this_line, '{{chars+space}}' ) !== false ) {
							$this_line = str_replace( '{{chars+space}}', number_format( strlen( $post_content ) ), $this_line );
						}
					}

					// Replace the category.
					$category = get_the_category( $post_id );
					$category = $category[0]->cat_name;
					if ( 'Uncategorized' === $category ) {
						$category = '';
					}
					$this_line = str_replace( '{{category}}', $category, $this_line );

					// Replace the categories.
					$category_list = '';
					foreach ( ( get_the_category( $post_id ) ) as $category ) {
						if ( 'Uncategorized' !== $category->cat_name ) {
							$category_list .= ', ' . $category->cat_name;
						}
					}
					if ( '' !== $category_list ) {
						$category_list = substr( $category_list, 2 );
					}

					$this_line = str_replace( '{{categories}}', $category_list, $this_line );

					// Now add the current line to the overall code output.
					$code .= $this_line . "\n";
					++$valid_draft;
				}
			}
		}

		if ( $list ) {
			$code .= '</' . $list_type . '>';
		}
	}

	return $code;
}

/**
 * Convert parameters to a template
 *
 * Convert old parameters to template equivalent
 *
 * @param  string $icon    Icon position.
 * @param  string $author  Whether to show author.
 * @return string          Template.
 */
function draft_list_convert_to_template( $icon = '', $author = '' ) {

	$template = '{{ul}}';
	if ( strtolower( $icon ) === 'left' ) {
		$template .= '{{icon}}&nbsp;';
	}
	$template .= '{{draft}}';
	if ( strtolower( $author ) === 'yes' ) {
		$template .= '&nbsp;({{author}})';
	}
	if ( strtolower( $icon ) === 'right' ) {
		$template .= '&nbsp;{{icon}}';
	}

	return $template;
}

/**
 * Report an error
 *
 * Function to report an error
 *
 * @param  string $error        Error message.
 * @param  string $plugin_name  The name of the plugin.
 * @param  string $output       True or false, depending on whether you wish to return or echo the results.
 * @return string               True.
 */
function draft_list_report_error( $error, $plugin_name, $output = true ) {

	$text = '<p style="color: #f00; font-weight: bold;">' . $plugin_name . ': ' . $error . "</p>\n";
	if ( $output ) {
		echo esc_html( $text );
		return true;
	} else {
		return $text;
	}
}
