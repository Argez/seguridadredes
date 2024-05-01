<?php
/**
 * Displays the post entry header
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

<header class="entry-header">

	<?php
	/**
	 * Hook: kapee_loop_post_header.
	 *
	 * @hooked kapee_template_loop_post_title - 10
	 * @hooked kapee_template_loop_post_meta - 20
	 */
	do_action( 'kapee_loop_post_header' );
	?>
	
</header><!-- .entry-header -->