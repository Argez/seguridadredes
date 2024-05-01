<?php
/**
 * Displays the post entry footer
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="entry-footer">
	<?php 
	/**
	 * kapee_loop_post_footer hook.
	 *
	 * @hooked kapee_read_more_link - 10
	 */
	do_action( 'kapee_loop_post_footer' );
	?>
</div>