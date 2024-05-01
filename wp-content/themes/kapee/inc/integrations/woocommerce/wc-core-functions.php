<?php
/**
 * WooCommerce Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @package Kapee\WooCommerce
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! function_exists( 'kapee_woocommerce_setup' ) ) :
	function kapee_woocommerce_setup() {
		
		// Enable product gallery zoom
		if( kapee_get_option( 'product-gallery-zoom', 1 ) ){
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		
		// Enable product gallery lightbox
		if( kapee_get_option( 'product-gallery-lightbox', 1 ) ){
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		
	}
	add_action( 'init', 'kapee_woocommerce_setup' );
endif;

/**
 * Get My Account Menu
 */
function kapee_get_myaccount_menu() {
	$user_roles = array();
	if( is_user_logged_in() ){
		$user_info = get_userdata( get_current_user_id() );
		$user_roles = $user_info->roles;
	}
	$orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
	$account_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
	if ( substr( $account_page_url, - 1, 1 ) != '/' ) {
		$account_page_url .= '/';
	}
	$orders_url   		= $account_page_url . $orders;
	$dashboard_url		= apply_filters('kapee_myaccount_dashboard_url', $account_page_url );
	$orders_url			= apply_filters('kapee_myaccount_orders_url', $orders_url  );

	$compare_url		= apply_filters('kapee_myaccount_compare_url', '#');
	$tracking_pageid	= kapee_get_option('order-tracking-page', '');
	$order_tracking_url	= apply_filters('kapee_myaccount_order_tracking_url', ( ! empty ( $tracking_pageid ) ) ? get_permalink( $tracking_pageid ) : '' );
	$logout_url			= apply_filters('kapee_myaccount_logout_url', wc_logout_url() );
	$user_data 			= wp_get_current_user();
	$current_user 		= apply_filters('kapee_myaccount_username',$user_data->user_login );	

	$woocommerce_account_menu = array();
	$woocommerce_account_menu['profile'] = array( 
										'icon'		=> 'pls-user',
										 'link'		=> $dashboard_url,
										 'label'	=> esc_html__('My Profile','kapee'),
								);
	$woocommerce_account_menu['orders'] = array( 
										'icon'		=> 'pls-notebook',
										 'link'		=> $orders_url,
										 'label'	=> esc_html__('My Orders','kapee'),
								);
	if( ! empty ( $tracking_pageid ) ):
	$woocommerce_account_menu['order-tracking'] = array( 
										'icon'		=> 'pls-plane',
										 'link'		=> $order_tracking_url,
										 'label'	=> esc_html__('Order Tracking','kapee'),
								);
	 endif;
	if( function_exists( 'YITH_WCWL' ) ){
		//Wishlist
		$wishlist_url 	= YITH_WCWL()->get_wishlist_url();
		$wishlist_url	= apply_filters( 'kapee_myaccount_wishlist_url', $wishlist_url );
		$woocommerce_account_menu['wishlist'] = array( 
										'icon'		=> 'pls-heart',
										 'link'		=> $wishlist_url,
										 'label'	=> esc_html__('My Wishlist','kapee'),
								);
	}
			
	if( defined( 'YITH_WOOCOMPARE' ) ): 
	$woocommerce_account_menu['compare'] = array( 
										'class'		=> 'yith-woocompare-open',
										'icon'		=> 'pls-refresh',
										'link'		=> $compare_url,
										'label'		=> esc_html__('Compare','kapee'),
								);
	endif;
	
	if ( KAPEE_DOKAN_ACTIVE && apply_filters( 'kapee_dokan_menu_link', true ) && ( in_array( 'seller', $user_roles ) || in_array( 'administrator', $user_roles ) ) ) {
			$items['dokan'] = esc_html__( 'Vendor dashboard', 'kapee' );
			$woocommerce_account_menu['dokan'] = array( 
										'icon'		=> 'pls-speedometer',
										'link'		=> dokan_get_navigation_url(),
										'label'		=> esc_html__('Vendor dashboard','kapee'),
								);
			
		}
		
	 $woocommerce_account_menu['logout'] = array( 
										'icon'		=> 'pls-power',
										'link'		=> $logout_url,
										'label'		=> esc_html__('Logout','kapee'),
								);
	return apply_filters( 'kapee_myaccount_menu', $woocommerce_account_menu );
}

if ( ! function_exists( 'kapee_myaccunt_logout_menu_link' ) ) {
	function kapee_myaccunt_logout_menu_link( $items, $args ) {
		$account_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		if ( substr( $account_page_url, - 1, 1 ) != '/' ) {
			$account_page_url .= '/';
		}
		
	   if ( 'myaccount-menu' == $args->theme_location ) {
		  if ( is_user_logged_in() ) {
			 $items .= '<li class="menu-item"><a href="'. esc_url( wc_logout_url() ) .'"><i class="pls-power"></i>'. esc_html__("Logout", "kapee") .'</a></li>';
		  } else {
			 $items .= '<li class="menu-item"><a href="'. esc_url( $account_page_url ) .'">'. esc_html__("Login", "kapee") .'</a></li>';
		  }
	   }
	   return $items;
	}
	add_filter( 'wp_nav_menu_items', 'kapee_myaccunt_logout_menu_link', 10, 2 );
}

if ( ! function_exists( 'kapee_my_account_navigation_endpoint_url' ) ) {
	function kapee_my_account_navigation_endpoint_url( $url, $endpoint, $value, $permalink ) {

		if ( 'dokan' === $endpoint && KAPEE_DOKAN_ACTIVE ) {
			$url = dokan_get_navigation_url();
		}
		return $url;
	}
	add_filter( 'woocommerce_get_endpoint_url', 'kapee_my_account_navigation_endpoint_url', 15, 4 );
}

if ( ! function_exists( 'kapee_my_account_navigation' ) ) {
	/**
	 * My Account Navigation
	 */
	function kapee_my_account_navigation( $items ) {
		$user_info = get_userdata( get_current_user_id() );
		if( !$user_info ){
			return $items;
		}
		$user_roles = $user_info->roles;

		unset( $items['customer-logout'] );

		if ( KAPEE_DOKAN_ACTIVE && apply_filters( 'kapee_dokan_menu_link', true ) && ( in_array( 'seller', $user_roles ) || in_array( 'administrator', $user_roles ) ) ) {
			$items['dokan'] = esc_html__( 'Vendor dashboard', 'kapee' );
		}
	
		$items['customer-logout'] = esc_html__( 'Logout', 'kapee' );

		return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'kapee_my_account_navigation', 15 );
}

