<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="product-instaview-<?php the_ID(); ?>" <?php post_class( 'instaview-product' ); ?>>

	<?php
		/**
		 * instaview_before_product_summary hook.
		 *
		 * @hooked instaview_product_sale_flash - 10
		 * @hooked instaview_show_product_images - 20
		 */
		do_action( 'instaview_before_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * instaview_product_summary hook.
			 *
			 * @hooked instaview_product_title - 5
			 * @hooked instaview_product_rating - 10
			 * @hooked instaview_product_price - 10
	 		 * @hooked instaview_product_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked instaview_view_more_btn - 30
			 * @hooked instaview_product_meta - 40
			 */
			do_action( 'instaview_product_summary' );
		?>

	</div><!-- .summary -->

	<?php
		/**
		 * instaview_after_product_summary hook.
		 *
		 */
		do_action( 'instaview_after_product_summary' );
	?>

</div>
