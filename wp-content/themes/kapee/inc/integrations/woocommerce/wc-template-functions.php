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
 * Adds custom classes to the array of body classes.
 */
function kapee_body_woocommerce_classes( $classes ) {
	
	global $post;
	
	if( kapee_is_catalog() && 'list-view' == kapee_get_option( 'products-view-mode-mobile', 'grid-view' ) ) {
		$classes[] = 'has-mobile-products-view-mode-list';
	}
	
	if( apply_filters( 'kapee_mobile_products_cart_icon', true ) ){
		$classes[] = 'has-mobile-product-cart-icon';
	}
	
	if( kapee_get_option( 'product-hover-mobile', 0 ) ){
		$classes[] = 'has-product-hover-mobile';
	}
	
	if( kapee_get_option( 'ajax-filter', 0 ) && kapee_is_catalog() ) {
		$classes[] = 'kapee-catalog-ajax-filter';
	}
	
	if( is_product() && kapee_get_option( 'single-product-quick-buy', 0 ) ) {
		$classes[] = 'has-single-product-quick-buy';
	}
	
	if( is_cart() && kapee_get_option( 'cart-auto-update', 1 ) ) {
		$classes[] = 'has-auto-update-cart';
	}
	
	if ( kapee_get_option( 'sticky-add-to-cart-button', 1 ) && is_singular( 'product' ) ) {
		$product = wc_get_product( $post->ID );
		
		if( $product->is_in_stock() ){
			$classes[] = 'has-sticky-add-to-cart';
		}		
	}
	
	if( is_checkout() && kapee_get_option( 'multi-step-checkout', 0 ) ) {
		$classes[] = 'has-multi-step-checkout';
	}
	
	$classes = apply_filters( 'kapee_body_woocommerce_classes', $classes );
	
	return $classes;
}

/**
 * Product Loop Row Classes
 */
if ( ! function_exists( 'kapee_product_row_classes' ) ):
	function kapee_product_row_classes(){
		
		$product_style 			= kapee_get_loop_prop( 'product-style' );
		$products_columns 		= kapee_get_loop_prop( 'products-columns' );
		$classes[] 				= $product_style;		

		if( kapee_get_loop_prop( 'name' ) == 'kapee-carousel' ){
			$columns 			= (int) $products_columns;			
			$classes[] 			= 'grid-view';
			$product_layout	 	= 'kapee-carousel';
			$classes[] 			= 'owl-carousel';
			$classes[] 			= 'grid-col-xl-'.kapee_get_loop_prop( 'rs_extra_large' );
			$classes[] 			= 'grid-col-lg-'.kapee_get_loop_prop( 'rs_large' );
			$classes[] 			= 'grid-col-md-'.kapee_get_loop_prop( 'rs_medium' );
			$classes[] 			= 'grid-col-sm-'.kapee_get_loop_prop( 'rs_small' );
			$classes[] 			= 'grid-col-'.kapee_get_loop_prop( 'rs_extra_small' );
		}else{
			$classes[] 			= 'row';
			$product_layout	 	= 'products-wrap';
			$columns 			= (int) $products_columns;
			$classes[] 			= kapee_get_loop_prop( 'products_view' );
		}
		$classes[] 			= $product_layout;
		$classes[]			= kapee_get_loop_prop( 'product-action-buttons-style' );
		if( apply_filters( 'kapee_products_cart_icon', true ) ){
			$classes[] 		= kapee_product_button_class( $product_style, $products_columns );	
		}		
		$classes[]			=  ( kapee_get_loop_prop( 'product-quantity-field' ) ) ? 'has-quantity-field' : '';
		
		$classes = apply_filters( 'kapee_product_row_classes', $classes );
		
		return implode( ' ', $classes );
	}
endif;

if ( ! function_exists( 'kapee_product_button_class' ) ):
	function kapee_product_button_class( $product_style ='', $products_columns = '' ){		
		
		if( empty ( $product_style ) || empty ( $products_columns ) || 'product-style-2' == $product_style ){
			return 'return';
		}
		
		$layout 	= kapee_get_layout();
		$element 	= kapee_get_loop_prop( 'products-element' );
		if( '5' == $products_columns || '6' == $products_columns ){
			return 'product-cart-icon';
		}elseif( 'full-width' != $layout && '4' == $products_columns ){
			return 'product-cart-icon';
		}elseif( ( ! empty ( $element ) && 'products-with-banner' == $element ) && '4' == $products_columns ) {
			return 'product-cart-icon';
		}elseif( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() && (int)$products_columns > 3 ){
			return 'product-cart-icon';
		}
	}
endif;

/**
 * Product loop classes
 */
if( ! function_exists( 'kapee_product_loop_classes' ) ):
	function kapee_product_loop_classes() {			
		$classes = array();
		if( kapee_get_loop_prop( 'name' ) != 'kapee-carousel' ){
			$columns = kapee_get_loop_prop('products-columns');
			$columns_val = ( 12 / $columns  );			
			$columns = ( is_float( $columns_val ) ) ?  $columns * 10 : $columns_val;			
			$classes[] ='col-xl-'.$columns;
			if( 'full-width' == kapee_get_layout() ) {
				$classes[] = 'col-lg-3';
				$classes[] = 'col-md-4';
				$classes[] = 'col-sm-6';
			}else{
				$classes[] = 'col-lg-4';
				$classes[] = 'col-md-6';
				$classes[] = 'col-sm-6';
			}
			$classes[] ='col-'.( 12 / kapee_get_loop_prop( 'products-columns-mobile' ) );			
		}
		if ( kapee_get_loop_prop( 'product-new-label' ) ) {
			$postdate = get_the_time( 'Y-m-d' ); // Post date
			$postdatestamp = strtotime( $postdate ); // Timestamped post date
			$newness = kapee_get_loop_prop( 'product-newness-days' ); // Newness in days
			if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
				$classes[] = 'new';
			}
		}
		return apply_filters( 'kapee_product_loop_classes', $classes );
	}
endif;
if( ! function_exists( 'kapee_add_product_new_class' ) ):
	function kapee_add_product_new_class( $classes =[]) {	
		if ( kapee_get_loop_prop( 'product-new-label' ) ) {
			$postdate = get_the_time( 'Y-m-d' ); // Post date
			$postdatestamp = strtotime( $postdate ); // Timestamped post date
			$newness = kapee_get_loop_prop( 'product-newness-days' ); // Newness in days
			if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
				$classes[] = 'new';
			}
		}
		return $classes;
	}
	add_filter('woocommerce_post_class','kapee_add_product_new_class');
endif;

/**
 * Adds extra post classes for products.
 *
 * @return array
 */
function kapee_get_product_gallery_layout() {	
	
	$product_layout = kapee_get_post_meta('single_product_layout');
	if( ! $product_layout ){
		$product_layout = kapee_get_option( 'product-gallery-style', 'product-gallery-left' );			
	}	
	return $product_layout;
}

/**
 * Mini Cart Slide
 */
