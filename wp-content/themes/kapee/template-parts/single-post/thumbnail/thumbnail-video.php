<?php
/**
 * Displays the post entry image / gallery / audio / video etc. As per the post format.
 *
 * @package Kapee Woocommerce theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !kapee_get_option('single-post-thumbnail', 1) ) return;

// Get post video
$video = kapee_get_post_video();

if(! empty( $video ) ){?>
	<div class="entry-video">
		<?php echo apply_filters( 'kapee_post_video', $video ); // WPCS: XSS OK. ?>
	</div>
<?php }else{
	if( has_post_thumbnail() ){?>
		<div class="post-thumbnail">
		<?php the_post_thumbnail('large');?>
		</div>
	<?php }
}