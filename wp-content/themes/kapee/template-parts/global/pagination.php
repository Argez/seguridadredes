<?php
/**
 * Template part for displaying pagination
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/global
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

$total   = $wp_query->max_num_pages;
$current = (get_query_var('paged')) ? get_query_var('paged') : 1;
$base    = esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );
$format  = '?page=%#%';
if ( $total <= 1 ) {
	return;
}
if( 'portfolio' == get_post_type() ){
	$pagination_style		= kapee_get_loop_prop( 'portfolio-pagination-style' );
	$load_more_label 		= kapee_get_loop_prop( 'portfolio-pagination-load-more-button-text' );
	$loading_finished_msg 	= kapee_get_loop_prop( 'portfolio-pagination-finished-message' );
	$container 				= 'portfolios-list';
	$container_element 		= 'portfolio';
} else {
	$pagination_style 		= kapee_get_loop_prop( 'blog-pagination-style' );
	$load_more_label 		= kapee_get_loop_prop( 'blog-pagination-load-more-button-text' );
	$loading_finished_msg 	= kapee_get_loop_prop( 'blog-pagination-finished-message' );
	$container 				= 'articles-list';
	$container_element 		= 'blog-post-loop';
}

if( is_search() ) {
	$pagination_style = 'default';
}
?>
<nav class="kapee-pagination">
	<?php
	if( $pagination_style != 'default' ){
		if($pagination_style == 'infinity-scroll'){
			wp_enqueue_script( 'isinviewport' );
		}
		if( get_next_posts_link() ) {?>
			<div class="kapee-ajax-load <?php echo esc_attr($pagination_style); ?>" 
			data-load_more_label = "<?php echo esc_attr($load_more_label);?>"
			data-loading_finished_msg = "<?php echo esc_attr($loading_finished_msg);?>"
			data-layout = "<?php echo esc_attr($pagination_style);?>"
			data-post_type = "<?php echo esc_attr( get_post_type() );?>"
			data-cur_page = "<?php echo esc_attr($current);?>"
			data-total_page = "<?php echo esc_attr($total);?>"
			data-container = "<?php echo esc_attr($container);?>"
			data-container_element = "<?php echo esc_attr($container_element);?>"
			>
			<a href="<?php echo esc_url( next_posts( $wp_query->max_num_pages, false ) ); ?>" rel="nofollow" 
			class="button">
				<?php echo esc_html($load_more_label); ?>
			</a>
			</div>
		<?php } 
	} else {
		echo paginate_links(
			apply_filters(
				'kapee_pagination_args',
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
</nav>
