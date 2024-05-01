<?php
/**
 * Template part for displaying portfolio action icon
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !kapee_get_loop_prop( 'portfolio-button-icon' ) ) return;
?>

<?php if( kapee_get_loop_prop( 'portfolio-link-icon' ) || kapee_get_loop_prop( 'portfolio-zoom-icon' ) ):?>
	<div class="action-icon">
		<?php if( kapee_get_loop_prop( 'portfolio-link-icon' ) ): ?>
			<a href="<?php echo esc_url( get_permalink() );?>" class="project-link"><?php esc_html_e('Project View','kapee');?></a>
		<?php endif;?>
		
		<?php if( kapee_get_loop_prop( 'portfolio-zoom-icon' ) ): ?>
			<a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); ?>" class="project-zoom"><?php esc_html_e('Zoom Image','kapee');?></a>
		<?php endif;?>
	</div>
<?php endif;?>