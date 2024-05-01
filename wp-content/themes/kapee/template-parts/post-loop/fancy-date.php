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

if( ! kapee_get_loop_prop( 'post-fancy-date' ) ) return;
?>

<div class="entry-date">	
	
	<?php echo sprintf('<span class="date-day">%1$s</span>
			<span class="date-month">%2$s</span><span class="date-year">%3$s</span>',	
			get_the_time('d'),
			get_the_time('M'),
			get_the_time('Y')
		);?>
		
</div>