if( ! function_exists( 'kapee_manage_woocommerce_hooks' ) ) {
	/**
	 *  Manage WooCommerce Hook
	 */
	function kapee_manage_woocommerce_hooks() {
		
		$breadcrumbs_position 		= kapee_get_option( 'single-product-breadcrumbs-position', 'above-summary' );
		$tabs_location 				= kapee_get_option( 'single-product-tabs-location', 'after-summary' );
		$share_location 			= kapee_get_option( 'product-share-location', 'summary-top' );
		$bought_together_location 	= kapee_get_option( 'product-bought-together-location', 'summary-bottom' );
		
		// Checkout steps
		if( kapee_get_option( 'checkout-steps', 1 ) && ( is_cart() || is_checkout() || is_order_received_page() )) {
			remove_action( 'kapee_inner_page_title', 'kapee_template_page_title', 10 );
			remove_action( 'kapee_inner_page_title', 'kapee_template_breadcrumbs', 20 );
			add_action( 'kapee_inner_page_title', 'kapee_checkout_steps', 10 );
		}
		
		// Shop page breadcrumbs
		if( ! kapee_get_option( 'shop-page-title', 1 ) ) {
			add_action( 'woocommerce_archive_description', 'kapee_template_breadcrumbs', 5	 );
		}
		
		// Remove Product Header
		if( ! kapee_get_option( 'product-header', 1 ) ) {
			remove_action( 'woocommerce_before_shop_loop', 'kapee_before_shop_loop', 20 );
		}
		
		// Remove Product Sorting
		if( ! kapee_get_option( 'product-sorting', 1 ) ) {
			remove_action( 'kapee_shop_loop_header_right', 'woocommerce_catalog_ordering', 30 );
		}
		
		// Enable catalog mode
		if( kapee_get_option( 'catalog-mode', 0 ) ) {			
			remove_action( 'kapee_product_loop_cart_button', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}		

		// Breadcrumbs Position in product page 
		if( kapee_get_option( 'single-product-breadcrumbs', 1 ) ) {
			$product_gallery_layout = kapee_get_product_gallery_layout();
			if( 'product-gallery-horizontal' == $product_gallery_layout || 'product-gallery-center' == $product_gallery_layout ){
				$breadcrumbs_position = 'above-image';
			}
			if( 'above-summary' == $breadcrumbs_position ){
				add_action( 'woocommerce_single_product_summary', 'kapee_template_breadcrumbs', 4 );
			}elseif( 'above-image' == $breadcrumbs_position ) {
				add_action( 'woocommerce_before_single_product', 'kapee_template_breadcrumbs', 50 );
			}
		}
		
		// Remove product rating
		if( ! kapee_get_option( 'single-product-rating', 1 ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 8 );
		}
		
		// Remove product short description
		if( ! kapee_get_option( 'single-product-short-description', 1 ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}
		
		// Remove product meta
		if( ! kapee_get_option( 'single-product-meta', 1 ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		
		// Product share location
		if( $share_location == 'summary-top' ) {
			remove_action( 'woocommerce_single_product_summary', 'kapee_single_product_share', 50 );
			add_action( 'kapee_product_navigation_share', 'kapee_single_product_share', 5);
		}
		
		// Product bought together location
		if( $bought_together_location == 'summary-bottom' ) {
			add_action( 'woocommerce_single_product_summary', 'kapee_bought_together_products', 55 );
		}elseif( $bought_together_location == 'after-summary' ) {			
			add_action( 'woocommerce_after_single_product_summary', 'kapee_bought_together_products', 5 );
		}
		
		// Disable product tabs title option
		if( ! kapee_get_option('single-product-tabs-titles', 1) ) {
			add_filter( 'woocommerce_product_description_heading', '__return_false', 20 );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 20 );
		}
				
		// Product tabs location
		if( $tabs_location == 'summary-bottom' ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 57 );
		}
		
		//Remove yith compare button in loop yith_woocompare_compare_button
		if( class_exists( 'YITH_Woocompare' ) ){
			global $yith_woocompare;
			$yith_woocompare_obj = $yith_woocompare->obj;
			if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
				remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare_obj, 'add_compare_link' ), 20 );
			}
		}
		
		// Remove UpSell Products
		if( ! kapee_get_option('upsells-products', 1 ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}
		
		// Remove Related Products
		if( ! kapee_get_option('related-products', 1 ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
		
		// Remove Recently Viewed Products
		if( ! kapee_get_option('recently-viewed-products', 0 ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'kapee_output_recently_viewed_products', 25 );
		}
		
		if ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price', 0 ) ) {
			add_filter( 'woocommerce_get_price_html', 'kapee_login_to_see_prices' );  
			add_filter( 'woocommerce_loop_add_to_cart_link', '__return_false' );  

			//Add to cart btns
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}
		
		add_filter( 'woocommerce_product_tabs', 'kapee_product_tabs', 90 );
		
		add_filter( 'woocommerce_output_related_products_args', 'kapee_related_products_args' );
		
		add_filter( 'woocommerce_upsell_display_args', 'kapee_related_products_args' );
		
		/**
		 * Multi Step Checkout
		 */
		if( kapee_get_option( 'multi-step-checkout', 0 ) && apply_filters( 'kapee_multi_step_checkout' , true ) ){
			
			add_filter( 'woocommerce_locate_template', 'kapee_multistep_checkout', 10, 3 );

			/* Checkout hack */
			remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
			remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
			remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
			remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

			add_action( 'kapee_woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
			add_action( 'kapee_woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20 );
			add_action( 'kapee_checkout_login_form','kapee_checkout_login_form', 10 );
			add_action( 'kapee_woocommerce_checkout_coupon', 'woocommerce_checkout_coupon_form', 10 );

			/* Prevent empty shipping tab */
			add_filter( 'woocommerce_enable_order_notes_field', '__return_true' );

			/* Support to WooCommerce secure submit gateway */
			if ( class_exists( 'WC_Gateway_SecureSubmit' ) ) {
				$secure_submit_options = get_option( 'woocommerce_securesubmit_settings' );
				if( ! empty( $secure_submit_options['use_iframes'] ) && 'yes' == $secure_submit_options['use_iframes'] ) {
					add_filter( 'option_woocommerce_securesubmit_settings', 'kapee_woocommerce_securesubmit_support', 10, 2 );
				}
			}
		}

	}
	add_action( 'wp', 'kapee_manage_woocommerce_hooks', 1000 );	
}

if( ! function_exists( 'kapee_wcwl_settings' ) ) {
	/**
	 * Remove WCWL default options
	 */
	function kapee_wcwl_settings(){
		if( function_exists( 'YITH_WCWL_Frontend' ) ){
			$kapee_wcwl_obj = YITH_WCWL_Frontend();
			remove_action( 'woocommerce_before_shop_loop_item', array( $kapee_wcwl_obj, 'print_button' ), 5 );
			remove_action( 'woocommerce_after_shop_loop_item', array( $kapee_wcwl_obj, 'print_button' ), 7 );
			remove_action( 'woocommerce_after_shop_loop_item', array( $kapee_wcwl_obj, 'print_button' ),15 );		
			remove_action( 'woocommerce_single_product_summary', array( $kapee_wcwl_obj, 'print_button' ),31 );		
			remove_action( 'woocommerce_product_thumbnails', array( $kapee_wcwl_obj, 'print_button' ),21 );		
			remove_action( 'woocommerce_after_single_product_summary', array( $kapee_wcwl_obj, 'print_button' ),11 );
			add_action( 'woocommerce_single_product_summary', array( $kapee_wcwl_obj, 'print_button' ),31 );
		}
	}
	add_action( 'wp_head', 'kapee_wcwl_settings', 10 );
}

if( ! function_exists( 'kapee_shop_vc_custom_css' ) ) {
	/*
	 * WPBakery Page Builder add custom CSS in Shop and Archive Page
	 */
	function kapee_shop_vc_custom_css() {
		if ( ! function_exists( 'wc_get_page_id' ) ) return;
		$shop_custom_css = get_post_meta( wc_get_page_id( 'shop' ), '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shop_custom_css ) ) {
			echo '<style data-type="vc_shortcodes-custom-css">' . $shop_custom_css . '</style>';
		}
	}
	add_action( 'wp_head', 'kapee_shop_vc_custom_css', 1000 );
}

if ( ! function_exists( 'kapee_update_cart_widget_quantity' ) ){
	/** 
	 * MINI Cart Quantity Update
	 */
	function kapee_update_cart_widget_quantity(){	
		$cart_item_key 	= sanitize_text_field( $_POST['cart_item_key'] );
		$quantity 		= (int) sanitize_text_field( $_POST['quantity'] );
		if( !empty( $cart_item_key ) ){
			$cart =  WC()->cart->get_cart();
			if( isset($cart[$cart_item_key]) ){
				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( '/[^0-9\.]/', '', $quantity ) ), $cart_item_key );
				if( !($quantity === '' || $quantity === $cart[$cart_item_key]['quantity']) ){
					if( !($cart[$cart_item_key]['data']->is_sold_individually() && $quantity > 1) ){
						WC()->cart->set_quantity( $cart_item_key, $quantity, false );
						$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', true );
						if( $cart_updated ){
							WC()->cart->calculate_totals();
						}
					}
				}
			}
			WC_AJAX::get_refreshed_fragments();
		}	
	}
	add_action( 'wp_ajax_kapee_update_cart_widget_quantity','kapee_update_cart_widget_quantity' );
	add_action( 'wp_ajax_nopriv_kapee_update_cart_widget_quantity','kapee_update_cart_widget_quantity' );
}

if ( ! function_exists( 'kapee_update_checkout_quantity' ) ){
	/** 
	 * Checkout Quantity Update
	 */
	function kapee_update_checkout_quantity(){
		$data = array();
        parse_str($_POST['form_data'], $data);
        $cart 			= $data['cart'];
        $cart_updated 	= false;
		$cart_totals  	= isset( $data['cart'] ) ? wp_unslash( $data['cart'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		
		if ( ! WC()->cart->is_empty() && is_array( $cart_totals ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

				$_product = $values['data'];

				// Skip product if no updated quantity was posted.
				if ( ! isset( $cart_totals[ $cart_item_key ] ) || ! isset( $cart_totals[ $cart_item_key ]['qty'] ) ) {
					continue;
				}

				// Sanitize.
				$quantity = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( '/[^0-9\.]/', '', $cart_totals[ $cart_item_key ]['qty'] ) ), $cart_item_key );

				if ( '' === $quantity || $quantity === $values['quantity'] ) {
					continue;
				}

				// Update cart validation.
				$passed_validation = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

				// is_sold_individually.
				if ( $_product->is_sold_individually() && $quantity > 1 ) {
					/* Translators: %s Product title. */
					wc_add_notice( sprintf( __( 'You can only have 1 %s in your cart.', 'kapee' ), $_product->get_name() ), 'error' );
					$passed_validation = false;
				}

				if ( $passed_validation ) {
					WC()->cart->set_quantity( $cart_item_key, $quantity, false );
					$cart_updated = true;
				}
			}
		}
		
		if ( $cart_updated ) {
            WC()->cart->calculate_totals();            
			WC_AJAX::get_refreshed_fragments();
        }
		die();
	}	
	add_action( 'wp_ajax_kapee_update_checkout_quantity','kapee_update_checkout_quantity' );
	add_action( 'wp_ajax_nopriv_kapee_update_checkout_quantity','kapee_update_checkout_quantity' );
}

/**
 * Shop Page
 */
 
if ( !function_exists( 'kapee_get_products_view' ) ){
	/*
	 * Product Default View 
	 */
	function kapee_get_products_view(){
		
		$product_view = kapee_get_option( 'products-default-view', 'grid-view' );
		if(isset($_GET['view'])){
			return $_GET['view'];
		}
		return $product_view;
	}
}

if( ! function_exists( 'kapee_product_quick_view' ) ){
	/**
	 * Product Quick View
	 */
	function kapee_product_quick_view(){
		
		if( isset( $_REQUEST['pid'] ) ) {
			$pid = sanitize_text_field( (int) $_REQUEST['pid'] );
		}
		
		global $post, $product;
		$post = get_post( $pid );
		setup_postdata( $post );
		$product = wc_get_product( $post->ID );
		ob_start();
			if ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price',0 ) ) {
				add_filter( 'woocommerce_get_price_html', 'kapee_login_to_see_prices' );  
				add_filter( 'woocommerce_loop_add_to_cart_link', '__return_false' );  

				//Add to cart btns
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if( kapee_get_option( 'catalog-mode', 0 ) ) {			
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
		
			get_template_part( 'woocommerce/content-quick-view' );
		echo ob_get_clean();
		die();
	}
	add_action( 'wp_ajax_kapee_product_quick_view','kapee_product_quick_view' );
	add_action( 'wp_ajax_nopriv_kapee_product_quick_view','kapee_product_quick_view' );
}

/*
 * Swap "Regular price" and "Sale price"
 */
function kapee_sale_regular_price( $price, $regular_price, $sale_price ) {	
	$price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del aria-hidden="true">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
	
    return $price;
}
add_filter( 'woocommerce_format_sale_price', 'kapee_sale_regular_price', 10, 3 );

if ( ! function_exists( 'kapee_login_to_see_prices' ) ) {
	/**
	 * Login to See Price
	 */
	function kapee_login_to_see_prices() {
		if( is_user_logged_in() ) return;
		$login_to_prices_text = apply_filters( 'kapee_login_to_prices_text', esc_html__( 'Login to see price', 'kapee' ) );
		$account_page_id 			= get_option( 'woocommerce_myaccount_page_id' );
		$account_page_url 			= !empty( $account_page_id ) ? get_permalink( $account_page_id ) : '#';
		return '<a href="'.esc_url( $account_page_url ).'" class="kapee-login-to-see-prices customer-signinup">' . $login_to_prices_text . '</a>';
	}
}

if ( ! function_exists( 'kapee_show_login_to_price' ) ) {
	function kapee_show_login_to_price(){
		if( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price' ) ) {
			return false;
		}
		return true;
	}
}

/**
 * Single Product Page
 */

if ( ! function_exists( 'kapee_get_single_product_images_classes' ) ) {
	/**
	 * Get Single Product Images Classes
	 * @since 1.4.0
	 */
	function kapee_get_single_product_images_classes() {
		$classes = array();
		$product_gallery_layout = kapee_get_product_gallery_layout();
		
		if( 'product-gallery-left' == $product_gallery_layout || 'product-gallery-bottom' == $product_gallery_layout || 'product-gallery-grid' == $product_gallery_layout || 'product-sticky-info' == $product_gallery_layout ){
			$classes[] = "col-md-6";
		}elseif('product-gallery-horizontal' == $product_gallery_layout || 'product-gallery-center' == $product_gallery_layout ){
			$classes[] = "col-12";
		}
		
		return apply_filters( 'kapee_get_single_product_images_classes', implode( ' ', array_map( 'sanitize_html_class', $classes ) ) );
	}
}

if ( ! function_exists( 'kapee_get_single_product_summary_classes' ) ) {
	/**
	 * Get Single Product Summary Classes
	 * @since 1.4.0
	 */
	function kapee_get_single_product_summary_classes() {
		$classes = array();
		$product_gallery_layout = kapee_get_product_gallery_layout();
		
		if( 'product-gallery-left' == $product_gallery_layout || 'product-gallery-bottom' == $product_gallery_layout || 'product-gallery-grid' == $product_gallery_layout || 'product-sticky-info' == $product_gallery_layout ){
			$classes[] = "col-md-6";
		}elseif( 'product-gallery-horizontal' == $product_gallery_layout || 'product-gallery-center' == $product_gallery_layout ){
			$classes[] = "col-12";
		}
		
		return apply_filters( 'kapee_get_single_product_summary_classes', implode( ' ', array_map( 'sanitize_html_class', $classes ) ) );
	}
}

if ( !function_exists('kapee_ajax_get_block') ) {
	function kapee_ajax_get_block(){
				
		$post_id = isset($_POST['id']) ? $_POST['id'] : 0;
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		if( $post_id ){
			echo '<div class="kapee-ajax-blok-content">';
			if( !empty( $title ) ){
				echo '<div class="kapee-blok-title">';
				echo esc_html($title);
				echo '</div>';
			}			
			echo do_shortcode('[kapee_block id="'.$post_id.'"]');
			echo '</div>';
		}else{
			echo esc_html__('Something wrong..','kapee');
		}
		die();
	}
	//Ajax Block
	add_action('wp_ajax_kapee_ajax_get_block', 'kapee_ajax_get_block');
	add_action('wp_ajax_nopriv_kapee_ajax_get_block', 'kapee_ajax_get_block');
}

if ( ! function_exists( 'kapee_wc_get_gallery_html' ) ) {
	/**
	 * Get HTML for a gallery
	 * @since 1.4.0
	 */
	function kapee_wc_get_gallery_html( $gallery_image_ids, $main_image = false ) {
		$gallery_output = '';

		foreach ( $gallery_image_ids as $gallery_image_id ) {
			$gallery_output .= kapee_wc_get_gallery_image_html( $gallery_image_id, $main_image );
		}
		return $gallery_output;
	}
}

if ( ! function_exists( 'kapee_wc_get_gallery_image_html' ) ) {
	/**
	 * Get Product Gallery Image HTML
	 * @since 1.4.0
	 */
	function kapee_wc_get_gallery_image_html( $attachment_id, $main_image = false ){
		$flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
		$image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
		$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
		$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
		if( empty( $thumbnail_src ) ){
			return;			
		}
		$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
		$alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
		if( $main_image ){
			$image             = wp_get_attachment_image(
				$attachment_id,
				$image_size,
				false,
				apply_filters(
					'woocommerce_gallery_image_html_attachment_image_params',
					array(
						'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
						'data-src'                => esc_url( $full_src[0] ),
						'data-large_image'        => esc_url( $full_src[0] ),
						'data-large_image_width'  => esc_attr( $full_src[1] ),
						'data-large_image_height' => esc_attr( $full_src[2] ),
						'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
					),
					$attachment_id,
					$image_size,
					$main_image
				)
			);
			//return $image;
			return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
		}else{
			return '<div class="kapee-gallery-thumbnail-image">'.wp_get_attachment_image( $attachment_id, $image_size ).'</div>';
		}
	}
}

if ( ! function_exists( 'kapee_wc_gallery_thumbnail_image_size' ) ) {
	function kapee_wc_gallery_thumbnail_image_size( $size ) {

		$product_gallery_layout = kapee_get_product_gallery_layout();

		if ( 'product-gallery-left' == $product_gallery_layout || 'product-gallery-bottom' == $product_gallery_layout ) {
			$size['width']  = 150;
			$size['height'] = 150;
		}
		return $size;
	}
	add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'kapee_wc_gallery_thumbnail_image_size' );
}

if ( ! function_exists( 'kapee_hide_in_stock_message' ) ) {
	/**
	 * Hide stock in message for variation product
	 */
	function kapee_hide_in_stock_message( $html, $product) {
		$availability = $product->get_availability();
		
		if($product->get_type() != 'variation'){
			return '';
		} 
		if ( $product->is_in_stock() ) {
			return '';
		}
		return $html;
	}
	add_filter( 'woocommerce_get_stock_html', 'kapee_hide_in_stock_message', 10, 2 );
}

if ( ! function_exists( 'kapee_product_tabs' ) ) {
	/**
	 * Kapee product tabs
	 */
	function kapee_product_tabs( $tabs ){
		global $post;
		$product_id = $post->ID;
		$prefix = KAPEE_PREFIX;		
		$additional_information = kapee_get_option( 'product-additional-information-tab', 1 );
		$review_tab = kapee_get_option( 'product-review-tab', 1 );
		$bought_together = kapee_get_option( 'single-product-bought-together', 1 );
		$bought_together_txt = kapee_get_option( 'product-bought-together-title', 'Frequently Bought Together' );
		if( ! $review_tab ){
			unset( $tabs['reviews'] ); 
		}
		if( ! $additional_information ){
			unset( $tabs['additional_information'] ); 
		}
		if( $bought_together && kapee_get_option( 'product-bought-together-location', 'summary-bottom' ) == 'in-tab' ){
			$pids = get_post_meta( $product_id, $prefix.'product_ids', true );
            if ( !empty($pids) ) {
                $tabs['bought_together'] = array(
                    'title' => $bought_together_txt,
                    'priority' => 1,
                    'callback' => 'kapee_bought_together_products'
                );
            }
		}
		$enable_custom_tab = get_post_meta( $product_id, $prefix.'enable_custom_tab', true );
		$product_custom_tab_heading = get_post_meta( $product_id, $prefix.'product_custom_tab_heading', true );
		if ($enable_custom_tab && !empty($product_custom_tab_heading) ) {
			$tabs['kapee_custom_tab'] = array(
				'title' => $product_custom_tab_heading,
				'priority' => 40,
				'callback' => 'kapee_custom_tab'
			);
		}
		return $tabs;
	}
}

if ( ! function_exists( 'kapee_custom_tab' ) ) {
	/**
	 * Kapee Product Custom Tab
	 */
	function kapee_custom_tab() {
		global $product;
		$prefix 					= KAPEE_PREFIX;
		$product_id 				= $product->get_id();
		$product_custom_tab_content = get_post_meta( $product_id,$prefix.'product_custom_tab_content', true );
		echo do_shortcode( $product_custom_tab_content );
	}
}

if ( ! function_exists( 'kapee_bought_together_products' ) ) {
	/**
	 * Bought Together Products
	 */
	function kapee_bought_together_products() {
		if ( is_singular( 'product' ) ) {
			global $product;
			$bought_together = kapee_get_option( 'single-product-bought-together', 1 );
			if(!$bought_together){
				return;
			}
			$prefix = KAPEE_PREFIX;
			$product_id = $product->get_id();
			$together_products = get_post_meta( $product_id,$prefix.'product_ids', true );
			if( empty($together_products)){ return;}
			$together_products = array_merge(array($product_id),$together_products);
			
			$args = apply_filters( 'woocommerce_bought_together_products_args', array(
				'post_type'            	=> array('product','product_variation'),
				'ignore_sticky_posts'  	=> 1,
				'no_found_rows'        	=> 1,
				'posts_per_page'       	=> -1,
				'orderby' 				=> 'post__in',
				'post__in' 				=> $together_products
			) );
			
			$products = new WP_Query( $args );
			$total_price = 0;
			$count = 0;
			$i = 1;
			$max_disply_products = apply_filters('kapee_display_bought_together_products',3);
			$bought_together_txt = kapee_get_option( 'product-bought-together-title', 'Frequently Bought Together' );
			if ( $products->have_posts() ) : ?>
			<div class="kapee-wc-message"></div>
			<div class="kapee-bought-together-products">
				<h3 class="bought-together-title">
					<?php echo apply_filters('woocommerce_bought_together_title',$bought_together_txt ); ?>
				</h3>
				<div class="row">
					<div class="products col-12 col-md-8 col-lg-9">
						<div class="row">
							<?php 
							while ( $products->have_posts() ) : $products->the_post(); 
								global $product;
														
								$args['count'] = $count;
								wc_get_template( 'content-bought-together.php', $args );					
								$price_html = $product->get_price_html();
								if ( $price_html ) {
									$display_price = wc_get_price_to_display( $product );
								}
								if ( $product->is_in_stock() ) {
									$total_price += wc_get_price_to_display( $product );					
									$count++;
								}
								if($i == $max_disply_products){
									break;								
								}
								$i++;
							endwhile; 
							wp_reset_postdata();
							?>
						</div>
					</div>
					<?php global $product;?>
					<?php if( kapee_show_login_to_price() ) { ?>
						<div class="items-total-price-button col-12 col-md-4 col-lg-3">				
							<div class="items-total-price">
								<div class="current-item">
									<span class="item"><?php if ( $product->is_in_stock() ) { echo sprintf( esc_html__('%d Item','kapee'),1);} else {echo sprintf(esc_html__('%d Item','kapee'),0);}?></span>
									<span class="item-price" data-id="<?php echo esc_attr($product->get_id());?>" data-itemprice="<?php echo esc_attr( wc_get_price_to_display( $product ) );?>" data-type="<?php echo esc_attr( $product->get_type() );?>"><?php echo wc_price( wc_get_price_to_display( $product ) );?></span>
								</div>
								<div class="addons-item">
									<span class="items"><?php echo wp_kses( sprintf(__('<span class="addon-count">%d</span> Add-Ons','kapee'),$count-1), kapee_allowed_html('span') );?></span>
									<span class="items-price"><?php echo wp_kses( wc_price($total_price - wc_get_price_to_display( $product) ), kapee_allowed_html('span') );?></span>
								</div>
								<div class="items-total">
									<span><?php echo esc_html__('Total','kapee');?></span>
									<span class="total-price"><?php echo wp_kses( wc_price($total_price) , kapee_allowed_html('span') );?></span>
								</div>
							</div>
							<?php if( !kapee_get_option( 'catalog-mode', 0 ) ) { ?>
							<div class="add-items-to-cart-wrap">
								<button type="button" class="add-items-to-cart"><?php echo esc_html__( 'Add items to cart', 'kapee' ); ?></button>
							</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php endif;
			wp_reset_postdata();
		}
	}
}

if ( ! function_exists( 'kapee_all_add_to_cart' ) ) {
	/**
	 * All Add To Cart Products
	 */
	function kapee_all_add_to_cart() {
		
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		$product_id        = apply_filters( 'kapee_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
		$variation_id      = empty( $_POST['variation_id'] ) ? 0 : $_POST['variation_id'];
		$variation         = empty( $_POST['variation'] ) ? array() : $_POST['variation'];
		$passed_validation = apply_filters( 'kapee_add_to_cart_validation', true, $product_id, $quantity );
		$product_status    = get_post_status( $product_id );


		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
			
			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wc_add_to_cart_message( array( $product_id => $quantity ), true );
			}

			// Return fragments
			WC_AJAX::get_refreshed_fragments();

		} else {

			// If there was an error adding to the cart, redirect to the product page to show any errors.
			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
			);

			wp_send_json( $data );

		}
		die();
	}
	add_action( 'wp_ajax_nopriv_kapee_all_add_to_cart',  'kapee_all_add_to_cart' );
	add_action( 'wp_ajax_kapee_all_add_to_cart',  'kapee_all_add_to_cart' );
}

if ( ! function_exists( 'kapee_ajax_add_to_cart' ) ) {
	/**
	 * Ajax Add to Cart
	 */
	function kapee_ajax_add_to_cart(){
		
		// Get messages
		ob_start();
		wc_print_notices();
		$notices = ob_get_clean();
		
		// Get fragments
		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();
		
		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
						'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
					)
				),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);
		wp_send_json( $data );		
		die();
	}
	add_action('wp_ajax_kapee_ajax_add_to_cart', 'kapee_ajax_add_to_cart');
	add_action('wp_ajax_nopriv_kapee_ajax_add_to_cart', 'kapee_ajax_add_to_cart');
}


