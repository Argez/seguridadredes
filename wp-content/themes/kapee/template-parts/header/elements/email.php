<?php
/**
 * Template part for displaying email adress on topbar
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

if( kapee_get_option( 'header-email' ) !='' ) { ?>			
	<span class="contact-email"><i class="pls-envelope"></i> <?php echo esc_html( kapee_get_option('header-email','sales@example.com' ) );?></span>
<?php } ?>