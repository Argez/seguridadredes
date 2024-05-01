<?php
/**
 * Template part for displaying main menu
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

wp_nav_menu( 
	array( 
		'theme_location' 	=> 'primary',
		'container_class'   => 'main-navigation kapee-navigation',
		'fallback_cb' 		=> 'kapee_fallback_menu',
		'walker' 			=> new Kapee_Mega_Menu_Walker()
	)
); 