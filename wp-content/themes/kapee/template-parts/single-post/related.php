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

// If post is there
if ( $related_posts->have_posts() ) {?>
	
	<div id="<?php echo esc_attr($unique_id); ?>" class="related posts">
		
		<h3><?php esc_html_e( 'Related Posts', 'kapee' ); ?></h3>

		<?php kapee_post_loop_start(); ?>

			<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

				<?php get_template_part( 'template-parts/post-loop/layout' ); ?>

			<?php endwhile; ?>

		<?php kapee_post_loop_end(); ?>
		
	</div>
<?php
}
wp_reset_postdata();
