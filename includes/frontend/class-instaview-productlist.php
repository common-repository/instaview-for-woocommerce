<?php
namespace InstaView\Frontend;

use \InstaView\Helper\InstaView_Loader;

/**
 * Ajax functions
 *
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Frontend
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InstaView_ProductList {

	/**
	 * Filter and actions of the plugin
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      InstaView    $loader    Maintains and registers all hooks for the plugin.
	 */
	public $loader;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'instaview_after_add_to_cart_btn' ), 20 );
		add_action( 'wp_ajax_instaview_product_popup', array( $this , 'instaview_product_popup' ) );
		add_action( 'wp_ajax_nopriv_instaview_product_popup', array( $this , 'instaview_product_popup' ) );
		add_action( 'instaview_product_details', array( $this, 'instaview_product_details' ) );
		add_action( 'wp_footer', array( $this, 'instaview_footer_popups' ) );

		$this->instaview_popup_action();

	}

	/**
	 * Adding the popup settings to frontend
	 */
	public function instaview_popup_action() {
		add_action( 'instaview_before_product_summary', array( $this, 'instaview_product_sale_flash' ), 10 );
		add_action( 'instaview_before_product_summary', array( $this, 'instaview_show_product_images' ), 20 );

		add_action( 'instaview_product_summary', array( $this, 'instaview_product_title' ), 5 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_product_rating' ), 10 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_product_price' ), 10 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_product_excerpt' ), 20 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_product_ajax_add_to_cart' ), 30 );
		add_action( 'instaview_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_view_more_btn' ), 30 );
		add_action( 'instaview_product_summary', array( $this, 'instaview_product_meta' ), 40 );

	}

	/**
	 * Product Sale Image to be displayed in popup
	 */
	public function instaview_product_sale_flash() {

		wc_get_template( 'sale-flash.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
 	 * Product Image to be displayed in popup
	 */
	public function instaview_show_product_images() {

		wc_get_template( 'product-image.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	* Product Title to be displayed in popup
	*/
	public function instaview_product_title() {

		wc_get_template( 'title.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	* Product Ratings to be displayed in popup
	*/
	public function instaview_product_rating() {

		wc_get_template( 'rating.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	* Product Price to be displayed in popup
	*/
	public function instaview_product_price() {

		wc_get_template( 'price.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	* Product Content to be displayed in popup
	*/
	public function instaview_product_excerpt() {

		wc_get_template( 'short-description.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	* Product Add to cart button to be displayed in popup
	*/
	public function instaview_product_ajax_add_to_cart() {

		global $product;

		echo '<input type="hidden" name="add-to-cart" value="' . esc_attr( $product->get_id() ) . '" />';

	}

	/**
	 * Product View More button to be displayed in popup
	 */
	public function instaview_view_more_btn( $args = array() ) {
		global $product;
		if ( $product ) {
			$defaults = array(
				'class'        => implode( ' ', array_filter( array(
					'button',
					wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '',
				) ) ),
			);
	
			$args = apply_filters( 'instaview_viewmore_args', wp_parse_args( $args, $defaults ), $product );
		}
		wc_get_template( 'view-more.php', $args, '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );
	}

	/**
	* Product Meta to be displayed in popup
	*/
	public function instaview_product_meta() {

		wc_get_template( 'meta.php', '', '', INSTAVIEW_PLUGIN_DIR . 'includes/frontend/instaview/' );

	}

	/**
	 * Footer InstaView
	 */
	public function instaview_footer_popups() {

		$instaview_enable = get_option( 'instaview_enable' );

		if ( !empty( $instaview_enable ) && isset( $instaview_enable ) && ( $instaview_enable == 'yes') ) {

			echo '<div id="instaview_popup" class="woocommerce instaviewpopup-content"></div>';

			// Load for instaview single product
			wp_enqueue_script( 'wc-single-product' );

			// Load for instaview single product variation
			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// Load for flex slider
			wp_enqueue_script( 'flexslider' );

			//load the zoom js
			wp_enqueue_script( 'zoom' );

		}
	}

	/**
	 * InstaView after add to cart Button in Popup
	 */
	public function instaview_after_add_to_cart_btn( $args = array() ) {

		global $product;

		$instaview_enable = get_option( 'instaview_enable' );

		if ( !empty( $instaview_enable ) && isset( $instaview_enable )  && ( $instaview_enable == 'yes') ) {

			$button_style = ! empty( get_option( 'instaview_buttontype' ) ) ? get_option( 'instaview_buttontype' ) : 'button';
    		$instaview_enableformobile =  ( ! empty( get_option( 'instaview_enableformobile' ) ) && get_option( 'instaview_enableformobile' ) == 'no' ) ? esc_attr( 'disable-mobile-instaview' ) : '';
			$class = ( $button_style == 'button' ) ? ( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : 'button' ) : '' ;

			if ( $product ) {
				$defaults = array(
                    'quantity' => 1,
                    'class' => implode( ' ', array_filter( array (
                			$class .' instaview-popup',
							'instaview-'.$button_style,
							$instaview_enableformobile,
                    ) ) ),
                );

				$args = apply_filters( 'instaview_args', wp_parse_args( $args, $defaults ), $product );

				wc_get_template( 'instaview-button.php', $args, '', INSTAVIEW_PLUGIN_DIR . 'templates/' );

			}
		} else {
			return false;
		}
	}

	/**
	 * Product Popup
	 */
	public function instaview_product_popup( $args = array() ) {

		check_ajax_referer('instaview_ajax_nonce', 'nonce');

		$productid = ! empty( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : '';

		if ( ! empty( $productid ) ) {

			ob_start();

			// Display instaview product details
			do_action( 'instaview_product_details', $productid );

            $output = ob_get_contents();

			ob_end_clean();

            echo sprintf( '%s', $output );

            die();
        }

	}

	public function instaview_product_details( $productid ) {

		if ( empty( $productid ) ) {
			return '';
		}

		$product_data = wc_get_product( $productid );

		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'product',
			'post_status' => 'publish',
			'no_found_rows' => 1,
		);

		if ( ! empty( $product_data->get_id() ) ) {
			$args['p'] = absint( $product_data->get_id() );
		}

		$single_product = new \WP_Query( $args );

		ob_start();

		// Backup query object so following loops think this is a product page.
		$previous_wp_query = $GLOBALS['wp_query'];
		$GLOBALS['wp_query'] = $single_product;

		while ( $single_product->have_posts() ) {

			$single_product->the_post();

			wc_get_template( 'instaview-singleproduct.php', '', '', INSTAVIEW_PLUGIN_DIR . 'templates/' );

		}

		$GLOBALS['wp_query'] = $previous_wp_query;
		wp_reset_postdata();

		$output = ob_get_clean();

		echo '<div class="woocommerce">';
			echo sprintf( '%s', $output );
		echo '</div>';

	}

}
