<?php
/**
 * Template part for displaying page breadcrumbs
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/page-title
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="entry-breadcrumbs">
	<?php  
	if ( ! empty( $breadcrumb ) ) {
		
		echo wp_kses_post($wrap_before);
		foreach ( $breadcrumb as $key => $crumb ) {
			echo wp_kses_post($before);
			if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
				echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
			} else {
				echo '<span class="last">'. esc_html( $crumb[0] ) .'</span>';
			}
			echo wp_kses_post($after);

			if ( sizeof( $breadcrumb ) !== $key + 1 ) {
				echo wp_kses_post($delimiter_before . $delimiter .$delimiter_after);
			}
		}
		echo wp_kses_post($wrap_after);
	}?>
</div>