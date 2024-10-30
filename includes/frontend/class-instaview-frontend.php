<?php
namespace InstaView\Frontend;

use \InstaView\Config\InstaView_Config;
use \InstaView\Helper\InstaView_Loader;
use \InstaView\Frontend\InstaView_ProductList;

/**
 * Fornted all actions and filters
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Frontend
 */

class InstaView_Frontend {

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

		$product_list = new InstaView_ProductList();

		$this->loader->add_filter( 'woocommerce_locate_template', $this, 'instaview_plugin_template', 1, 3 );

		$this->loader->run();

	}

	/**
	 * Plugin template changes for locate_template
	 *
	 * @since  1.0.0
	 */
	public function instaview_plugin_template( $template, $template_name, $template_path ) {

		global $woocommerce;
		$_template = $template;
		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path  = INSTAVIEW_PLUGIN_DIR . '/templates/woocommerce/';
	
		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name
			)
		);

		if( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		if ( ! $template ) {
			$template = $_template;
		}

		return $template;

	}

}
