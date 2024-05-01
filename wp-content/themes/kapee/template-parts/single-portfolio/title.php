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

if ( ! kapee_get_option('single-portfolio-information-title', 1) ) return;
?>

<h3 class="project-information-title"><?php esc_html_e( 'Project Information', 'kapee' );?></h3>