<?php
/**
 * Template part for displaying location of topbar
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

if( kapee_get_option( 'header-location' ) !='' ) { ?>
	<span class="contact-location"><i class="pls-location-pin"></i> <?php echo esc_html( kapee_get_option('header-location','123 Shop Street, New York, US') );?></span>
<?php } ?>
