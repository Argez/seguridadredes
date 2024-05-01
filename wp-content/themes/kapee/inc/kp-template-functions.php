<?php
/**
 * Functions to allow styling of the templating system
 *
 * @author 		PressLayouts
 * @package 	kapee/inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sets up the kapee_loop global from the passed args.
 */
function kapee_setup_loop( $args = array() ) {
	
	$default_args = array(
		'name'          						=> 'posts-loop',
		//Blog
		'post-fancy-date'          				=> kapee_get_option( 'post-fancy-date', 0 ),
		'fancy-date-style'          			=> kapee_get_option( 'fancy-date-style','fancy-square-date' ),
		'sticky-post-icon'          			=> kapee_get_option( 'sticky-post-icon', 1 ),
		'post-format-icon'          			=> kapee_get_option( 'post-format-icon', 0 ),
		'post-category'          				=> kapee_get_option( 'post-category', 1 ),
		'post-meta'          					=> kapee_get_option( 'post-meta', 1 ),
		'specific-post-meta'          			=> kapee_get_option( 'specific-post-meta', array( 'post-author', 'post-date' ) ),
		'post-meta-icon'          				=> kapee_get_option( 'post-meta-icon', 0 ),
		'post-meta-separator'          			=> kapee_get_option( 'post-meta-separator', 'meta-separator-dot' ),
		
		//Blog Archive
		'blog-post-style'          				=> kapee_get_option( 'blog-post-style', 'blog-default-center' ),
		'blog-grid-layout'          			=> kapee_get_option( 'blog-grid-layout', 'simple-grid' ),
		'blog-grid-post-style'          		=> kapee_get_option( 'blog-grid-post-style', 'blog-grid-center' ),
		'blog-grid-columns'          			=> kapee_get_option( 'blog-grid-columns', '2' ),
		'blog-post-thumbnail'          			=> kapee_get_option( 'blog-post-thumbnail', 1 ),
		'blog-post-title'          				=> kapee_get_option( 'blog-post-title', 1 ),
		'show-blog-post-content'          		=> kapee_get_option( 'show-blog-post-content', 1 ),
		'blog-post-content'          			=> kapee_get_option( 'blog-post-content', 'full-content' ),
		'blog-excerpt-length'          			=> kapee_get_option( 'blog-excerpt-length', 30 ),
		'read-more-button'          			=> kapee_get_option( 'read-more-button', 1 ),
		'read-more-button-style'          		=> kapee_get_option( 'read-more-button-style', 'read-more-link' ),
		'read-more-text'          				=> kapee_get_option( 'read-more-text', 'Continue Reading' ),
		'blog-pagination-style'          		=> kapee_get_option( 'blog-pagination-style', 'default' ),
		'blog-pagination-load-more-button-text'	=> kapee_get_option( 'blog-pagination-load-more-button-text', 'Load More Posts' ),
		'blog-pagination-finished-message'		=> kapee_get_option( 'blog-pagination-finished-message', 'No More Posts Available...' ),
		
		/* Portfolio Options */
		'portfolio-post-thumbnail'          	=> kapee_get_option( 'portfolio-post-thumbnail', 1 ),
		'portfolio-style'          				=> kapee_get_option( 'portfolio-style', 'portfolio-style-1' ),
		'portfolio-grid-layout'          		=> kapee_get_option( 'portfolio-grid-layout', 'masonry-grid' ),
		'portfolio-grid-gap'          			=> kapee_get_option( 'portfolio-grid-gap', 15 ),
		'portfolio-grid-columns'          		=> kapee_get_option( 'portfolio-grid-columns', 3 ),
		'portfolio-filter'          			=> kapee_get_option( 'portfolio-filter', 1 ),
		'portfolio-per-page'          			=> kapee_get_option( 'portfolio-per-page', 9 ),
		'portfolio-button-icon'          		=> kapee_get_option( 'portfolio-button-icon', 1 ),
		'portfolio-link-icon'          			=> kapee_get_option( 'portfolio-link-icon', 1 ),
		'portfolio-zoom-icon'          			=> kapee_get_option( 'portfolio-zoom-icon', 1 ),
		'portfolio-content-part'          		=> kapee_get_option( 'portfolio-content-part', 1 ),
		'portfolio-category'          			=> kapee_get_option( 'portfolio-category',1 ),
		'portfolio-title'          				=> kapee_get_option( 'portfolio-title', 1 ),
		'portfolio-pagination-style'          	=> kapee_get_option( 'portfolio-pagination-style','default'),
		'portfolio-pagination-load-more-button-text'=> kapee_get_option( 'portfolio-pagination-load-more-button-text','Load More Portfolios' ),
		'portfolio-pagination-finished-message'	=> kapee_get_option( 'portfolio-pagination-finished-message', 'No More Portfolios Available...' ),
		
		/* WooCommerce */
		'product-labels'        				=> kapee_get_option( 'product-labels', 1 ),
		'sale-product-label'        			=> kapee_get_option( 'sale-product-label', 1 ),
		'sale-product-label-after-price'        => kapee_get_option( 'sale-product-label-after-price', 'after-price'),
		'sale-single-product-label-after-price' => kapee_get_option( 'sale-single-product-label-after-price', 'after-price'),
		'sale-product-label-text-options'       => kapee_get_option( 'sale-product-label-text-options', 'percentage' ),
		'sale-product-label-percentage-text'    => kapee_get_option( 'sale-product-label-percentage-text', 'Off' ),
		'sale-product-label-text'        		=> kapee_get_option( 'sale-product-label-text', 'Sale' ),
		'sale-product-label-color'        		=> kapee_get_option( 'sale-product-label-color','#82B440' ),
		'product-new-label'        				=> kapee_get_option( 'product-new-label', 1 ),
		'new-product-label-text'        		=> kapee_get_option( 'new-product-label-text','New' ),
		'product-newness-days'        			=> kapee_get_option( 'product-newness-days', 30 ),
		'new-product-label-color'        		=> kapee_get_option( 'new-product-label-color', '#388e3c' ),
		'featured-product-label'        		=> kapee_get_option( 'featured-product-label', 1 ),
		'featured-product-label-text'        	=> kapee_get_option( 'featured-product-label-text', 'Featured' ),
		'featured-product-label-color'        	=> kapee_get_option( 'featured-product-label-color', '#ff9f00' ),
		'outofstock-product-label'        		=> kapee_get_option( 'outofstock-product-label', 1 ),
		'outofstock-product-label-text'        	=> kapee_get_option( 'outofstock-product-label-text', 'Out Of Stock' ),
		'outofstock-product-label-color'        => kapee_get_option( 'outofstock-product-label-color','#ff6161'),
		'outofstock-product-opacity'        	=> kapee_get_option( 'outofstock-product-opacity', .6 ),
		'products-default-view'          		=> kapee_get_option( 'products-default-view', 'grid-view' ),
		'products-columns'          			=> (int)kapee_get_option( 'products-columns', 4 ),
		'products-element'          			=> '',
		'products-columns-mobile'          		=> (int)kapee_get_option( 'products-columns-mobile', 2 ),
		'products-pagination-style'          	=> kapee_get_option( 'products-pagination-style', 'default' ),
		'products-pagination-load-more-button-text'	=> kapee_get_option( 'products-pagination-load-more-button-text', 'Load More Products' ),
		'products-pagination-finished-message'	=> kapee_get_option( 'products-pagination-finished-message', 'No More Products Available...' ),
		'products-countdown'          			=> kapee_get_option( 'products-countdown', 0 ),
		'product-style'          				=> kapee_get_option( 'product-style','product-style-1' ),
		'product-action-buttons-style'    		=> '',
		'products-hover-image'          		=> kapee_get_option( 'products-hover-image', 1 ),
		'products-category'          			=> kapee_get_option( 'products-category', 1 ),
		'products-title'          				=> kapee_get_option( 'products-title', 1 ),
		'products-rating'          				=> kapee_get_option( 'products-rating', 1 ),
		'products-rating-style'          		=> kapee_get_option( 'products-rating-style', 'fancy-rating' ),
		'products-rating-count'          		=> kapee_get_option( 'products-rating-count', 1 ),
		'products-rating-histogram'          	=> kapee_get_option( 'products-rating-histogram', 1 ),
		'products-price'          				=> kapee_get_option( 'products-price', 1 ),
		'product-quantity-field'       			=> kapee_get_option( 'product-quantity-field', 0 ),
		'products-variations'          			=> kapee_get_option( 'products-variations', 1 ),
		'products-short-description'          	=> kapee_get_option( 'products-short-description', 1 ),
		'products_view'							=> function_exists ( 'kapee_get_products_view' ) ? kapee_get_products_view() : 'grid-view',
		'category-style'						=> kapee_get_option('category-style', 'category-style-1' ),
		'is_quick_view'		                    => false,
		
	);
	
	// Merge any existing values.
	if ( isset( $GLOBALS['kapee_loop'] ) ) {
		$default_args = array_merge( $default_args, $GLOBALS['kapee_loop'] );
	}

	$GLOBALS['kapee_loop'] = wp_parse_args( $args, $default_args );
}
add_action( 'woocommerce_before_shop_loop', 'kapee_setup_loop' );
add_action( 'wp', 'kapee_setup_loop', 10 );

/**
 * Sets a property in the kapee_loop global.
 */
function kapee_set_loop_prop( $prop, $value = '' ) {
	if ( ! isset( $GLOBALS['kapee_loop'] ) ) {
		kapee_setup_loop();
	}
	$GLOBALS['kapee_loop'][ $prop ] = $value;
}

/**
 * Resets the kapee_loop global.
 */
function kapee_reset_loop() {
	unset( $GLOBALS['kapee_loop'] );
}
add_action( 'woocommerce_after_shop_loop', 'woocommerce_reset_loop', 999 );
//add_action( 'loop_end', 'kapee_reset_loop', 999 );

/**
 * Gets a property from the kapee_loop global.
 */
if ( ! function_exists( 'kapee_get_loop_prop' ) ) {
	function kapee_get_loop_prop( $prop, $default = '' ) {

		kapee_setup_loop(); // Ensure post loop is setup.

		$value = isset( $GLOBALS['kapee_loop'], $GLOBALS['kapee_loop'][ $prop ] ) ? $GLOBALS['kapee_loop'][ $prop ] : $default;
		$value = apply_filters( 'kapee_get_loop_prop' , $value, $prop, $GLOBALS['kapee_loop']);
		return apply_filters( 'kapee_get_loop_prop_' . $prop, $value, $prop,$GLOBALS['kapee_loop']) ;
	}
}

/**
 * Adds custom classes to the array of body classes.
 */
