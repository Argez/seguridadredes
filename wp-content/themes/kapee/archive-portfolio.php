<?php
/**
 * Template part for displaying archive portfolio
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */

get_header(); ?>

<?php
/**
 * Hook: kapee_before_main_content.
 *
 * @hooked kapee_output_content_wrapper - 10 (outputs opening divs for the content area)
 */
do_action( 'kapee_before_main_content' );

if ( have_posts() ) :

	/**
	 * Hook: kapee_before_portfolio_loop.
	 *
	 * @hooked kapee_portfolio_filter - 10
	 */
	do_action( 'kapee_before_portfolio_loop' );
	
	kapee_portfolio_loop_start();
	
	while ( have_posts() ) :
		the_post();	
		
		// Include the portfolio loop content template.
		get_template_part( 'template-parts/portfolio-loop/layout', get_post_format() );

	endwhile;
	
	kapee_portfolio_loop_end();
	
	/**
	 * Hook: kapee_after_portfolio_loop.
	 *
	 * @hooked kapee_portfolio_pagination - 10
	 */
	do_action( 'kapee_after_portfolio_loop' );

else :

	get_template_part( 'template-parts/content', 'none' );

endif;

/**
 * Hook: kapee_after_main_content.
 *
 * @hooked kapee_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'kapee_after_main_content' );

/**
 * Hook: kapee_sidebar.
 *
 * @hooked kapee_get_sidebar - 10
 */
do_action( 'kapee_sidebar' );?>

<?php get_footer();
