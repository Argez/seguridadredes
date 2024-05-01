<?php
/**
 * Template part for displaying phone number on topbar
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

if( kapee_get_option( 'header-phone-number' ) !='' ) { ?>
	<span class="contact-phone"><i class="pls-phone"></i> <?php echo esc_html( kapee_get_option('header-phone-number', '+123 4567 890') );?></span>
<?php } ?>
