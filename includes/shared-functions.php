<?php
/**
* Shared Functions
*
* Assorted functions that are used throughout the code
*
* @package	Artiss-Draft-List
*/

/**
* Convert parameters to a template
*
* Convert old parameters to template equivalent
*
* @since	2.0
*
* @param	$icon	string	Icon position
* @param	$author string	Whether to show author
* @return			string	Template
*/

function adl_convert_to_template( $icon = '', $author = '' ) {

	$template = '{{ul}}';
	if ( strtolower( $icon ) === 'left' ) { $template .= '{{icon}}&nbsp;'; }
	$template .= '{{draft}}';
	if ( strtolower( $author ) === 'yes' ) { $template .= '&nbsp;({{author}})'; }
	if ( strtolower( $icon ) === 'right' ) { $template .= '&nbsp;{{icon}}'; }

	return $template;
}

/**
* Extract Parameters
*
* Function to extract parameters from an input string
*
* @since	1.0
*
* @param	$input	string	Input string
* @param	$para	string	Parameter to find
* @return			string	Parameter value
*/

function adl_get_parameters( $input, $para, $divider = '=', $seperator = '&' ) {

	$start = strpos( strtolower( $input ), $para . $divider);
	$content = '';
	if ( $start !== false ) {
		$start = $start + strlen( $para ) + 1;
		$end = strpos( strtolower( $input ), $seperator, $start );
		if ( $end !== false ) { $end = $end - 1; } else { $end = strlen( $input ); }
		$content = substr( $input, $start, $end - $start + 1 );
	}
	return $content;
}

/**
* Report an error (1.3)
*
* Function to report an error
*
* @since	2.0
*
* @param	$error			string	Error message
* @param	$plugin_name	string	The name of the plugin
* @param	$echo			string	True or false, depending on whether you wish to return or echo the results
* @return					string	True
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
