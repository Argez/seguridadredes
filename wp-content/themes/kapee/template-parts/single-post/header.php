<?php
/**
 * Displays the post entry header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-post
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
	 * Hook: kapee_single_post_header.
	 *
	 * @hooked kapee_template_single_post_title - 10
	 * @hooked kapee_template_single_post_meta - 20
	 */
	do_action( 'kapee_single_post_header' );
	?>
	
</header><!-- .entry-header -->