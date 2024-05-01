<?php
/**
 * Template part for displaying cart
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/header
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_option( 'header-cart', 1 ) || ! KAPEE_WOOCOMMERCE_ACTIVE || kapee_get_option( 'catalog-mode', 0 ) || ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price',0 ) ) ) return;

global $woocommerce;
$count 				= is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
$cart_url			= wc_get_cart_url();
$cart_style			= kapee_get_option( 'header-cart-style', 1 );
?>			

<div class="header-cart cart-style-<?php echo esc_attr($cart_style); ?>">
	<a href="<?php echo esc_url($cart_url);?>">		
		<?php 
		switch ($cart_style) {
			case 1:?>				
				<div class="header-cart-icon <?php echo esc_attr( kapee_get_option( 'header-cart-icon','cart-icon') );?>">
					<span class="header-cart-count"><?php echo wp_kses_post( $count ); ?></span>
				</div>
				<div class="cart-wrap">
					<small><?php esc_html_e('Cart','kapee');?></small>
					<span class="header-cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
				</div>
				<?php 
				break;
			case 2:?>				
				<div class="header-cart-icon <?php echo esc_attr( kapee_get_option( 'header-cart-icon','cart-icon') );?>">
					<span class="header-cart-count"><?php echo wp_kses_post( $count ); ?></span>
				</div>
				<div class="cart-wrap">
					<span class="header-cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
				</div>
				<?php  
				break;		
			case 3:?>
				<div class="header-cart-icon <?php echo esc_attr( kapee_get_option( 'header-cart-icon','cart-icon') );?>">
					<span class="header-cart-count"><?php echo wp_kses_post( $count ); ?></span>
				</div>
				<?php 
				break;
			default:
		}?>		
	</a>
</div>