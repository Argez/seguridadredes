<?php
/**
 * Displays the post entry fancy date
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !has_post_thumbnail() || ! kapee_get_loop_prop( 'blog-post-thumbnail' ) ) {
	return;
}

// Thumbnail size full, large, medium or thumbnail
$size =  kapee_get_post_thumbnail_size();

?>

<div class="post-thumbnail">
	<a href="<?php echo esc_url( get_permalink() );?>" > <?php echo kapee_get_post_thumbnail( $size, 'wp-post-image' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped?></a>
</div>