function kapee_body_classes( $classes ) {
	
	$classes[] 			= 'kapee-v' . KAPEE_VERSION;
	$classes[] 			= 'wrapper-' . kapee_get_option( 'theme-layout', 'full' );
	$classes[] 			= 'kapee-skin-' . kapee_get_option( 'site-skin', 'light' );
	
	// Owl nav style
	$classes[] 			= kapee_get_option( 'slider-nav-style', 'owl-nav-rectangle' );
	//$classes[] 			= kapee_get_option( 'slider-nav-position', 'owl-nav-middle' );	
	$classes[] 			= 'owl-nav-middle';	
	$classes[] 			= kapee_get_option( 'widget-title-style', 'widget-title-bordered-full' );
	$layout 			= kapee_get_layout();
	
	if( kapee_get_option( 'open-categories-menu', 0 ) && is_front_page() ) {
		$classes[] = 'open-categories-menu';
	}
	
	if( $layout != 'full-width' ) {
		$classes[] = 'has-sidebar';
	}else{
		$classes[] = 'no-sidebar';
	}
	
	if( kapee_get_option( 'skeleton-effect', 0 ) ) {
		$classes[] = 'kapee-skeleton';
	}
	
	if( kapee_get_option( 'widget-toggle', 0 ) ) {
		$classes[] = 'has-widget-toggle';
	}
	
	if( kapee_get_option( 'widget-menu-toggle', 0 ) ) {
		$classes[] = 'has-widget-menu-toggle';
	}
		
	if( kapee_get_option( 'mobile-bottom-navbar', 1 ) ) {
		if( function_exists('is_product') && is_product() ) {
			if( kapee_get_option( 'mobile-product-page-button', 1 ) ){
				$classes[] = 'has-mobile-bottom-navbar-single-page';
			}else{
				$classes[] = 'has-mobile-bottom-navbar';
			}
		}elseif( function_exists('is_cart') && is_cart() ){
			if( kapee_get_option( 'mobile-cart-page-button', 1 ) ) {
				$classes[] = 'has-mobile-bottom-navbar-single-page';
			}else{
				$classes[] = 'has-mobile-bottom-navbar';
			}
		}elseif( function_exists('is_checkout') && is_checkout() ){
			if( kapee_get_option( 'mobile-checkout-page-button', 1 ) ){
				$classes[] = 'has-mobile-bottom-navbar-single-page';
			}else{
				$classes[] = 'has-mobile-bottom-navbar';
			}
		}else{
			$classes[] = 'has-mobile-bottom-navbar';
		}		
	}
	
	if( kapee_get_option( 'sidebar-canvas-mobile', 0 ) ) {
		if( ! kapee_is_vendor_page() ){
			$classes[] = 'has-mobile-canvas-sidebar';
		}
	}elseif( kapee_get_option( 'mobile-bottom-navbar', 1 )  && !kapee_is_vendor_page() ){
		$mobile_elemets = (array) kapee_get_option( 'mobile-navbar-elements',  array(
				'enabled'  => array(
				   'shop'  		=> esc_html__( 'Shop', 'kapee' ),
					'sidebar'  		=> esc_html__( 'Sidebar/Filters', 'kapee' ),
					'wishlist' 		=> esc_html__( 'Wishlist', 'kapee' ),
					'cart'     		=> esc_html__( 'Cart', 'kapee' ),
					'account'  		=> esc_html__( 'Account', 'kapee' ),							
				) ) );
		if(!isset($mobile_elemets['enabled'])){
			$mobile_elemets['enabled'] =  array(
			   'shop'  		=> esc_html__( 'Shop', 'kapee' ),
				'sidebar'  	=> esc_html__( 'Sidebar/Filters', 'kapee' ),
				'wishlist' 	=> esc_html__( 'Wishlist', 'kapee' ),
				'cart'     	=> esc_html__( 'Cart', 'kapee' ),
				'account'  	=> esc_html__( 'Account', 'kapee' ),							
			);
		}		
		if(array_key_exists('sidebar',$mobile_elemets['enabled'])){
			$classes[] = 'has-mobile-canvas-sidebar';
		}
	}
	
	if( kapee_get_option( 'promo-bar', 0 ) && 'bottom' == kapee_get_option( 'promo-bar-position', 'top' ) ) {
		$classes[] = 'has-promo-bar-bottom';
	}

	$classes = apply_filters( 'kapee_body_classes', $classes );
	
	return $classes;
}

/**
 * Adds custom class to the array of posts classes.
 */
function kapee_post_classes( $classes, $class, $post_id ) {
	//$classes[] = 'entry';

	return $classes;
}

/**
 * Display classes for primary div
 */
if ( ! function_exists( 'kapee_primary_class' ) ) :
	function kapee_primary_class( $class = '' ) {
		echo 'class="' . esc_attr( join( ' ', kapee_get_primary_class( $class ) ) ) . '"';
	}
endif;

/**
 * Retrieve the classes for the primary element as an array.
 */
if ( ! function_exists( 'kapee_get_primary_class' ) ) :
	function kapee_get_primary_class( $class = '' ) {
		$classes 		= array();
		$page_id 		= get_the_ID();
		$page_layout 	= get_post_meta( $page_id, KAPEE_PREFIX.'page_sidebar_position', true );
		
		$classes[] = 'content-area';
		
		$content_columns = kapee_get_content_columns();
		if(!empty($content_columns)){
			$classes = array_merge($classes,$content_columns);
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );
		} else {
			$class = array();
		}
		
		$classes = apply_filters( 'kapee_primary_class', $classes, $class );
		$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
	}
endif;


/**
 * Display classes for sidebar div
 */
if ( ! function_exists( 'kapee_sidebar_class' ) ) :
	function kapee_sidebar_class( $class = '' ) {
		echo 'class="' . esc_attr( join( ' ', kapee_get_sidebar_class( $class ) ) ) . '"';
	}
endif;

/**
 * Retrieve the classes for the sidebar as an array.
 */
if ( ! function_exists( 'kapee_get_sidebar_class' ) ) :
	function kapee_get_sidebar_class( $class = '' ) {
		$classes 		= array();
		$classes[] = 'widget-area';
		
		$sidebar_columns = kapee_get_sidebar_columns();		
		if(!empty($sidebar_columns)){
			$classes = array_merge($classes,$sidebar_columns);
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );
		} else {
			$class = array();
		}
		
		$classes = apply_filters( 'kapee_sidebar_class', $classes, $class );

		return array_unique( $classes );
	}
endif;

/**
 * Blog wrapper classes
 */
if( !function_exists( 'kapee_blog_wrapper_classes' ) ):
	function kapee_blog_wrapper_classes() {			
		$classes = array();
		if( 'related-posts' == kapee_get_loop_prop( 'name' ) ){
			
			if( 'slider' == kapee_get_option('related-posts-display', 'slider') ) {
				$classes[] = 'kapee-carousel';
				$classes[] = 'owl-carousel';
				$classes[] ='grid-col-xl-2';
				$classes[] ='grid-col-lg-2';
				$classes[] ='grid-col-md-2';
				$classes[] ='grid-col-sm-1';
				$classes[] ='grid-col-1';
			}else{
				$classes[] = 'items-grid';
			}
			$classes[] = ( kapee_get_option('read-more-button-style', 1) ) ? kapee_get_option('read-more-button-style', 'read-more-link') : '';
		}else{
			$blog_post_style	= kapee_get_loop_prop( 'blog-post-style' );
			$blog_grid_layout	= kapee_get_loop_prop( 'blog-grid-layout' );		
			
			$classes[] ='articles-list';
			if( 'blog-grid' == $blog_post_style && 'posts-slider-shortcode' != kapee_get_loop_prop( 'name' ) ){
				$classes[] ='row';
			}
			
			if( 'masonry-grid' == $blog_grid_layout ){
				wp_enqueue_script( 'isotope' );
				wp_enqueue_script( 'masonry' );
			}	
			
			$classes[] = $blog_post_style;
			if( 'blog-grid' == $blog_post_style ){
				$classes[] = kapee_get_loop_prop( 'blog-grid-post-style' );
				$classes[] = $blog_grid_layout;
			}
			if( 'posts-slider-shortcode' == kapee_get_loop_prop('name') ){
				$classes[] = 'kapee-carousel';
				$classes[] = 'owl-carousel';				
				$classes[] ='grid-col-xl-'.kapee_get_loop_prop( 'rs_extra_large' );
				$classes[] ='grid-col-lg-'.kapee_get_loop_prop( 'rs_large' );
				$classes[] ='grid-col-md-'.kapee_get_loop_prop( 'rs_medium' );
				$classes[] ='grid-col-sm-'.kapee_get_loop_prop( 'rs_small' );
				$classes[] ='grid-col-'.kapee_get_loop_prop( 'rs_extra_small' );
			}
			$classes[] = ( kapee_get_loop_prop( 'read-more-button-style' ) ) ? kapee_get_loop_prop( 'read-more-button-style' ) : '';
		}			
				
		$classes = apply_filters( 'kapee_blog_wrapper_classes', $classes );
		
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', $classes );
		}
		
		echo esc_attr( $classes );
	}
endif;
 
/**
 * Portfolio wrapper classes
 */
if( !function_exists( 'kapee_portfolio_wrapper_classes' ) ):
	function kapee_portfolio_wrapper_classes() {
		
		$classes = array();
		$portfolio_style		= kapee_get_loop_prop( 'portfolio-style' );
		$portfolio_grid_layout	= kapee_get_loop_prop( 'portfolio-grid-layout' );		
		wp_enqueue_script( 'isotope' );
		if( kapee_get_loop_prop('name') == 'related-portfolios'){			
			$classes[] = 'portfolio-style-1';			
			if(kapee_get_option('related-portfolios-display', 'slider') =='slider') {
				$classes[] = 'kapee-carousel';
				$classes[] = 'owl-carousel';
				$classes[] ='grid-col-xl-2';
				$classes[] ='grid-col-lg-2';
				$classes[] ='grid-col-md-2';
				$classes[] ='grid-col-sm-1';
				$classes[] ='grid-col-1';
			}else{
				$classes[] = 'items-grid';
			}
		}else{			
			
			if( kapee_get_loop_prop('name') == 'portfolios-slider-shortcode'){
				$classes[] = 'kapee-carousel';
				$classes[] = 'owl-carousel';
				$classes[] = 'items-grid';				
				$classes[] ='grid-col-xl-'.kapee_get_loop_prop( 'rs_extra_large' );
				$classes[] ='grid-col-lg-'.kapee_get_loop_prop( 'rs_large' );
				$classes[] ='grid-col-md-'.kapee_get_loop_prop( 'rs_medium' );
				$classes[] ='grid-col-sm-'.kapee_get_loop_prop( 'rs_small' );
				$classes[] ='grid-col-'.kapee_get_loop_prop( 'rs_extra_small' );
			}else{
				$classes[] = 'portfolios-list';
				$classes[] = 'row';
			}
			if(  $portfolio_style != 'portfolio-style-1' && $portfolio_style != 'portfolio-style-2' ){
				$classes[] ='gutters-space-'.kapee_get_loop_prop( 'portfolio-grid-gap' );		
			}
			if( !kapee_get_loop_prop( 'portfolio-content-part' )){
				$classes[] ='no-content-part';
			}
			
			if( $portfolio_grid_layout == 'masonry-grid'){
				wp_enqueue_script('masonry');
			}		
			$classes[] = $portfolio_grid_layout;
			$classes[] = kapee_get_loop_prop( 'portfolio-style' );
			if(kapee_get_loop_prop('portfolio-filter')){
				$classes[] = 'portfolio-filter-enabled';
			}
			
		}
		
		$classes = apply_filters( 'kapee_portfolio_wrapper_classes', $classes );
		
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', $classes );
		}
		
		echo esc_attr( $classes );
	}