if( ! function_exists( 'kapee_minicart_slide' ) ) :
	function kapee_minicart_slide(){ ?>
	
		<div class="kapee-minicart-slide">
			<div class="minicart-header">
				<a href="#" class="close-sidebar"><?php esc_html_e( 'Close', 'kapee' ); ?></a>
				<h3 class="minicart-title"><?php echo apply_filters( 'kapee_mini_cart_header_text', esc_html__('My Cart','kapee' ) );?></h3>
			</div>
			<div class="woocommerce widget_shopping_cart">
				<div class="widget_shopping_cart_content">
					<?php woocommerce_mini_cart();?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

/**
 * Canvas Sidebar
 */
if( ! function_exists( 'kapee_canvas_sidebar' ) ) :
	function kapee_canvas_sidebar() {
		
		if( 'full-width' == kapee_get_layout() || ! kapee_get_option( 'sidebar-canvas-mobile', 0 ) ) {
			return;
		}
		if( kapee_get_option( 'mobile-bottom-navbar', 1 ) ){
			$mobile_elemets = (array)kapee_get_option( 'mobile-navbar-elements',  array(
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
			if( array_key_exists('sidebar',$mobile_elemets['enabled']) ){
				if( function_exists('is_product') && is_product() && kapee_get_option('mobile-product-page-button')  ){
					/* Do someting */
				}else{
					return;
				}								
			}
		} ?>
		
		<div class="kapee-canvas-sidebar">
			<div class="kp-canvas-sidebar"><?php esc_html_e('Sidebar','kapee')?></div>
		</div>
		<?php
	}
endif;

/**
 * Function to checkout form checkout-step
 */
function kapee_multistep_checkout( $template, $template_name, $template_path ) {
	if ( 'checkout/form-checkout.php' == $template_name ) {
		$template 	= KAPEE_DIR . '/woocommerce/checkout/form-multistep-checkout.php';
		$theme_file = get_stylesheet_directory() . '/woocommerce/checkout/form-multistep-checkout.php';

		if ( file_exists( $theme_file ) ) {
			$template = $theme_file;
		}
	}

	// Return
	return $template;
}

/**
 * Checkout login form.
 *
 * @since 1.0.0
 */
function kapee_checkout_login_form( $login_message ) {
	woocommerce_login_form(
		array(
			'message'  => $login_message,
			'redirect' => wc_get_page_permalink( 'checkout' ),
			'hidden'   => false
		)
	);

	// If WooCommerce social login
	if ( class_exists( 'WC_Social_Login' ) ) {
		do_shortcode( '[woocommerce_social_login_buttons]' );
	}
}

function kapee_woocommerce_securesubmit_support( $value, $options ) {
	$value['use_iframes'] = 'no';
	return $value;
}	

/**
 * User Login Signup Popup
 */
if( ! function_exists( 'kapee_login_signup_popup' ) ) :
	function kapee_login_signup_popup() {
		if( !kapee_get_option('login-register-popup', 1) ){
			return;
		}
		if ( ! shortcode_exists( 'woocommerce_my_account' ) || is_user_logged_in() ) {
			return;
		}
		if( is_account_page() || is_checkout() || is_page('vendor-registration') ){
			return;
		} ?>	
		<div id="kapee-signin-up-popup" class="kapee-signin-up-popup mfp-hide">
			<?php echo do_shortcode( '[woocommerce_my_account]' ); ?>
		</div>
		<?php
	}
endif;

/** 	
 * Ajax Count Wishlist Product
 */
if( ! function_exists( 'kapee_ajax_wishlist_count' ) ) :
	function kapee_ajax_wishlist_count() {
			
		if( function_exists( 'YITH_WCWL' ) ){
			wp_send_json( YITH_WCWL()->count_products() );
			die();
		}
	}
endif;

/* 	
 * Ajax Count Compare Product
 */
if( ! function_exists( 'kapee_ajax_compare_count' ) ) {
	function kapee_ajax_compare_count(){
		//check_ajax_referer( 'kapee-ajax-nonce', 'nonce' );
		if( defined( 'YITH_WOOCOMPARE' ) ){			
			
			$products_list	= array();
			$products_list 	= isset( $_COOKIE[ 'yith_woocompare_list' ] ) && ! empty( $_COOKIE[ 'yith_woocompare_list' ] ) ? maybe_unserialize( $_COOKIE[ 'yith_woocompare_list' ] ) : array();
			$products_list	= json_decode( $products_list );
			
			if ( ! empty( $products_list ) && $products_list > 0 ) {				
				if( isset( $_REQUEST['id'] ) ) {
					if ( $_REQUEST['id'] == 'all' ) {
						unset( $products_list );
					} else {
						$products_list	= array_diff( $products_list, array( $_REQUEST['id'] ) );
					}
				}	
				echo count( $products_list );
			} else {
				echo '0';
			}
		}
		die();
	}
}

/** 	
 * Ensure cart contents update when products are added to the cart via AJAX
 */
if( ! function_exists( 'kapee_cart_data' ) ) :
	add_filter('woocommerce_add_to_cart_fragments', 'kapee_cart_data', 30);
	function kapee_cart_data( $array ) {
		$count 			= is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
		$cart_count 	= '<span class="header-cart-count">'.wp_kses_post( $count ).'</span>';
		$cart_total 	= '<span class="header-cart-total">'.WC()->cart->get_cart_subtotal().'</span>';
		$cart_item_text = '<span class="header-cart-item-text">'.wp_kses_post( $count ).' '._n( 'item', 'items', $count, 'kapee' ).'</span>';
		
		$array['span.header-cart-count'] 		= $cart_count;
		$array['span.header-cart-total'] 		= $cart_total;
		$array['span.header-cart-item-text'] 	= $cart_item_text;
		
		return $array;
	}
endif;

/** 	
 * Empty Mini Cart Browse Categories
 */
if( ! function_exists( 'kapee_empty_mini_cart_browse_categories' ) ) :
	function kapee_empty_mini_cart_browse_categories(){
		$browse_categories_ids = kapee_get_option( 'empty-cart-browse-categories', array() );
		if( ! empty( $browse_categories_ids ) ):
			$browse_categories = get_terms( 'product_cat', array(
				'include' => $browse_categories_ids,
				'orderby' => 'include',
			) );
			
			if ( ! is_wp_error( $browse_categories ) ) :?>
				<div class="empty-cart-browse-categories">
					<p class="browse-categories-title"><?php esc_html_e( 'Browse Categories', 'kapee' );?></p>
					<div class="browse-categories-list">
					<?php foreach($browse_categories as $browse_category):?>
							<a href="<?php echo esc_url( get_term_link( $browse_category -> term_id ) )?>"><?php echo esc_html( $browse_category -> name );?></a>
					<?php endforeach;?>
					</div>
				</div>
			<?php endif;
		endif;
	}
endif;

/** 	
 * Empty Mini Cart Shop Button
 */
if( ! function_exists( 'kapee_empty_mini_cart_button' ) ) :
	function kapee_empty_mini_cart_button(){?>
	<p class="woocommerce-empty-mini-cart__buttons">
		<a class="button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php echo apply_filters( 'kapee_empty_mini_cart_button_text', esc_html__( 'Continue Shopping', 'kapee' ) );?></a>
	</p>
	<?php }
endif;

/** 	
 * Checkout Progress Steps
 */
if( ! function_exists( 'kapee_checkout_steps' ) ) :
	function kapee_checkout_steps(){	
				
		$step = 1;
		if( is_checkout() ){
			$step = 2;
		}
		if( is_order_received_page() ){
			$step = 3;
		}?>
		
		<ul class="kapee-chekout-steps">
			<li class="step <?php echo esc_attr( $step == 1 ) ? 'current' : ''; ?>">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
					<span><?php esc_html_e( 'Shopping Cart', 'kapee' ); ?></span>
				</a>
			</li>
			<li class="step <?php echo esc_attr( $step == 2 ) ? 'current' : ''; ?>">
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
					<span><?php esc_html_e( 'Checkout', 'kapee' ); ?></span>
				</a>
			</li>
			<li class="step <?php echo esc_attr( $step == 3 ) ? 'current' : ''; ?>">
				<span><?php esc_html_e( 'Order Complete', 'kapee' ); ?></span>
			</li>
		</ul>
		<?php
	}
endif;

/**
 * Shop Loop Header
 */
if( ! function_exists( 'kapee_before_shop_loop' ) ) :
	function kapee_before_shop_loop(){ ?>
		<div class="products-header">
			<div class="products-header-left">
				<?php 
				/**
				 * Hook: kapee_shop_loop_header_left.
				 *
				 * @hooked kapee_shop_page_title - 10
				 * @hooked kapee_proudcts_result_count - 20
				 */
				do_action( 'kapee_shop_loop_header_left' );
				?>
			</div>
			<div class="products-header-right">
				<?php 
				/**
				 * Hook: kapee_shop_loop_header_right.
				 *
				 * @hooked kapee_product_loop_view - 20
				 * @hooked kapee_product_loop_show - 25
				 * @hooked woocommerce_catalog_ordering - 30
				 * @hooked kapee_product_filter_top - 35
				 */
				do_action( 'kapee_shop_loop_header_right' );
				?>
			</div>
		</div>
	<?php }
endif;



if ( ! function_exists( 'kapee_shop_page_title' ) ) :
	/**
	 * Show the shop page title on the product loop. By default this is an H1.
	 */
	function kapee_shop_page_title() { ?>
		<h5 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h5>
	<?php }
endif;

if ( ! function_exists( 'kapee_product_loop_view' ) ) :
	/**
	 * Products view grid/list style on shop page
	 */
	function kapee_product_loop_view() {
		
		if( ! kapee_get_option( 'products-view-icon', 1 ) || ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) return;
		$product_view = kapee_get_loop_prop('products_view');
		?>
		<div class="products-view">
			<a class="grid-view <?php echo esc_attr( $product_view =='grid-view' ) ? 'active' : ''; ?>" data-shopview="grid-view" href="<?php echo esc_url( add_query_arg( array( 'view' => 'grid-view' ) ) );?>"><?php esc_html_e('Grid View','kapee');?></a>
			<a class="list-view <?php echo esc_attr( $product_view =='list-view' ) ? 'active' : ''; ?>" data-shopview="list-view" href="<?php echo esc_url( add_query_arg( array( 'view' => 'list-view' ) ) );?>"><?php esc_html_e('List View','kapee');?></a>
		</div>
		<?php 
	}
endif;

if ( ! function_exists( 'kapee_product_loop_show' ) ) :
	/**
	 * Show number of products per page on product loop
	 */
	function kapee_product_loop_show() {
			
		if( ! kapee_get_option( 'products-per-page-dropdown', 1 ) || ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) return;
		
		$show_numbers = kapee_get_shop_viewnumbers();
		$loop_shop_per_page = kapee_loop_shop_per_page();
		
		if( !empty( $show_numbers ) ) { ?>
			<div class="product-show">
				<form class="show-products-number" method="get">
					<span><?php esc_html_e('Show:','kapee');?></span>
					<select class="show-number per_page" name="per_page">
						<?php foreach( $show_numbers as $show_per_page ) { 	?> 
							<option value="<?php echo esc_attr($show_per_page); ?>" <?php selected($show_per_page,$loop_shop_per_page);?>><?php echo absint($show_per_page);?></option>
						<?php } ?>
					</select>
					<?php
					foreach( $_GET as $name => $value ) {
						if ( 'per_page' != $name ) {
							printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $name ), esc_attr( $value ) );
						}
					}
					?>
				</form>
			</div>
		<?php }
	}
endif;

if ( ! function_exists( 'kapee_product_filter_top' ) ) :
	/**
	 * Show product filter top
	 */
	function kapee_product_filter_top() {
			
		if( ! kapee_get_option( 'shop-top-filter', 0 ) ) return;
		?>
		<span class="kapee-product-filter-btn"><?php echo esc_html__('Filter','kapee');?></span>
	
	<?php }
endif;

if ( ! function_exists( 'kapee_filter_widgets' ) ) :
	/**
	 * Show the shop page title on the product loop. By default this is an H1.
	 */
	function kapee_filter_widgets() { 
		if( ! kapee_get_option( 'shop-top-filter', 0 ) ) return; ?>
			<div id="kapee-filter-widgets" class="kapee-filter-widgets" style="display:none">
				<div class="kapee-filter-inner">
					<?php 
					if ( is_active_sidebar('shop-filters-sidebar') ) { 
					dynamic_sidebar('shop-filters-sidebar');
					}else{
						esc_html_e('No, Any filters available.','kapee');
					} ?>
				</div>
			</div>
		<?php
		}
endif;

if ( ! function_exists( 'kapee_active_filter_widgets' ) ) :
	/**
	 * Show the shop page title on the product loop. By default this is an H1.
	 */
	function kapee_active_filter_widgets() { ?>
		<div class="kapee-active-filters">
			<?php 

				do_action( 'kapee_before_active_filters_widgets' );

				the_widget( 'WC_Widget_Layered_Nav_Filters', array('title' => ''), array() ); 

				do_action( 'kapee_after_active_filters_widgets' );

			?>
		</div>
	<?php
		}
endif;

if ( ! function_exists( 'kapee_clear_filters_btn' ) ) :
	/**
	 * Show the shop page title on the product loop. By default this is an H1.
	 */
	function kapee_clear_filters_btn() { 
			global $wp;  
			$url = home_url( add_query_arg( array( $_GET ), $wp->request ) );
			$filters = array( 'filter_', 'rating_filter', 'min_price', 'max_price', 'product_visibility', 'stock', 'onsales' );
			$need_clear = false;
				
			foreach ( $filters as $filter )
				if ( strpos( $url, $filter ) ) $need_clear = true;	
				
			if ( $need_clear ) {
				$reset_url = strtok( $url, '?' );
				if ( isset( $_GET['post_type'] ) ) $reset_url = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $reset_url );
				?>
					<div class="kapee-clear-filters-wrapp">
						<a class="kapee-clear-filters" href="<?php echo esc_url( trailingslashit( $reset_url ) ); ?>"><?php echo esc_html__( 'Clear filters', 'kapee' ); ?></a>
					</div>
				<?php
			}
		}
