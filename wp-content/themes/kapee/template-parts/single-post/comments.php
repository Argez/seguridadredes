<?php
/**
 * Template part for displaying related posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-post
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// If comments are open or we have at least one comment, load up the comment template.
if ( (comments_open() || get_comments_number()) && kapee_get_option('single-post-comment', 1) )  :
	comments_template();
endif;