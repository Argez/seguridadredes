<?php
/* 	
 * Functions file for Kapee child
 */

/*
 * Enqueue script and styles
 */
function kapee_child_enqueue_styles() {
	$theme   = wp_get_theme( 'kapee' );
	$version = $theme->get( 'Version' );
	wp_enqueue_style( 'kapee-child-style', get_stylesheet_directory_uri().'/style.css',array( 'kapee-style', 'kapee-basic' ), $version );
}
add_action( 'wp_enqueue_scripts', 'kapee_child_enqueue_styles', 10010 );


/********************************************************************* 
                        Cutom Code
**********************************************************************/