endif;

/**
 * Checks to see if we're on the homepage or not.
 */
function kapee_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if we're on the homepage or not.
 */
function kapee_site_loader() {
	
	if( ! kapee_get_option( 'site-preloader', 0 ) ) return;
	
	$preloader_style = kapee_get_option('predefine-loader-style', '1' );
	if( 'predefine-loader' == kapee_get_option('preloader-image', 'predefine-loader' ) ){		
		$html = '';
		switch ( $preloader_style ) {
			case '1':
				$html ='<div class="spinner style-'.$preloader_style.'">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>';
				break;
			case '2':
				$html ='<div class="sk-folding-cube style-'.$preloader_style.'">
						<div class="sk-cube1 sk-cube"></div>
						<div class="sk-cube2 sk-cube"></div>
						<div class="sk-cube4 sk-cube"></div>
						<div class="sk-cube3 sk-cube"></div>
					</div>';
				break;
			case '3':
				$html ='<div class="spinner style-'.$preloader_style.'"></div>';
				break;
			case '4':
				$html ='<div class="spinner style-'.$preloader_style.'">						
						<div class="double-bounce1"></div>
						<div class="double-bounce2"></div>
					</div>';
				break;
			case '5':
				$html ='<div class="spinner style-'.$preloader_style.'">						
						<div class="rect1"></div>
						<div class="rect2"></div>
						<div class="rect3"></div>
						<div class="rect4"></div>
						<div class="rect5"></div>
					</div>';
				break;
		}
		$html = '<div class="kapee-site-preloader">'.$html.'</div>';
	}else{		
		$html = '<div class="kapee-site-preloader"></div>';
	}
	
	echo apply_filters( 'kapee_site_preloader', $html, $preloader_style );
}

/**
 * Global
 */
