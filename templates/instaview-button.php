<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$button_label = ! empty( get_option( 'instaview_buttonlabel' ) ) ? get_option( 'instaview_buttonlabel' ) : esc_html__( 'InstaView', 'instaview' );

$class = isset( $class ) ? esc_attr( $class ) : 'button';

echo '<div class="instaview-after-cart-btn">';
	echo apply_filters(
		'woocommerce_loop_product_insta_view_link',
		sprintf(
			'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
			esc_attr( $product->get_id() ),
			$class,
			sprintf(
				'<span class="instaview-text button-text">%s</span>',
				$button_label
			)
		),
		$product
	);
echo '</div>';
