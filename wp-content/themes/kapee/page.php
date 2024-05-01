<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

	do_action( 'kapee_before_page_loop' );
	
	while ( have_posts() ) : the_post();			
			
		get_template_part( 'template-parts/page/layout', 'page' );

	endwhile; // End of the loop. 
	
	/**
	 * Hook: kapee_after_loop_page.
	 *
	 */
	do_action( 'kapee_after_page_loop' );
	
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
