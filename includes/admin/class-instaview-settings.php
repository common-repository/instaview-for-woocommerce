<?php
namespace InstaView\Admin;

/**
 * Admin settings for the plugin actions and filters.
 *
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Gift Cards Settings.
 *
 * @class    InstaView_Settings
 * @version  1.7.3
 */
class InstaView_Settings extends \WC_Settings_Page {

	/**
	 * @var $print_message
	 */
	protected $print_message;

	/**
	 * Constructor for custom fields
	 */
	public function __construct() {

		$this->id = 'instaview_settings';

		$this->label = __( "InstaView Settings", 'instaview' );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

	}

	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() {

		$sections = array(
			'settings' => __( 'General Settings', 'instaview' ),
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {

		if ( $current_section === '' ) {
			$current_section = 'settings';
		}

	  	if ( 'settings' == $current_section ) {
		 
			$settings = apply_filters( 'section_settings', array(

					array(
						'title' => __( 'General Settings', 'instaview' ),
						'type' => 'title',
						'id' => 'instaview'
					),

					array(
						'desc' => __( 'Select to enable InstaView feature', 'instaview' ),
						'default' => 'yes',
						'show_if_checked' => 'true',
						'type' => 'checkbox',
						'id' => 'instaview_enable',
						'name' => __( 'Enable InstaView', 'instaview' ),
						'class' => 'wc-instaview',
					),

					array(
						'desc' => __( 'Select to enable Mobile view', 'instaview' ),
						'default' => 'yes',
						'show_if_checked' => 'true',
						'type' => 'checkbox',
						'id' => 'instaview_enableformobile',
						'name' => __( 'View In Mobile', 'instaview' ),
						'class' => 'wc-instaview',
					),

					array(
						'default' => 'button',
						'type' => 'radio',
						'id' => 'instaview_buttontype',
						'name' => __( 'Select Style', 'instaview' ),
						'class' => 'wc-instaview',
						'options' => array(
											'button' => __( 'Display InstaView Button', 'instaview' ),
											'link' => __( 'Display InstaView Link', 'instaview' ),
										),
					),

					array(
						'title' => __( 'Label Text', 'instaview' ),
						'id' => 'instaview_buttonlabel',
						'type' => 'text',
 						'placeholder' => __( 'InstaView', 'instaview' ),
					),

					array( 'type' => 'sectionend', 'id' => 'settings_config' ),

				)

			);

		}

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}

	/**
	 * Output the settings
	 *
	 * @since 1.0
	 */
	public function output() {

		global $current_section;

		$settings = $this->get_settings( $current_section );

		foreach ( $settings as $setting ) {

			\WC_Admin_Settings::output_fields( array( $setting ) );
			
		}
	}

	/**
	* Save settings
	*
	* @since 1.0
	*/
	public function save() {
	
		global $current_section,$wp_query;

		$settings = $this->get_settings( $current_section );

		\WC_Admin_Settings::save_fields( $settings );

	}

	/**
	 * Print messages
	 *
	 * @since 1.0
	*/
	public function print_message() {
		?>
			<div class="notice notice-error">
				<p><?php wc_print_notices(); ?></p>
			</div>
		<?php
	}

}
