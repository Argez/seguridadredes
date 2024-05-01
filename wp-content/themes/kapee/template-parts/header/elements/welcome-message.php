<?php
/**
 * Template part for displaying welcome message of topbar
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

if( kapee_get_option( 'header-welcome-message' ) !='' ) { ?>	
	<span class="welcome-message"><?php echo esc_html( kapee_get_option('header-welcome-message', 'Welcome to Our Store!') );?></span>
<?php } ?>
