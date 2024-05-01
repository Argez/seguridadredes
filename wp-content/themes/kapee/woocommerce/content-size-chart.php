<?php 
/**
 * The template for displaying product size chart
 * $title
 * $content
 * $table_html
 * $chart_id
 */
 
defined( 'ABSPATH' ) || exit;

if( ! empty ( $content ) ){
}

?>
<div class="kapee-product-sizechart">
	<div class="sizechart-header row">
		<div class="col-12"><h2><?php echo apply_filters( 'kapee_product_sizechart_popup_title', esc_html__('Size Chart', 'kapee') );?></h2></div>
	</div>
	<div class="product-sizechart-inner row">
		<?php if( empty ( $content ) ){ ?>
			<div class="col-12 table-responsive"><?php echo wp_kses_post( $table_html );?></div>
		<?php } else { ?>
			<div class="col-12 col-md-6 table-responsive"><?php echo wp_kses_post( $table_html );?></div>
			<div class="col-12 col-md-6"><?php echo wp_kses_post( $content );?></div>
		<?php } ?>
	</div>
</div>