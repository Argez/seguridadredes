<?php
/**
 * Displays the post entry header title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-post
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! kapee_get_option('single-post-title', 1) ) return;

the_title( '<h1 class="entry-title">', '</h1>' );