endif;

if( ! function_exists( 'kapee_loop_shop_per_page' ) ) :
	/**
	 * Set per page product loop product page
	 */
	function kapee_loop_shop_per_page(){
		
		$shop_loop_per_page = kapee_get_option('products-per-page', 12);
		if ( isset( $_GET[ 'per_page' ] ) ) {
			return $_GET[ 'per_page' ];
		}
		
		return $shop_loop_per_page;
	}
	add_filter( 'loop_shop_per_page', 'kapee_loop_shop_per_page', 20 );
endif;

if ( ! function_exists( 'kapee_loop_product_wrapper' ) ) :
	/**
	 * Product loop wrapper start
	 */
	function kapee_loop_product_wrapper() { ?>
		<div class="product-wrapper">
	<?php }
endif;

if ( ! function_exists( 'kapee_product_wrapper_end' ) ) :
	/**
	 * Product loop wrapper end
	 */
	function kapee_product_wrapper_end() { ?>
		</div>
	<?php }
endif;

if ( ! function_exists( 'kapee_before_shop_loop_item_title' ) ) :
	/**
	 * Product loop image
	 */
	function kapee_before_shop_loop_item_title() { ?>
		<div class="product-image">
			<?php
			/**
			 * Hook: kapee_before_shop_loop_item_title.
			 *
			 * @hooked kapee_template_loop_product_thumbnail - 10
			 */
			 do_action( 'kapee_before_shop_loop_item_title' );?>
		 </div>
		 <?php 
	}
endif;

if ( ! function_exists( 'kapee_subcategory_count_html' ) ) :
	/**
	 * Categories loop products count
	 */
	function kapee_subcategory_count_html( $html, $category ) { 	
		 return sprintf(
			'<span class="product-count">%1$s</span>',
			sprintf( _n( '%s Product', '%s Products', $category->count, 'kapee' ), $category->count )
		);
	}
	add_filter('woocommerce_subcategory_count_html', 'kapee_subcategory_count_html', 10, 2);
endif;

if ( ! function_exists( 'kapee_template_loop_product_thumbnail' ) ) :
	/**
	 * Get the product thumbnail for the loop.
	 */
	function kapee_template_loop_product_thumbnail() { 		
		global $product;

		$image_size 	= apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );		
		$attachment_ids = $product->get_gallery_image_ids();
		$hover_image 	= '';
		$mobile_hover_image	= true;
		
		if( wp_is_mobile() && ! kapee_get_option( 'mobile-product-hover-image', 0 ) ) {
			$mobile_hover_image	= false;
		}

		if ( $mobile_hover_image && ! empty( $attachment_ids[0] ) ) {
			$hover_image = kapee_get_image_html($attachment_ids[0] , $image_size, 'hover-image');
		}
		
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		$target = '_self';
		if( kapee_get_option( 'open-product-page-new-tab', 0 ) ){
			$target = '_blank';
		}
		
		$html = '<a href="'. esc_url( $link ) .'" class="woocommerce-LoopProduct-link" target="'.$target.'">';		
			$html .=  $product ? kapee_get_post_thumbnail( $image_size, 'front-image' ) : '';			
			if( '' != $hover_image && kapee_get_option( 'products-hover-image', 1 ) ):
				$html .= $hover_image;
			endif;			
		$html .= '</a>';
		
		echo apply_filters( 'kapee_template_loop_product_thumbnail', $html );
	}
endif;

if ( ! function_exists( 'kapee_shop_loop_item_title' ) ) :
	/**
	 * Product loop title hooke
	 */
	function kapee_shop_loop_item_title() { 
		/**
		 * Hook: kapee_shop_loop_item_title.
		 *
		 * @hooked kapee_loop_product_info_wrapper - 5
		 * @hooked kapee_product_title_rating_wrapper - 10
		 * @hooked kapee_product_loop_category - 15
		 * @hooked woocommerce_template_loop_product_title - 20
		 * @hooked kapee_product_rating_html - 25
		 * @hooked woocommerce_template_single_excerpt - 30
		 * @hooked kapee_product_wrapper_end - 50
		 */
		 do_action( 'kapee_shop_loop_item_title' );
	}
endif;

if ( ! function_exists( 'kapee_loop_product_info_wrapper' ) ) :
	/**
	 * Product loop info wrapper start
	 */
	function kapee_loop_product_info_wrapper() { ?>
		<div class="product-info">
	<?php }
endif;

if ( ! function_exists( 'kapee_product_title_rating_wrapper' ) ) :
	/**
	 * Product loop title & rating
	 */
	function kapee_product_title_rating_wrapper() { ?>
		<div class="product-title-rating">
	<?php }
endif;

if( ! function_exists( 'kapee_product_loop_categories' ) ) :
	
	function kapee_product_loop_categories() {
		global $product;
		
		if( ! kapee_get_option( 'products-category', 1 ) ) return;?>
		
		<div class="product-cats">
			<?php echo wc_get_product_category_list( $product->get_id(), ', ' );?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) :
	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function woocommerce_template_loop_product_title() {
		
		if( ! kapee_get_loop_prop( 'products-title') ) return;
		
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		
		$target = '_self';
		if( kapee_get_option( 'open-product-page-new-tab', 0 ) ){
			$target = '_blank';
		}
		echo '<h3 class="product-title"><a href="' . esc_url( $link ) . '" target="'.$target.'">' . get_the_title() . '</a></h3>';
	}
endif;

if ( ! function_exists( 'kapee_product_rating_html' ) ) :
	/**
	 * Product rating html
	 */
	function kapee_product_rating_html( $html, $rating, $count ) {
		
		if( ! kapee_get_loop_prop( 'products-rating') || ( is_admin() && ! wp_doing_ajax() ) ) { return; }
		
		global $product;
		
		if( ! $product ){
			return;
		}
		
		if( 'fancy-rating' == kapee_get_loop_prop( 'products-rating-style' ) ){
			$review_count 	= $product->get_review_count();
			$rating_class	= ( $rating >= 3 ) ? 'good' : ( ( $rating < 3 && $rating >= 2 ) ? 'poor' : 'bad' );
			ob_start();
			if ( 0 < $rating ) { ?>
				<div class="fancy-star-rating">
					<div class="rating-wrap">
						<span class="fancy-rating <?php echo esc_attr($rating_class);?>"><?php echo round( $rating, 1 );?> &#9733;</span>
						<?php kapee_fancy_rating_summary();?>
					</div>
					<?php if( kapee_get_loop_prop( 'products-rating-count') && comments_open() ){ ?>
						<div class="rating-counts">
							<?php if( is_product() ){ ?>
								<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php esc_html_e( $review_count ) ?>)</a>
							<?php } else {?>
								(<?php esc_html_e( $review_count ) ?>)
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<?php 
			}
			$html = ob_get_clean();
		}
		
		if( 'simple-rating' == kapee_get_loop_prop( 'products-rating-style') && kapee_get_loop_prop( 'products-rating-count' ) ){
			if ( 0 < $rating ) {
				$review_count 	= $product->get_review_count();
				$count_html = '<div class="rating-counts">('.$review_count .')</div>';
				$html = '<div class="product-rating">'.$html.''.$count_html.'</div>';
			}
		}
		return $html;
	}
	add_filter('woocommerce_product_get_rating_html', 'kapee_product_rating_html', 10, 3);
endif;

if ( ! function_exists( 'kapee_fancy_rating_summary' ) ):
	function kapee_fancy_rating_summary() {
		
		if( ! kapee_get_loop_prop( 'products-rating-histogram' ) ) return; 
		
		global $product;
		$product_id 	= $product->get_id();
		$rating 		= $product->get_average_rating();
		$rating_counts 	= $product->get_rating_counts();
		$review_count 	= $product->get_review_count();?>
		
		<div class="fancy-rating-summery kapee-arrow">
			<div class="rating-avg-wrap">
				<div class="rating-avg"><?php echo round( $rating, 1 );?> &#9733;</div>
				<div class="rating-review-count">
					<span><?php echo sprintf( _n( '%s Rating', '%s Ratings', $review_count, 'kapee' ), number_format_i18n( $review_count ) );?></span>
				</div>
			</div>
			<div class="rating-histogram-wrap">
				<div class="rating-histogram">
					<?php for ( $r=5; $r > 0; $r-- ){ 
						$rating_class	= ( $r >= 3 ) ? 'good' : ( ( $r == 2 ) ? 'poor' : 'bad' );
						$rating_percentage = 0;
						if ( isset( $rating_counts[$r] ) && $review_count > 0 ) {
							$rating_percentage = (round( $rating_counts[$r] / $review_count, 2 ) * 100 );
						}?>																	
						<div class="rating-bar">									
							<div class="rating-star"><?php echo number_format_i18n( $r )?> &#9733; </div>
							<div class="progress">
								<div class="progress-bar <?php echo esc_attr($rating_class);?>" style="width:<?php echo esc_attr( $rating_percentage ); ?>%"></div>
							</div>
							<?php if ( isset( $rating_counts[$r] ) ) : ?>
								<div class="rating-count"><?php echo esc_html( $rating_counts[$r] ); ?> </div>
							<?php else : ?>
								<div class="rating-count zero"><?php echo number_format_i18n( 0 )?></div>
							<?php endif; ?>
						</div>
					<?php }?>							
				</div>
			</div>
		</div>
		<?php 
	}
endif;

if ( ! function_exists( 'kapee_after_shop_loop_item_title' ) ) :
	/**
	 * Product loop action buttons
	 */
	function kapee_after_shop_loop_item_title() { ?>
		<div class="product-price">
			<?php
			/**
			 * Hook: kapee_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 * @hooked kapee_product_sale_percentage - 20
			 */
			 do_action( 'kapee_after_shop_loop_item_title' );?>
		 </div>
		 <?php 
	}
endif;

if ( ! function_exists( 'kapee_product_price_buttons_wrapper' ) ) :
	/**
	 * Product loop price & buttons
	 */
	function kapee_product_price_buttons_wrapper() { ?>
		<div class="product-price-buttons">
	<?php }
endif;

if ( ! function_exists( 'kapee_product_labels' ) ) :
	/**
	 * Product labels
	 */
	function kapee_product_labels( $sale_label ='' ) {
		global $product;
		$output 				= array();
		$sale_percentage_label 	= ( $sale_label == 'percentage' ) ? $sale_label : kapee_get_loop_prop( 'sale-product-label-text-options' );
		
		if ( kapee_get_loop_prop( 'product-new-label' ) ) {
			
			$postdate 		= get_the_time( 'Y-m-d' );								// Post date
			$postdatestamp 	= strtotime( $postdate );								// Timestamped post date
			$newness 		= kapee_get_loop_prop( 'product-newness-days' ); 	// Newness in days
			$new_label_text	= kapee_get_loop_prop( 'new-product-label-text' );

			if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
				$output['new'] = '<span class="new">' . $new_label_text . '</span>';
			}					
		}
		
		if( $product->is_on_sale() && kapee_get_loop_prop( 'sale-product-label' ) ) {		
			$percentage = '';
			if( $product->get_type() == 'variable' && $sale_percentage_label =='percentage' ){				
				$available_variations = $product->get_variation_prices();
				$max_value = 0;
				foreach( $available_variations['regular_price'] as $key => $regular_price ) {					
					$sale_price = $available_variations['sale_price'][$key];					
					if ( $sale_price < $regular_price ) {
						$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
						if ( $percentage > $max_value ) {
							$max_value = $percentage;
						}
					}
				}
				$percentage = $max_value;
				
			} elseif ( ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) && $sale_percentage_label =='percentage' ) {				
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}
			if ( $percentage ) {	
				$sale_percentage_label_text = kapee_get_loop_prop( 'sale-product-label-percentage-text' );
				$output['sale'] = '<span class="on-sale"><span>'. $percentage . '</span>% ' .$sale_percentage_label_text. '</span>';
			}else{
				if($product->is_on_sale() && $sale_percentage_label =='percentage'){
					/* Fixed issue for you may also like variable products*/
					$percentage = 0;
					if($product->get_regular_price() && $product->get_sale_price()){
						$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
					}
					if( $percentage > 0 ){
						$sale_percentage_label_text = kapee_get_loop_prop( 'sale-product-label-percentage-text' );
						$output['sale'] = '<span class="on-sale"><span>'. $percentage . '</span>% ' .$sale_percentage_label_text. '</span>';
					}
				} else {
					$sale_label_text = kapee_get_loop_prop( 'sale-product-label-text' );
					$output['sale'] = '<span class="on-sale"><span>' . $sale_label_text . '</span></span>';
				}
			}
		}		

		if ( $product->is_featured() && kapee_get_loop_prop( 'featured-product-label' ) ) {
			$featured_label_text = kapee_get_loop_prop( 'featured-product-label-text' );
			$output['featured'] = '<span class="featured">' . $featured_label_text . '</span>';
		}	
		
		if( !$product->is_in_stock() && kapee_get_loop_prop( 'outofstock-product-label' ) ){
			$out_stock_label_text = kapee_get_loop_prop( 'outofstock-product-label-text' );
			$output['out_of_stock'] = '<span class="out-of-stock">' . $out_stock_label_text . '</span>';
		}
		if ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price',0 ) ) {
			if(isset($output['sale'])){
				unset($output['sale']);
			}
		}		
		return apply_filters( 'kapee_product_labels', $output );
	}