if ( ! function_exists( 'kapee_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function kapee_output_content_wrapper() {
		kapee_get_template( 'template-parts/global/wrapper-start.php' );		
	}
}
if ( ! function_exists( 'kapee_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 */
	function kapee_output_content_wrapper_end() {
		kapee_get_template( 'template-parts/global/wrapper-end.php' );
	}
}
if( ! function_exists( 'kapee_mobile_menu' ) ) {
	/**
	 * Header Mobile menu
	 */
	function kapee_mobile_menu() {
		
		$mobile_primary_menu 		= 'mobile-menu';
		$mobile_categories_menu 	= 'mobile-categories-menu';
		
		if ( ! has_nav_menu( $mobile_primary_menu ) ) {
			$mobile_primary_menu = 'primary';
		}
		
		if ( ! has_nav_menu( $mobile_categories_menu ) ) {
			$mobile_categories_menu = 'categories-menu';
		}
		
		$primary_menu_location 		= apply_filters( 'kapee_mobile_primary_menu_location', $mobile_primary_menu );
		$categories_menu_location 	= apply_filters( 'kapee_mobile_categories_menu_location', $mobile_categories_menu );
		$mobile_signup_text			= apply_filters( 'kapee_mobile_signup_text', esc_html__( 'Login/Signup', 'kapee' ) );
		$mobile_menu_text			= apply_filters( 'kapee_mobile_menu_text', esc_html__('Menu','kapee') );
		$mobile_categories_text		= apply_filters( 'kapee_mobile_categories_text', esc_html__( 'Categories', 'kapee' ) );
		$menu_link 					= get_admin_url( null, 'nav-menus.php' );
		$user_data 					= wp_get_current_user();
		$current_user 				= apply_filters( 'kapee_myaccount_username', $user_data->user_login );	?>		
		<div class="kapee-mobile-menu">
			<div class="mobile-menu-header">
				<?php
				if( KAPEE_WOOCOMMERCE_ACTIVE && kapee_get_option( 'mobile-menu-header-login-register', 1 ) ){
					$dashboard_url	= apply_filters( 'kapee_myaccount_dashboard_url', wc_get_page_permalink( 'myaccount' ) ); 
					if( ! is_user_logged_in() ):?>
						<a class="login-register customer-signinup" href="<?php echo ( kapee_get_option( 'login-register-popup', 1 ) ) ? 'javaScript:void(0)' : esc_url($dashboard_url);?>"><?php echo esc_html($mobile_signup_text);?></a>
					<?php else:?>
						<a class="login-register user-myaccount" href="<?php echo esc_url($dashboard_url);?>"><?php echo esc_html($current_user);?></a>
					<?php endif;?>						
				<?php } ?>
				<a href="#" class="close-sidebar"><?php esc_html_e( 'Close', 'kapee' ); ?></a>
			</div>
			
			<?php if( has_nav_menu( $primary_menu_location ) || has_nav_menu( $categories_menu_location ) ){ ?>
				<div class="mobile-nav-tabs">
					<ul>
						<li class="primary active" data-menu="primary"><span><?php echo esc_html( $mobile_menu_text );?></span></li>
						<?php if ( kapee_get_option( 'mobile-categories-menu', 1 ) && has_nav_menu( 'categories-menu' ) ) { ?>
							<li class="categories" data-menu="categories"><span><?php echo esc_html( $mobile_categories_text );?></span></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
			
			<?php
			// Mobile Primary Menu
			$admin_menu_link = get_admin_url( null, 'nav-menus.php' );
			if ( has_nav_menu( $primary_menu_location ) ) {
				wp_nav_menu( array( 
					'theme_location' 	=> $primary_menu_location,
					'menu_class'      	=> 'mobile-main-menu',
					'container_class'	=> 'mobile-primary-menu mobile-nav-content active',
					'fallback_cb' 		=> '',
					'walker' 			=> new Kapee_Menu_Walker()
				) ); 			
			}else{ ?>
				<div class="mobile-primary-menu mobile-nav-content active">
					<span class="add-navigation-message">
						<?php printf( wp_kses( __('Add your <a href="%s">navigation menu here</a>', 'kapee' ),array( 'a' => array( 'href' => array() )	) )	, $admin_menu_link );	?>
					</span>
				</div>
			<?php }
			
			// Mobile Categories Menu
			if ( kapee_get_option('mobile-categories-menu', 1 ) && has_nav_menu( $categories_menu_location ) ) {
				wp_nav_menu( array( 
					'theme_location' 	=> $categories_menu_location,
					'menu_class'      	=> 'mobile-main-menu',
					'container_class'   => 'mobile-categories-menu mobile-nav-content',
					'fallback_cb' 		=> '',
					'walker' 			=> new Kapee_Menu_Walker()
				) );
			}?>
			
			
			<?php if( kapee_get_option( 'mobile-menu-social-profile', 0 ) ) { ?>
				<div class="kapee-mobile-menu-social">
					<?php kapee_get_template( 'template-parts/header/elements/social-profile' ); ?>
				</div>
			<?php } ?>
			
			<?php if( kapee_get_option( 'header-language-switcher', 1 ) || kapee_get_option( 'header-currency-switcher', 1 ) ) { ?>
				<div class="kapee-mobile-menu-bottom">
					<?php kapee_get_template( 'template-parts/header/elements/language-switcher' ); ?>
					<?php kapee_get_template( 'template-parts/header/elements/currency-switcher' ); ?>
				</div>
			<?php } ?>
			
		</div>
		<?php
	}
}

/**
 * Header
 */
if ( ! function_exists( 'kapee_template_header' ) ) {

	/**
	 * Kapee template header.
	 */
	function kapee_template_header() {

		$args = $class = array();
		
		$header_style 			= kapee_get_post_meta( 'header_style' );
		if(!$header_style || $header_style == 'default'){
			if( kapee_get_option( 'header-select', 'style' ) == 'style' ){
				$header_style 	= kapee_get_option( 'header-style', '1' );
			}else{
				$header_style 	= kapee_get_option( 'header-select', 'builder' );
			}
		}	
		$header_style 			= apply_filters( 'kapee_header_style', $header_style );
		$class[]				= 'header-'.$header_style;
		
		$header_top 			= kapee_get_post_meta( 'header_top' );
		$header 				= kapee_get_post_meta( 'header' );
		$header_transparent 	= kapee_get_post_meta( 'header_transparent' );

		if(!$header_top || $header_top == 'default'){
			$header_top = kapee_get_option( 'header-topbar', 1 );				
		}elseif($header_top == 'enable'){
			$header_top = 1;
		}elseif($header_top == 'disable'){
				$header_top = 0;
		}

		if( ! $header || $header == 'default' ){
			$header = 1;				
		}elseif($header == 'enable'){
			$header = 1;
		}elseif($header == 'disable'){
				$header = 0;
		}

		if( ! $header_transparent || 'default' == $header_transparent ){
			$header_transparent = 0;
			if( kapee_get_option( 'header-transparent', 0 ) ){
				if ( is_front_page() && 'front-page' == kapee_get_option( 'header-transparent-on', 'front-page' ) ) {
					$header_transparent = 1;
				}elseif( 'all-pages' == kapee_get_option( 'header-transparent-on', 'front-page' ) ){
					$header_transparent = 1;
				}
			}
		}elseif( 'enable' == $header_transparent ){
			$header_transparent = 1;
		}elseif( 'disable' == $header_transparent ){
			$header_transparent = 0;
		}
		
		if( KAPEE_WOOCOMMERCE_ACTIVE && is_product() ){
			$header_transparent = 0;
		}
		
		if( $header_transparent ){
			$class[]	= 'header-overlay';
			$class[]	= 'header-color-'.kapee_get_option( 'header-transparent-color', 'dark' );
		}
		
		$args['header_style'] 	= 'header-'.$header_style;
		$args['class']	 		= implode( ' ', array_filter( $class ) );
		$args['header_top'] 	= $header_top;
		$args['header'] 		= $header;
		$args['sticky_header'] 	= kapee_get_option( 'sticky-header', 0 );
		$args['sticky_header_table'] 	= kapee_get_option( 'sticky-header-tablet', 0 );
		$args['sticky_header_mobile'] 	= kapee_get_option( 'sticky-header-mobile', 0 );
		
		if( ! $header ) return;
		
		kapee_get_template( 'template-parts/header/header',$args );
	}
}

if ( ! function_exists( 'kapee_search_popup' ) ) {

	/**
	 * Kapee header search popup.
	 */
	function kapee_search_popup() {
		if( ! kapee_get_option( 'header-search', 1 ) ) {
			return;
		}?>
		<div class="kapee-search-popup">
			<div class="kapee-search-popup-wrap">
				<a href="#" class="close-sidebar"><?php esc_html_e( 'Close', 'kapee' ); ?></a>
				<?php kapee_get_template( 'template-parts/header/elements/ajax-search' );?>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'kapee_header_topbar_left' ) ) {

	/**
	 * Output header topbar left.
	 */
	function kapee_header_topbar_left() {
		$elements = kapee_get_option( 'header-topbar-manager', array ( 'left' => array ( 'language-switcher' => 'Language Switcher', 'currency-switcher' => 'Currency Switcher' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_topbar_right' ) ) {

	/**
	 * Output header topbar right.
	 */
	function kapee_header_topbar_right() {
		$elements = kapee_get_option( 'header-topbar-manager', array ( 'right' => array ( 'topbar-menu' => 'Topbar Menu' ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_main_left' ) ) {

	/**
	 * Output header main left.
	 */
	function kapee_header_main_left() {
		$elements = kapee_get_option( 'header-main-manager', array ( 'left' => array ( 'logo' => 'Logo' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'header', 'custom_html' => 'header-main-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_main_center' ) ) {

	/**
	 * Output header main center.
	 */
	function kapee_header_main_center() {
		$elements = kapee_get_option( 'header-main-manager', array ( 'center' => array ( 'ajax-search' => 'Ajax Search' ) ) );
		
		if ( isset( $elements['center']['placebo'] ) ) {
			unset( $elements['center']['placebo'] );
		}
				
		if ($elements['center']): 
			foreach ($elements['center'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'header', 'custom_html' => 'header-main-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_main_right' ) ) {

	/**
	 * Output header main right.
	 */
	function kapee_header_main_right() {
		$elements = kapee_get_option( 'header-main-manager', array ( 'right' => array ( 'myaccount' => 'My Account', 'cart' => 'Cart' ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'header', 'custom_html' => 'header-main-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_navigation_left' ) ) {

	/**
	 * Output header navigation left.
	 */
	function kapee_header_navigation_left() {
		$elements = kapee_get_option( 'header-navigation-manager', array ( 'left' => array ( 'category-menu' => 'Category Menu' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, ['custom_html' => 'header-navigation-custom-html'] );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_navigation_center' ) ) {

	/**
	 * Output header navigation center.
	 */
	function kapee_header_navigation_center() {
		$elements = kapee_get_option( 'header-navigation-manager', array ( 'center' => array ( 'primary-menu' => 'Primary Menu' ) ) );
		
		if ( isset( $elements['center']['placebo'] ) ) {
			unset( $elements['center']['placebo'] );
		}
				
		if ($elements['center']): 
			foreach ($elements['center'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, ['custom_html' => 'header-navigation-custom-html'] );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_navigation_right' ) ) {

	/**
	 * Output header navigation right.
	 */
	function kapee_header_navigation_right() {
		$elements = kapee_get_option( 'header-navigation-manager', array ( 'right' => array ( ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, ['custom_html' => 'header-navigation-custom-html'] );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_sticky_left' ) ) {

	/**
	 * Output header sticky left.
	 */
	function kapee_header_sticky_left() {
		$elements = kapee_get_option( 'header-sticky-manager', array ( 'left' => array ( 'logo' => 'Logo' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'sticky', 'custom_html' => 'header-sticky-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_sticky_center' ) ) {

	/**
	 * Output header sticky center.
	 */
	function kapee_header_sticky_center() {
		$elements = kapee_get_option( 'header-sticky-manager', array ( 'center' => array ( 'primary-menu' => 'Primary Menu' ) ) );
		
		if ( isset( $elements['center']['placebo'] ) ) {
			unset( $elements['center']['placebo'] );
		}
				
		if ($elements['center']): 
			foreach ($elements['center'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'sticky', 'custom_html' => 'header-sticky-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_sticky_right' ) ) {

	/**
	 * Output header sticky right.
	 */
	function kapee_header_sticky_right() {
		$elements = kapee_get_option( 'header-sticky-manager', array ( 'right' => array ( 'myaccount' => 'My Account','wishlist' => 'Wishlist', 'cart' => 'Cart' ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'sticky', 'custom_html' => 'header-sticky-custom-html' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_left' ) ) {

	/**
	 * Output header mobile left.
	 */
	function kapee_header_mobile_left() {
		$elements = kapee_get_option( 'header-mobile-manager', array ( 'left' => array ( 'mobile-navbar'=> 'Mobile Nav', 'logo' => 'Logo' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_center' ) ) {

	/**
	 * Output header mobile center.
	 */
	function kapee_header_mobile_center() {
		$elements = kapee_get_option( 'header-mobile-manager', array () );
		
		if ( isset( $elements['center']['placebo'] ) ) {
			unset( $elements['center']['placebo'] );
		}
				
		if ($elements['center']): 
			foreach ($elements['center'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_right' ) ) {

	/**
	 * Output header mobile right.
	 */
	function kapee_header_mobile_right() {
		$elements = kapee_get_option( 'header-mobile-manager', array ( 'right' => array ( 'myaccount'=> 'My Account', 'cart' => 'Cart' ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_sticky_left' ) ) {

	/**
	 * Output header mobile sticky left.
	 */
	function kapee_header_mobile_sticky_left() {
		$elements = kapee_get_option( 'header-mobile-sticky-manager', array ( 'left' => array ( 'mobile-navbar' => 'Mobile Nav' ) ) );
		
		if ( isset( $elements['left']['placebo'] ) ) {
			unset( $elements['left']['placebo'] );
		}
				
		if ($elements['left']): 
			foreach ($elements['left'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_sticky_center' ) ) {

	/**
	 * Output header mobile sticky center.
	 */
	function kapee_header_mobile_sticky_center() {
		$elements = kapee_get_option( 'header-mobile-sticky-manager', array ( 'center' => array ( 'ajax-search' => 'Ajax Search' ) ) );
		
		if ( isset( $elements['center']['placebo'] ) ) {
			unset( $elements['center']['placebo'] );
		}
				
		if ($elements['center']): 
			foreach ($elements['center'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_header_mobile_sticky_right' ) ) {

	/**
	 * Output header mobile sticky right.
	 */
	function kapee_header_mobile_sticky_right() {
		$elements = kapee_get_option( 'header-mobile-sticky-manager', array ( 'right' => array ( 'cart' => 'Cart' ) ) );
		
		if ( isset( $elements['right']['placebo'] ) ) {
			unset( $elements['right']['placebo'] );
		}
				
		if ($elements['right']): 
			foreach ($elements['right'] as $element=>$value) {
				kapee_get_template( 'template-parts/header/elements/'.$element, array( 'header_logo' => 'mobile' ) );
			}
		endif;
	}
}

if ( ! function_exists( 'kapee_is_open_categories_menu' ) ) :

	/**
	 * Check categories menu is open in home page or not.
	 */
	function kapee_is_open_categories_menu() {
		
		$return_value = false;
		
		if( is_front_page() && kapee_get_option( 'open-categories-menu', 0 ) ){
			$return_value = true;
		}
		
		return apply_filters('kapee_open_categories_menu', $return_value );
	}
endif;


/**
 * Page Title
 */
if ( ! function_exists( 'kapee_page_title' ) ) :

	/**
	 * Kapee page title.
	 */
	function kapee_page_title() {
		
		// Return if page title disable
		if( (is_front_page() && !is_home())
			|| ( function_exists( 'is_product' ) && is_product() ) 
			|| ( kapee_is_catalog() && !kapee_get_option( 'shop-page-title', 1 )) ) {
			return;
		} 
		
		if( kapee_is_vendor_page() ){
			return;
			
		}
		$prefix 					= KAPEE_PREFIX; // Taking metabox prefix
		$page_title_section 		= kapee_get_post_meta('page_title_section');
		$page_title_style 			= kapee_get_post_meta('page_title_style');
		$title_font_size 			= kapee_get_post_meta('title_font_size');
		$page_heading 				= kapee_get_post_meta('page_heading');
		$breadcrumb 				= kapee_get_post_meta('breadcrumb');
		
		/* Style Param*/
		$title_padding_top 			= kapee_get_post_meta('title_padding_top');
		$title_padding_bottom 		= kapee_get_post_meta('title_padding_bottom');
		$title_bg_color 			= kapee_get_post_meta('title_bg_color');
		$title_color 				= kapee_get_post_meta('title_color'); /* Dark/Light */
		$title_bg_img 				= kapee_get_post_meta('title_bg_img');
		$title_bg_position 			= kapee_get_post_meta('title_bg_position');
		$title_bg_attachment 		= kapee_get_post_meta('title_bg_attachment'); /* Scroll/Fixed */
		$title_bg_repeat 			= kapee_get_post_meta('title_bg_repeat');
		$title_bg_size 				= kapee_get_post_meta('title_bg_size');
		$title_bg_opacity 			= kapee_get_post_meta('title_bg_opacity');
		
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {				
			$queried_object = get_queried_object();
			$term_id        = $queried_object->term_id;				
			$cat_title_bg_img    	= get_term_meta( $term_id, $prefix.'kapee_attachment_id', true );
			$sidebar_title_color    = get_term_meta( $term_id, $prefix.'sidebar_title_color', true );
			
			$cat_ancestors  = get_ancestors( $term_id, 'product_cat' );
			if ( empty( $cat_title_bg_img ) && count( $cat_ancestors ) > 0 ) {
				$parent_id   = $cat_ancestors[0];
				$cat_title_bg_img = get_term_meta( $parent_id, $prefix.'kapee_attachment_id', true );
			}
			
			if( !empty( $cat_title_bg_img ) ){
				$title_bg_img 	= $cat_title_bg_img;
			}
			if( !empty( $sidebar_title_color ) ){
				$title_color 	= $sidebar_title_color;
			}
		}
			
		if( ! $page_title_section || $page_title_section == 'default' ){
			$page_title_section = kapee_get_option( 'page-title-layout', 'center' );				
		}elseif( $page_title_section == 'enable' ){
			$page_title_section = true;
		}elseif( $page_title_section == 'disable' ){
				$page_title_section = false;
		}
		
		if( is_tax() || is_tag() || is_category() || is_date() || is_author() ){
			if( !kapee_get_option( 'blog-page-title', 1 ) && !kapee_get_option( 'blog-page-breadcrumb', 1 )){
				$page_title_section = false;
			}
			
		}
		
		// Return if disabled page title
		if( ! $page_title_section 
			|| 'disable' == $page_title_section ) {
			return;
		}
		
		if( !$page_title_style || $page_title_style == 'default' ){
			$page_title_style = kapee_get_option( 'page-title-layout', 'center' );				
		}
		if( !$title_font_size || $title_font_size == 'default' ){
			$title_font_size = kapee_get_option( 'page-title-size', 'default' );				
		}
		
		if( !$page_heading || $page_heading == 'default' ){
			$page_heading = kapee_get_option( 'page-title', 1 );				
		}elseif( $page_heading == 'enable' ){
			$page_heading = true;
		}elseif( $page_heading == 'disable' ){
			$page_heading = false;
		}
		
		if( ! $breadcrumb || 'default' == $breadcrumb ){
			$breadcrumb = kapee_get_option( 'page-breadcrumbs', 1 );				
		}elseif( 'enable' == $breadcrumb ){
			$breadcrumb = true;
		}elseif( 'disable' == $breadcrumb ){
			$breadcrumb = false;
		}
		if ( is_home() ) {
			$page_heading = (int)kapee_get_option( 'blog-page-title', 1 );			
			$breadcrumb = kapee_get_option( 'blog-page-breadcrumb', 1 );
		}
		if( kapee_is_portfolio() ) {
			$page_heading = (int)kapee_get_option( 'portfolio-page-title', 1 );
			$breadcrumb = (int)kapee_get_option( 'portfolio-page-breadcrumb', 1 );
		}
		$custom_css = array();
		$custom_style = '';
		if( ! empty( $title_padding_top ) ){
			$custom_css[] = 'padding-top:'.$title_padding_top.'px;';
		}
		if( ! empty( $title_padding_bottom ) ){
			$custom_css[] = 'padding-bottom:'.$title_padding_bottom.'px;';
		}
		
		if( !$title_color || $title_color == 'default' ){
			$title_color = kapee_get_option( 'page-title-color', 'dark' );				
		}
		
		if( ! empty( $title_bg_img ) ){
			$image_src = kapee_get_image_src( $title_bg_img, 'full' );
			$custom_css[] = 'background-image:url('.$image_src.');';
			if( ! empty($title_bg_position) && $title_bg_position != 'default' ){
				$title_bg_position =  str_replace('-',' ',$title_bg_position);
				$custom_css[] = 'background-position:'.$title_bg_position.';';
			}
			if( ! empty($title_bg_attachment) && $title_bg_attachment != 'default' ){
				$custom_css[] = 'background-attachment:'.$title_bg_attachment.';';
			}
			if( ! empty($title_bg_repeat) && $title_bg_repeat != 'default' ){
				$custom_css[] = 'background-repeat:'.$title_bg_repeat.';';
			}
			if( ! empty($title_bg_size) && $title_bg_size != 'default' ){
				$custom_css[] = 'background-size:'.$title_bg_size.';';
			}
		}
		if( ! empty( $custom_css ) ){
			$custom_style .= '.page-title-wrapper {';
			$custom_style .= implode(' ',$custom_css);
			$custom_style .= '}';
		}
		if( ! empty( $title_bg_color ) ){
			$custom_css[] = 'background-color:'.$title_bg_color.';';
		}
		
		if( $page_heading || $breadcrumb  ) {
			$args 				= array();
			$class[]			= 'text-'.$page_title_style;
			$class[]			= 'title-size-'.$title_font_size;
			$class[]			= 'color-scheme-'.$title_color;
			$args['class']	 	= implode( ' ', array_filter( $class ) );
			$args['custom_css'] = '';
			$args['custom_css']	= implode( ' ', array_filter( $custom_css ) );
			kapee_get_template( 'template-parts/page-title/page-title', $args );
		}
	}
endif;

if ( ! function_exists( 'kapee_template_page_title' ) ) :

	/**
	 * Kapee template title.
	 */
	function kapee_template_page_title() {
		$page_heading 				= kapee_get_post_meta('page_heading');
		
		if(!$page_heading || $page_heading == 'default'){
			$page_heading = kapee_get_option( 'page-title', 1 );				
		}elseif($page_heading == 'enable'){
			$page_heading = 1;
		}elseif($page_heading == 'disable'){
				$page_heading = 0;
		}
		if( kapee_is_portfolio() ) {
			$page_heading = (int)kapee_get_option( 'portfolio-page-title', 1 );
		}
		if( ! $page_heading ) return;
		$args['tag'] = 'h1';
		if( is_singular('post') ){
			$args['tag'] = 'h2';
		}
		kapee_get_template( 'template-parts/page-title/title',$args);
	}
endif;

if ( ! function_exists( 'kapee_template_breadcrumbs' ) ) :
	/**
	 * Kapee template page breadcrumbs.
	 */
	function kapee_template_breadcrumbs( $args = array() ) {
		
		$breadcrumb	= kapee_get_post_meta('breadcrumb');
		
		if(!$breadcrumb || $breadcrumb == 'default'){
			$breadcrumb = kapee_get_option( 'page-breadcrumbs', 1 );				
		}elseif($breadcrumb == 'enable'){
			$breadcrumb = 1;
		}elseif($breadcrumb == 'disable'){
				$breadcrumb = 0;
		}
		if(kapee_is_portfolio()){
			$breadcrumb = kapee_get_option( 'portfolio-page-breadcrumb', 1 );
		}
		if( is_tax() || is_tag() || is_category() || is_date() || is_author() ){
			$breadcrumb = kapee_get_option( 'blog-page-breadcrumb', 1 );
		}
		if ( is_home()) {
			$breadcrumb = kapee_get_option( 'blog-page-breadcrumb', 1 );
		}
		if( ! $breadcrumb ) return;

		$delimiter = kapee_get_option( 'breadcrumbs-delimiter', 'forward-slash' );
		// use yoast breadcrumbs if enabled
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$yoast_breadcrumbs = yoast_breadcrumb( '', '', false );
			yoast_breadcrumb( '<div class="entry-breadcrumbs">','</div>' );
			if ( $yoast_breadcrumbs ) {
				return $yoast_breadcrumbs;
			}
		}
		
		$args = wp_parse_args( $args, apply_filters( 'kapee_breadcrumb_defaults', array(
			'wrap_before' 		=> '<nav class="kapee-breadcrumb">',
			'wrap_after'  		=> '</nav>',
			'delimiter_before'	=> '<span class="delimiter-sep '.$delimiter.'">',
			'delimiter_after'	=> '</span>',
			'delimiter'   		=> '',
			'before'      		=> '',
			'after'       		=> '',
		) ) );
		$breadcrumbs = new Kapee_Breadcrumb();
		 

		$args['breadcrumb'] = $breadcrumbs->generate();

		/**
		 * WooCommerce Breadcrumb hook
		 *
		 * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
		 */
		do_action( 'kapee_breadcrumb', $breadcrumbs, $args );

		kapee_get_template( 'template-parts/page-title/breadcrumbs',$args );
	}
endif;

/**
 * Footer
 */
if ( ! function_exists( 'kapee_template_footer' ) ) :

	/**
	 * Kapee template footer.
	 */
	function kapee_template_footer() {	
		
		$footer_layout 				= kapee_get_option( 'footer-layout', '2' );
		$footer_layout_data 		= kapee_get_footer_layout($footer_layout);
		$site_footer 				= kapee_get_post_meta('site_footer');
		$footer_copyright 			= kapee_get_post_meta('footer_copyright');
		
		if( !$site_footer || $site_footer == 'default' ){
			$site_footer = kapee_get_option( 'site-footer', 1 );				
		}elseif( $site_footer == 'enable' ){
			$site_footer = 1;
		}elseif( $site_footer == 'disable' ){
				$site_footer = 0;
		}
		if( !$footer_copyright || $footer_copyright == 'default' ){
			$footer_copyright = kapee_get_option( 'footer-copyright', 1 );				
		}elseif( $footer_copyright == 'enable' ){
			$footer_copyright = 1;
		}elseif( $footer_copyright == 'disable' ){
				$footer_copyright = 0;
		}
		if(!kapee_footer_widget_active()){
			$site_footer = 0;
		}
		$args['site_footer'] 	= $site_footer;
		$args['footer_copyright'] 	= $footer_copyright;
		$args['footer_layout_data'] 	= $footer_layout_data;
		
		kapee_get_template( 'template-parts/footer/footer', $args );		
	}
endif;
if ( ! function_exists( 'kapee_footer_widget_active' ) ) :
	/**
	 * Check is footer widget active
	 */
	function kapee_footer_widget_active() {
		if ( is_active_sidebar( 'footer-area-1' ) 
			|| is_active_sidebar( 'footer-area-2' ) 
			|| is_active_sidebar( 'footer-area-3' ) 
			|| is_active_sidebar( 'footer-area-4' ) 
			|| is_active_sidebar( 'footer-area-5' ) ){
			return true;
		}
		return false;
	}
endif;
if ( ! function_exists( 'kapee_back_to_top' ) ) :

	/**
	 * Back to top button.
	 */
	function kapee_back_to_top() {
		if( ! kapee_get_option( 'back-to-top', 1 ) 
			|| ( wp_is_mobile() 
			&& ! kapee_get_option( 'back-to-top-mobile', 1 ) ) ) {
				return; 
		}?>
		
		<div class="kapee-back-to-top">
			<?php esc_html_e('Scroll To Top', 'kapee');?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_mask_overaly' ) ) :

	/**
	 * Close sidebar popup.
	 */
	function kapee_mask_overaly() {?>
	
		<div class="kapee-mask-overaly"></div>
		
	<?php }
endif;

/**
 * Sidebar
 */
if ( ! function_exists( 'kapee_get_sidebar' ) ) :

	/**
	 * Get the kapee sidebar.
	 */
	function kapee_get_sidebar() {
		get_sidebar();
	}
endif;

/**
 * Page
 */
if ( ! function_exists( 'kapee_template_page_content' ) ) :

	/**
	 * Kapee template page content.
	 */
	function kapee_template_page_content() {
		get_template_part( 'template-parts/page/content');
	}
endif;

if ( ! function_exists( 'kapee_template_page_comments' ) ) :

	/**
	 * Kapee template page comments.
	 */
	function kapee_template_page_comments() {
		get_template_part( 'template-parts/page/comments');
	}
endif;

/**
 * Post Loop
 */
if ( ! function_exists( 'kapee_post_loop_start' ) ) :

	/**
	 * Post loop start.
	 */
	function kapee_post_loop_start( $echo = true ) {
				
		ob_start();
		
		kapee_get_template( 'template-parts/post-loop/loop-start.php' );

		if ( $echo ) {
			echo apply_filters( 'kapee_post_loop_start', ob_get_clean() ); // WPCS: XSS ok.
		} else {
			return apply_filters( 'kapee_post_loop_start', ob_get_clean() );
		}		
	}
endif;

if ( ! function_exists( 'kapee_post_loop_end' ) ) :

	/**
	 * Post loop end.
	 */
	function kapee_post_loop_end( $echo = true ) {
		
		ob_start();

		kapee_get_template( 'template-parts/post-loop/loop-end.php' );

		if ( $echo ) {
			echo apply_filters( 'kapee_post_loop_end', ob_get_clean() ); // WPCS: XSS ok.
		} else {
			return apply_filters( 'kapee_post_loop_end', ob_get_clean() );
		}
	}
endif;

if ( ! function_exists( 'kapee_post_wrapper' ) ) {

	/**
	 * Post wrapper.
	 */
	function kapee_post_wrapper() {
		$output='<div class="entry-post">';
		echo apply_filters('kapee_post_wrapper',$output);
	}
}

if ( ! function_exists( 'kapee_post_wrapper_end' ) ) {

	/**
	 * Post wrapper end.
	 */
	function kapee_post_wrapper_end() {
		$output='</div>';
		echo apply_filters('kapee_post_wrapper_end',$output);
	}
}

if ( ! function_exists( 'kapee_template_loop_post_fancy_date' ) ) {

	/**
	 * Loop post fancy date.
	 */
	function kapee_template_loop_post_fancy_date() {
		get_template_part( 'template-parts/post-loop/fancy-date' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_highlight' ) ) {

	/**
	 * Loop post highlight format, sticky.
	 */
	function kapee_template_loop_post_highlight() {
		get_template_part( 'template-parts/post-loop/highlight' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_thumbnail' ) ) {

	/**
	 * Loop post thumbnail.
	 */
	function kapee_template_loop_post_thumbnail() {
		get_template_part( 'template-parts/post-loop/thumbnail' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_header' ) ) {

	/**
	 * Loop post header.
	 */
	function kapee_template_loop_post_header() {
		get_template_part( 'template-parts/post-loop/header' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_category' ) ) {

	/**
	 * Loop post header category.
	 */
	function kapee_template_loop_post_category() {
		get_template_part( 'template-parts/post-loop/category' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_title' ) ) {

	/**
	 * Loop post header title.
	 */
	function kapee_template_loop_post_title() {
		get_template_part( 'template-parts/post-loop/title' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_meta' ) ) {

	/**
	 * Loop post header meta.
	 */
	function kapee_template_loop_post_meta() {
		get_template_part( 'template-parts/post-loop/meta' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_content' ) ) {

	/**
	 * Loop post content.
	 */
	function kapee_template_loop_post_content() {
		get_template_part( 'template-parts/post-loop/content' );		
	}
}

if ( ! function_exists( 'kapee_template_loop_post_footer' ) ) {

	/**
	 * Loop post footer.
	 */
	function kapee_template_loop_post_footer() {
		get_template_part( 'template-parts/post-loop/footer' );		
	}
}

if ( ! function_exists( 'kapee_template_read_more_link' ) ) {

	/**
	 * Loop post readmore link.
	 */
	function kapee_template_read_more_link() {
		get_template_part( 'template-parts/post-loop/readmore' );		
	}
}

if ( ! function_exists( 'kapee_pagination' ) ) {

	/**
	 * Output the pagination.
	 */
	function kapee_pagination() {
		get_template_part( 'template-parts/global/pagination' );
	}
}

/**
 * Single Post
 */
if ( ! function_exists( 'kapee_template_single_post_fancy_date' ) ) {

	/**
	 * Single post fancy date.
	 */
	function kapee_template_single_post_fancy_date() {
		get_template_part( 'template-parts/single-post/fancy-date' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_highlight' ) ) {

	/**
	 * Single post highlight format, sticky.
	 */
	function kapee_template_single_post_highlight() {
		get_template_part( 'template-parts/single-post/highlight' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_thumbnail' ) ) {

	/**
	 * Single post thumbnail.
	 */
	function kapee_template_single_post_thumbnail() {
		get_template_part( 'template-parts/single-post/thumbnail/thumbnail', get_post_format() );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_header' ) ) {

	/**
	 * Single post header.
	 */
	function kapee_template_single_post_header() {
		get_template_part( 'template-parts/single-post/header' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_category' ) ) {

	/**
	 * Single post header category.
	 */
	function kapee_template_single_post_category() {
		get_template_part( 'template-parts/single-post/category' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_title' ) ) {

	/**
	 * Single post header title.
	 */
	function kapee_template_single_post_title() {
		get_template_part( 'template-parts/single-post/title' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_meta' ) ) {

	/**
	 * Single post header meta.
	 */
	function kapee_template_single_post_meta() {
		get_template_part( 'template-parts/single-post/meta' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_content' ) ) {

	/**
	 * Single post content.
	 */
	function kapee_template_single_post_content() {
		get_template_part( 'template-parts/single-post/content' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_footer' ) ) {

	/**
	 * Single post footer.
	 */
	function kapee_template_single_post_footer() {
		get_template_part( 'template-parts/single-post/footer' );		
	}
}

if ( ! function_exists( 'kapee_template_single_tag_social_share' ) ) {

	/**
	 * Single post Tags & Social share.
	 */
	function kapee_template_single_tag_social_share() {
		
		$args = array();
		$args['is_tag_enable'] 		= kapee_get_option( 'single-post-tag', 1 );
		$args['is_share_enable'] 	= kapee_get_option( 'single-post-social-share-link', 1 );
		$args['social_icons_style'] = kapee_get_option( 'social-sharing-icons-style','icons-bordered' );
		$args['social_icons_shape'] = kapee_get_option( 'sharing-icons-shape','icons-shape-circle' );
		$args['social_icons_size']  = kapee_get_option( 'sharing-icons-size','icons-size-default' );
		
		kapee_get_template( 'template-parts/single-post/tags-social-share', $args );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_author_bios' ) ) {

	/**
	 * Single post author bios.
	 */
	function kapee_template_single_post_author_bios() {
		get_template_part( 'template-parts/single-post/author-bios' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_navigation' ) ) {

	/**
	 * Single post navigation.
	 */
	function kapee_template_single_post_navigation() {
		get_template_part( 'template-parts/single-post/navigation' );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_related' ) ) {

	/**
	 * Single related posts.
	 */
	function kapee_template_single_post_related( $args = array() ) {
		
		if ( ! kapee_get_option('single-post-related', 1) ) return;
		
		$post_id = get_the_id();
		$taxonomy = kapee_get_option('related-posts-taxonomy', 'post_tag');
		
		$defaults = array (
			'post_type'     	 	=> 'post',
			'post_status' 			=> array( 'publish' ),
			'ignore_sticky_posts'	=> true,
			'post__not_in' 			=> array($post_id),
			'showposts' 			=> kapee_get_option('show-related-posts', 6),
			'orderby' 				=> kapee_get_option('related-posts-orderby', 'rand'),
			'order' 				=> kapee_get_option('related-posts-order', 'DESC'),
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		$taxs = get_the_terms($post_id, $taxonomy);
		
		if ( $taxs ) {
			$tax_ids = array();
			foreach( $taxs as $tag ) $tax_ids[] = $tag->term_id;			
		}

		if( !empty($tax_ids) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'id',
					'terms' => $tax_ids
				)
			);
		}
		
		$query 	= new WP_Query( apply_filters( 'kapee_related_posts_args', $args ) );
		
		$args['related_posts'] = $query;
		
		$unique_id = kapee_uniqid('section-');		
		global $kapee_owlparam;
		$slider_data = shortcode_atts( kapee_slider_options() ,array(
				'slider_margin'		=> 30,			
				'rs_extra_large'	=> 2,			
				'rs_large'     		=> 2,			
				'rs_medium'     	=> 2,
				'rs_small'     		=> 2,			
				'rs_extra_small'	=> 1,			
			));
		$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
		
		$args['unique_id'] = $unique_id;

		// Set global loop values.
		kapee_set_loop_prop( 'name', 'related-posts' );
		kapee_set_loop_prop( 'blog-custom-thumbnail-size','medium');
		kapee_set_loop_prop( 'specific-post-meta', array( 'post-author', 'post-date' ) );
		kapee_get_template( 'template-parts/single-post/related.php', $args );		
	}
}

if ( ! function_exists( 'kapee_template_single_post_comments' ) ) {

	/**
	 * Single post comments.
	 */
	function kapee_template_single_post_comments() {
		get_template_part( 'template-parts/single-post/comments' );		
	}
}

/**
 * Portfolio Loop
 */
if ( ! function_exists( 'kapee_portfolio_loop_start' ) ) :

	/**
	 * Portfolio loop start.
	 */
	function kapee_portfolio_loop_start( $echo = true ) {
		ob_start();

		kapee_get_template( 'template-parts/portfolio-loop/loop-start.php' );

		if ( $echo ) {
			echo apply_filters( 'kapee_portfolio_post_loop_start', ob_get_clean() ); // WPCS: XSS ok.
		} else {
			return apply_filters( 'kapee_portfolio_post_loop_start', ob_get_clean() );
		}		
	}
endif;

if ( ! function_exists( 'kapee_portfolio_loop_end' ) ) :
	/**
	 * Portfolio loop end.
	 */
	function kapee_portfolio_loop_end( $echo = true ) {
		
		ob_start();

		kapee_get_template( 'template-parts/portfolio-loop/loop-end.php' );

		if ( $echo ) {
			echo apply_filters( 'kapee_portfolio_post_loop_end', ob_get_clean() ); // WPCS: XSS ok.
		} else {
			return apply_filters( 'kapee_portfolio_post_loop_end', ob_get_clean() );
		}
	}
endif;

if ( ! function_exists( 'kapee_template_portfolio_filter' ) ) {
	/**
	 * Portfolio filter.
	 */
	function kapee_template_portfolio_filter() {
		get_template_part( 'template-parts/portfolio-loop/filter' );		
	}
}

if ( ! function_exists( 'kapee_template_portfolio_loop_thumbnail' ) ) {
	/**
	 * Portfolio loop thumbnail.
	 */
	function kapee_template_portfolio_loop_thumbnail() {
		get_template_part( 'template-parts/portfolio-loop/thumbnail' );		
	}
}

if ( ! function_exists( 'kapee_template_portfolio_loop_action_icon' ) ) {
	/**
	 * Portfolio loop action icon.
	 */
	function kapee_template_portfolio_loop_action_icon() {
		get_template_part( 'template-parts/portfolio-loop/action-icon' );		
	}
}

if ( ! function_exists( 'kapee_template_portfolio_loop_header' ) ) {
	/**
	 * Portfolio loop header.
	 */
	function kapee_template_portfolio_loop_header() {
		get_template_part( 'template-parts/portfolio-loop/header' );		
	}
}

if ( ! function_exists( 'kapee_template_portfolio_loop_categories' ) ) {
	/**
	 * Portfolio loop header category.
	 */
	function kapee_template_portfolio_loop_categories() {
		get_template_part( 'template-parts/portfolio-loop/category' );		
	}
}

if ( ! function_exists( 'kapee_template_portfolio_loop_title' ) ) {
	/**
	 * Portfolio loop header title.
	 */
	function kapee_template_portfolio_loop_title() {
		get_template_part( 'template-parts/portfolio-loop/title' );		
	}
}

if ( ! function_exists( 'kapee_portfolio_pagination' ) ) {
	/**
	 * Output the pagination.
	 */
	function kapee_portfolio_pagination() {
		get_template_part( 'template-parts/global/pagination' );
	}
}

/**
 * Single Portfolio
 */

if ( ! function_exists( 'kapee_template_single_portfolio_image' ) ) {
	/**
	 * Output the portfolio image/gallery.
	 */
	function kapee_template_single_portfolio_image() {
		$show_portfolio_gallery 	= kapee_get_post_meta('show_portfolio_gallery');
		$portfolio_gallery_style 	= kapee_get_post_meta('portfolio_gallery_style');
		$attachment_ids 	= get_post_meta( get_the_ID(), KAPEE_PREFIX.'gallery_images' );
		$is_gallery_style = 1;
		
		if(!$show_portfolio_gallery || $show_portfolio_gallery == 'default'){
			$is_gallery_style = kapee_get_option('single-portfolio-gallery', 1);				
		}elseif($show_portfolio_gallery == 'gallery'){
			$is_gallery_style = 1;
		}elseif($show_portfolio_gallery == 'thumbnail'){
			$is_gallery_style = 0;
		}
		if($is_gallery_style){
			if(!$portfolio_gallery_style || $portfolio_gallery_style == 'default'){
				$portfolio_gallery_style = kapee_get_option('single-portfolio-gallery-style', 'slider');				
			}
		}
		$thumbnail_size		= apply_filters( 'kapee_single_portfolio_image_size', ( kapee_get_option('single-portfolio-layout', '8' ) == '12' ? 'full' : 'large' ) );
		$post_thumbnail_id 	= get_post_thumbnail_id( get_the_ID() );
		
		$carousel_classes 	= array();
		if( ! empty ( $attachment_ids ) && $is_gallery_style){
			$carousel_classes	= ( ! empty ($attachment_ids ) && $portfolio_gallery_style == 'slider' ? array('kapee-gallery-carousel', 'owl-carousel') : array( 'row', 'gallery-grid' ) );
		}
		$wrapper_classes	= apply_filters( 'kapee_single_portfolio_image_classes', array_merge( array(
			'kapee-portfolio-image',
			( has_post_thumbnail() ? 'with-images' : 'without-images' ),
		), $carousel_classes) );
		$args['thumbnail_size'] 	=  $thumbnail_size;
		$args['is_gallery_style'] 	=  $is_gallery_style;
		$args['gallery_style'] 		=  $portfolio_gallery_style;
		$args['post_thumbnail_id'] 	=  $post_thumbnail_id;
		$args['attachment_ids'] 	=  $attachment_ids;
		$args['wrapper_classes'] 	=  $wrapper_classes;
		
		kapee_get_template( 'template-parts/single-portfolio/portfolio-image',$args );
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_title' ) ) {
	/**
	 * Output the portfolio title.
	 */
	function kapee_template_single_portfolio_title() {
		
		kapee_get_template( 'template-parts/single-portfolio/title' );
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_content' ) ) {
	/**
	 * Output the portfolio content.
	 */
	function kapee_template_single_portfolio_content() {
		
		kapee_get_template( 'template-parts/single-portfolio/content' );
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_preview' ) ) {
	/**
	 * Output the portfolio preview.
	 */
	function kapee_template_single_portfolio_preview() {
		
		$args['website_url']	= get_post_meta( get_the_ID(), KAPEE_PREFIX.'website_url', true );
		
		kapee_get_template( 'template-parts/single-portfolio/preview', $args );
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_client' ) ) {
	/**
	 * Output the portfolio client.
	 */
	function kapee_template_single_portfolio_client() {		
		
		$args['client']	= get_post_meta( get_the_ID(), KAPEE_PREFIX.'client_name', true );
		
		kapee_get_template( 'template-parts/single-portfolio/client', $args);
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_date' ) ) {
	/**
	 * Output the portfolio date.
	 */
	function kapee_template_single_portfolio_date() {
				
		kapee_get_template( 'template-parts/single-portfolio/date');
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_category' ) ) {
	/**
	 * Output the portfolio categories.
	 */
	function kapee_template_single_portfolio_category() {
				
		kapee_get_template( 'template-parts/single-portfolio/category');
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_skill' ) ) {
	/**
	 * Output the portfolio skill.
	 */
	function kapee_template_single_portfolio_skill() {
				
		kapee_get_template( 'template-parts/single-portfolio/skill');
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_share' ) ) {
	/**
	 * Output the portfolio share.
	 */
	function kapee_template_single_portfolio_share() {
		
		if ( ! kapee_get_option('single-portfolio-share', 1) ) return;
		
		$args = array();
		$args['social_icons_style'] = kapee_get_option( 'social-sharing-icons-style','icons-bordered' );
		$args['social_icons_shape'] = kapee_get_option( 'sharing-icons-shape','icons-shape-circle' );
		$args['social_icons_size']  = kapee_get_option( 'sharing-icons-size','icons-size-default' );		
				
		kapee_get_template( 'template-parts/single-portfolio/share', $args );
	}
}

/**
 * Get HTML for a gallery image.
 *
 * @return string
 */
function kapee_get_gallery_image_html( $attachment_id, $thumbnail_size, $gallery_style='' ) {	
	$grid_classes	='';
	if( $gallery_style == 'grid' ){
		$grid_classes = 'col-12 col-sm-6';
	}elseif( $gallery_style == 'one-column' ){
		$grid_classes = 'col-12 col-sm-12';
	}
	
	$grid_classes	= apply_filters( 'kapee_post_gallery_grid_classes', $grid_classes );
	$full_size		= apply_filters( 'kapee_post_gallery_full_size', 'full' );
	$full_src       = wp_get_attachment_image_src( $attachment_id, $full_size );
	$image     		= wp_get_attachment_image( $attachment_id, $thumbnail_size );
	
	return '<div class="kapee-post-gallery__image '.$grid_classes.'"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
}
 
if ( ! function_exists( 'kapee_template_single_portfolio_navigation' ) ) {
	/**
	 * Output the navigation.
	 */
	function kapee_template_single_portfolio_navigation() {
		get_template_part( 'template-parts/single-portfolio/navigation' );
	}
}

if ( ! function_exists( 'kapee_template_single_related_portfolio' ) ) {
	/**
	 * Output related the portfolio.
	 */
	function kapee_template_single_related_portfolio( $args =array() ) {
		
		if ( ! kapee_get_option( 'single-portfolio-related', 1 ) ) return;
		
		$post_id = get_the_id();
		$taxonomy = kapee_get_option('related-portfolios-taxonomy', 'portfolio_cat');
		
		$defaults = array (
			'post_type'     	 	=> 'portfolio',
			'post_status' 			=> array( 'publish' ),
			'ignore_sticky_posts'	=> true,
			'post__not_in' 			=> array($post_id),
			'showposts' 			=> kapee_get_option('show-related-portfolios', 6),
			'orderby' 				=> kapee_get_option('related-portfolios-orderby', 'rand'),
			'order' 				=> kapee_get_option('related-portfolios-order', 'DESC'),
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		$taxs = get_the_terms($post_id, $taxonomy);
		
		if ( $taxs ) {
			$tax_ids = array();
			foreach( $taxs as $tag ) $tax_ids[] = $tag->term_id;			
		}

		if( !empty($tax_ids) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'id',
					'terms' => $tax_ids
				)
			);
		}
		
		$query 	= new WP_Query( apply_filters( 'kapee_related_portfolios_args', $args ) );
		
		$args['related_portfolios'] = $query;
		
		$unique_id = kapee_uniqid('section-');		
		global $kapee_owlparam;
		$slider_data = shortcode_atts(kapee_slider_options(),array(
				'slider_margin'		=> 30,		
				'rs_extra_large'	=> 3,			
				'rs_large'     		=> 3,			
				'rs_medium'     	=> 2,
				'rs_small'     		=> 2,			
				'rs_extra_small'	=> 1,		
			));
		$kapee_owlparam['owlCarouselArg'][$unique_id] = $slider_data;
		$args['unique_id'] = $unique_id;

		// Set global loop values.
		kapee_set_loop_prop( 'name', 'related-portfolios' );
		if(kapee_get_option('related-portfolios-display', 'slider') =='grid'){
			kapee_set_loop_prop( 'portfolio-grid-layout','simple-grid');
			kapee_set_loop_prop( 'portfolio-grid-columns',3);
		}
		kapee_get_template( 'template-parts/single-portfolio/related.php', $args );
	}
}

if ( ! function_exists( 'kapee_template_single_portfolio_comments' ) ) {
	/**
	 * Output portfolio the comments.
	 */
	function kapee_template_single_portfolio_comments() {
		get_template_part( 'template-parts/single-portfolio/comments' );
	}
}

if ( ! function_exists( 'kapee_newsletter_popup' ) ) {	
	/**
	 * Newsletter Popup.
	 */
	function kapee_newsletter_popup(){
		
		if( ! kapee_get_option( 'newsletter-popup', 0 ) ) { return; }
		
		if( 'front-page' == kapee_get_option( 'newsletter-popup-on', 'all-pages' ) && !is_front_page() ){
			return;
		}
		
		$color 				= 'color-scheme-'.kapee_get_option( 'newsletter-color', 'light' );
		$content 			= kapee_get_option('newsletter-tag-line', 'Signup today for free and be the first to hear of special </br> promotions, new arrivals and designer news.');
		
		if( !class_exists( 'WooCommerce' ) ) { 
			wp_enqueue_script( 'cookie' ); 
		}?>
		
		<div class="kapee-newsletter-popup mfp-hide <?php echo esc_attr($color);?>">		
			<div class="kapee-newsletter-inner">				
				<div class="newsletter-text">
					<h2 class="newsltter-title"><?php echo esc_html( kapee_get_option('newsletter-title', 'Sign Up & Get 40% Off') );?></h2>
					<p class="tag-line"><?php echo do_shortcode( $content );?></p>
				</div>
				<div class="newsletter-form">
					<?php if( function_exists( 'mc4wp_show_form' ) ) {
						mc4wp_show_form();
					}?>
					<div class="checkbox-group form-group-top clearfix">
					  <input type="checkbox" id="newsletter-donotshow" value="do-not-show">
					  <label for="newsletter-donotshow"> 
						<span class="check"></span>
						<span class="box"></span>
						<?php echo esc_html( kapee_get_option('newsletter-dont-show', 'Don\'t show this popup again') );?>
					  </label>
					</div>
				</div>
			</div>  	  
		</div>
		<?php
	}
}

if ( ! function_exists( 'kapee_coming_soon_redirect' ) ) {	
	/**
	 *  Comming Soon
	 */
	function kapee_coming_soon_redirect(){
		
		$is_maintenance 	= kapee_get_option( 'maintenance-mode', 0 );
		$maintenance_page 	= kapee_get_option( 'maintenance-page', 0 );
		
        // Dont't show coming soon page if not coming soon mode on or  is user logged in.
        if ( is_user_logged_in() || !$is_maintenance ) {
            return;
        }
		if ( !is_page( $maintenance_page ) && $is_maintenance && $maintenance_page && !current_user_can('edit_posts') && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ){
            wp_redirect( esc_url( home_url( 'index.php?page_id='.$maintenance_page) ) );
            exit();
        }
	}
}

if ( ! function_exists( 'kapee_mobile_bottom_navbar' ) ) {	
	/**
	 * Mobile Bottom Navbar.
	 */
	function kapee_mobile_bottom_navbar(){
		
		if( ! apply_filters( 'kapee_mobile_bottom_navbar', true ) || ! kapee_get_option( 'mobile-bottom-navbar', 1 ) ) {
			return; 
		}
		
		$mobile_elemets = (array) kapee_get_option( 'mobile-navbar-elements',  array(
                    'enabled'  => array(
                        'shop'  		=> esc_html__( 'Shop', 'kapee' ),
						'sidebar'  		=> esc_html__( 'Sidebar/Filters', 'kapee' ),
						'wishlist' 		=> esc_html__( 'Wishlist', 'kapee' ),
						'cart'     		=> esc_html__( 'Cart', 'kapee' ),
						'account'  		=> esc_html__( 'Account', 'kapee' ),				
                    ) ) );
		
		if ( isset( $mobile_elemets['enabled']['placebo'] ) ) {
			unset( $mobile_elemets['enabled']['placebo'] );
		}
		if(!isset($mobile_elemets['enabled'])){
			$mobile_elemets['enabled'] =  array(
			   'shop'  		=> esc_html__( 'Shop', 'kapee' ),
				'sidebar'  	=> esc_html__( 'Sidebar/Filters', 'kapee' ),
				'wishlist' 	=> esc_html__( 'Wishlist', 'kapee' ),
				'cart'     	=> esc_html__( 'Cart', 'kapee' ),
				'account'  	=> esc_html__( 'Account', 'kapee' ),							
			);
		}	
		if( empty( $mobile_elemets['enabled'] ) ){
			return;
		}
		
		$args['navbar_class']	= ' navbar-color-'.kapee_get_option( 'mobile-navbar-color', 'light' );
		$args['navbar_class']	.= ( !kapee_get_option( 'mobile-navbar-label', 1 ) ) ? ' navbar-label-hide' : '';
		
		foreach ( $mobile_elemets['enabled'] as $element => $value ) {
			$element_args = array();
			switch ( $element ) {
				case 'shop':
					if ( ! function_exists( 'is_shop' ) ) {
						continue 2;
					}
					$element_args['link'] 	= get_permalink( get_option( 'woocommerce_shop_page_id' ) );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-shop', 'pls-home' );
					$element_args['label'] 	= kapee_get_option( 'mobile-navbar-label-shop', esc_html__( 'shop', 'kapee' ) );
					$element_args['class'] 	= 'item-shop';					
					break;
				case 'wishlist':
					if ( ! function_exists( 'YITH_WCWL' ) ) {
						continue 2;
					}		
					$wishlist_page_id 		= get_option( 'yith_wcwl_wishlist_page_id' );
					$wishlist_url 			= YITH_WCWL()->get_wishlist_url();
					$element_args['link'] 	= apply_filters('kapee_myaccount_wishlist_url', $wishlist_url );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-wishlist', 'pls-heart' );
					$element_args['count'] 	= YITH_WCWL()->count_products();
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-wishlist',esc_html__( 'Wishlist', 'kapee' ) );
					$element_args['class'] 	= 'item-wishlist';					
					if ( is_page( $wishlist_page_id ) ) {
						$element_args['class'] .= ' active';
					}
					break;			
				case 'cart':
					if( ! KAPEE_WOOCOMMERCE_ACTIVE || kapee_get_option( 'catalog-mode', 0 ) || ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price',0 ) ) ){
						continue 2;
					}					
					$element_args['link'] 	= wc_get_cart_url();
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-cart', 'pls-handbag' );
					$element_args['count'] 	= is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-cart', esc_html__( 'Cart', 'kapee' ) );
					$element_args['class'] 	= 'item-cart header-cart';
					if ( function_exists( 'is_cart' ) && is_cart() ) {
						$element_args['class'] .= ' active';
					}
					break;
				case 'account':
					if( ! KAPEE_WOOCOMMERCE_ACTIVE ){
						continue 2;
					}
					$element_args['link'] 	= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-account', 'pls-user' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-account', esc_html__( 'Account', 'kapee' ) );
					$element_args['class'] 	= 'item-account';	
					if( ! is_user_logged_in() ){
						$element_args['class'] 	.= ' customer-signinup';	
					}
					if ( is_account_page() ) {
						$element_args['class'] .= ' active';
					}
					break;
				case 'home':
					$element_args['link'] 	= home_url( '/' );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-home', 'pls-home' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-home', esc_html__( 'Home', 'kapee' ));
					$element_args['class'] 	= 'item-home';					
					if ( is_front_page() ) {
						$element_args['class'] .= ' active';
					}
					break;
				case 'menu':
					$element_args['link'] 	= '#';
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-menu', 'pls-menu' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-menu', esc_html__( 'Menu', 'kapee' ) );
					$element_args['class'] 	= 'item-menu navbar-toggle';					
					break;
				case 'category':
					$element_args['link'] 	= '#';
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-category', 'pls-categories' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-category', esc_html__( 'Category', 'kapee' ) );
					$element_args['class'] 	= 'item-category';					
					break;
				case 'compare':
					if ( ! class_exists( 'YITH_Woocompare' ) ) {
						continue 2;
					}
					$element_args['link'] 	= '#';
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-compare', 'pls-shuffle' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-compare', esc_html__( 'Compare', 'kapee' ) );
					$element_args['class'] 	= 'yith-woocompare-open';					
					break;
				case 'sidebar':
					if( 'full-width' == kapee_get_layout() || ! kapee_get_option( 'canvas-sidebar-mobile', 1 ) ) {
						continue 2;
					}
					if( function_exists('kapee_is_vendor_page') && kapee_is_vendor_page()){
						continue 2;
					}
					if( kapee_is_catalog() ){												
						$element_args['link'] 	= '#';
						$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-filter', 'pls-equalizer' );
						$element_args['label'] 	= kapee_get_option('mobile-navbar-label-filter', esc_html__( 'Filters', 'kapee' ) );
						$element_args['class'] 	= 'item-sidebar kp-canvas-sidebar';
					}else{						
						$element_args['link'] 	= '#';
						$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-sidebar', 'pls-sidebar' );
						$element_args['label'] 	= kapee_get_option('mobile-navbar-label-sidebar', esc_html__( 'Sidebar', 'kapee' ) );
						$element_args['class'] 	= 'item-sidebar kp-canvas-sidebar';
					}						
					break;
				case 'search':
					$element_args['link'] 	= '#';
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-search', 'pls-magnifier' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-search', esc_html__( 'Search', 'kapee' ) );
					$element_args['class'] 	= 'item-search';					
					break;
				case 'order':
					if( ! KAPEE_WOOCOMMERCE_ACTIVE ){
						continue 2;
					}
					$orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
					$account_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
					if ( substr( $account_page_url, - 1, 1 ) != '/' ) {
						$account_page_url .= '/';
					}
					$orders_url   			= $account_page_url . $orders;					
					$element_args['link'] 	= apply_filters('kapee_myaccount_orders_url', $orders_url  );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-order', 'pls-letter' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-order', esc_html__( 'Order', 'kapee' ) );
					$element_args['class'] 	= 'item-order';	
					break;
				case 'order-tracking':
					if( ! KAPEE_WOOCOMMERCE_ACTIVE ){
						continue 2;
					}
					$tracking_pageid		= kapee_get_option('order-tracking-page', '');
					if( empty( $tracking_pageid ) ){
						continue 2;
					}
					$order_tracking_url		= apply_filters('kapee_myaccount_order_tracking_url', ( ! empty ( $tracking_pageid ) ) ? get_permalink( $tracking_pageid ) : '' );
					$element_args['link'] 	= $order_tracking_url;
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-order-tracking', 'pls-plane' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-order-tracking', esc_html__( 'Order Tracking', 'kapee' ) );
					$element_args['class'] 	= 'item-order';					
					break;
				case 'blog':
					$element_args['link'] 	= get_permalink( get_option( 'page_for_posts' ) );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-label-icon-blog', 'pls-note' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-label-blog', esc_html__( 'Blog', 'kapee' ) );
					$element_args['class'] 	= 'item-blog';					
					break;
				case 'custom_link1':
					$element_args['link'] 	= kapee_get_option( 'mobile-navbar-custom-link1-url', '' );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-custom-link1-icon', '' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-custom-link1-label' );
					$element_args['class'] 	= 'item-custom-link1';					
					break;
				case 'custom_link2':
					$element_args['link'] 	= kapee_get_option( 'mobile-navbar-custom-link2-url', '' );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-custom-link2-icon', '' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-custom-link2-label' );
					$element_args['class'] 	= 'item-custom-link1';					
					break;
				case 'custom_link3':
					$element_args['link'] 	= kapee_get_option( 'mobile-navbar-custom-link3-url', '' );
					$element_args['icon'] 	= kapee_get_option( 'mobile-navbar-custom-link3-icon', '' );
					$element_args['label'] 	= kapee_get_option('mobile-navbar-custom-link3-label' );
					$element_args['class'] 	= 'item-custom-link1';					
					break;
			}
			$args['elements'][$element] = apply_filters( 'kapee_mobile_bottom_navbar_element_'.$element, $element_args );
			
		}
		
		if( empty( $args['elements'] ) ) { 
			return;
		}
		
		kapee_get_template( 'template-parts/mobile/mobile-bottom-navbar.php', $args );			
	}
}

if ( ! function_exists( 'kapee_promo_bar' ) ) {
	/**
	 * Promo bar
	 */
	function kapee_promo_bar() {
		
		if( ( kapee_get_option( 'promo-bar-close-btn', 1 ) && kapee_get_option( 'promo-bar-dismiss', 0 ) && isset( $_COOKIE['kapee_promo_bar_close'] ) ) ){
			return; 
		}
			
		$args = array();
		
		$args['promo_position'] 			= kapee_get_option( 'promo-bar-position', 'top' );
		$args['promo_position_type'] 		= kapee_get_option( 'promo-bar-position-type', 'absolute' );
		$args['promo_message'] 				= kapee_get_option( 'promo-bar-message-text', esc_html__( 'SUMMER SALE, Get 40% Off for all products.', 'kapee' ) );
		$args['promo_link_btn'] 			= kapee_get_option( 'promo-bar-link-btn', 0 );
		$args['promo_link_text'] 			= kapee_get_option( 'promo-bar-link-btn-text', esc_html__( 'Click Here', 'kapee' ) );
		$args['promo_link_url'] 			= kapee_get_option( 'promo-bar-link-btn-url', '#' );
		$args['promo_link_open_new_tab'] 	= kapee_get_option( 'promo-bar-link-open-new-tab', 0 ) ;
		$args['promo_close_btn']			= kapee_get_option( 'promo-bar-close-btn', 1 ) ;
		$args['promo_dismiss_class'] 		= '' ;
		$args['target'] 					= '_self' ;
		
		if( kapee_get_option( 'promo-bar-dismiss', 0 ) ){
			$args['promo_dismiss_class'] = 'promo-bar-dismiss' ;
		}
		
		if( kapee_get_option( 'promo-bar-link-open-new-tab', 0 ) ){
			$args['target'] = '_blank' ;
		}
		
		kapee_get_template( 'template-parts/promo-bar/promo-bar', $args );
	}
}