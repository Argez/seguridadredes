<?php
/**
 * Custom functions for layout.
 *
 * @package Kapee
 */

/**
 * Get layout base on current page
 *
 * @return string
 */
if ( ! function_exists( 'kapee_get_layout' ) ) :
function kapee_get_layout() {
	$layout = kapee_get_option( 'blog-page-layout', 'right-sidebar' );

	if ( kapee_get_post_meta( 'layout' ) ) {		
		$layout = kapee_get_post_meta( 'layout' );
	} elseif ( is_singular( 'post' ) ) {
		$layout = kapee_get_option( 'single-post-layout', 'right-sidebar' );
	} elseif ( is_singular( 'portfolio' ) ) {
		$layout = kapee_get_option( 'single-portfolio-page-layout', 'full-width' );
	} elseif( function_exists( 'kapee_is_wcmp_vendor_page' ) && kapee_is_wcmp_vendor_page() ) {
		$layout = kapee_get_option( 'vendor-page-layout', 'left-sidebar' );
	}elseif( kapee_is_wc_vendor_page() ){
		$layout = kapee_get_option( 'vendor-page-layout', 'left-sidebar' );
	}elseif ( kapee_is_catalog() ) {
		$layout = kapee_get_option( 'shop-page-layout','left-sidebar' );
		$product_columns = kapee_get_loop_prop( 'products-columns' );
		if($product_columns > 4){
			$layout = 'full-width';
		}		
	} elseif(KAPEE_DOKAN_ACTIVE && ( dokan_is_store_page() || dokan_is_product_edit_page() )){
		$layout = 'full-width';
	} elseif( function_exists('kapee_is_wcmp_vendor_page') && kapee_is_wcmp_vendor_page()){
		$layout = 'full-width';
	} elseif ( function_exists('is_product') && is_product() )  {
		$layout = kapee_get_option( 'product-page-layout', 'full-width' );
	} elseif ( function_exists('kapee_full_pages') && kapee_full_pages() )  {
		$layout = 'full-width';
	} elseif ( is_404() ) {
		$layout = 'full-width';
	}elseif ( kapee_is_portfolio() ) {
		$layout = kapee_get_option( 'portfolio-page-layout', 'full-width' );		
	}elseif (  is_singular( 'page' ) ) { 
		$layout = kapee_get_option( 'page-layout', 'full-width' );
	} 
	$layout = !empty($layout) ? $layout : 'full-width';
	return apply_filters( 'kapee_site_layout', $layout );
}
endif;

/**
 * Get sidebar width on current page
 *
 * @return string
 */
if ( ! function_exists( 'kapee_get_sidebar_width' ) ) :
function kapee_get_sidebar_width() {
	$layout = kapee_get_layout();
	$sidebar_width = kapee_get_option( 'blog-sidebar-width', '3' );
	if($layout == 'full-width'){
		$sidebar_width = '';
	}else{
		$meta_sidebar = kapee_get_post_meta( 'sidebar_width' );
		if ( !empty($meta_sidebar) && $meta_sidebar != 'default') {
			$sidebar_width = kapee_get_post_meta( 'sidebar_width' ); 
		} elseif ( is_singular( 'post' ) ) {
			$sidebar_width = kapee_get_option( 'single-post-sidebar-width', '3' );
		} elseif ( is_singular( 'portfolio' ) ) {
			$sidebar_width = kapee_get_option( 'single-portfolio-sidebar-width', '3' );
		} elseif( function_exists( 'kapee_is_wcmp_vendor_page' ) && kapee_is_wcmp_vendor_page() ) {
			$sidebar_width = kapee_get_option( 'vendor-sidebar-width', '3');
		} elseif( kapee_is_wc_vendor_page() ){
			$sidebar_width = kapee_get_option( 'vendor-sidebar-width', '3');
		}elseif ( kapee_is_catalog() ) {
			$sidebar_width = kapee_get_option( 'shop-page-sidebar-width','3' );
		} elseif ( function_exists('is_product') && is_product()  ) {
			$sidebar_width = kapee_get_option( 'product-page-sidebar-width', '3' );
		} elseif ( kapee_is_portfolio() ) {
			$sidebar_width = kapee_get_option( 'portfolio-sidebar-width', '3' );		
		} elseif ( is_singular( 'page' ) ) {			
			$sidebar_width = kapee_get_option( 'page-sidebar-width', '3' );
		} 
	}
	
	return apply_filters( 'kapee_sidebar_width', $sidebar_width );
}
endif;

/**
 * Get sidebar name on current page
 *
 * @return string
 */
