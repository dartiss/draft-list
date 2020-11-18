<?php
/**
 * Widgets
 *
 * Create and display widgets
 *
 * @package Artiss-Draft-List
 */

/**
 * Add meta to plugin details
 *
 * Add options to plugin meta line
 */
class DraftListWidget extends WP_Widget {

	/**
	 * Widget Constructor
	 *
	 * Call WP_Widget class to define widget
	 *
	 * @uses WP_Widget Standard WP_Widget class
	 */
	public function __construct() {

		parent::__construct(
			'draft_list_widget',
			__( 'Draft List', 'simple-draft-list' ),
			array( 
				'description'                 => __( 'WordPress plugin to manage and promote your unpublished content.', 'simple-draft-list' ),
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
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		// Output the header.
		echo wp_kses( $before_widget, 'post' );

		// Extract title for heading.
		$title = $instance['title'];

		// Output title, if one exists.
		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title . $title . $after_title, 'post' );
		}

		// Generate the video and output it.
		echo wp_kses(
			adl_generate_code(
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
			),
			'post',
		);

		// Output the trailer.
		echo wp_kses( $after_widget, 'post' );
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
	public function update( $new_instance, $old_instance ) {

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
	public function form( $instance ) {

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
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Widget Title', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['title'] ) . '" /></p>';

		// Template field.

		$field_id   = $this->get_field_id( 'template' );
		$field_name = $this->get_field_name( 'template' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Template', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['template'] ) . '" /></p>';

		// Limit field.

		$field_id   = $this->get_field_id( 'limit' );
		$field_name = $this->get_field_name( 'limit' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Maximum number of drafts (0=unlimited)', 'simple-draft-list' ) . ': </label><input type="text" size="2" maxlength="2" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['limit'] ) . '" /></p>';

		// Minimum number of words.

		$field_id   = $this->get_field_id( 'words' );
		$field_name = $this->get_field_name( 'words' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Minimum number of words', 'simple-draft-list' ) . ': </label><input type="text" size="3" maxlength="3" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['words'] ) . '" /></p>';

		// Draft types field.

		$field_id   = $this->get_field_id( 'type' );
		$field_name = $this->get_field_name( 'type' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Draft Type', 'simple-draft-list' ) . ': </label><select name="' . esc_html( $field_name ) . '" class="widefat" id="' . esc_html( $field_id ) . '"><option value=""';
		if ( esc_html( $instance['type'] ) === '' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Posts & Pages', 'simple-draft-list' ) . '</option><option value="page"';
		if ( esc_html( $instance['type'] ) === 'page' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Pages', 'simple-draft-list' ) . '</option><option value="post"';
		if ( esc_html( $instance['type'] ) === 'post' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Posts', 'simple-draft-list' ) . '</option></select></p>';

		// Order field.

		$field_id   = $this->get_field_id( 'order' );
		$field_name = $this->get_field_name( 'order' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Order', 'simple-draft-list' ) . ': </label><select name="' . esc_html( $field_name ) . '" class="widefat" id="' . esc_html( $field_id ) . '"><option value=""';
		if ( esc_html( $instance['order'] ) === '' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Descending Modified Date', 'simple-draft-list' ) . '</option><option value="ma"';
		if ( esc_html( $instance['order'] ) === 'ma' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Ascending Modified Date', 'simple-draft-list' ) . '</option><option value="cd"';
		if ( esc_html( $instance['order'] ) === 'cd' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Descending Created Date', 'simple-draft-list' ) . '</option><option value="ca"';
		if ( esc_html( $instance['order'] ) === 'ca' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Ascending Created Date', 'simple-draft-list' ) . '</option><option value="td"';
		if ( esc_html( $instance['order'] ) === 'td' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Descending Title', 'simple-draft-list' ) . '</option><option value="ta"';
		if ( esc_html( $instance['order'] ) === 'ta' ) {
			echo " selected='selected'";
		}
		echo '>' . esc_html__( 'Ascending Title', 'simple-draft-list' ) . '</option></select></p>';

		// Scheduled field.

		$field_id   = $this->get_field_id( 'scheduled' );
		$field_name = $this->get_field_name( 'scheduled' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Hide Scheduled Posts', 'simple-draft-list' ) . ': </label><input type="checkbox" name="' . esc_html( $field_name ) . '" id="' . esc_html( $field_id ) . '" value="no"';
		if ( 'no' === esc_html( $instance['scheduled'] ) ) {
			echo " checked='checked'";
		}
		echo '/></p>';

		// Show pending posts.

		$field_id   = $this->get_field_id( 'pending' );
		$field_name = $this->get_field_name( 'pending' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Show Pending Posts', 'simple-draft-list' ) . ': </label><input type="checkbox" name="' . esc_html( $field_name ) . '" id="' . esc_html( $field_id ) . '" value=true';
		if ( 'no' === esc_attr( $instance['pending'] ) ) {
			echo " checked='checked'";
		}
		echo '/></p>';

		// Folder field.

		$field_id   = $this->get_field_id( 'folder' );
		$field_name = $this->get_field_name( 'folder' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Icon Folder', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['folder'] ) . '" /></p>';

		// Date format field.

		$field_id   = $this->get_field_id( 'date' );
		$field_name = $this->get_field_name( 'date' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Date Output Format', 'simple-draft-list' ) . ': </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['date'] ) . '" /></p>';

		// Created field.

		$field_id   = $this->get_field_id( 'created' );
		$field_name = $this->get_field_name( 'created' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Must have been created in the last', 'simple-draft-list' ) . '*: </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['created'] ) . '" /></p>';

		// Modified field.

		$field_id   = $this->get_field_id( 'modified' );
		$field_name = $this->get_field_name( 'modified' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Must have been modified in the last', 'simple-draft-list' ) . '*: </label><input type="text" class="widefat" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['modified'] ) . '" /></p>';

		echo '<p>* ' . esc_html__( 'leave blank to show posts across all time periods', 'simple-draft-list' ) . '</p>';

		// Cache field.

		$field_id   = $this->get_field_id( 'cache' );
		$field_name = $this->get_field_name( 'cache' );
		echo "\r\n" . '<p><label for="' . esc_html( $field_id ) . '">' . esc_html__( 'Cache', 'simple-draft-list' ) . ': </label><input type="text" size="5" maxlength="5" id="' . esc_html( $field_id ) . '" name="' . esc_html( $field_name ) . '" value="' . esc_html( $instance['cache'] ) . '" /> hours</p>';
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
