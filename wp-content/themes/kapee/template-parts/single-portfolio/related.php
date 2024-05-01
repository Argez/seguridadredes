<?php
/**
 * Template part for displaying related portfolios
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-portfolio
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// If post is there
if ( $related_portfolios->have_posts() ) {?>
	
	<div id="<?php echo esc_attr($unique_id); ?>" class="related portfolios">
		
		<h3><?php esc_html_e( 'Related Projects', 'kapee' ); ?></h3>

		<?php kapee_portfolio_loop_start(); ?>

			<?php while ( $related_portfolios->have_posts() ) : $related_portfolios->the_post(); ?>

				<?php get_template_part( 'template-parts/portfolio-loop/layout' ); ?>

			<?php endwhile; ?>

		<?php kapee_portfolio_loop_end(); ?>
		
	</div>
<?php
}
wp_reset_postdata();