if ( ! function_exists( 'kapee_related_products_args' ) ){
	/**
	 * Related Product args
	 */
	function kapee_related_products_args($args){		
		$args['posts_per_page'] = kapee_get_option( 'related-upsells-products', 12 );
		return $args;
	}
}


if ( ! function_exists( 'kapee_get_shop_viewnumbers' ) ){
	/*
	 * Number of Product View
	 */
	function kapee_get_shop_viewnumbers(){
		$show_numbers = kapee_get_option( 'products-per-page-number', '6, 9, 12, 24, 36, 48' );
		$show_numbers = explode( ',', $show_numbers);
		$show_numbers = array_map( 'trim', $show_numbers );
		return $show_numbers;
	}
}

if ( ! function_exists( 'kapee_set_recently_viewed_products' ) ){
	/**
	 * Track Recently Viewed Products 
	 */
	function kapee_set_recently_viewed_products() {
		if ( ! is_singular( 'product' )) {
			return;
		}

		global $post;

		if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
			$viewed_products = array();
		} else {
			$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
		}

		// Unset if already in viewed products list.
		$keys = array_flip( $viewed_products );

		if ( isset( $keys[ $post->ID ] ) ) {
			unset( $viewed_products[ $keys[ $post->ID ] ] );
		}

		$viewed_products[] = $post->ID;

		if ( count( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}

		// Store for session only.
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
	}
	add_action( 'template_redirect', 'kapee_set_recently_viewed_products', 20 );
}

