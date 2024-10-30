<?php
namespace InstaView;

use \InstaView\Helper\InstaView_Loader;
use \InstaView\Config\InstaView_Config;
use \InstaView\Core\InstaView_i18n;
use \InstaView\Admin\InstaView_Admin;
use \InstaView\Frontend\InstaView_Frontend;

/**
 * Core class file to import all other classes
 *
 * @package  InstaView
 * @version  1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InstaView_Run {

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
	 * Fired during plugin activation.
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      InstaView_Activator    $activator    Defines all code necessary to run during the plugin's activation.
	 */
	public $activator;

	/**
	 * Fired during plugin deactivation.
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      InstaView_Deactivator    $deactivator    Defines all code necessary to run during the plugin's deactivation.
	 */
	public $deactivator;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	public $plugin_name = InstaView_Config::PLUGIN_NAME;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version = InstaView_Config::PLUGIN_VERSION;

	/**
	 * Min required WC version.
	 *
	 * @var string
	 */
	private $wc_min_version = InstaView_Config::WC_MIN_PLUGIN_VERSION;

	/**
	 * The single instance of the class.
	 *
	 * @var WC_InstaView
	 */
	protected static $_instance = null;

	/**
	 * Tab name for settings.
	 *
	 * @var WC_InstaView
	 */
	protected $tab_name = InstaView_Config::WC_TAB_NAME;

	/**
	 * @var $request
	 */
	protected $request;

	/**
	 * Main WC_InstaView instance. Ensures only one instance is loaded or can be loaded - @see 'WC_InstaView()'.
	 *
	 * @static
	 * @return  WC_InstaView
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		//By default options
		add_option( 'instaview_enable', 'yes' );
		add_option( 'instaview_enableformobile', 'yes' );

		// Initialize object for actions and filters hooks
		$this->loader = new InstaView_Loader();

		// Initialize languages translations
		$this->set_locale_lang();

		// Load Admin Settings
		$admin_settings = new InstaView_Admin();

		// Load Fronted Settings
		$frontend_settings = new InstaView_Frontend();

	}

	/**
	 * InstaView_i18n class in order to set the domain
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale_lang() {

		$plugin_i18n = new InstaView_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'instaview_load_plugin_textdomain' );

		$this->run();
	}

	/**
	 * Execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}
}