endif;

if ( ! function_exists( 'kapee_output_product_labels' ) ) :
	/**
	 * Product labels
	 */
	function kapee_output_product_labels() {
		
		if( ! kapee_get_loop_prop( 'product-labels' ) ) return;
		
		$output_labels = kapee_product_labels();
		$html='';
		$current_filter = current_filter();
		if( isset( $output_labels['sale'] ) && ( ! is_product() && kapee_get_loop_prop( 'sale-product-label-after-price' ) == 'after-price' ) || ( is_product() && $current_filter == 'woocommerce_before_single_product_summary' && kapee_get_loop_prop( 'sale-single-product-label-after-price' ) == 'after-price' ) ){
			unset($output_labels['sale']);
		}
		if(isset( $output_labels['sale'] ) && is_product() && kapee_get_loop_prop( 'sale-product-label-after-price' ) == 'after-price' && $current_filter != 'woocommerce_before_single_product_summary' ){
			unset($output_labels['sale']);
		}
		if( isset( $output_labels['out_of_stock'] ) && ( is_product() && $current_filter == 'kapee_product_gallery_top') ){			
			unset($output_labels['out_of_stock']);			
		}
		if ( ! empty( $output_labels ) ) {
			$html = '<div class="product-labels">' . implode( '', $output_labels ) . '</div>';
		}
		echo apply_filters( 'kapee_output_product_labels', $html, $output_labels );
	}
endif;

if ( ! function_exists( 'kapee_product_sale_percentage' ) ) :
	/**
	 * Product sale percentage
	 */
	function kapee_product_sale_percentage() {

		if( ! kapee_get_loop_prop( 'product-labels' ) || 
		kapee_get_loop_prop( 'sale-product-label-after-price' ) != 'after-price' || 
		! kapee_get_loop_prop( 'sale-product-label' ) ) return;
		
		$output_label = kapee_product_labels();
		
		echo ( isset( $output_label['sale'] ) && ( kapee_get_loop_prop( 'sale-product-label-after-price' ) == 'after-price' ) ) ? $output_label['sale'] : '';
	}
endif;

if ( ! function_exists( 'kapee_product_loop_buttons_variations' ) ) :
	/**
	 * Product loop buttons & variations
	 */
	function kapee_product_loop_buttons_variations() { ?>
		<div class="product-buttons-variations">
			<?php
			/**
			 * Hook: kapee_product_loop_buttons_variations.
			 *
			 * @hooked kapee_template_loop_action_buttons - 10
			 * @hooked kapee_template_loop_variations - 20
			 */
			 do_action( 'kapee_product_loop_buttons_variations' );?>
		 </div>
		 <?php 
	}
endif;

if ( ! function_exists( 'kapee_template_loop_action_buttons' ) ) :
	/**
	 * Product loop buttons
	 */
	function kapee_template_loop_action_buttons() { ?>
		
		<div class="product-buttons">
			<?php
			/**
			 * Hook: kapee_template_loop_action_buttons.
			 *
			 * @hooked kapee_product_loop_cart_button - 10
			 * @hooked kapee_product_loop_wishlist_button - 15
			 * @hooked kapee_product_loop_compare_button - 20
			 * @hooked kapee_product_loop_quick_view_button - 25
			 */
			 do_action( 'kapee_template_loop_action_buttons' );?>
		 </div>
		 <?php 
	}
endif;

if ( ! function_exists( 'kapee_product_loop_cart_button' ) ) :
	/**
	 * Product loop cart button
	 */
	function kapee_product_loop_cart_button() {
		
		if( ! kapee_get_option('product-cart-button', 1) ) return; ?>
		
		<div class="cart-button">
			<?php
			/**
			 * Hook: kapee_product_loop_cart_button.
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			 do_action( 'kapee_product_loop_cart_button' );?>
		 </div>
		<?php 
	}
endif;

if ( ! function_exists( 'kapee_product_loop_wishlist_button' ) ) :
	/**
	 * Product loop wishlist button
	 */
	function kapee_product_loop_wishlist_button() {
		
		if( ! kapee_get_option( 'product-wishlist-button', 1 ) ) return; ?>
		
		<div class="whishlist-button">
			<?php if( class_exists( 'YITH_WCWL_Shortcode' ) ) echo YITH_WCWL_Shortcode::add_to_wishlist( array() ); ?>
		</div>
		<?php 
	}
endif;

if ( ! function_exists( 'kapee_product_loop_compare_button' ) ) :
	/**
	 * Product loop compare button
	 */
	function kapee_product_loop_compare_button() {
		
		if( ! defined( 'YITH_WOOCOMPARE' )) return; 
		if( ! kapee_get_option('product-compare-button', 1) ) return; 
		global $product;
		$id = $product->get_id();
		$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'kapee' ) );
		$compare_button_style = get_option( 'yith_woocompare_is_button' );		
		?>
		
		<div class="compare-button">
			<?php printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>',
						kapee_compare_add_product_url( $id ),
						'compare'.' '.$compare_button_style,
						$id,
						$button_text ); 
			?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_compare_add_product_url' ) ) :
	function kapee_compare_add_product_url( $product_id ) {

		$action_add = 'yith-woocompare-add-product';

		$url_args = array(
			'action' => $action_add,
			'id'     => $product_id,
		);

		return apply_filters( 'yith_woocompare_add_product_url',
			esc_url_raw( add_query_arg( $url_args ) ),
			$action_add );
	}
endif;