if ( ! function_exists( 'kapee_get_recently_viewed_products' ) ){
	/**
	 * Get Recently Viewed Product
	 */
	function kapee_get_recently_viewed_products(){
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
		if ( empty( $viewed_products ) ) {
			return array();
		}
		return $viewed_products;
	}
}

if( ! function_exists( 'kapee_get_products_tab_data' ) ){
	/**
	 * Ajax Tab
	 */
    function kapee_get_products_tab_data(){
		check_ajax_referer( 'kapee_nonce', 'nonce' );
        $response   = array(
            'html'    => '',
            'message' => '',
            'success' => 'no',
        );
        $datasource 	= isset( $_POST['datasource'] ) ? $_POST['datasource'] : '';
        $limit         	= isset( $_POST['limit'] ) ? $_POST['limit'] : '';
        $slider_data	= isset( $_POST['slider_data'] ) ? $_POST['slider_data'] : '';
        $nonce         	= isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
		$query 			= kapee_get_products($datasource, array('limit' => $limit) );
        $the_query 		= new WP_Query( $query );
		ob_start();
		
		kapee_set_loop_prop('name','kapee-carousel');
		kapee_set_loop_prop('products-default-view','grid-view');			
		kapee_set_loop_prop('products-columns',$slider_data['rs_desktop']);
		$unique_id 		= kapee_uniqid('section-');
		kapee_set_loop_prop('unique_id',$unique_id);	
		kapee_set_loop_prop('slider_data',$slider_data);
		global $kapee_owlparam;
		$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
		woocommerce_product_loop_start();
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			wp_reset_postdata();
		woocommerce_product_loop_end();
        $response['html']    = ob_get_clean();
        $response['success'] = 'ok';
        wp_send_json( $response );
        die();
    }
	add_action('wp_ajax_kapee_get_products_tab_data', 'kapee_get_products_tab_data');
	add_action('wp_ajax_nopriv_kapee_get_products_tab_data', 'kapee_get_products_tab_data');
}

