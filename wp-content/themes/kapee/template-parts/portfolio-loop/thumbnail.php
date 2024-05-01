<?php
/**
 * Displays the portfolio post entry  thumbnail
 *
 * @author 		PressLayouts
 * @package 	Kapee/template-parts/portfolio
 * @since 	1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !has_post_thumbnail() || ! kapee_get_loop_prop( 'portfolio-post-thumbnail' ) ) {
	return;
}
?>

<div class="post-thumbnail">
	
	<a href="<?php echo esc_url( get_permalink() );?>" ><?php echo kapee_get_post_thumbnail('medium','wp-post-image'); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped?></a>
	
</div>