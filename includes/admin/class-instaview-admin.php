<?php
namespace InstaView\Admin;

use \InstaView\Config\InstaView_Config;
use \InstaView\Helper\InstaView_Loader;
use \InstaView\Admin\InstaView_Settings;

/**
 * The admin-specific code functionality of the plugin.
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

class InstaView_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name = InstaView_Config::PLUGIN_NAME;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version = InstaView_Config::PLUGIN_VERSION;

	/**
	 * Filter and actions of the plugin
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      InstaView_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	public $loader;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Initialize object for actions and filters hooks

		$this->loader = new InstaView_Loader();

		$this->loader->run();

		// Apply New Tab on Woocommerce Settings
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'instaview_settings_tab' ) );

	}

	/**
	 * Add tab to WooCommerce Settings tabs.
	 *
	 * @param  array $settings
	 * @return array $settings
	*/
	public static function instaview_settings_tab( $settings ) {
	
		$settings[] = new InstaView_Settings();
		return $settings;
	}

}
