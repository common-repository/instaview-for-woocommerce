<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$button_label = esc_html__( 'View More', 'instaview' );

$class = isset( $class ) ? esc_attr( $class ) : 'button';

echo apply_filters(
	'instaview_loop_product_view_more_link',
	sprintf(
		'<div class="view-more-wrapper"><a rel="nofollow" href="%s" data-product_id="%s" class="alt-font %s">%s</a></div>',
		esc_url( get_the_permalink( $product->get_id() ) ),
		esc_attr( $product->get_id() ),
		$class,
		sprintf(
			'<span class="instaview-text button-text">%s</span>',
			$button_label
		)
	),
	$product
);
