<?php
/**
 * Template part for displaying posts
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

$classes[] = 'single-post-page';
$classes[] = ( kapee_get_loop_prop( 'post-meta' ) ) ? kapee_get_loop_prop( 'post-meta-separator' ) : '';
$classes[] = ( kapee_get_loop_prop( 'post-meta' ) && kapee_get_loop_prop( 'post-meta-icon' ) ) ? 'post-meta-icon' : 'post-meta-label';
$classes[] = ( kapee_get_loop_prop( 'post-fancy-date' ) ) ? kapee_get_option('fancy-date-style', 'fancy-square-date') : '';
$classes[] = ( kapee_get_option( 'single-post-thumbnail', 1 ) && kapee_has_post_thumbnail() ) ? 'has-post-thumbnail' : 'no-post-thumbnail';
$classes[] = ( is_sticky() ) ? 'sticky' : '';
?>

<?php do_action( 'kapee_before_single_post_entry' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php
	/**
	 * kapee_single_post_entry_top hook.
	 *
	 * @hooked kapee_post_wrapper - 10
	 * @hooked kapee_single_post_header 	- 15
	 */
	do_action( 'kapee_single_post_entry_top' );
	?>
	
	<div class="entry-thumbnail-wrapper">
		<?php 
		/**
		 * kapee_single_post_thumbnail hook.
		 *
		 * @hooked kapee_template_single_post_fancy_date - 10
		 * @hooked kapee_template_single_post_highlight - 20
		 * @hooked kapee_template_single_post_thumbnail - 30
		 */
		do_action( 'kapee_single_post_thumbnail' );
		?>
	</div>
	
	<div class="entry-content-wrapper">
		<?php	
		/**
		 * kapee_single_post_content hook.
		 *		 
		 * @hooked kapee_single_post_content - 20
		 */
		do_action( 'kapee_single_post_content' );
		?>
	</div>
	
	<?php	
	/**
	 * kapee_single_post_entry_bottom hook.
	 *
	 * @hooked kapee_post_wrapper_end - 10
	 */
	do_action( 'kapee_single_post_entry_bottom' );
	?>
		
</article>

<?php
/**
 * kapee_after_single_post_entry hook.
 * 
 * @hooked kapee_template_single_post_author_bios - 10
 * @hooked kapee_template_single_social_share - 20
 * @hooked kapee_template_single_post_navigation - 30
 * @hooked kapee_template_single_related - 40
 * @hooked kapee_template_single_post_comments - 50
 */
do_action( 'kapee_after_single_post_entry' ); 