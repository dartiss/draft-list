<?php
/**
 * Shared Functions
 *
 * Assorted functions that are used throughout the code
 *
 * @package Artiss-Draft-List
 */

/**
 * Convert parameters to a template
 *
 * Convert old parameters to template equivalent
 *
 * @param  string $icon    Icon position.
 * @param  string $author  Whether to show author.
 * @return string          Template.
 */
function adl_convert_to_template( $icon = '', $author = '' ) {

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
 * Extract Parameters
 *
 * Function to extract parameters from an input string
 *
 * @param  string $input      Input string.
 * @param  string $para       Parameter to find.
 * @param  string $divider    Which divider to use.
 * @param  string $seperator  Which seperator to use.
 * @return string             Parameter value.
 */
function adl_get_parameters( $input, $para, $divider = '=', $seperator = '&' ) {

	$start   = strpos( strtolower( $input ), $para . $divider );
	$content = '';
	if ( false !== $start ) {
		$start = $start + strlen( $para ) + 1;
		$end   = strpos( strtolower( $input ), $seperator, $start );
		if ( false !== $end ) {
			--$end;
		} else {
			$end = strlen( $input );
		}
		$content = substr( $input, $start, $end - $start + 1 );
	}
	return $content;
}

/**
 * Report an error
 *
 * Function to report an error
 *
 * @param  string $error        Error message.
 * @param  string $plugin_name  The name of the plugin.
 * @param  string $echo         True or false, depending on whether you wish to return or echo the results.
 * @return string               True.
 */
function adl_report_error( $error, $plugin_name, $echo = true ) {
	$output = '<p style="color: #f00; font-weight: bold;">' . $plugin_name . ': ' . __( $error ) . "</p>\n";
	if ( $echo ) {
		echo $output;
		return true;
	} else {
		return $output;
	}
}
