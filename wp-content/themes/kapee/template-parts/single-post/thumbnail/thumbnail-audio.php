<?php
/**
 * Displays the post entry audio post format.
 *
 * @package Kapee Woocommerce theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !kapee_get_option('single-post-thumbnail', 1) ) return;

// Get post audio
$audio = kapee_get_post_audio();

if(! empty( $audio ) ){?>
	<div class="post-thumbnail">
		<?php echo apply_filters( 'kapee_post_audio', $audio ); // WPCS: XSS OK. ?>
	</div>
<?php }else{
	if( has_post_thumbnail() ){?>
		<div class="post-thumbnail">
		<?php echo kapee_get_post_thumbnail('large'); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php }
}