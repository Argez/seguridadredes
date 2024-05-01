<?php
/**
 * Template part for displaying header logo
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

if( !kapee_get_option( 'show-header-logo', 1 ) ) return;
		
$logo_url 			= kapee_get_option( 'header-logo', array( 'url' => KAPEE_IMAGES.'logo.png' ) );
$logo_light_url 	= kapee_get_option( 'header-logo-light', array( 'url' => KAPEE_IMAGES.'logo-light.png' ) );
$sticky_logo_url	= kapee_get_option( 'sticky-header-logo', array( 'url' => KAPEE_IMAGES.'logo.png' ) );
$mobile_logo_url	= kapee_get_option( 'mobile-header-logo', array( 'url' => KAPEE_IMAGES.'logo-light.png' ) );
$site_title 		= get_bloginfo( 'name', 'display' );

if( is_ssl() ) {
	$logo 					= str_replace('http://', 'https://', $logo_url['url']);
	$logo_light				= str_replace('http://', 'https://', $logo_light_url['url']);
	$sticky_logo 			= str_replace('http://', 'https://', $sticky_logo_url['url']);
	$mobile_logo 			= str_replace('http://', 'https://', $mobile_logo_url['url']);
}else{
	$logo					= $logo_url['url'];
	$logo_light				= $logo_light_url['url'];
	$sticky_logo			= $sticky_logo_url['url'];
	$mobile_logo			= $mobile_logo_url['url'];
}
?>	

<div class="header-logo">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="<?php echo esc_attr('home');?>">
		<?php if( 'header' == $header_logo ) :?>
			<img class="logo" src="<?php echo esc_url($logo);?>" alt="<?php echo esc_attr($site_title);?>" />
		<?php endif;?>
		<?php if( 'header' == $header_logo || 'mobile' == $header_logo ) :?>
			<img class="logo-light" src="<?php echo esc_url($logo_light);?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) );?>" />
		<?php endif;?>
		<?php if( 'sticky' == $header_logo ) :?>
			<img class="sticky-logo" src="<?php echo esc_url($sticky_logo);?>" alt="<?php echo esc_attr($site_title);?>" />
		<?php endif;?>
		<?php if( 'mobile' == $header_logo || 'sticky' == $header_logo ) :?>
			<img class="mobile-logo" src="<?php echo esc_url($mobile_logo);?>" alt="<?php echo esc_attr($site_title);?>" />
		<?php endif;?>
	</a>
</div>
