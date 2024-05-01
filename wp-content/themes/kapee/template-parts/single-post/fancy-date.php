<?php
/**
 * Displays the post entry fancy date
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

if( ! kapee_get_loop_prop( 'post-fancy-date' ) ) return;
?>

<div class="entry-date">	
	
	<?php echo sprintf('<span class="date-day">%1$s</span>
			<span class="date-month">%2$s</span><span class="date-year">%3$s</span>',	
			esc_html( get_the_time('d') ),
			esc_html( get_the_time('M') ),
			esc_html( get_the_time('Y') )
		);?>
		
</div>