if ( ! function_exists( 'kapee_product_loop_quick_view_button' ) ) :
	/**
	 * Product loop quick view button
	 */
	function kapee_product_loop_quick_view_button() {
		
		if( ! kapee_get_option('product-quickview-button', 1) ) return; ?>
		
		<div class="quickview-button">
			<a class="quickview-btn" href="<?php echo esc_url( get_the_permalink() );?>" data-id="<?php echo esc_attr(get_the_ID());?>"><?php esc_html_e('Quick View','kapee')?></a>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_product_loop_quantity_field' ) ) :
	/**
	 * Product loop quick view button
	 */
	function kapee_product_loop_quantity_field() {
		
		if( ! kapee_get_loop_prop( 'product-quantity-field' ) || 
		'product-style-1' == kapee_get_loop_prop( 'product-style' ) ||
		'product-style-2' == kapee_get_loop_prop( 'product-style' ) ) 
		{
			return;
		}
		global $product;		
		//add quantity field only to simple products
		if ( $product->is_type( 'simple' ) && ! $product->is_sold_individually() && $product->is_purchasable() && $product->is_in_stock() ) {
			woocommerce_quantity_input(
				array(
					'min_value' => 1,
					'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
				),
				$product
			);
		}
	}
endif;

if ( ! function_exists( 'kapee_quantity_button_plus' ) ) :
	/**
	 * Quantity Button Plus
	 */
	function kapee_quantity_button_plus() { ?>
		<input type="button" value="+" class="plus" />
	<?php }
endif;

if ( ! function_exists( 'kapee_quantity_button_minus' ) ) :
	/**
	 * Quantity Button Minus
	 */
	function kapee_quantity_button_minus() { ?>
		<input type="button" value="-" class="minus" />
	<?php }
endif;	 

if ( ! function_exists( 'kapee_stock_progress_bar' ) ) :
	/**
	 * Product loop buttons & variations
	 */
	function kapee_stock_progress_bar() { 
		if( ! kapee_get_loop_prop( 'products-stock-progressbar' ) ){
			return;
		}
		global $product;
		$product_error 		= false;
		$productId 			= get_the_ID();	
		$stock_available 	= false;	
		$stock_sold 		= ($total_sales = get_post_meta($productId, 'total_sales', true)) ? round($total_sales) : 0;
		
		$stock_available 	= ($stock = get_post_meta($productId, '_stock', true)) ? round($stock) : 0;
		$percentage 		= $stock_available > 0 ? round($stock_sold/($stock_available + $stock_sold) * 100) : 0;
		
		if($stock_available) :?>
			<div class="product-special-deal-progress">
				<div class="deal-stock-label">
					<span class="stock-sold text-right"><?php echo esc_html__('Already Sold:', 'kapee');?> <strong><?php echo esc_html($stock_sold); ?></strong></span>
					<span class="stock-available text-left"><?php echo esc_html__('Available:', 'kapee');?> <strong><?php echo esc_html($stock_available); ?></strong></span>
				</div>
				<div class="progress">
					<span class="progress-bar active" style="<?php echo esc_attr('width:' . $percentage . '%'); ?>"><?php echo esc_html($percentage).'%'; ?></span>
				</div>
			</div>
		<?php endif;
	}
endif;

if ( ! function_exists( 'kapee_after_shop_loop_item' ) ):
	/**
	 * Product after shop loop wrapper end
	 */
	function kapee_after_shop_loop_item() {
		/**
		 * Hook: kapee_after_shop_loop_item.
		 *
		 * @hooked kapee_product_wrapper_end - 10
		 * @hooked kapee_product_wrapper_end - 20
		 * @hooked kapee_product_wrapper_end - 30
		 */
		 do_action( 'kapee_after_shop_loop_item' );
	}
endif;

/**
 * Single Product
 */
if( ! function_exists( 'kapee_wc_get_gallery_image_html' ) ) :
	/**
	 * Get Product Gallery Thumbnails
	 */
	function kapee_wc_get_gallery_image_html( $attachment_id ){	
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$attributes      = array(
			'title'                   => get_post_field( 'post_title', $attachment_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-src'                => $thumbnail[0],
			'data-large_image'        => $thumbnail[0],
			'data-large_image_width'  => $thumbnail[1],
			'data-large_image_height' => $thumbnail[2],
		);

		$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, $attributes );
		$html .= '</div>';
		
		return $html;
	}
endif;

if ( ! function_exists( 'kapee_single_product_photoswipe_btn' ) ) :
	/**
	 * Single product photoswipe button
	 */
	function kapee_single_product_photoswipe_btn(){
		
		if( ! kapee_get_option( 'product-gallery-lightbox', 1 ) ) return; ?>
		
		<div class="product-photoswipe-btn">
			<a href="#" class="kapee-product-image-full"><?php esc_html_e('Lightbox', 'kapee'); ?></a>
		</div>		
	<?php
	}
endif;

if ( ! function_exists( 'kapee_single_product_video_btn' ) ) :
	/**
	 * Single product video button
	 */
	function kapee_single_product_video_btn(){
		
		if( ! kapee_get_option( 'single-product-video', 1 ) ) return;
		
		$prefix 	= KAPEE_PREFIX;
		$video_url 	= get_post_meta(get_the_ID(),  $prefix.'product_video', true );
		if( ! empty( $video_url ) ){ ?>
			<div class="product-video-btn">
				<a href="<?php echo esc_url( $video_url ); ?>" class="kapee-video-popup"><?php esc_html_e('Show Video', 'kapee'); ?></a>
			</div>
			
		<?php }
	}
endif;

if ( ! function_exists( 'kapee_single_product_degree360_btn' ) ) :
	/**
	 * Single product 360 degree View button
	 */
	function kapee_single_product_degree360_btn(){
		
		if( ! kapee_get_option( 'product-360-degree', 1 ) ) return;
		global $post;
		if ( ! $post ) {
			return;
		}
		$prefix 			= KAPEE_PREFIX;
		$gallery_images 	= get_post_meta($post->ID,  $prefix.'product_360_degree_images' );
		
		if( ! empty( $gallery_images ) ){ ?>
			<div class="product-360-degree-btn">
				<a href="#kapee-360-degree-wrapper" ><?php esc_html_e('360 Degree', 'kapee'); ?></a>
			</div>			
		<?php }
	}
endif;

if ( ! function_exists( 'kapee_single_product_360_degree_content' ) ) :
	/**
	 * Single Product 360 Degree Content
	 */
	function kapee_single_product_360_degree_content(){
		
		if( ! kapee_get_option( 'product-360-degree', 1 ) ) return;
		global $post;
		if ( ! $post ) {
			return;
		}
		$prefix 	= KAPEE_PREFIX;
		$gallery_images 	= get_post_meta($post->ID,  $prefix.'product_360_degree_images' );
		if( empty( $gallery_images ) ){
			return;
		}
		$image_array = array();
		foreach ( $gallery_images as $attachment_id ) {
			$image_src = wp_get_attachment_image_url($attachment_id, 'woocommerce_single');
			if( $image_src ){
				$image_array[] = "'" . $image_src . "'";
			}		
		}
		$frames_count  = count( $image_array );
		$images_js_string = implode( ',', $image_array );	?>
		<div id="kapee-360-degree-wrapper" class="kapee-360-degree-wrapper mfp-hide">
			<ol class="kapee-360-degree-images"></ol>	
			<div class="spinner">
				<span>0%</span>
			</div>
		</div>
		<?php
		wp_enqueue_script( 'threesixty' );
		wp_add_inline_script('threesixty',
			'jQuery(document).ready(function( $ ) {
				$(".kapee-360-degree-wrapper").ThreeSixty({
					totalFrames: ' . esc_js( $frames_count ) . ',
					endFrame: ' . esc_js( $frames_count ) . ',
					currentFrame: 1,
					imgList: ".kapee-360-degree-images",
					progress: ".spinner",
					imgArray: ' . '[' . $images_js_string . ']' . ', 
					width: 300,
					height: 300,
					responsive: true,
					navigation: true,
					position: "bottom-center",
				});
			});',
			'after'
		);
	}
endif;

if ( ! function_exists( 'kapee_before_single_product_price' ) ) :
	/**
	 * Before Single Products Price
	 */
	function kapee_before_single_product_price() { 
		/**
		 * Hook: kapee_before_single_product_price.
		 *
		 * @hooked kapee_product_navigation_share - 10
		 */
		 do_action( 'kapee_before_single_product_price' );
	}
endif;

if ( ! function_exists( 'kapee_product_navigation_share' ) ) :
	/**
	 * Single Product Navigation & Share
	 */
	function kapee_product_navigation_share() { ?>
		
		<div class="product-navigation-share">
			<?php 
			/**
			 * Hook: kapee_product_navigation_share.
			 *
			 * @hooked kapee_single_product_share - 5
			 * @hooked kapee_single_product_navigation - 10
			 */
			 do_action( 'kapee_product_navigation_share' );
			?>
		</div>
		<?php 
	}
endif;

if( ! function_exists( 'kapee_single_product_navigation' ) ) :
	/**
	 * Single Product Navigation
	 */
	function kapee_single_product_navigation(){
		
		if( ! kapee_get_option( 'single-product-navigation', 1 ) ) return; 
	
		$next = get_next_post();
	    $prev = get_previous_post();

	    $next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
	    $prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false; ?>
		
		<div class="product-navigation">
			<?php if ( ! empty( $prev ) ): ?>
				<div class="product-nav-btn product-prev">
					<a href="<?php echo esc_url( $prev->get_permalink() ); ?>">
						<?php esc_html_e('Previous product', 'kapee'); ?>
					</a>				
					<div class="product-info-wrap kapee-arrow">
						<div class="product-info">
							<div class="product-thumb">
								<a href="<?php echo esc_url( $prev->get_permalink() ); ?>">
									<?php echo wp_kses( $prev->get_image(), kapee_allowed_html(array('img')) );?>
								</a>
							</div>
							<div class="product-title-price">							
								<a class="product-title" href="<?php echo esc_url( $prev->get_permalink() ); ?>">
									<?php echo esc_html( $prev->get_title() ); ?>
								</a>
								<span class="price"><?php echo wp_kses( $prev->get_price_html(), kapee_allowed_html(array( 'span','del','ins' ) ) );?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
			
			<?php if ( ! empty( $next ) ): ?>
				<div class="product-nav-btn product-next">				
					<a href="<?php echo esc_url( $next->get_permalink() ); ?>">
						<?php esc_html_e('Next product', 'kapee'); ?>
					</a>
					<div class="product-info-wrap kapee-arrow">
						<div class="product-info">
							<div class="product-thumb">
								<a href="<?php echo esc_url( $next->get_permalink() ); ?>">
									<?php echo wp_kses( $next->get_image(), kapee_allowed_html(array('img')) );?>
								</a>
							</div>
							<div class="product-title-price">							
								<a class="product-title" href="<?php echo esc_url( $next->get_permalink() ); ?>">
									<?php echo esc_html( $next->get_title() ); ?>
								</a>
								<span class="price"><?php echo wp_kses( $next->get_price_html(), kapee_allowed_html(array( 'span','del','ins' ) ) );?></span>
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	<?php }
endif;

if ( ! function_exists( 'kapee_sale_product_countdown' ) ) :
	/**
	 * Sale Product Countdown
	 */
	function kapee_sale_product_countdown() {
		
		$current_filter = current_filter();
		if( ( !kapee_get_loop_prop('products-countdown')  && $current_filter != 'woocommerce_single_product_summary' ) || (is_product() && $current_filter == 'woocommerce_single_product_summary' && ! kapee_get_option('single-product-countdown', 1 ) ) ) return; 
		
		global $product;
		$html = $sale_time = $offer_text = $offer_html = '';
		$countdown_style 	='countdown-box';
		$timezone 			= wc_timezone_string();
		
		if( is_single() && $current_filter == 'woocommerce_single_product_summary' ){
			$countdown_style = kapee_get_option('single-product-countdown-style', 'countdown-box');
			$offer_text = kapee_get_option('single-product-countdown-tag', 'Special price ends in less than');
			$offer_html = ( $countdown_style =='countdown-text' ) ? '<span class="offer-tag">'.$offer_text.'</span> ' : '';
		}

		if ( $product->is_on_sale() ) : 
			$sale_time = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		endif;
		
		/* variable product */
		if( $product->has_child() && $product->is_on_sale() ){
			$vsale_end = array();
			
			$pvariables = $product->get_children();
			foreach($pvariables as $pvariable){
				$vsale_end[] = (int)get_post_meta( $pvariable, '_sale_price_dates_to', true );
			}			
			/* get the latest time */
			$sale_time = max( $vsale_end );				
		}
		
		if( $product->is_on_sale() && $sale_time ) :
			wp_enqueue_script( 'countdown' );
			$sale_time = $sale_time;
			$sale_time = date('Y-m-d H:i:s', $sale_time); ?>
			<div class="product-countdown-timer <?php echo esc_attr( $countdown_style );?>">
				<?php echo wp_kses( $offer_html, kapee_allowed_html(array('span')) );?>
				<div class="product-countdown" data-end-date="<?php echo esc_attr( $sale_time );?>" data-timezone="<?php echo esc_attr( $timezone );?>" data-countdown-style="<?php echo esc_attr( $countdown_style );?>"></div>	
			</div>
			<?php
		endif;
		
		echo apply_filters( 'kapee_sale_product_countdown', $html, $sale_time, $timezone, $countdown_style );
	}
