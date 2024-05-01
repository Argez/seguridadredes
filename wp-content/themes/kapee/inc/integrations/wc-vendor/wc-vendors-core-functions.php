<?php

/**
 * WC Vendors Functions
 *
 * @since  1.0
 */


add_action( 'init','kapee_wc_hook' );

function kapee_wc_hook(){
	if ( get_option('wcvendors_display_label_sold_by_enable') == 'yes' ) {
		
		$sold_by_template 	= kapee_get_option('vendor-sold-by-template','theme');
		$sold_by_loop 		= kapee_get_option( 'enable-sold-by-in-loop' , 1 );
		$sold_by_single 	= kapee_get_option( 'enable-sold-by-in-single' , 1 );
		if($sold_by_template == 'theme'){
			if ( class_exists( 'WCV_Vendor_Shop' ) && method_exists( 'WCV_Vendor_Shop', 'template_loop_sold_by' ) ) {
				remove_action( 'woocommerce_after_shop_loop_item', array(
					'WCV_Vendor_Shop',
					'template_loop_sold_by',
				), 9 );
			}		
			add_action( 'kapee_shop_loop_item_title', 'kapee_wc_loop_sold_by_label', 21 );
			add_action( 'woocommerce_single_product_summary', 'kapee_wc_item_sold_by_label',8 ); 
	 
			if ( class_exists( 'WCV_Vendor_Cart' ) && method_exists( 'WCV_Vendor_Cart', 'sold_by_meta' ) ) {
				remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
			}
		}else{
			if(!$sold_by_loop){
				if ( class_exists( 'WCV_Vendor_Shop' ) && method_exists( 'WCV_Vendor_Shop', 'template_loop_sold_by' ) ) {
					remove_action( 'woocommerce_after_shop_loop_item', array(
						'WCV_Vendor_Shop',
						'template_loop_sold_by',
					), 9 );
				}		
			}
			if(!$sold_by_single){
				if ( class_exists( 'WCV_Vendor_Cart' ) && method_exists( 'WCV_Vendor_Cart', 'sold_by_meta' ) ) {
					remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );
				}		
			}
		}	
	}
	add_filter( 'body_class', 'kapee_wc_body_class' );
}

function kapee_wc_body_class( $classes ) {
		if ( class_exists( 'WC_Vendors' ) ) {
			
			$orders_page_id     	= get_option( 'wcvendors_product_orders_page_id' );
			$shop_settings_page 	= get_option( 'wcvendors_shop_settings_page_id' );
			$shop_dashboard_page 	= get_option( 'wcvendors_vendor_dashboard_page_id' );
			
			if ( is_page( $orders_page_id ) ) {
				$classes[] = 'kapee-wc-vendors';
			} elseif ( $shop_settings_page == get_the_ID() ) {
				$classes[] = 'kapee-wc-vendors wc-vendors-shop-settings';
			} elseif( $shop_dashboard_page == get_the_ID() ){ 
				$classes[] = 'kapee-wc-vendors wc-vendors-dashboard';
			}
		}

		return $classes;
	}

function kapee_wc_loop_sold_by_label(){
	$sold_by_loop = kapee_get_option( 'enable-sold-by-in-loop' , 1 );
	if( !$sold_by_loop ) { return false; }
	kapee_get_wc_vendor_name();
}

function kapee_wc_item_sold_by_label(){
	$sold_by_single = kapee_get_option( 'enable-sold-by-in-single' , 1 );
	if( !$sold_by_single ) { return false; }
	kapee_get_wc_vendor_name();
}

function kapee_get_wc_vendor_name(){
	
	global $product;
	$author_id = get_post_field( 'post_author', $product->get_id() );
	$author    = get_user_by( 'id', $author_id );
	if ( empty( $author ) ) {
		return;
	}
	
	$store_name		= WCV_Vendors::get_vendor_shop_name( $author_id );
	$store_url		= WCV_Vendors::get_vendor_shop_page( $author_id );
	if(empty($store_name	)){		
		return;
	}
	$sold_by_label 	= apply_filters('wcvendors_sold_by_in_loop',esc_html__( 'Sold By : ', 'kapee' ));
	?>
	
	<div class="sold-by">
		<span class="sold-by-label"><?php echo esc_html( $sold_by_label ); ?> </span>
		<a href="<?php echo esc_url(  $store_url ); ?>"><?php echo esc_html( $store_name ); ?></a>
	</div>
	
	<?php	
}