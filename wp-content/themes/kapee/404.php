<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */

get_header(); 

/**
 * Hook: kapee_before_main_content.
 *
 * @hooked kapee_output_content_wrapper - 10 (outputs opening divs for the content area)
 */
do_action( 'kapee_before_main_content' );?>

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="title"><?php esc_html_e('404', 'kapee');?></h1>
			<h2 class="sub-title"><?php echo esc_attr( kapee_get_option('kapee-404_heading', 'PAGE NOT FOUND') ); ?></h2>
		</header><!-- .page-header -->
		<div class="page-content">
			<?php  
			$content = kapee_get_option('kapee-404_content', 'Sorry, the page you are looking for is not available. Maybe you want to perform a search?');
			echo do_shortcode($content);
			 get_search_form(); ?>
		
			<div class="back-button">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php echo esc_html( kapee_get_option('kapee-404_btn_txt', 'Back To Home?') );?></a>
			</div>
		</div>
		
		<!-- .page-content -->
	</section><!-- .error-404 -->

<?php 
/**
 * Hook: kapee_after_main_content.
 *
 * @hooked kapee_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'kapee_after_main_content' );

get_footer();