/**
 * Check enable swatch
 * @since 1.0.8
*/
function kapee_has_enable_switch( $attribute_name ){
	$prefix = KAPEE_PREFIX;
	$enable_swatch = get_option($prefix.$attribute_name.'_enable_swatch',false);
	if( !empty( $enable_swatch ) && $enable_swatch ){
		return true;
	}
	return false;
}

/**
 * Swatch HTML
 * @since 1.0.8
*/
function kapee_swatch_html($html,$terms,$options, $attribute_name, $selected_attributes,$product = null){
	
	if ( isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) {
		$selected_value = $_REQUEST[ 'attribute_' . $attribute_name ];
	} elseif ( isset( $selected_attributes[ $attribute_name ] ) ) {
		$selected_value = $selected_attributes[ $attribute_name ];
	} else {
		$selected_value = '';
	}	
	foreach ( $terms as $term ) {
		$html .= kapee_get_swatch_html( $term,$selected_value, $attribute_name, $product );
	}
	return $html;
}

/**
 * Get Swatch HTML
 * @since 1.0.8
*/
function kapee_get_swatch_html($term,$selected_value ='',$attribute_name = '', $product = null ){
	$html 					= '';
	$prefix 				= KAPEE_PREFIX;
	$swatch_display_style 	= get_option($prefix.$attribute_name.'_swatch_display_style',true);
	$swatch_display_type 	= get_option($prefix.$attribute_name.'_swatch_display_type',true);
	$swatch_size 			= get_option($prefix.$attribute_name.'_swatch_display_size',true);
	$name     				= esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );
		$selected = sanitize_title( $selected_value ) == $term->slug ? 'swatch-selected' : '';
		if($swatch_display_type == 'color'){			
			$color = get_term_meta( $term->term_id,  $prefix.'color', true );
			list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
			if(empty($color)){
				$color = strtolower($name);
			}
			$html .= sprintf(
			'<span class="swatch-term swatch swatch-color term-%s swatch-%s swatch-%s %s"  title="%s" data-term="%s"><span class="kapee-tooltip" style="background-color:%s;color:%s;">%s</span></span>',
			esc_attr( $term->slug ),
			$swatch_display_style,
			$swatch_size,
			$selected,					
			esc_attr( $name ),
			esc_attr( $term->slug ),
			esc_attr( $color ),
			"rgba($r,$g,$b,0.5)",
			$name
			);
		}else if($swatch_display_type == 'image'){
			
			$image = get_term_meta( $term->term_id, $prefix.'kapee_attachment_id', true );
			
			$show_variation_image = apply_filters( 'kapee_show_variation_image', true );
			if( $show_variation_image ) {
				$pid 	= $product->get_id();
				$cache_enabled = apply_filters( 'kapee_has_swatches_cache', true );
				$transient_name     = 'kapee_swatches_cache_' . $pid;
				
				if ( $cache_enabled ) {
					$available_variations = get_transient( $transient_name );
				} else {
					$available_variations = array();
				}
				
				if ( ! $available_variations ) {					
					$available_variations = $product->get_available_variations();
					if ( $cache_enabled ) {
						set_transient( $transient_name, $available_variations, apply_filters( 'kapee_swatches_cache_time', WEEK_IN_SECONDS ) );
					}
				}
				if ( empty( $available_variations ) ) {
					return;
				}
				foreach ( $available_variations as $variation ) {
					if ( $variation['attributes'][ 'attribute_' . $attribute_name ] == $term->slug ) {
						$data_var_id = $variation['variation_id'];
					}
				}
				$variation = new WC_Product_Variation( $data_var_id );
				$image_id = $variation->get_image_id(); 
				
				if($image_id){
					$image = $image_id;
				}
			}
			
			$image = $image ? wp_get_attachment_image_src( $image ) : '';
			$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
			$html  .= sprintf(
				'<span class="swatch-term swatch swatch-image term-%s swatch-%s swatch-%s %s" title="%s" data-term="%s"><img src="%s" alt="%s"></span>',
				esc_attr( $term->slug ),
				$swatch_display_style,
				$swatch_size,
				$selected,
				esc_attr( $name ),
				esc_attr( $term->slug ),
				esc_url( $image ),
				esc_attr( $name )
			);
		}else{
			$label = get_term_meta( $term->term_id, 'label', true );
			$label = $label ? $label : $name;
			if( $swatch_display_style == 'square' ){
				$swatch_size = 'default';
			}
			$html  .= sprintf(
				'<span class="swatch-term swatch swatch-label term-%s swatch-%s swatch-%s %s" title="%s" data-term="%s"><span>%s</span></span>',
				esc_attr( $term->slug ),
				$swatch_display_style,
				$swatch_size,
				$selected,
				esc_attr( $name ),
				esc_attr( $term->slug ),
				esc_html( $label )
			);
		}
	return apply_filters('kapee_single_swatch_html',$html,$term,$selected_value);
}

