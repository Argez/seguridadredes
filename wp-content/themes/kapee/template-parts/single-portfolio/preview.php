<?php
/**
 * Template part for displaying preview of project
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! kapee_get_option( 'single-portfolio-preview-button', 1 ) || empty($website_url)) return;
?>

<div class="project-preview">
	<a class="btn preview-link" href="<?php echo esc_url($website_url);?>" target="_blank"><?php esc_html_e('Live Preview', 'kapee');?></a>
</div>