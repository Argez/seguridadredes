<?php
/**
 * The template for displaying all single portfolios
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-portfolios
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


do_action( 'kapee_before_single_post_loop' ); 
		
/* Start the Loop */
while ( have_posts() ) : the_post();	
	
	// Include the post content template.
	get_template_part( 'template-parts/single-portfolio/layout', get_post_format() );	

endwhile; // End of the loop.		
		
do_action( 'kapee_after_single_post_loop' ); 

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
