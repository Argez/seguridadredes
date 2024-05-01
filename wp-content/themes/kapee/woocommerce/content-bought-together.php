<?php 
global $product;
$product_id = $product->get_id();
$availability       = $product->get_availability();
$disabled           = '';
$avai_text_html           = '';
$availability_text          = isset( $availability['availability'] ) ? $availability['availability'] : '';
$availability_class         = isset( $availability['class'] ) ? $availability['class'] : '';
$availability_text_html     = '';
if ( ! $product->is_in_stock() ) {
	$avai_text_html     = '<span class="kapee-out-of-stock">' . $availability_text . '</span>';
	$disabled           = 'disabled';
}
?>
<div class="product col-4 <?php echo esc_attr($availability_class);?>" data-product-id="<?php echo esc_attr($product_id);?>">
	<div class="product-wrapper">
		<div class="product-image">
			<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
				<?php echo wp_kses_post( $product->get_image('woocommerce_thumbnail', array(), true ) );?>
			</a>
		</div>
		<div class="product-info">
			<h3 class="product-title">
				<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo trim( $product->get_title() ); ?></a>
			</h3>
			<?php 
				if( wc_review_ratings_enabled() ){ 
				?>
					<div class="rating clearfix">
						<?php
						$rating_html = wc_get_rating_html( $product->get_average_rating() );
						if ( $rating_html ) {
							echo trim( $rating_html );
						}?>
					</div>
			<?php } ?>
			<span class="price"><?php echo trim($product->get_price_html()); ?></span>
			<?php echo wp_kses_post( $avai_text_html );?>
		</div>
		<?php if($count >0) {?>
		<div class="product-checkbox kapee-checkbox">
			<input type="checkbox" <?php echo checked( true, $product->is_in_stock(), false ). ' ' . $disabled ;?> data-id="<?php echo esc_attr($product_id); ?>" data-product-type="<?php echo esc_attr($product->get_type()); ?>" data-price="<?php echo esc_attr( wc_get_price_to_display( $product ) ); ?>" />
			<span></span>
		</div>
		<?php } ?>
	</div>
</div>