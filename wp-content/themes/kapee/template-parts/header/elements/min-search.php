<?php
/**
 * Template part for displaying mini search in header.php
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

if( ! kapee_get_option( 'header-search', 1 ) ) return;
?>			

<div class="header-mini-search">
	<a class="search-icon-text" href="#"><span class="search-text"><?php esc_html_e('Search','kapee');?></span></a>
</div>