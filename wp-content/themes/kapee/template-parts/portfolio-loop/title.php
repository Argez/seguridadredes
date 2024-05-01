<?php
/**
 * Displays the post entry header title
 *
 * @author 		PressLayouts
 * @package 	Kapee/template-parts/portfolio
 * @since 	1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! kapee_get_loop_prop( 'portfolio-title' ) ) return;

the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );