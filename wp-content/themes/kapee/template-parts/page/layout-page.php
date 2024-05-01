<?php
/**
 * Template part for displaying page layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kapee
 * @since 1.0
 */

do_action( 'kapee_before_page_entry' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php	
	/**
	 * kapee_page_content hook.
	 *		 
	 * @hooked kapee_template_page_content - 10
	 */
	do_action( 'kapee_page_content' );
	?>	
</article><!-- #post-## -->

<?php
/**
 * kapee_after_page_entry hook.
 * 
 * @hooked kapee_template_page_comments - 10
 */
do_action( 'kapee_after_page_entry' ); 
