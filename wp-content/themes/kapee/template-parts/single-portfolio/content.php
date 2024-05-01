<?php
/**
 * Template part for displaying title of portfolio description
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! kapee_get_option('single-portfolio-description', 1) ) return;
?>

<div class="project-description"><?php the_content();?></div>