<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

	do_action( 'kapee_before_loop_post' );
	
	kapee_post_loop_start();
	
	while ( have_posts() ) :
		the_post();	
		
		// Include the loop post content template.
		get_template_part( 'template-parts/post-loop/layout', get_post_format() );

	endwhile;
	
	kapee_post_loop_end();
	
	/**
	 * Hook: kapee_after_loop_post.
	 *
	 * @hooked kapee_pagination - 10
	 */
	do_action( 'kapee_after_loop_post' );

else :

	get_template_part( 'template-parts/post-loop/content', 'none' );

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