/**
 * My Account Page
 */
 
if ( ! function_exists( 'kapee_social_nextend_social_login' ) ) {
	/* 
	 * The social nextend social login/register 
	 */
    function kapee_social_nextend_social_login() {
		if (!defined('NSL_PRO_PATH')) {
			if ( class_exists('NextendSocialLogin') ) {
				echo '<div class="social-login-separator"><span>'. esc_html__('Or login with', 'kapee') .'</span></div>';
				echo do_shortcode('[nextend_social_login]');
			}
		}
        
    }
    add_action( 'woocommerce_login_form_end', 'kapee_social_nextend_social_login', 10 );
}
 
if ( ! function_exists( 'kapee_social_nextend_social_register' ) ) {
	/* 
	 * The social nextend social login/register 
	 */
    function kapee_social_nextend_social_register() {
		if (!defined('NSL_PRO_PATH')) {
			if ( class_exists('NextendSocialLogin') ) {
				echo '<div class="social-login-separator"><span>'. esc_html__('Or connect with', 'kapee') .'</span></div>';
				echo do_shortcode('[nextend_social_login]');
			}
		}
        
    }
    add_action( 'woocommerce_register_form_end', 'kapee_social_nextend_social_register', 10 );
}

/**
 * Checkout Page
 */
 