endif;

if ( ! function_exists( 'kapee_after_single_product_price' ) ) :
	/**
	 * After Single Product Price
	 */
	function kapee_after_single_product_price() {
		/**
		 * Hook: kapee_after_single_product_price.
		 *
		 * @hooked kapee_single_product_price_discount - 5
		 * @hooked kapee_single_product_price_summary - 5
		 * @hooked kapee_single_product_offer - 10
		 * @hooked kapee_single_product_brands - 15
		 * @hooked kapee_single_product_service - 20
		 */
		 do_action( 'kapee_after_single_product_price' );
	}
endif;

if( ! function_exists( 'kapee_single_product_price_discount' ) ) :
	/**
	 * Single Product Discount
	 */
	function kapee_single_product_price_discount(){
		
		if( kapee_get_option( 'sale-single-product-label-after-price', 'after-price' ) != 'after-price' ) return;
		if ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price', 0 ) ) {
			return;
		}
		$output_labels = kapee_product_labels( 'percentage' );
		
		$output ='<div class="product-price-discount">';
		$output .= ( isset( $output_labels['sale'] ) ) ? $output_labels['sale'] : '';
		$output .='</div>';
		
		echo apply_filters( 'kapee_single_product_price_discount',  $output );
	}
endif;

if( ! function_exists( 'kapee_single_product_price_summary' ) ) :
	/**
	 * Single Product Price Summery
	 */
	function kapee_single_product_price_summary(){
	
		if( ! kapee_get_option( 'single-product-price-summary', 1 ) ) { return; }
		
		if ( ! is_user_logged_in() && kapee_get_option( 'login-to-see-price',0 ) ) { return;}
		
		global $product;
		
		if($product->get_type() == 'grouped'){
			return;
		}
		
		if( $product->get_price_html() === '' ){
			return;
		}
		
		$regular_price = $sale_price = $percentage = $discount = $discount_price = 0;
		if( $product->is_on_sale() && $product->get_type() == 'variable' ){
			
			$available_variations 	= $product->get_variation_prices();
			$variation_min_price = $product->get_variation_price('min');
			$variation_max_price = $product->get_variation_price('max');
			
			$max_value 				= 0;
			foreach( $available_variations['regular_price'] as $key => $regular_price ) {
				$sale_price = $available_variations['sale_price'][$key];	
				if ( $sale_price < $regular_price ) {
					$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
					if ( $percentage > $max_value ) {
						$max_value 				= $percentage;
						$variation_max_price 	= $regular_price;
					}
				}
			}
			$percentage 	= $max_value;
			$regular_price 	= $variation_max_price;
			$sale_price 	= $variation_min_price;
			$discount_price = $regular_price - $sale_price;			
		} elseif ( $product->get_type() == 'variable' ) {
			$variation_min_price = $product->get_variation_price('min');
			$variation_max_price = $product->get_variation_price('max');
			$regular_price = $variation_max_price;
			$sale_price = $variation_min_price;
			$discount_price	= $regular_price - $sale_price;
			$percentage 	= ( $regular_price > 0 ) ? round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) : 0 ;			
		} elseif ( $product->is_on_sale() && ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) ) {
			$regular_price 	= $product->get_regular_price();
			$sale_price 	= $product->get_sale_price();
			$discount_price	= $regular_price - $sale_price;
			$percentage 	= round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		}else{
			$regular_price = $product->get_regular_price();
			$sale_price = $product->get_regular_price();
		}
		$regular_price = wc_get_price_to_display($product, array('qty' => 1, 'price'=> $regular_price ));
		$sale_price = wc_get_price_to_display($product, array('qty' => 1, 'price'=> $sale_price ));
		if($discount_price){
			$discount_price	= $regular_price - $sale_price;
		}
		ob_start();?>
		<div class="product-price-summary exclamation-mark open">
			<div class="price-summary kapee-arrow">
				<div class="price-summary-header">
					<span class="kapee-close"><?php esc_html_e( 'Close', 'kapee' );?></span>
					<h5><?php echo apply_filters( 'kapee_product_price_summary_title', esc_html__('Price Summary', 'kapee' ));?></h5>
				</div>
				<div class="price-summary-content">
					<ul class="price-summary-list">
						<li class="regular-price">
							<label><?php esc_html_e( 'Maximum Retail Price', 'kapee' );?><br/>
								<span><?php esc_html_e( '(incl. of all taxes)', 'kapee' );?></span>
							</label>
							<?php if( $product->is_on_sale() ) :?>
								<span style="text-decoration:line-through"><?php echo wc_price( $regular_price );?></span>
							<?php else: ?>
								<span><?php echo wc_price( $regular_price );?></span>
							<?php endif;?>
						</li>
						
						<li class="selling-price">
							<label><?php esc_html_e( 'Selling Price', 'kapee' );?></label>
							<span><?php echo wc_price( $sale_price );?></span>
						</li>
						
						<?php if( $product->is_on_sale() && isset( $percentage) &&  $percentage != 0 ) :?>
						<li class="discount">
							<label><?php esc_html_e( 'Discount', 'kapee' );?></label>
							<span><?php echo esc_html( $percentage );?>&#37;</span>
						</li>
						<?php endif;?>
						
						<li class="total-discount">
							<label><?php esc_html_e( 'Total', 'kapee' );?></label>
							<span> <?php echo wc_price( $sale_price ); ?></span>
						</li>
						<?php if( $product->is_on_sale() ) :?>
						<li class="overall-discount">
							<?php echo sprintf(__( 'Overall you save <span class="amount-discount">%1$s</span> <span class="percentage-discount">(%2$s)</span> on this product', 'kapee' ), wc_price( $discount_price ), $percentage.'%' );?>
						</li>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</div>
		<?php
		$output = ob_get_clean();
		
		echo apply_filters( 'kapee_single_product_price_summary',  $output );
	}
endif;

function kapee_get_products_availability( $availability, $_product ) {
   //global $product;
 
   // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] 	= kapee_get_option( 'single-product-availability-instock-msg', 'In Stock' );
		$availability['class'] 			= 'in-stock';
		$stockQty						= kapee_get_option( 'single-product-availability-lowstock-qty', 5 );
    }
 
    // Change in Stock Text to only 1 or 2 left
    if ( $_product->is_in_stock() && $_product->get_stock_quantity() <= $stockQty ) {
		$stock_string = kapee_get_option( 'single-product-availability-hurry-left-msg', 'Hurry, Only {qty} left.' );
		$qty = $_product->get_stock_quantity();
		if( ! empty( $qty ) ){
			$stock_outputstring  = str_replace('{qty}',$qty,$stock_string); 
			$availability['availability'] = $stock_outputstring;
			$availability['class'] = 'min-stock';
		}else{
			$availability['availability'] = kapee_get_option( 'single-product-availability-instock-msg', 'In Stock' );
			$availability['class'] = 'in-stock';
		}
		
	}
 
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
    	$availability['availability'] = kapee_get_option( 'single-product-availability-outstock-msg', 'Out of Stock' );
		$availability['class'] = 'out-of-stock';
    } 
    return $availability;
}
add_filter( 'woocommerce_get_availability', 'kapee_get_products_availability', 1, 2);

if ( ! function_exists( 'kapee_single_product_stock_availability' ) ) :
	/**
	 * Single Product Stock Availability Message
	 */
	function kapee_single_product_stock_availability() {

		if( ! kapee_get_option( 'single-product-stock-availability', 1 ) ) return;
		
		global $product;    
		$availability = $product->get_availability();
		
		echo '<div class="stock-availability '.esc_attr($availability['class']).'">'.$availability['availability'].'</div>';
	}
endif;

if( ! function_exists( 'kapee_single_product_offers' ) ) :
	/**
	 * Single Product Offers
	 */
	function kapee_single_product_offers(){
		
		if( ! kapee_get_option( 'single-product-offers', 1 ) ) return;
		
		global $product;
		$prefix 	= KAPEE_PREFIX;
		$post_id 	= $product->get_id();
		$offer_data = get_post_meta( $post_id, $prefix.'offer',true);
		$is_offer_available = get_post_meta( $post_id, $prefix.'is_offer_available', true );
		if( !$is_offer_available || empty( $offer_data ) ) return;
		
		ob_start();?>
		<div class="product-offers">
			<ul class="product-offers-list">
				<?php foreach( $offer_data as $data ){ ?>
					<li class="product-offer-item">
						<?php 
						echo wp_kses( $data['title'], kapee_allowed_html(array('span','strong','div','a')) );
						
						if( ! empty( $data['link_txt'] ) ){ 
							$block_id = $data['desc'];
						?>
						<div class="product-term-wrap"> 
							<span class="product-term-text kapee-ajax-block" data-id="<?php echo esc_attr($block_id);?>"><?php echo wp_kses( $data['link_txt'], kapee_allowed_html(array('span','strong','div','a')) );?>
							
							</span>							
						</div>	
						<?php }
						?>
					</li>
					<?php
				}?>
			</ul>
		</div>
		<?php
		$output = ob_get_clean();
		echo apply_filters( 'kapee_single_product_offers',  $output );
	}
endif;

