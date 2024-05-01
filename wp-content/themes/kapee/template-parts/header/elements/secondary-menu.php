<?php
/**
 * Template part for displaying secondary menu
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

if ( has_nav_menu( 'secondary' ) ) { 	
	wp_nav_menu( 
		array( 
			'theme_location' 	=> 'secondary',
			'container_class'   => 'main-navigation kapee-navigation',
			'walker' 			=> new Kapee_Mega_Menu_Walker()
		)
	); 
}		