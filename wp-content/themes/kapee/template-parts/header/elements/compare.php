<?php
/**
 * Template part for displaying compare in header.php
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

if( ! kapee_get_option( 'header-compare', 1 ) || ! KAPEE_WOOCOMMERCE_ACTIVE || ! defined( 'YITH_WOOCOMPARE' ) ) { return; }

global $yith_woocompare; 
$compare_count = count( $yith_woocompare->obj->products_list );
?>			

<div class="header-compare">
	<a href="#" class="yith-woocompare-open"><span class="header-compare-icon"><span class="header-compare-count"><?php echo esc_html( $compare_count );?></span></span></a>	
</div>