if( ! function_exists( 'kapee_single_product_services' ) ) :
	/**
	 * Single Product Services
	 */
	function kapee_single_product_services(){
		
		if( ! kapee_get_option( 'single-product-services', 1 ) ) return;
		
		global $product;
		$prefix 	= KAPEE_PREFIX;
		$post_id 	= $product->get_id();
		$service_data = get_post_meta( $post_id, $prefix.'service', true );
		$is_service_available = get_post_meta( $post_id, $prefix.'is_service_available', true );
		if( ! $is_service_available || empty( $service_data ) ) { return; }
		$services_label_text = kapee_get_option( 'single-product-services-label', esc_html__( 'Services:', 'kapee' ) );
		$services_label = apply_filters( 'kapee_single_product_services_label', $services_label_text );
		
		ob_start();?>
		<div class="product-services">
			<?php if( ! empty( $services_label ) ){ ?>
				<span><?php echo esc_html__( $services_label );?></span>
			<?php } ?>
			<ul class="product-services-list">
				<?php foreach( $service_data as $data ){ ?>
					<li class="product-service-item">
						<?php 
						echo wp_kses( $data['title'], kapee_allowed_html( array( 'span', 'strong', 'div', 'a' ) ) );
						$block_id = $data['desc']; ?>
						<div class="product-term-wrap"> 
							<span class="product-term-text<?php echo ( empty( $data['link_txt'] ) ) ? ' question-mark' : ''?> kapee-ajax-block" data-id="<?php echo esc_attr($block_id);?>">
							<?php echo wp_kses( $data['link_txt'], kapee_allowed_html( array( 'span', 'strong', 'div', 'a' ) ) );?>
							</span>
						</div>
					</li>					
				<?php }?>
			</ul>
		</div>
		<?php
		$output = ob_get_clean();
		echo apply_filters( 'kapee_single_product_services',  $output );
	}
endif;

if( ! function_exists( 'kapee_single_product_brands' ) ) :
	/**
	 * Single Product Brands
	 */
	function kapee_single_product_brands(){		
		
		if( ! kapee_get_option( 'single-product-brands', 1 ) ) return;
		
		$brands = get_the_terms( get_the_ID(), 'product_brand' );	
		if( ! is_wp_error( $brands ) && !empty ( $brands ) ):?>		
			<div class="product-brands">
				<?php foreach( $brands as $brand ): 
					$thumbnail_id 	= absint( get_term_meta( $brand->term_id, 'thumbnail_id', true ) );
					$brand_link 	= get_term_link( $brand, 'product_brand' ); 
					$brand_class 	= $thumbnail_id ? 'brand-image' : 'brand-title'; ?>
					<a class="<?php echo esc_attr($brand_class);?>" href="<?php echo esc_url( get_term_link($brand) ); ?>" title="<?php echo esc_attr($brand->name);?>">                        
						<?php 
						if ($thumbnail_id  ) {
							echo wp_get_attachment_image( $thumbnail_id, 'full' );
						} else {
							echo esc_html($brand->name);
						}
						 ?>
					</a> 
				<?php endforeach; // end of the loop. ?>
			</div>
		<?php
		endif;
	}
endif;

if( ! function_exists( 'kapee_woocommerce_grouped_product_list_image' ) ) :
	/**
	 * Group Product added image in grouped product list
	 */
	function kapee_woocommerce_grouped_product_list_image( $product ){
		 $image = $product->get_image( array( '50', '50' ), array( 'class' => 'product-img' ) );
		$thumbnail = '<div class="product-thumbnail">'.$image.'</div>';
		echo '<td class="woocommerce-grouped-product-list-item__thumbnail">'.$thumbnail.'</td>';
	}
	add_action( 'woocommerce_grouped_product_list_before_quantity', 'kapee_woocommerce_grouped_product_list_image' );
endif;

if( ! function_exists( 'kapee_single_product_size_chart' ) ) :
	/**
	 * Single Product Size Chart
	 */
	function kapee_single_product_size_chart(){
		
		if( ! kapee_get_option( 'single-product-size-chart', 1 ) ) return;
		
		$prefix 	= KAPEE_PREFIX;
		$chart_id 	= get_post_meta(get_the_ID(),  $prefix.'size_guide', true );
		if( empty( trim($chart_id) ) ) return;?>		
		<div class="product-sizechart">
			<a href="#" data-id="<?php echo esc_attr($chart_id);?>" class="kapee-ajax-size-chart"><?php echo apply_filters( 'kapee_single_product_sizechart_label', esc_html__('Size Guide', 'kapee') );?></a>
		</div>
		<?php 
	}
endif;

if( ! function_exists('kapee_add_quick_buy_pid') ) :
	/* Quick buy button*/
	function kapee_add_quick_buy_pid() {
		
		if( ! kapee_get_option( 'single-product-quick-buy', 0 ) ) return;
		
		global $product;
		if ( $product != null ) {
			echo '<input type="hidden" id="kapee_quick_buy_product_' . esc_attr( $product->get_id() ). '" value="' . esc_attr( $product->get_id() ) . '"  />';
		}
	}
endif;

if( ! function_exists('kapee_add_quick_buy_button') ) :
	function kapee_add_quick_buy_button(){
		
		if( ! kapee_get_option( 'single-product-quick-buy', 0 ) ) return;
		
		global $product;
		$html = '';

		if ( $product == null ) {
			return;
		}
		if ( $product->get_type() == 'external' ) {
			return;
		}
		$pid 			= $product->get_id();
		$type 			= $product->get_type();
		$label 			= kapee_get_option( 'product-quickbuy-button-text', 'Buy Now' );
		$quick_buy_btn_style 	= 'button';
		$class 			= '';
		$defined_class 	= 'kapee_quick_buy_' . $type . ' kapee_quick_buy_' . $pid;
		$defined_id    	= 'kapee_quick_buy_button_'. $pid ;
		$defined_attrs 	= 'name="kapee_quick_buy_button"  data-product-type="' . esc_attr( $type ) . '" data-kapee-product-id="' . esc_attr($pid ) . '"';
		echo '<div id="kapee_quick_buy_container_' . esc_attr( $pid ).'" class="kapee-quick-buy">';

		if ( $quick_buy_btn_style == 'button' ) {
			echo '<button  id="' . esc_attr( $defined_id ) . '"   class="kapee_quick_buy_button '.esc_attr( $defined_class ).'" value="' . esc_attr($label) . '" type="button" ' . $defined_attrs . '>' . esc_attr($label) . '</button>';
		}
		echo  '</div>';
	}
endif;

if( ! function_exists('kapee_quick_buy_redirect') ) :
	/**
	 * Function to redirect user after qucik buy button is submitted
	 */
	function kapee_quick_buy_redirect( $url ) {
		if ( isset( $_REQUEST['kapee_quick_buy'] ) && $_REQUEST['kapee_quick_buy'] == true ) {
			$redirect = 'checkout';
			if ( $redirect == 'cart' ) {
				return wc_get_cart_url();
			} elseif ( $redirect == 'checkout' ) {
				return wc_get_checkout_url();
			}
		}
		return $url;
	}
endif;

if( ! function_exists('kapee_single_product_delivery_return_ask_question') ) :
	/**
	 * Single Product Delivery Return & Ask a Quesion
	 */
	function kapee_single_product_delivery_return_ask_question() {
		
		if( kapee_get_option( 'product-delivery-return', 0 ) || kapee_get_option( 'product-ask-quetion', 0 ) ){ ?>
			
			<div class="kapee-deliver-return-ask-questions">
				<?php if( kapee_get_option( 'product-delivery-return', 0 ) ){
					$class = '';
					$block_id = kapee_get_option( 'delivery-return-terms', 0 ); 
					if( $block_id ){
						$class = ' kapee-block-ajax';
					}
					?>
					<div class="kapee-deliver-return<?php echo esc_attr($class);?>" data-id="<?php echo esc_attr($block_id);?>">
						<?php echo esc_html( kapee_get_option( 'delivery-return-label', 'Delivery & Return' ) ); ?>
					</div>
				<?php } ?>
				
				<?php if( kapee_get_option( 'product-ask-quetion', 0 ) ){
					$class = '';
					$form_id = kapee_get_option( 'ask-question-form', 0 );
					if( $form_id ){
						$class = ' kapee-ask-questions-ajax';
					}					
					global $product;
					$product_title = $product->get_name(); ?>
					<div class="kapee-ask-questions<?php echo esc_attr( $class );?>" data-id="<?php echo esc_attr( $form_id );?>">
						<?php echo esc_html( kapee_get_option( 'ask-quetion-label', 'Ask a Question' ) ); ?>
					</div>
					<div id="kapee-ask-questions-popup" class="kapee-ask-questions-popup mfp-hide">
						<h3 class="ask-questions-form-tile"> 
							<?php echo esc_html( kapee_get_option( 'ask-quetion-form-title', 'Ask a Question' ) ); ?>
						</h3>
						<?php echo do_shortcode('[contact-form-7 id="'.$form_id.'" product-title="'.$product_title.'"]'); ?>
					</div>
				<?php } ?>
			</div>
		<?php }
	}
endif;

if( ! function_exists('kapee_shortcode_atts_wpcf7_filter') ) :
	/**
	 * Custom attribute add to form
	 */
	function kapee_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
		$my_attr = 'product-title';
		if ( isset( $atts[$my_attr] ) ) {
			$out[$my_attr] = $atts[$my_attr];
		}
		return $out;
	}
	add_filter( 'shortcode_atts_wpcf7', 'kapee_shortcode_atts_wpcf7_filter', 10, 3 );
endif;