if ( ! function_exists( 'kapee_get_sidebar_name' ) ) :
function kapee_get_sidebar_name() {
	$layout = kapee_get_layout();
	$sidebar_widget = kapee_get_option( 'blog-page-sidebar-widget', 'sidebar-1' );
	if($layout == 'full-width'){
		$sidebar_widget = '';
	}else{
		if ( kapee_get_post_meta( 'sidebar_widget' )) {
			$sidebar_widget = kapee_get_post_meta( 'sidebar_widget' );
		} elseif ( is_singular( 'post' ) ) {
			$sidebar_widget = kapee_get_option( 'single-post-sidebar-widget', 'sidebar-1' );
		} elseif ( is_singular( 'portfolio' ) ) {
			$sidebar_widget = kapee_get_option( 'single-portfolio-sidebar-widget', 'sidebar-1' );
		} elseif( function_exists( 'kapee_is_wcmp_vendor_page' ) && kapee_is_wcmp_vendor_page() ) {
			$sidebar_widget = kapee_get_option( 'vendor-page-sidebar-widget', 'shop-page-sidebar' );
		} elseif( kapee_is_wc_vendor_page() ){
			$sidebar_widget = kapee_get_option( 'vendor-page-sidebar-widget', 'shop-page-sidebar' );
		} elseif ( kapee_is_catalog() ) {
			$sidebar_widget = kapee_get_option( 'shop-page-sidebar-widget', 'shop-page-sidebar' );
			$prefix = KAPEE_PREFIX;
			$cat_sidebar    = '';
			if ( function_exists( 'is_product_category' ) && is_product_category() ) {				
				$queried_object = get_queried_object();
				$term_id        = $queried_object->term_id;				
				$cat_sidebar    = get_term_meta( $term_id, $prefix.'sidebar', true );
				$cat_ancestors  = get_ancestors( $term_id, 'product_cat' );
				if ( empty( $cat_sidebar ) && count( $cat_ancestors ) > 0 ) {
					$parent_id   = $cat_ancestors[0];
					$cat_sidebar = get_term_meta( $parent_id, $prefix.'sidebar', true );
				}				
			}
			if( !empty( $cat_sidebar ) ){
				$sidebar_widget  = $cat_sidebar;
			}
			
		} elseif ( function_exists('is_product') && is_product() ) {
			$sidebar_widget = kapee_get_option( 'product-page-sidebar-widget', 'product-page-sidebar' );
		} elseif ( kapee_is_portfolio() ) {
			$sidebar_widget = kapee_get_option( 'portfolio-sidebar-widget', 'sidebar-1' );		
		}
	}
	
	return apply_filters( 'kapee_sidebar_widget', $sidebar_widget );
}
endif;

/**
 * Get Bootstrap column classes for content area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */
if ( ! function_exists( 'kapee_get_content_columns' ) ) :
function kapee_get_content_columns( $layout = null, $sidebar_width = null ) {
	$layout  		= $layout ? $layout : kapee_get_layout();
	$sidebar_width  = $sidebar_width ? $sidebar_width : kapee_get_sidebar_width();
	$classes 		= array( 'col-12', 'col-md-8', 'col-lg-9', 'col-xl-9' );	
	$sidebar_name 	= kapee_get_sidebar_name();
	
	if ( 'full-width' == $layout  || ! is_active_sidebar( $sidebar_name ) ) {
		$classes = array( 'col-md-12' );
	}elseif($sidebar_width == 4){
		$classes = array( 'col-12', 'col-md-8', 'col-lg-8', 'col-xl-8' );
	}

	return apply_filters( 'kapee_content_columns', $classes );
}
endif;

/**
 * Get Bootstrap column classes for sidebar area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */
if ( ! function_exists( 'kapee_get_sidebar_columns' ) ) :
function kapee_get_sidebar_columns( $layout = null, $sidebar_width = null ) {
	$layout  = $layout ? $layout : kapee_get_layout();
	$sidebar_width  = $sidebar_width ? $sidebar_width : kapee_get_sidebar_width();
	$classes = array( 'col-12', 'col-md-4', 'col-lg-3', 'col-xl-3' );

	if($sidebar_width == 4){
		$classes = array( 'col-12', 'col-md-4', 'col-lg-4', 'col-xl-4' );
	}

	return apply_filters( 'kapee_sidebar_columns', $classes );
}
endif;

/**
 * Function to get grid class
 */
