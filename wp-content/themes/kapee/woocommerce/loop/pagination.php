<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';
global $wp_query;
if ( $total <= 1 ) {
	return;
}
$pagination_style = kapee_get_loop_prop( 'products-pagination-style' );

if( is_search() && apply_filters( 'kapee_woocommerce_search_pagination_style_default' , true ) ) {
	$pagination_style = 'default';
}
?>
<div class="kapee-pagination">
	<?php
	if($pagination_style != 'default'){
		if($pagination_style == 'infinity-scroll'){
			wp_enqueue_script( 'isinviewport' );
		}
		$load_more_label 		= kapee_get_loop_prop( 'products-pagination-load-more-button-text' );
		$loading_finished_msg 	= kapee_get_loop_prop( 'products-pagination-finished-message' );
		if( get_next_posts_link() ) {?>
			<div class="kapee-ajax-load <?php echo esc_attr($pagination_style); ?>" 
			data-load_more_label = "<?php echo esc_attr($load_more_label);?>"
			data-loading_finished_msg = "<?php echo esc_attr($loading_finished_msg);?>"
			data-layout = "<?php echo esc_attr($pagination_style);?>"
			data-post_type = "<?php echo esc_attr( get_post_type() );?>"
			data-cur_page = "<?php echo esc_attr($current);?>"
			data-total_page = "<?php echo esc_attr($total);?>"
			data-container = "<?php echo esc_attr('products');?>"
			data-container_element = "<?php echo esc_attr('product');?>"
			>
			<a href="<?php echo esc_url( next_posts( $wp_query->max_num_pages, false ) ); ?>" rel="nofollow" class="button">
				<?php echo esc_html($load_more_label); ?>
			</a>
			</div>
		<?php }
	} else {
		echo paginate_links(
			apply_filters(
				'woocommerce_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'current'   => max( 1, $current ),
					'total'     => $total,
					'prev_text' => esc_html__( 'Previous', 'kapee' ),
					'next_text' => esc_html__( 'Next', 'kapee' ),
					'type'      => 'list',
					'end_size'  => 2,
					'mid_size'  => 2,
				)
			)
		);		
	} ?>
</div>