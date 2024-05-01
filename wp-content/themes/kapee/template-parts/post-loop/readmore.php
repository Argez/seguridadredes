<?php
/**
 * Displays the post entry readmore link
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_loop_prop( 'read-more-button' ) || ( kapee_get_loop_prop( 'blog-post-content' ) == 'full-content' && kapee_get_loop_prop( 'name' ) != 'related-posts' ) ) return;
?>

<p class="read-more-btn">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>" class="more-link"><?php echo esc_html( kapee_get_option('read-more-text','Continue Reading') );?> </a>
</p>