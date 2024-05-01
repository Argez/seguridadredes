<?php

/**
 * YITH Add to Quote Functions
 *
 * @since  1.0.3
 */
 
if ( function_exists( 'YITH_YWRAQ_Frontend' ) ) {
	remove_action( 'woocommerce_before_single_product', array( YITH_YWRAQ_Frontend(), 'show_button_single_page' ) );
	remove_action( 'woocommerce_single_product_summary', array( YITH_YWRAQ_Frontend(), 'add_button_single_page' ),35 );

	if( ! function_exists( 'kapee_yith_quote_button_single_page' ) ) {
		function kapee_yith_quote_button_single_page(){
			global $product;

		    if( ! $product ){
			    global  $post;
			    if (  ! $post || ! is_object( $post ) || ! is_singular() ) {
				    return;
			    }
			    $product = wc_get_product( $post->ID );
		    }
			
			if( (get_option('ywraq_show_button_near_add_to_cart','no') == 'yes') && $product->is_in_stock() && $product->get_price() !== '' ){
			    if( $product->is_type( 'variable' ) ){
				    add_action( 'woocommerce_after_single_variation', array(  YITH_YWRAQ_Frontend(), 'add_button_single_page' ),30 );
			    }else{ 
				    add_action( 'woocommerce_after_add_to_cart_button', array(  YITH_YWRAQ_Frontend(), 'add_button_single_page' ),100);
			    }
		    }else{
			   add_action( 'woocommerce_single_product_summary', array( YITH_YWRAQ_Frontend(), 'add_button_single_page' ), 35 );
		    }
		} 

		add_action( 'woocommerce_before_single_product', 'kapee_yith_quote_button_single_page');
	}
}