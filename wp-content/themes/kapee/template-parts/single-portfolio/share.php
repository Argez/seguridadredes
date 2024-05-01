<?php
/**
 * Template part for displaying share of project
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'kapee_social_share' ) ) { ?>
	<div class="project-info-item">
		<h5><?php esc_html_e( 'Share', 'kapee' );?><span>:</span></h5>
		<?php kapee_social_share( 
			array('type' => 'share', 'style' => $social_icons_style, 'shape' => $social_icons_shape, 'size' => $social_icons_size ) ); ?>
	</div>
<?php } ?>