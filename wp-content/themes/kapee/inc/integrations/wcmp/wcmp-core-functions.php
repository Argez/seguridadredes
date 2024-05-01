<?php

/**
 * WC Vendors Functions
 *
 * @since  1.0
 */
 
add_action('init','kapee_wcmp_hook');

function kapee_wcmp_hook(){
	/**
	 * Remove hook kapee_product_loop_categories
	 *
	 * @since  1.0
	 */

	remove_action( 'kapee_shop_loop_item_title', 'kapee_product_loop_categories', 15 );
	
	/**
	 * Remove hook wcmp_sold_by_text_after_products_shop_page
	 *
	 * @since  1.0
	 */
	add_filter( 'wcmp_sold_by_text_after_products_shop_page', '__return_false' );
	
	add_action( 'kapee_shop_loop_item_title', 'kapee_wcmp_loop_sold_by_label', 21 );
	add_action( 'woocommerce_single_product_summary', 'kapee_wcmp_item_sold_by_label',8 );
 
}

/**
 * Remove bootstrap
 *
 * @since  1.0
 *
 */
add_action( 'wp_enqueue_scripts','kapee_wcmp_script' , 10001 );
if( ! function_exists ( 'kapee_wcmp_script' ) ){
	function kapee_wcmp_script(){
		if ( class_exists( 'WCMp' ) && is_vendor_dashboard() && ( is_user_wcmp_vendor( get_current_user_id() ) || is_user_wcmp_pending_vendor( get_current_user_id() ) || is_user_wcmp_rejected_vendor( get_current_user_id() ) ) ) {
			wp_deregister_style( 'bootstrap' );
			wp_dequeue_style( 'bootstrap' );
			wp_dequeue_script('bootstrap');
			wp_dequeue_script('kapee-script');
		}
	}
}

/**
 * check is wcmp vendor page
 *
 * @since  1.0
 *
 * @return string size
 */
function kapee_is_wcmp_vendor_page(){
	global $WCMp;
	if (isset( $WCMp->taxonomy->taxonomy_name ) && is_tax($WCMp->taxonomy->taxonomy_name)) {
		return true;
	}
	return false;
}

function kapee_wcmp_loop_sold_by_label(){
	$sold_by_loop = kapee_get_option( 'enable-sold-by-in-loop' , 1 );
	if( !$sold_by_loop ) { return false; }
	kapee_get_wcmp_vendor_name();
}

function kapee_wcmp_item_sold_by_label(){
	$sold_by_single = kapee_get_option( 'enable-sold-by-in-single' , 1 );
	if( !$sold_by_single ) { return false; }
	kapee_get_wcmp_vendor_name();
}

function kapee_get_wcmp_vendor_name(){
	
	if ( ! function_exists( 'get_wcmp_product_vendors' ) ) {
		return;
	}
	
	if ( ! function_exists( 'get_wcmp_vendor_settings' ) ) {
		return;
	}
	
	if ( 'Enable' !== get_wcmp_vendor_settings( 'sold_by_catalog', 'general' ) ) {
		return;
	}
	
	global $post;
	$vendor = get_wcmp_product_vendors( $post->ID );

	if ( empty( $vendor ) ) {
		return;
	}
	$sold_by_label = apply_filters('kapee_sold_by_label',esc_html__( 'Sold By : ', 'kapee' ));
	?>
	
	<div class="sold-by">
		<span class="sold-by-label"><?php echo esc_html( $sold_by_label ); ?> </span>
		<a href="<?php echo esc_url(  $vendor->permalink ); ?>"><?php echo esc_html( $vendor->user_data->display_name ); ?></a>
	</div>
	
	<?php	
}