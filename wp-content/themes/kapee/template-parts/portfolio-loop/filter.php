<?php
/**
 * Displays the portfolio filter
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_loop_prop('portfolio-filter' ) ) return;

$portfolio_cats = get_categories(array(
	'taxonomy' => 'portfolio_cat'
));

if (is_array($portfolio_cats) && !empty($portfolio_cats)) :	?>
	<div class="portfolio-filter">
		<div class="filter-categories">
			<a href="#" data-filter="*" class="active"><?php echo esc_html__('View All', 'kapee'); ?></a></li>
			<?php foreach ($portfolio_cats as $portfolio_cats) : ?>
				<a href="#" data-filter=".portfolio_cat-<?php echo esc_attr($portfolio_cats->slug);?>"><?php echo esc_html($portfolio_cats->name);?></a>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif;?>