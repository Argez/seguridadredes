<?php
/**
 * Template part for displaying topbar navigation menu
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

if(!kapee_get_option('show-topbar-navigation', 1)) return;
			
if ( has_nav_menu( 'topbar-menu' ) ) { 	
	wp_nav_menu( 
			array( 	'theme_location' 	=> 'topbar-menu',
					'container_class'   => 'topbar-navigation kapee-navigation',
					'walker' 			=> new Kapee_Menu_Walker()
			)
	); 
}	