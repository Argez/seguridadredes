<?php
/**
 * Template part for displaying currency in header.php
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

if( ! kapee_get_option( 'header-currency-switcher', 1 ) ) { return; }

if( class_exists('woocommerce_wpml') ) {
	echo(do_shortcode('[currency_switcher]'));
}elseif ( class_exists('woocs') ){
	echo( do_shortcode( '[woocs ]' ) );
}?>