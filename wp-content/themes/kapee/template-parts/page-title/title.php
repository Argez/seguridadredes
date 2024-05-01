<?php
/**
 * Template part for displaying page title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/page-title
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="entry-header">
	<<?php echo esc_attr($tag);?> class="title">
		<?php echo kapee_get_page_title(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</<?php echo esc_attr($tag);?>>
</div>