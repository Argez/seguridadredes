<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

$highlights_label 	= kapee_get_option( 'single-product-short-description-label', esc_html__( 'Highlights:', 'kapee' ) );
$highlights 		= apply_filters( 'kapee_single_product_highlights_label', $highlights_label ); ?>

<div class="woocommerce-product-details__short-description">
	<?php if( ! empty( $highlights ) ){ ?>
		<span><?php echo esc_html__( $highlights );?></span>
	<?php } ?>
	<div class="short-description">
		<?php echo $short_description; // WPCS: XSS ok. ?>
	</div>
</div>
