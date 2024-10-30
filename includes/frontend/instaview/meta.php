<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper">
			<?php esc_html_e( 'SKU:', 'instaview' ); ?>
			<span class="sku">
				<?php
				$sku = $product->get_sku();
				echo esc_html( $sku ? $sku : esc_html__( 'N/A', 'instaview' ) );
				?>
			</span>
		</span>

	<?php endif; ?>

	<?php
	$category_list = wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . esc_html__( 'Category:', 'instaview' ) . ' ', '</span>' );
	echo wp_kses_post( $category_list );
	?>

	<?php
	$tag_list = wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . esc_html__( 'Tag:', 'instaview' ) . ' ', '</span>' );
	echo wp_kses_post( $tag_list );
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
