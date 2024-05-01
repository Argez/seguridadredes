<?php
/**
 * Template part for displaying single portfolio layout
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-portfolio
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$portfolio_style 	= kapee_get_post_meta('portfolio_style');
if(!$portfolio_style || $portfolio_style == 'default'){
	$portfolio_style = kapee_get_option('single-portfolio-layout', '8' );		
}
$column_class	= $portfolio_style;
$gallery_claases	= ( $column_class == 12 ) ? 'col-12' : 'col-12 col-md-6 col-lg-'. $column_class;
$summary_claases	= ( $column_class == 12 ) ? 'col-12' : 'col-12 col-md-6 col-lg-'. ( 12 - absint( $column_class ) );

do_action( 'kapee_before_single_portfolio_entry' ); 

$classes[] = 'single-portfolio-page';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php
	/**
	 * kapee_single_portfolio_entry_top hook.
	 *
	 * @hooked kapee_post_wrapper - 10
	 */
	do_action( 'kapee_single_portfolio_entry_top' );
	?>
	<div class="row">
		<div class="portfolio-entry-gallery <?php echo esc_attr($gallery_claases);?>">
			<?php 
			/**
			 * kapee_single_portfolio_image hook.
			 *
			 * @hooked kapee_template_single_portfolio_image - 10
			 */
			do_action( 'kapee_single_portfolio_image' );
			?>
		</div>
		
		<div class="portfolio-entry-summary <?php echo esc_attr($summary_claases);?>">
			<?php	
			/**
			 * kapee_single_portfolio_summary hook.
			 *		 
			 * @hooked kapee_template_single_portfolio_title - 5
			 * @hooked kapee_template_single_portfolio_content - 10
			 * @hooked kapee_template_single_portfolio_preview - 15
			 * @hooked kapee_template_single_portfolio_client - 20
			 * @hooked kapee_template_single_portfolio_date - 25
			 * @hooked kapee_template_single_portfolio_category - 30
			 * @hooked kapee_template_single_portfolio_skill - 35
			 * @hooked kapee_template_single_portfolio_share - 40
			 */
			do_action( 'kapee_single_portfolio_summary' );
			?>
		</div>
	</div>
	<?php	
	/**
	 * kapee_single_portfolio_entry_bottom hook.
	 *
	 * @hooked kapee_post_wrapper_end - 10
	 */
	do_action( 'kapee_single_portfolio_entry_bottom' );
	?>
		
</article>

<?php
/**
 * kapee_after_single_portfolio_entry hook.
 * 
 * @hooked kapee_template_single_portfolio_navigation - 10
 * @hooked kapee_template_single_related_portfolio - 20
 * @hooked kapee_template_single_portfolio_comments - 30
 */
do_action( 'kapee_after_single_portfolio_entry' ); 