if ( ! function_exists( 'kapee_validate_checkout_callback' ) ) {
	/**
	* Validate multi-step checkout fields.
	*
	* @since 1.0.0
	*/
	function kapee_validate_checkout_callback() {
		check_ajax_referer( 'kapee_nonce', 'nonce' );
		$posted_data = isset($_POST['posted_data'])?$_POST['posted_data']:array();

		$WC_Checkout = new WC_Checkout();
		$errors = new WP_Error();


		////////////////////////////////////////
		$skipped = array();
		$data = array(
			'terms' => (int) isset($posted_data['terms']),
			'createaccount' => (int) !empty($posted_data['createaccount']),
			'payment_method' => isset($posted_data['payment_method']) ? wc_clean($posted_data['payment_method']) : '',
			'shipping_method' => isset($posted_data['shipping_method']) ? wc_clean($posted_data['shipping_method']) : '',
			'ship_to_different_address' => !empty($posted_data['ship_to_different_address']) && !wc_ship_to_billing_address_only(),
			'woocommerce_checkout_update_totals' => isset($posted_data['woocommerce_checkout_update_totals']),
		);
		
		foreach ($WC_Checkout->get_checkout_fields() as $fieldset_key => $fieldset) {
			if (isset($data['ship_to_different_address'])) {
				if ('shipping' === $fieldset_key && (!$data['ship_to_different_address'] || !WC()->cart->needs_shipping_address() )) {
					continue;
				}
			}

			if (isset($data['createaccount'])) {
				if ('account' === $fieldset_key && ( is_user_logged_in() || (!$WC_Checkout->is_registration_required() && empty($data['createaccount']) ) )) {
					continue;
				}
			}
			foreach ($fieldset as $key => $field) {
				$type = sanitize_title(isset($field['type']) ? $field['type'] : 'text' );

				switch ($type) {
					case 'checkbox' :
						$value = isset($posted_data[$key]) ? 1 : '';
						break;
					case 'multiselect' :
						$value = isset($posted_data[$key]) ? implode(', ', wc_clean($posted_data[$key])) : '';
						break;
					case 'textarea' :
						$value = isset($posted_data[$key]) ? wc_sanitize_textarea($posted_data[$key]) : '';
						break;
					default :
						$value = isset($posted_data[$key]) ? wc_clean($posted_data[$key]) : '';
						break;
				}

				$data[$key] = apply_filters('woocommerce_process_checkout_' . $type . '_field', apply_filters('woocommerce_process_checkout_field_' . $key, $value));
			}
		}

		if (in_array('shipping', $skipped) && ( WC()->cart->needs_shipping_address() || wc_ship_to_billing_address_only() )) {
			
			foreach ( $WC_Checkout->get_checkout_fields('shipping') as $key => $field) {
				$data[$key] = isset($data['billing_' . substr($key, 9)]) ? $data['billing_' . substr($key, 9)] : '';
			}
		}


		//////////////////////////////////////////////////
		foreach ($WC_Checkout->get_checkout_fields() as $fieldset_key => $fieldset) {

			if($fieldset_key!=$_POST['type'])
				 continue;
			
			
			if (isset($data['ship_to_different_address'])) {
				if ('shipping' === $fieldset_key && (!$data['ship_to_different_address'] || !WC()->cart->needs_shipping_address() )) {
					continue;
				}
			}

			if (isset($data['createaccount'])) {
				if ('account' === $fieldset_key && ( is_user_logged_in() || (!$WC_Checkout->is_registration_required() && empty($data['createaccount']) ) )) {
					continue;
				}
			}

			foreach ($fieldset as $key => $field) {
				if (!isset($data[$key])) {
					continue;
				}
				$required = !empty($field['required']);
				$format = array_filter(isset($field['validate']) ? (array) $field['validate'] : array() );
				$field_label = isset($field['label']) ? $field['label'] : '';

				switch ($fieldset_key) {
					case 'shipping' :
						/* translators: %s: field name */
						$field_label = sprintf( esc_html__('Shipping %s', 'kapee'), $field_label);
						break;
					case 'billing' :
						/* translators: %s: field name */
						$field_label = sprintf( esc_html__('Billing %s', 'kapee'), $field_label);
						break;
				}

				if (in_array('postcode', $format)) {
					$country = isset($data[$fieldset_key . '_country']) ? $data[$fieldset_key . '_country'] : WC()->customer->{"get_{$fieldset_key}_country"}();
					$data[$key] = wc_format_postcode($data[$key], $country);

					if ('' !== $data[$key] && !WC_Validation::is_postcode($data[$key], $country)) {
						$errors->add('validation', sprintf(__('%s is not a valid postcode / ZIP.', 'kapee'), '<strong>' . esc_html($field_label) . '</strong>'));
					}
				}

				if (in_array('phone', $format)) {
					$data[$key] = wc_format_phone_number($data[$key]);

					if ('' !== $data[$key] && !WC_Validation::is_phone($data[$key])) {
						/* translators: %s: phone number */
						$errors->add('validation', sprintf(__('%s is not a valid phone number.', 'kapee'), '<strong>' . esc_html($field_label) . '</strong>'));
					}
				}

				if (in_array('email', $format) && '' !== $data[$key]) {
					$data[$key] = sanitize_email($data[$key]);

					if (!is_email($data[$key])) {
						/* translators: %s: email address */
						$errors->add('validation', sprintf(__('%s is not a valid email address.', 'kapee'), '<strong>' . esc_html($field_label) . '</strong>'));
						continue;
					}
				}

				if ('' !== $data[$key] && in_array('state', $format)) {
					$country = isset($data[$fieldset_key . '_country']) ? $data[$fieldset_key . '_country'] : WC()->customer->{"get_{$fieldset_key}_country"}();
					$valid_states = WC()->countries->get_states($country);

					if (!empty($valid_states) && is_array($valid_states) && sizeof($valid_states) > 0) {
						$valid_state_values = array_map('wc_strtoupper', array_flip(array_map('wc_strtoupper', $valid_states)));
						$data[$key] = wc_strtoupper($data[$key]);

						if (isset($valid_state_values[$data[$key]])) {
							// With this part we consider state value to be valid as well, convert it to the state key for the valid_states check below.
							$data[$key] = $valid_state_values[$data[$key]];
						}

						if (!in_array($data[$key], $valid_state_values)) {
							/* translators: 1: state field 2: valid states */
							$errors->add('validation', sprintf(__('%1$s is not valid. Please enter one of the following: %2$s', 'kapee'), '<strong>' . esc_html($field_label) . '</strong>', implode(', ', $valid_states)));
						}
					}
				}

				if ($required && '' === $data[$key]) {
					/* translators: %s: field name */
					$errors->add('required-field', apply_filters('woocommerce_checkout_required_field_notice', sprintf(__('%s is a required field.', 'kapee'), '<strong>' . esc_html($field_label) . '</strong>'), $field_label));
				}
			}
		}

		$html = '';
		$valid = TRUE;
		if ($errors->get_error_messages()) {
			$valid = FALSE;
			$html = '<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert">';
			foreach ($errors->get_error_messages() as $message) {
				$html.='<li>' . $message . '</li>';
			}
			$html.='</ul></div>';
		}
		
		wp_send_json(array("valid"=>$valid,"html"=>$html));
		wp_die();
	}
	add_action( 'wp_ajax_kapee_validate_checkout', 'kapee_validate_checkout_callback'  );
	add_action( 'wp_ajax_nopriv_kapee_validate_checkout', 'kapee_validate_checkout_callback' );
}