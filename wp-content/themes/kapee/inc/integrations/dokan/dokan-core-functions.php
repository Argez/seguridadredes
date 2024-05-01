<?php
/**
 * Functions for dokan vendor plugin
 *
 * @since  1.0
 *
 * @return bool
 */
 
add_action( 'kapee_shop_loop_item_title', 'kapee_dokan_loop_sold_by_label', 21 );
add_action( 'woocommerce_single_product_summary', 'kapee_dokan_item_sold_by_label',8 );
 
function kapee_dokan_loop_sold_by_label(){
	$sold_by_loop = kapee_get_option( 'enable-sold-by-in-loop' , 1 );
	if( !$sold_by_loop ) { return false; }
	kapee_get_dokan_vendor_name();
}

function kapee_dokan_item_sold_by_label(){
	$sold_by_single = kapee_get_option( 'enable-sold-by-in-single' , 1 );
	if( !$sold_by_single ) { return false; }
	kapee_get_dokan_vendor_name();
}

function kapee_get_dokan_vendor_name(){
	
	global $product;
	$author_id = get_post_field( 'post_author', $product->get_id() );
	$author    = get_user_by( 'id', $author_id );
	if ( empty( $author ) ) {
		return;
	}

	$shop_info = get_user_meta( $author_id, 'dokan_profile_settings', true );
	$shop_name = $author->display_name;
	if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
		$shop_name = $shop_info['store_name'];
	} 
	$sold_by_label = apply_filters('kapee_sold_by_label',esc_html__( 'Sold By : ', 'kapee' ));
	?>
	<div class="sold-by">
		<span class="sold-by-label"><?php echo esc_html( $sold_by_label ); ?> </span>
		<a href="<?php echo esc_url( dokan_get_store_url( $author_id ) ); ?>"><?php echo esc_html( $shop_name ); ?></a>
	</div>
	<?php	
}