if ( ! function_exists( 'kapee_get_grid_class' ) ) :
	function kapee_get_grid_class( $column = '3' ){
		$grid_class = '';
		switch( $column ){
			case 1:
				$grid_class = ' col-12';
				break;
			case 2:
				$grid_class = ' col-12 col-md-6 col-lg-6';
				break;
			case 3:
				$grid_class = ' col-12 col-md-6 col-lg-4';
				break;
			case 4:
				$grid_class = ' col-12 col-md-6 col-lg-3';
				break;
		}
		
		return apply_filters( 'kapee_get_grid_class', $grid_class );
	}
endif;

/**
 * Get Bootstrap reverse class
 *
 * @since  1.0
 *
 * @return string 
 */
if ( ! function_exists( 'kapee_sidebar_reverse' ) ) :
function kapee_sidebar_reverse($echo = true) {
	$layout  = kapee_get_layout();
	$reverse_class = '';
	if($layout == 'left-sidebar'){
		$reverse_class = 'flex-row-reverse';
	}
	if($echo){
		echo apply_filters('kapee_sidebar_reverse',$reverse_class);
	}else{
		return apply_filters('kapee_sidebar_reverse',$reverse_class);
	}
}
endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'kapee_is_catalog' ) ) :
	function kapee_is_catalog() {

		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() || is_tax( 'product_brand' ) ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'kapee_full_pages' ) ) :
	function kapee_full_pages() {

		if ( (function_exists( 'is_cart' )  && is_cart()) ||
			 (function_exists( 'is_checkout' )  && is_checkout()) ||
			 (function_exists( 'is_account_page' )  && is_account_page()) ||
			 (function_exists( 'is_wc_endpoint_url' )  && is_wc_endpoint_url()) || kapee_is_wishlist_page()) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is wishlist page
 *
 * @return bool
 */
if ( ! function_exists( 'kapee_is_wishlist_page' ) ) :
	function kapee_is_wishlist_page() {
		if ( function_exists( 'YITH_WCWL' )) {
			$wishlist_pageid = get_option('yith_wcwl_wishlist_page_id',true);
			global $post;
			if($post){
				$page_id = $post->ID;
				if($page_id == $wishlist_pageid){
					return true;
				}
			} 
		}
		return false;
	}
endif;

/**
 * Check is portfolio
 *
 * @return bool
 */
if ( ! function_exists( 'kapee_is_portfolio' ) ) :
	function kapee_is_portfolio() {

		if (  is_post_type_archive( 'portfolio' ) || is_tax( array('portfolio_cat', 'portfolio_tag') ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Get image size
 *
 * @since  1.0
 *
 * @return string size
 */
if ( ! function_exists( 'kapee_get_post_thumbnail_size' ) ) :
	function kapee_get_post_thumbnail_size() {
		$layout  					=  kapee_get_layout();
		$blog_post_style			= kapee_get_loop_prop( 'blog-post-style' );
		$grid_columns				= kapee_get_loop_prop( 'blog-grid-columns' );
		$blog_custom_image_size		= kapee_get_loop_prop( 'blog-custom-thumbnail-size' );
		
		$size	= 'large';
		if( $layout == 'full-width' && ( $blog_post_style == 'blog-center' ) ){
			$size	= 'full';
		} elseif(	$blog_post_style == 'blog-grid'  && ($layout != 'full-width' || $grid_columns != 'two-columns') ){
			$size	='medium';
		}
		if( ! empty( $blog_custom_image_size ) ){
			$size = $blog_custom_image_size;	 
		}
		return apply_filters( 'kapee_post_thumbnail_size', $size );
	}
endif;

if ( ! function_exists( 'kapee_is_vendor_page' ) ) :
	function kapee_is_vendor_page(){
		
		/* Dokan */
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			return true;
		}

		/* WC Vendor */
		if ( kapee_is_wc_vendor_page() ) {
			return true;
		}	
		
		/* WCMP plugin*/
		if ( function_exists( 'kapee_is_wcmp_vendor_page' ) && kapee_is_wcmp_vendor_page() ) {
			return true;
		}
		
		/* WCFM plugin*/
		if ( function_exists( 'wcfm_is_store_page' ) && wcfm_is_store_page() ) {
			return true;
		}
		return false;
			
	}
endif;

/**
 * Check is vendor page
 *
 * @return bool
 */
if ( ! function_exists( 'kapee_is_wc_vendor_page' ) ) :
	/* WC Vendor */
	function kapee_is_wc_vendor_page() {
	
		if ( class_exists( 'WCV_Vendors' ) && method_exists( 'WCV_Vendors', 'is_vendor_page' ) ) {
			return WCV_Vendors::is_vendor_page();
		}

		return false;
	}
endif;