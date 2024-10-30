<?php
use \InstaView\Config\InstaView_Config;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.qewebby.com
 * @since             1.0.0
 * @package           InstaView
 *
 * @wordpress-plugin
 * Plugin Name:       InstaView for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/instaview-for-woocommerce
 * Description:       InstaView for WooCommerce
 * Version:           1.2
 * Author:            Qewebby
 * Author URI:        https://www.qewebby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       instaview
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load plugin if woocommerce installed else show notice to install woocommerce.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

	// Define required constants
	if ( ! defined( 'INSTAVIEW_PLUGIN_URL' ) ) {
		define( 'INSTAVIEW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}
	if ( ! defined( 'INSTAVIEW_ABSPATH' ) ) {
		define( 'INSTAVIEW_ABSPATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}
	if ( ! defined( 'INSTAVIEW_PLUGIN_DIR' ) ) {
		define( 'INSTAVIEW_PLUGIN_DIR', INSTAVIEW_ABSPATH );
	}
	if ( ! defined( 'INSTAVIEW_PLUGIN_BASENAME' ) ) {
		define( 'INSTAVIEW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
	}
	if ( ! defined( 'INSTAVIEW_VERSION' ) ) {
		define( 'INSTAVIEW_VERSION', '1.0.0' );
	}
	if ( ! function_exists( 'instaview_plugin' ) ) {

		function instaview_plugin() {

			// Load the autoloader from it's own file
			require_once INSTAVIEW_ABSPATH . 'autoload.php';

			// The code that runs during plugin deactivation.
			if ( ! function_exists( 'instaview_deactivate' ) ) {

				function instaview_deactivate() {
					\InstaView\Core\InstaView_Deactivator::deactivate();
				}

				register_deactivation_hook( __FILE__, 'instaview_deactivate' );
			}

			if ( ! function_exists( 'instaview_enqueue_custom_style' ) ) {

				function instaview_enqueue_custom_style() {

					if ( is_shop() || is_product_taxonomy() || is_singular( 'product' ) ) {

						wp_register_style( 'instaview-style', INSTAVIEW_PLUGIN_URL . 'css/style.css', null, INSTAVIEW_VERSION );
						wp_enqueue_style( 'instaview-style' );

						wp_register_style( 'instaview-colorbox-popup', INSTAVIEW_PLUGIN_URL . 'css/colorbox.css', null, INSTAVIEW_VERSION );
						wp_enqueue_style( 'instaview-colorbox-popup' );

						wp_register_script( 'instaview-jquery-colorbox-popup', INSTAVIEW_PLUGIN_URL . 'js/jquery.colorbox-min.js', array( 'jquery' ), '1.6.4', true );
						wp_enqueue_script( 'instaview-jquery-colorbox-popup' );

						$instaview_nonce = wp_create_nonce( 'instaview_ajax_nonce' );
						wp_register_script( 'instaview-custom-js', INSTAVIEW_PLUGIN_URL . 'js/custom.js', array( 'jquery' ), INSTAVIEW_VERSION, true );
						wp_enqueue_script( 'instaview-custom-js' );
						wp_localize_script( 'instaview-custom-js', 'instaviewAjax', array(
							'ajaxurl' => admin_url( 'admin-ajax.php' ),
							'nonce' =>  $instaview_nonce,
						) );
					}
				}

				add_action( 'wp_enqueue_scripts', 'instaview_enqueue_custom_style' );
			}

			if( ! function_exists( 'instaview_action_links' ) ) {

				function instaview_action_links( $links ) {

					$url = 'admin.php?page=wc-settings&tab=instaview_settings';

					$settings_link = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'instaview' ) . '</a>';

					array_unshift( $links, $settings_link );

					return $links;
				}

				add_filter( 'plugin_action_links_' . INSTAVIEW_PLUGIN_BASENAME, 'instaview_action_links' );
			}

			// Load session if it is not created
			add_action(
				'woocommerce_init',
				function() {
					if (
						function_exists( 'WC' )
						&& class_exists( 'woocommerce' )
						&& is_plugin_active( 'woocommerce/woocommerce.php' )
						&& isset( WC()->session )
						&& ! WC()->session->has_session()
					) {
						WC()->session->set_customer_session_cookie( true );
					}
				},
				9999
			);			

			// Start the execution of the plugin.
			if( ! function_exists( 'instaview_run_plugin' ) ) {

				function instaview_run_plugin() {
	
					return \InstaView\InstaView_Run::instance();
				}
				instaview_run_plugin();
			}

		}

		add_action( 'plugins_loaded', 'instaview_plugin', 999 );

	}

} else {

	// Deactivate Plugin Conditional if Woocommerce is not installed.
	if ( !function_exists('instaview_deactivate') ) {

		function instaview_deactivate() {

			if ( !( function_exists( 'WC' ) && class_exists( 'woocommerce' ) && is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {

				// Check for nonce
				if ( isset( $_GET['_wpnonce'] ) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'deactivate-plugin_' . plugin_basename(__FILE__) ) ) {

					add_action( 'admin_notices', function () {
						echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'InstaView plugin requires WooCommerce to be installed and active. You can download %s here.', 'instaview' ), '<a href="https://woocommerce.com/" target="_blank">' . esc_html__( 'WooCommerce', 'instaview' ) . '</a>' ) . '</strong></p></div>';
					} );

					// Sanitize $_GET['activate']
					$activate = isset( $_GET['activate'] ) ? sanitize_text_field( $_GET['activate'] ) : '';

					deactivate_plugins( plugin_basename(__FILE__) );
					if ( '' !== $activate ) {
						unset( $_GET['activate'] );
					}

				} else {
					wp_die( 'Security check failed. Please try again.' );
				}
			}
		}

		add_action( 'admin_init', 'instaview_deactivate' );
	}

}