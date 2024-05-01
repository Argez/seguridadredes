<?php
/**
 * Template part for displaying social profile icon on topbar
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

$style 	= kapee_get_option( 'social-profile-icons-style', 'icons-default' );
$shape 	= kapee_get_option( 'profile-icons-shape', 'icons-shape-circle' );
$size 	= kapee_get_option( 'profile-icons-size', 'icons-size-small' );
if ( function_exists( 'kapee_social_share' ) ) {		
	kapee_social_share( 
		array(
			'type' => 'profile', 
			'style' => $style, 
			'shape' => $shape,
			'size' => $size
		) 
	);
}