<?php
/**
 * Template part for displaying posts
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$blog_post_style	= kapee_get_loop_prop( 'blog-post-style' );
if( kapee_get_loop_prop( 'name' ) == 'related-posts' ) {
	$classes[] = 'related-post';
}else{
	$classes[]   = 'blog-post-loop';
}
$classes[] = ( ! kapee_get_loop_prop( 'blog-post-thumbnail' ) ) ? 'no-post-thumbnail' : '';
if( kapee_get_loop_prop( 'name' ) == 'posts-loop-shortcode' ){
	if( $blog_post_style == 'blog-grid' ){
		$classes[] = kapee_get_grid_class( kapee_get_loop_prop( 'blog-grid-columns' ) );
	}				
}elseif( $blog_post_style == 'blog-grid' && !is_single() ){
	if( kapee_get_loop_prop( 'name' ) != 'posts-slider-shortcode' ){
		$classes[] = kapee_get_grid_class( kapee_get_loop_prop( 'blog-grid-columns' ) );
	}					
}
$classes[] = ( kapee_get_loop_prop( 'post-meta' ) ) ? kapee_get_loop_prop( 'post-meta-separator' ) : '';
$classes[] = ( kapee_get_loop_prop( 'post-meta' ) && kapee_get_loop_prop( 'post-meta-icon' ) ) ? 'post-meta-icon' : 'post-meta-label';
$classes[] = ( kapee_get_loop_prop( 'post-fancy-date' ) ) ? kapee_get_loop_prop( 'fancy-date-style' ) : '';
?>

<?php do_action( 'kapee_before_loop_post_entry' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php
	/**
	 * kapee_loop_post_entry_top hook.
	 *
	 * @hooked kapee_post_wrapper - 10
	 */
	do_action( 'kapee_loop_post_entry_top' );
	?>
	
	<div class="entry-thumbnail-wrapper">
		<?php 
		/**
		 * kapee_loop_post_thumbnail hook.
		 *
		 * @hooked kapee_template_loop_post_fancy_date - 10
		 * @hooked kapee_template_loop_post_highlight - 20
		 * @hooked kapee_template_loop_post_thumbnail - 30
		 */
		do_action( 'kapee_loop_post_thumbnail' );
		?>
	</div>
	
	<div class="entry-content-wrapper">
		<?php	
		/**
		 * kapee_loop_post_content hook.
		 *
		 * @hooked kapee_loo_post_header 	- 10
		 * @hooked kapee_loop_post_content 	- 20
		 * @hooked kapee_loop_post_footer 	- 30
		 */
		do_action( 'kapee_loop_post_content' );
		?>
	</div>
	
	<?php	
	/**
	 * kapee_loop_post_entry_bottom hook.
	 *
	 * @hooked kapee_post_wrapper_end - 10
	 */
	do_action( 'kapee_loop_post_entry_bottom' );
	?>
		
</article>

<?php
do_action( 'kapee_after_loop_post_entry' ); 