if( ! function_exists('kapee_single_product_estimated_delivery') ) :
	/**
	 * Single Product Estimated Delivery Time
	 */
	function kapee_single_product_estimated_delivery() {
		
		if( ! kapee_get_option( 'product-estimated-delivery', 0 ) ) { 
			return;			
		}
		$number			= kapee_get_option( 'estimated-delivery-days', array( 1 => 3, 2 => 7, ) );
		$to_days		= $number['1'];
		$from_days		= $number['2'];
		$minDate		= wp_date( 'Y-m-d', strtotime( " + " . $to_days . " days" ) );
		$maxDate 		= wp_date( 'Y-m-d', strtotime( " + " . $from_days . " days" ) );
		$date_string	= date_i18n( "d F ", strtotime( $minDate ) ) . ' - ' . date_i18n( "d F", strtotime( $maxDate ) );
		?>
		<div class="kapee-estimated-delivery">
			<div class="kapee-delivery-label">
				<?php echo esc_html( kapee_get_option( 'estimated-delivery-label', 'Estimated Delivery:' ) ); ?>
			</div>
			<div class="kapee-delivery-date"><?php echo esc_html( $date_string );?> </div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_single_product_visitor_count' ) ) :
	/**
	 * Single Product Visitor Count
	 */
	function kapee_single_product_visitor_count() {
		
		if( ! kapee_get_option( 'single-product-visitor-count', 0 ) ) { 
			return;
		}
		
		$number			= kapee_get_option( 'random-visitor-number', array( 1 => 20, 2 => 50, ) );
		$min 			= $number['1'];
		$max 			= $number['2'];
		$delay 			=  kapee_get_option( 'visitor-count-delay-time', '5' );
		$visitor_count 	= rand( $min, $max );
		$enable_enterval = '';
		if( $delay  > 0 ){
			$enable_enterval 	= ' kapee-visitor-change';
		}		
		$visitor_count_btml = '<span class="product-visitor-count">'.$visitor_count.'</span>';
		$count_message		= kapee_get_option( 'visitor-count-text', '{visitor_count} People viewing this product right now!' );
		$count_message		= str_replace( '{visitor_count}', $visitor_count_btml, $count_message );
		
		
		$visitor_count_html = '<div class="kapee-visitor-count'.$enable_enterval.'" data-min="'.$min.'" data-max="'.$max.'" data-delay="'.$delay.'">'. $count_message .'</div>';
		
		echo apply_filters('kapee_product_visitor_count', $visitor_count_html );
	}
endif;

if ( ! function_exists( 'kapee_single_product_trust_badge' ) ) :
	/**
	 * Single Product Trust Badge
	 */
	function kapee_single_product_trust_badge() {
		
		if( ! kapee_get_option( 'single-product-trust-badge', 0 ) ) { 
			return;
		}
		
		$trust_badge_url = kapee_get_option( 'trust-badge-image', array( 'url' => KAPEE_IMAGES.'/trust_badge.png') );
		
		if( empty( $trust_badge_url ) ) { 
			return;
		}
		
		ob_start(); ?>						
		<div class="kapee-product-trust-badge">
			<fieldset>
				<legend><?php echo esc_html( kapee_get_option( 'trust-badge-label', 'Guaranteed Safe Checkout' ) ); ?></legend>
				<img src="<?php echo esc_url($trust_badge_url['url']); ?>" alt="<?php esc_attr_e( 'Trues Badge', 'kapee' ); ?>"/>
			</fieldset>
		</div>		
		<?php 
		$badge_html = ob_get_clean();
			
		echo apply_filters( 'kapee_product_trust_badge', $badge_html );
	}
endif;

if ( ! function_exists( 'kapee_single_product_share' ) ) :
	/**
	 * Single Product Share
	 */
	function kapee_single_product_share() {
		
		if( ! kapee_get_option( 'single-product-share', 1 ) ) return; ?>
		
		<?php if ( function_exists( 'kapee_social_share' ) ) { ?>
			<div class="product-share">
				<span class="share-label">
					<?php esc_html_e('Share:', 'kapee');?>
				</span>
				<?php kapee_social_share( array( 'type'=>'share', 'el_class' => 'kapee-arrow' ) ); ?>
			</div>
		<?php 
		}
	}
endif;

if ( ! function_exists( 'kapee_product_navigation_share' ) ) :
	/**
	 * Single Product Navigation & Share
	 */
	function kapee_product_navigation_share() { ?>
		
		<div class="product-navigation-share">
			<?php 
			/**
			 * Hook: kapee_product_navigation_share.
			 *
			 * @hooked kapee_single_product_share - 5
			 * @hooked kapee_single_product_navigation - 10
			 */
			 do_action( 'kapee_product_navigation_share' );
			?>
		</div>
		<?php 
	}
endif;

if ( ! function_exists( 'kapee_output_recently_viewed_products' ) ) :
	/**
	 * Single Product Share
	 */
	function kapee_output_recently_viewed_products() {
		
		$recently_viewed_products = kapee_get_recently_viewed_products();		
		if(empty($recently_viewed_products)){ return;}
		$args['recently_viewed_products'] = $recently_viewed_products;
		// Set global loop values.
		wc_set_loop_prop( 'name', 'recently-viewed' );
		wc_get_template( 'single-product/recently-viewed.php', $args );
	}
endif;

if( ! function_exists('kapee_reduce_woocommerce_min_strength_requirement') ) :
	/** 
	 *Reduce the strength requirement on the woocommerce password.
	 * 
	 * Strength Settings
	 * 3 = Strong (default)
	 * 2 = Medium
	 * 1 = Weak
	 * 0 = Very Weak / Anything
	 */
	function kapee_reduce_woocommerce_min_strength_requirement( $strength ) {
		if( kapee_get_option('manage-password-strength', 0) )
			return kapee_get_option('user-password-strength', 3);
		else
			return 3;		 
	}
	add_filter( 'woocommerce_min_password_strength', 'kapee_reduce_woocommerce_min_strength_requirement' );
endif;

/**
 * My Account Page
 */
if ( ! function_exists( 'kapee_before_account_navigation' ) ) :
	/**
	 * Add wrap and user info to the account navigation
	 */
	function kapee_before_account_navigation() {

		// Name to display
		$current_user = wp_get_current_user();

		if ( $current_user->display_name ) {
			$name = $current_user->display_name;
		} else {
			$name = esc_html__( 'Welcome!', 'kapee' );
		}
		$name = apply_filters( 'kapee_user_profile_name_text', $name );

		echo '<div class="MyAccount-navigation-wrapper">';
			echo '<div class="kapee-user-profile">';
				echo '<div class="user-avatar">'. get_avatar( $current_user->user_email, 128 ) .'</div>';
				echo '<div class="user-info">';
					echo '<h5 class="display-name">'. esc_attr( $name ) .'</h5>';
				echo '</div>';
			echo '</div>';
	}
endif;

if ( ! function_exists( 'kapee_after_account_navigation' ) ) :
	/**
	 * Add wrap to the account navigation.
	 */
	function kapee_after_account_navigation() {
		echo '</div>';
	}
endif;

if ( ! function_exists( 'kapee_woocommerce_before_account_orders' ) ) :
	/**
	 *  My Orders Page Title
	 */
	function kapee_woocommerce_before_account_orders( $has_orders) {
		?>
		<div class="section-title">
			<h2><?php esc_html_e( 'My Orders', 'kapee' ); ?></h2>
			<p><?php esc_html_e( 'Your recent orders are displayed in the table below.', 'kapee' ); ?></p>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_woocommerce_before_account_downloads' ) ) :
	/**
	 *  My Downloads Page Title
	 */
	function kapee_woocommerce_before_account_downloads( $has_orders) {
		?>
		<div class="section-title">
			<h2><?php esc_html_e( 'My Downloads', 'kapee' ); ?></h2>
			<p><?php esc_html_e( 'Your digital downloads are displayed in the table below.', 'kapee' ); ?></p>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_woocommerce_my_account_my_address_description' ) ):
	/**
	 *  My Address Page Title
	 */
	function kapee_woocommerce_my_account_my_address_description( $address_desc ) {
		
		$address_title = '<div class="section-title">';
		$address_title .= '<h2>'.esc_html__('Address','kapee').'</h2>';
		$address_title .= '<p>' . $address_desc . '</p>';
		$address_title .= '</div>';
		return $address_title;
	}
endif;


if ( ! function_exists( 'kapee_woocommerce_myaccount_edit_account_heading' ) ) :
	/**
	 * Edit Account Heading
	 */
	function kapee_woocommerce_myaccount_edit_account_heading() {
		?>
		<div class="section-title">
			<h2><?php esc_html_e( 'My account', 'kapee' ) ?></h2>
			<p><?php esc_html_e( 'Edit your account details or change your password', 'kapee' ); ?></p>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'kapee_free_shipping_bar' ) ) :
	/**
	 * Free Shipping Progress Bar
	 */
	function kapee_free_shipping_bar() {
		
		if( ! kapee_get_option( 'free-shipping-bar', 0 ) ) {
			return;
		}
		if( empty( kapee_get_option( 'free-shipping-amount', '' ) ) ) {
			return;
		}
		$subtotal = WC()->cart->subtotal;
		$minimum_amount = kapee_get_option( 'free-shipping-amount', 0 );
		if( $subtotal < $minimum_amount ){
			$remaining 		= $minimum_amount - $subtotal;
			$percentage 	= round( ( $subtotal / $minimum_amount ) * 100 ) ;
			$missing_amount = wc_price($remaining);
			$free_shipping_text = kapee_get_option('free-shipping-msg','Spend {missing_amount} to get <strong>free shipping</strong>');
			$free_shipping_text = str_replace( '{missing_amount}', $missing_amount, $free_shipping_text );
			$class = 'active';
			
		}else{
			$free_shipping_text = kapee_get_option('free-shipping-complete-msg','Congratulation! You have got free shipping');
			$percentage = 100;
			$class = 'completed';
		}?>
		<div class="kapee-freeshipping-bar <?php echo esc_attr($class);?>">
			<div class="freeshipping-bar">				
				<span class="progress-bar active" style="width:<?php echo esc_attr( $percentage );?>%"><?php echo wp_kses_post( $percentage );?>%</span>
			</div>
			<div class="freeshipping-bar-msg"><?php echo wp_kses_post( $free_shipping_text );?></div>
		</div>
	<?php }
endif;

if ( ! function_exists( 'kapee_woocommerce_cart_page_wrapper' ) ) :
	/**
	 * Cart Page Wrapper Start
	 */
	function kapee_woocommerce_cart_page_wrapper() { ?>
		<div class="woocommerce-cart-wrapper">
	<?php }
endif;

if ( ! function_exists( 'kapee_woocommerce_cart_page_wrapper_end' ) ) :
	/**
	 * Cart Page Wrapper End
	 */
	function kapee_woocommerce_cart_page_wrapper_end() { ?>
		</div>
	<?php }
endif;

if ( ! function_exists( 'kapee_sticky_add_to_cart_button' ) ) :
	/**
	 * Single Product Sticky Add To Cart Button
	 */
	function kapee_sticky_add_to_cart_button(){
		
		global $product;		
		$stick_add_to_cart = kapee_get_option( 'sticky-add-to-cart-button', 1 );
		
		if ( !$product || ! is_singular( 'product' ) || ! $stick_add_to_cart || !$product->is_in_stock() ) {
			return;
		}
		?>
		<div class="kapee-sticky-add-to-cart">
			<div class="container">
				<div class="row">
					<div class="col sticky-add-to-cart-left">
						<div class="sticky-product-image">
							<?php echo woocommerce_get_product_thumbnail( 'woocommerce_gallery_thumbnail'); ?>
						</div>
						<div class="sticky-product-info">
							<div class="sticky-product-title"><?php the_title(); ?></div>
							<?php 
								if( wc_review_ratings_enabled() ){
									echo wc_get_rating_html( $product->get_average_rating() );
								}
							?>
						</div>
					</div>
					<div class="col-auto sticky-add-to-cart-right">
						<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>						
						<a href="<?php echo esc_url( '#' ); ?>" class="button <?php echo esc_attr( $product->get_type() );?>" rel="nofollow">
							<?php echo esc_attr( $product->add_to_cart_text() ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;