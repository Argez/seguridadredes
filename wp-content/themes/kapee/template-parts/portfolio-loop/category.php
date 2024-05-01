<?php
/**
 * Template part for displaying portfolio categories
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_loop_prop( 'portfolio-category' ) ) return;
?>		
		
<div class="categories">	
	<?php echo kapee_get_taxonomy_list( get_the_ID(), 'portfolio_cat', ', ', '<span class="cat-links">', '</span>' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>