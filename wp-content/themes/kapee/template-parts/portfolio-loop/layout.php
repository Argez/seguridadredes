<?php
/**
 * Template part for displaying portfolio layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/portfolio
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( kapee_get_loop_prop('name') == 'related-portfolios') {
	$classes[] = 'portfolio-post-loop';
	$classes[] = 'related-portfolio';
}elseif( kapee_get_loop_prop('name') == 'portfolios-slider-shortcode') {
	$classes[] = 'portfolio-post-loop';
	$classes[] = 'portfolios-slider-shortcode';
}else{
	$classes[] = 'portfolio-post-loop';
	$classes[] = 'col-12 col-sm-6 col-md-6 col-lg-'. 12 / kapee_get_loop_prop( 'portfolio-grid-columns' ) ;
}
?>
<?php do_action( 'kapee_before_portfolio_loop_entry' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ) ?> > 
	
	<?php
	/**
	 * kapee_portfolio_loop_entry_top hook.
	 *
	 * @hooked kapee_post_wrapper - 10
	 */
	do_action( 'kapee_portfolio_loop_entry_top' );
	?>
	
	<div class="entry-thumbnail-wrapper">
		<?php 
		/**
		 * kapee_portfolio_loop_thumbnail hook.
		 *
		 * @hooked kapee_template_portfolio_loop_thumbnail - 10
		 * @hooked kapee_template_portfolio_loop_action_icon - 20
		 */
		do_action( 'kapee_portfolio_loop_thumbnail' );
		?>
	</div>
	
	<div class="entry-content-wrapper">
		<?php	
		/**
		 * kapee_portfolio_loop_content hook.
		 *
		 * @hooked kapee_portfolio_loop_header 	- 10
		 * @hooked kapee_portfolio_loop_content 	- 20
		 * @hooked kapee_portfolio_loop_footer 	- 30
		 */
		do_action( 'kapee_portfolio_loop_content' );
		?>
	</div>
	
	<?php	
	/**
	 * kapee_portfolio_loop_entry_bottom hook.
	 *
	 * @hooked kapee_post_wrapper_end - 10
	 */
	do_action( 'kapee_portfolio_loop_entry_bottom' );
	?>
		
</article>

<?php
do_action( 'kapee_after_portfolio_loop_entry' ); 
