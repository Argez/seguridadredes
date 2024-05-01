<?php
/**
 * Displays the post entry highlight
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ( kapee_get_loop_prop('sticky-post-icon') || kapee_get_loop_prop('post-format-icon') ) && (is_sticky() || !empty( get_post_format() ) ) ){ ?>
	<div class="post-highlight">		
	
		<?php do_action( 'kapee_loop_post_highlight_top' ); ?>
		
		<?php if( kapee_get_loop_prop( 'sticky-post-icon' ) && is_sticky() ): ?>
		
			<span class="post-sticky-icon"></span>
			
		<?php endif;?>
		
		<?php if( kapee_get_loop_prop( 'post-format-icon' ) ) : ?>
			
			<span class="post-format"></span>
			
		<?php endif;?>
		
		<?php do_action( 'kapee_loop_post_highlight_bottom' ); ?>
	</div>
<?php }