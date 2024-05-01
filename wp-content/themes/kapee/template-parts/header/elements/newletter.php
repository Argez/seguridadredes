<?php
/**
 * Template part for displaying newsletter
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

if( kapee_get_option( 'header-newsletter' ) !='' ) { ?>
	<span class="header-newsletter"><i class="pls-envelope"></i> <?php echo esc_html( kapee_get_option('header-newsletter','Newsletter') );?></span>
<?php } ?>