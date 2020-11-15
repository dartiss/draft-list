<?php
/**
 * Widgets
 *
 * Create and display widgets
 *
 * @package Artiss-Draft-List
 */
class DraftListWidget extends WP_Widget {

	/**
	 * Widget Constructor
	 *
	 * Call WP_Widget class to define widget
	 *
	 * @uses WP_Widget Standard WP_Widget class
	 */
	function __construct() {

		parent::__construct(
			'draft_list_widget',
			__( 'Draft List', 'simple-draft-list' ),
			array( 
				'description'                 => __( 'Display a list of draft posts and/or pages.', 'simple-draft-list' ),
				'class'                       => 'dl-widget',
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Display widget
	 *
	 * Display the widget
	 *
	 * @uses  adl_generate_code  Generate the required code
	 *
	 * @param string $args       Arguments.
	 * @param string $instance   Instance.
	 */
	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		// Output the header.
		echo $before_widget;

		// Extract title for heading.
		$title = $instance['title'];

		// Output title, if one exists.
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		// Generate the video and output it.
		echo adl_generate_code(
			$instance['limit'],
			$instance['type'],
			$instance['order'],
			$instance['scheduled'],
			$instance['folder'],
			$instance['date'],
			$instance['created'],
			$instance['modified'],
			$instance['cache'],
			$instance['template'],
			$instance['words'],
			$instance['pending'],
		);

		// Output the trailer.
		echo $after_widget;
	}

	/**
	 * Widget update/save function
	 *
	 * Update and save widget
	 *
	 * @param  string $new_instance  New instance.
	 * @param  string $old_instance  Old instance.
	 * @return string                Instance.
	 */
	function update( $new_instance, $old_instance ) {

		$instance              = $old_instance;
		$instance['title']     = wp_strip_all_tags( $new_instance['title'] );
		$instance['limit']     = $new_instance['limit'];
		$instance['type']      = $new_instance['type'];
		$instance['order']     = $new_instance['order'];
		$instance['scheduled'] = $new_instance['scheduled'];
		$instance['folder']    = $new_instance['folder'];
		$instance['cache']     = $new_instance['cache'];
		$instance['date']      = $new_instance['date'];
		$instance['created']   = $new_instance['created'];
		$instance['modified']  = $new_instance['modified'];
		$instance['template']  = $new_instance['template'];
		$instance['words']     = $new_instance['words'];
		$instance['pending']   = $new_instance['pending'];

		return $instance;
	}

	/**
	 * Widget Admin control form
	 *
	 * Define admin file
	 *
	 * @param string $instance  Instance.
	 */
	function form( $instance ) {

		// Set default options.

		$default  = array(
			'title'     => __( 'Coming Soon', 'simple-draft-list' ),
			'limit'     => '0',
			'type'      => '',
			'order'     => '',
			'scheduled' => '',
			'folder'    => '',
			'cache'     => '0.5',
			'date'      => 'F j, Y, g:i a',
			'created'   => '',
			'modified'  => '',
			'template'  => '{{ol}}{{draft}} {{icon}}',
		);
		$instance = wp_parse_args( (array) $instance, $default );

		// Title field.

		$field_id   = $this->get_field_id( 'title' );
		$field_name = $this->get_field_name( 'title' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Widget Title', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['title'] ) . '" /></p>';

		// Template field.

		$field_id   = $this->get_field_id( 'template' );
		$field_name = $this->get_field_name( 'template' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Template', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['template'] ) . '" /></p>';

		// Limit field.

		$field_id   = $this->get_field_id( 'limit' );
		$field_name = $this->get_field_name( 'limit' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Maximum number of drafts (0=unlimited)', 'simple-draft-list' ) . ': </label><input type="text" size="2" maxlength="2" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['limit'] ) . '" /></p>';

		// Minimum number of words.

		$field_id   = $this->get_field_id( 'words' );
		$field_name = $this->get_field_name( 'words' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Minimum number of words', 'simple-draft-list' ) . ': </label><input type="text" size="3" maxlength="3" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['words'] ) . '" /></p>';

		// Draft types field.

		$field_id   = $this->get_field_id( 'type' );
		$field_name = $this->get_field_name( 'type' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Draft Type', 'simple-draft-list' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '"><option value=""';
		if ( esc_attr( $instance['type'] ) === '' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Posts & Pages', 'simple-draft-list' ) . '</option><option value="page"';
		if ( esc_attr( $instance['type'] ) === 'page' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Pages', 'simple-draft-list' ) . '</option><option value="post"';
		if ( esc_attr( $instance['type'] ) === 'post' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Posts', 'simple-draft-list' ) . '</option></select></p>';

		// Order field.

		$field_id   = $this->get_field_id( 'order' );
		$field_name = $this->get_field_name( 'order' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Order', 'simple-draft-list' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '"><option value=""';
		if ( esc_attr( $instance['order'] ) === '' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Descending Modified Date', 'simple-draft-list' ) . '</option><option value="ma"';
		if ( esc_attr( $instance['order'] ) === 'ma' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Ascending Modified Date', 'simple-draft-list' ) . '</option><option value="cd"';
		if ( esc_attr( $instance['order'] ) === 'cd' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Descending Created Date', 'simple-draft-list' ) . '</option><option value="ca"';
		if ( esc_attr( $instance['order'] ) === 'ca' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Ascending Created Date', 'simple-draft-list' ) . '</option><option value="td"';
		if ( esc_attr( $instance['order'] ) === 'td' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Descending Title', 'simple-draft-list' ) . '</option><option value="ta"';
		if ( esc_attr( $instance['order'] ) === 'ta' ) {
			echo " selected='selected'";
		}
		echo '>' . __( 'Ascending Title', 'simple-draft-list' ) . '</option></select></p>';

		// Scheduled field.

		$field_id   = $this->get_field_id( 'scheduled' );
		$field_name = $this->get_field_name( 'scheduled' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Hide Scheduled Posts', 'simple-draft-list' ) . ': </label><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="no"';
		if ( 'no' === esc_attr( $instance['scheduled'] ) ) {
			echo " checked='checked'";
		}
		echo '/></p>';

		// Show pending posts.

		$field_id   = $this->get_field_id( 'pending' );
		$field_name = $this->get_field_name( 'pending' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Show Pending Posts', 'simple-draft-list' ) . ': </label><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value=true';
		if ( 'no' === esc_attr( $instance['pending'] ) ) {
			echo " checked='checked'";
		}
		echo '/></p>';

		// Folder field.

		$field_id   = $this->get_field_id( 'folder' );
		$field_name = $this->get_field_name( 'folder' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Icon Folder', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['folder'] ) . '" /></p>';

		// Date format field.

		$field_id   = $this->get_field_id( 'date' );
		$field_name = $this->get_field_name( 'date' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Date Output Format', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['date'] ) . '" /></p>';

		// Created field.

		$field_id   = $this->get_field_id( 'created' );
		$field_name = $this->get_field_name( 'created' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Must have been created in the last', 'simple-draft-list' ) . '*: </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['created'] ) . '" /></p>';

		// Modified field.

		$field_id   = $this->get_field_id( 'modified' );
		$field_name = $this->get_field_name( 'modified' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Must have been modified in the last', 'simple-draft-list' ) . '*: </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['modified'] ) . '" /></p>';

		echo '<p>* ' . __( 'leave blank to show posts across all time periods', 'simple-draft-list' ) . '</p>';

		// Cache field.

		$field_id   = $this->get_field_id( 'cache' );
		$field_name = $this->get_field_name( 'cache' );
		echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Cache', 'simple-draft-list' ) . ': </label><input type="text" size="5" maxlength="5" id="' . $field_id . '" name="' . $field_name . '" value="' . esc_attr( $instance['cache'] ) . '" /> hours</p>';
	}
}

/**
 * Register Widget
 *
 * Register widget when loading the WP core
 */
function adl_register_widgets() {
	register_widget( 'DraftListWidget' );
}

add_action( 'widgets_init', 'adl_register_widgets' );
