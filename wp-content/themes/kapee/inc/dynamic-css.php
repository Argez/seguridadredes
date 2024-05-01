<?php
/**
 * Load dynamic css
 */
if ( ! function_exists( 'kapee_theme_style' ) ) :
function kapee_theme_style() {	
	
	/** Site Fonts */
	$style_options['font']['body']= kapee_get_option( 'body-font', array(
		'font-weight'  		=> '400', 
		'font-family' 		=> 'Lato', 
		'google'      		=> true,
		'font-backup' 		=> 'Arial, Helvetica, sans-serif',
		'font-size'   		=> '14px', 
		'letter-spacing'	=> '',
	) );
	
	/** Site Layouts Options */
	$style_options['site']['site_layouts'] 		= kapee_get_option( 'theme-layout', 'full' );
	$container_width 							= kapee_get_option( 'theme-container-width', 1200 );
	$style_options['site']['container_width'] 	= $container_width.'px';
	if( 'wide' == kapee_get_option( 'theme-layout', 'full' ) ) {
		$style_options['site']['container_width'] = '100%';
	}
	
	/* Promo Bar */	
	$style_options['promo_bar']['max_height'] = kapee_get_option( 'promo-bar-height', 60 );
	$style_options['promo_bar']['button_text'] = kapee_get_option('promo-button-text-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#fcfcfc',
	) );
	$style_options['promo_bar']['button_background'] = kapee_get_option('promo-button-background', array(
		'regular' 	=> '#2370F4',
		'hover' 	=> '#538ef4',
	) );
	
	/** Site Logos Width */
	$style_options['site']['logo_width'] = kapee_get_option( 'header-logo-width', 126 );
	$style_options['site']['sticky_logo_width'] = kapee_get_option( 'sticky-header-logo-width', 98 );
	$style_options['site']['mobile_logo_width'] = kapee_get_option( 'mobile-header-logo-width', 86 );
	
	/** Site Colors Options */
	$style_options['site']['primary_color'] = kapee_get_option('primary-color','#2370F4');
	$style_options['site']['primary_inverse_color'] = kapee_get_option('primary-inverse-color','#ffffff');
	$style_options['site']['hover_background_color'] = kapee_get_option('theme-hover-background-color','#F5fAFF');
	$style_options['site']['hex2rgb_color'] = kapee_hex2rgb( $style_options['site']['primary_color'] );

	$style_options['site']['background'] = kapee_get_option('site-background', array(
			'background-color' 		=> '#ffffff',
			'background-image' 		=> '',
			'background-repeat' 	=> '',
			'background-size' 		=> '',
			'background-attachment' => '',
			'background-position' 	=> ''
	) );
	$style_options['site']['wrapper_background'] = kapee_get_option('site-wrapper-background', array( 
			'background-color' 		=> '#ffffff', 
			'background-image' 		=> '',
			'background-repeat' 	=> '',
			'background-size' 		=> '',
			'background-attachment' => '',
			'background-position' 	=> ''
	) );
	$style_options['site']['text_color'] = kapee_get_option('site-text-color','#555555');
	$site_link_color =  kapee_get_option('site-link-color', array(
		'regular' => '#333333',
		'hover' => '#2370F4',
	) );
	$style_options['site']['link_color'] = kapee_get_option('site-link-color', array(
		'regular' => '#333333',
		'hover' => '#2370F4',
	) );
	$style_options['site']['border'] = kapee_get_option('site-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );

	$style_options['site']['border_radius'] = kapee_get_option( 'site-border-radius', 0 );
	$style_options['site']['input_color'] = kapee_get_option( 'site-input-color', '#555555' );
	$style_options['site']['input_background'] = kapee_get_option('site-input-background', '#ffffff' );
	$style_options['site']['preloader_background'] = kapee_get_option('preloader-background', '#2370f4' );
	$style_options['site']['preloader_image'] = '';
	if( 'predefine-loader' != kapee_get_option('preloader-image', 'predefine-loader' ) ){
		$url = kapee_get_option('preloader-custom-image', array( 'url' => KAPEE_IMAGES.'logo-light.png' ) );
		$style_options['site']['preloader_image'] = $url['url'];
	}

	/** Site Buttons */
	$style_options['button']['background'] = kapee_get_option('button-background', array(
		'regular' 	=> '#2370F4',
		'hover' 	=> '#2370F4',
	) );
	$style_options['button']['color'] = kapee_get_option('button-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#f1f1f1',
	) );
	
	/** Product Page Buttons */
	$style_options['button']['product_cart_background'] = kapee_get_option('product-cart-button-background', array(
		'regular' 	=> '#ff9f00',
		'hover' 	=> '#ff9f00',
	) );
	$style_options['button']['product_cart_color'] = kapee_get_option('product-cart-button-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#fcfcfc',
	) );
	$style_options['button']['buy_now_background'] = kapee_get_option('buy-now-button-background', array(
		'regular' 	=> '#FB641B',
		'hover' 	=> '#FB641B',
	) );
	$style_options['button']['buy_now_color'] = kapee_get_option('buy-now-button-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#fcfcfc',
	) );
	
	/** Checkout Buttons */
	$style_options['button']['checkout_background'] = kapee_get_option('checkout-button-background', array(
		'regular' 	=> '#FB641B',
		'hover' 	=> '#FB641B',
	) );
	$style_options['button']['checkout_color'] = kapee_get_option('checkout-button-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#fcfcfc',
	) );
	
	/** Topbar Colors Options */
	$style_options['topbar']['text_color'] = kapee_get_option('topbar-text-color','#FFFFFF');
	$style_options['topbar']['link_color'] = kapee_get_option('topbar-link-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#F1F1F1',
	) );
	$style_options['topbar']['border'] = kapee_get_option( 'topbar-border', array(
		'border-color'  => '#3885fe',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['topbar']['input_color'] = kapee_get_option( 'topbar-input-color', '#555555' );
	$style_options['topbar']['input_background'] = kapee_get_option( 'topbar-input-background', '#ffffff');
	$style_options['topbar']['max_height'] = kapee_get_option( 'topbar-max-height', array( 'height' => '42' ) );
	$style_options['topbar']['max_height'] = str_replace( 'px', '', $style_options['topbar']['max_height'] );
	
	/** Header Colors Options */
	$style_options['header']['text_color'] = kapee_get_option('header-text-color','#555555');  
	$style_options['header']['link_color'] = kapee_get_option('header-link-color', array(
		'regular' => '#333333',
		'hover' => '#2370f4',
	) );
	$style_options['header']['border'] = kapee_get_option('header-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['header']['input_color'] = kapee_get_option('header-input-color','#555555');
	$style_options['header']['input_background'] = kapee_get_option('header-input-background','#ffffff');
	$style_options['header']['min_height'] = kapee_get_option( 'header-min-height', array( 'height' => '100' ) );
	$style_options['header']['min_height'] = str_replace( 'px', '', $style_options['header']['min_height'] );
	
	/** Header Sticky Options */
	$style_options['header_sticky']['text_color'] = kapee_get_option('header-sticky-text-color','#555555'); 
	$style_options['header_sticky']['link_color'] = kapee_get_option('header-sticky-link-color', array(
		'regular' => '#333333',
		'hover' => '#2370f4',
	) );
	$style_options['header_sticky']['border'] = kapee_get_option('header-sticky-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['header_sticky']['input_color'] = kapee_get_option('header-sticky-input-color','#555555');
	$style_options['header_sticky']['input_background'] = kapee_get_option('header-sticky-input-background','#ffffff');
	$style_options['header_sticky']['min_height'] = kapee_get_option( 'header-sticky-max-height', array( 'height' => '56' ) );
	$style_options['header_sticky']['min_height'] = str_replace( 'px', '', $style_options['header_sticky']['min_height'] );
	
	/** Navigation Options */
	$style_options['navigation']['text_color'] = kapee_get_option('navigation-text-color','#555555');
	$style_options['navigation']['link_color'] = kapee_get_option('navigation-link-color', array(
		'regular' => '#2370F4',
		'hover' => '#ff8400',
	) );
	$style_options['navigation']['border'] = kapee_get_option('navigation-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['navigation']['input_color'] = kapee_get_option('navigation-input-color','#555555');
	$style_options['navigation']['input_background'] = kapee_get_option('navigation-input-background','#ffffff');
	$style_options['navigation']['min_height'] = kapee_get_option( 'navigation-min-height', array( 'height' => '50' ) );
	$style_options['navigation']['min_height'] = str_replace( 'px', '', $style_options['navigation']['min_height'] );
	
	
	/** Menu Options */	
	$style_options['first_level_menu']['hover_background'] = kapee_get_option('first-level-menu-background-color','transparent');
	$style_options['first_level_menu']['link_color'] = kapee_get_option('first-level-menu-link-color', array(
		'regular' 	=> '#333333',
		'hover' 	=> '#2370F4',
	) );
	$style_options['first_level_sticky_menu']['hover_background'] = kapee_get_option('first-level-sticky-menu-background-color', 'transparent');
	$style_options['first_level_sticky_menu']['link_color'] = kapee_get_option('first-level-sticky-menu-link-color', array(
		'regular' 	=> '#333333',
		'hover' 	=> '#2370F4',
	) );
	$style_options['categories_menu']['title_background'] = kapee_get_option('categories-menu-title-background', '#2370F4' );
	$style_options['categories_menu']['title_color'] = kapee_get_option('categories-menu-title-color', '#ffffff');
	$style_options['categories_menu']['wrapper_background'] = kapee_get_option('categories-menu-wrapper-background', '#ffffff' );
	$style_options['categories_menu']['hover_background'] = kapee_get_option('categories-menu-hover-background', '#f5faff');
	$style_options['categories_menu']['link_color'] = kapee_get_option('categories-menu-link-color', array(
		'regular' 	=> '#333333',
		'hover' 	=> '#2370F4',
	) );
	$style_options['categories_menu']['border'] = kapee_get_option('categories-menu-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['popup_menu']['hover_background'] = kapee_get_option( 'popup-menu-hover-background', '#f5faff' );
	$style_options['popup_menu']['text_color'] = kapee_get_option('popup-menu-text-color', '#555555');
	$menu_link_color =  
	$style_options['popup_menu']['link_color'] = kapee_get_option('popup-menu-link-color', array(
		'regular' 	=> '#333333',
		'hover' 	=> '#2370F4',
	) );
	$style_options['popup_menu']['border'] = kapee_get_option('popup-menu-border', array(
		'border-color'  => '#e9e9e9',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	
	/** Page Title Options */
	$style_options['page_title']['padding'] = kapee_get_option('page-title-padding', array(
		'padding-top'     	=> '50px', 
		'padding-bottom'  	=> '50px',
	) );
	if(is_numeric($style_options['page_title']['padding']['padding-top'])){
		$style_options['page_title']['padding']['padding-top'] = absint( $style_options['page_title']['padding']['padding-top'] ) . 'px';
	}
	if(is_numeric($style_options['page_title']['padding']['padding-bottom'])){
		$style_options['page_title']['padding']['padding-bottom'] = absint( $style_options['page_title']['padding']['padding-bottom'] ) . 'px';
	}
	
	/** Footer Options */
	$style_options['footer']['title_color'] = kapee_get_option('footer-title-color','#ffffff');
	$style_options['footer']['text_color'] = kapee_get_option('footer-text-color','#f1f1f1');
	$style_options['footer']['link_color'] = kapee_get_option('footer-link-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#f1f1f1',
	) );
	$style_options['footer']['border'] = kapee_get_option('footer-border', array(
		'border-color'  => '#454d5e',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	$style_options['footer']['input_color'] = kapee_get_option('footer-input-color','#555555');
	$style_options['footer']['input_background'] = kapee_get_option('footer-input-background','#ffffff');
	
	/** Copyright Options */
	$style_options['copyright']['text_color'] = kapee_get_option('copyright-text-color','#f1f1f1');
	$style_options['copyright']['link_color'] = kapee_get_option('copyright-link-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#f1f1f1',
	) );
	$style_options['copyright']['border'] = kapee_get_option('copyright-border', array(
		'border-color'  => '#454d5e',
		'border-style'  => 'solid',
		'border-top'    => '1px',
		'border-right'  => '1px',
		'border-bottom' => '1px',
		'border-left'   => '1px'
	) );
	
	/** Mobile Header Options */
	$style_options['mobile_header']['background'] = kapee_get_option('header-mobile-background','#2370F4');
	$style_options['mobile_header']['text_color'] = kapee_get_option('header-mobile-text-color','#FFFFFF');
	$style_options['mobile_header']['link_color'] = kapee_get_option('header-mobile-link-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#f1f1f1',
	) );
	$style_options['mobile_header']['input_color'] = kapee_get_option('header-mobile-input-color','#555555');
	$style_options['mobile_header']['input_background'] = kapee_get_option('header-mobile-input-background','#ffffff');
	
	/** Woocommece */
	$style_options['woocommece']['single_line_title'] = kapee_get_option('single-line-product-title', 1 );
	$style_options['woocommece']['sale_label_color'] = kapee_get_option('sale-product-label-color','#82B440');
	$style_options['woocommece']['new_label_color'] = kapee_get_option('new-product-label-color','#388e3c');
	$style_options['woocommece']['featured_label_color'] = kapee_get_option('featured-product-label-color','#ff9f00');
	$style_options['woocommece']['outofstock_label_color'] = kapee_get_option('outofstock-product-label-color','#ff6161');
	
	/* Free Shiping Button Color */
	$style_options['free_shipping']['background'] = kapee_get_option('shipping-bar-bg-color','#efefef');
	$style_options['free_shipping']['color'] = kapee_get_option('shipping-bar-color','#2370F4');
	
	/** Newsletter Popup Options */
	$style_options['newsletter']['button_background'] = kapee_get_option( 'newsletter-button-bg-color', array(
		'regular' 	=> '#2370F4',
		'hover' 	=> '#2370F4',
	) );
	$style_options['newsletter']['button_color'] = kapee_get_option( 'newsletter-button-text-color', array(
		'regular' 	=> '#ffffff',
		'hover' 	=> '#f1f1f1',
	) );	
	
	$theme_css = '
		
		:root {
			/* Site Font */
			--site-primary-font: '.$style_options['font']['body']['font-family'].', '.$style_options['font']['body']['font-backup'].';		
			--site-font-size: '. $style_options['font']['body']['font-size'] .';
			--site-line-height: 1.9;
			
			/* Site Color */
			--primary-color: '. kapee_get_option( 'primary-color', '#2370F4' ) .';
			--primary-inverse-color: '. kapee_get_option( 'primary-inverse-color', '#ffffff' ) .';
			--site-text-color: '. kapee_get_option( 'site-text-color', '#555555' ) .';
			--site-hover-background-color: '. kapee_get_option( 'theme-hover-background-color', '#F5fAFF' ) .';
			--site-body-background: '. $style_options['site']['wrapper_background']['background-color'] .';
			--site-link-color: '. $style_options['site']['link_color']['regular'] .';
			--site-link-hover-color: '. $style_options['site']['link_color']['hover'] .';
			--site-border-top: '. $style_options['site']['border']['border-top'] .' '.$style_options['site']['border']['border-style'].' '.$style_options['site']['border']['border-color'].';
			--site-border-right: '. $style_options['site']['border']['border-right'].' '.$style_options['site']['border']['border-style'].' '.$style_options['site']['border']['border-color'] .';
			--site-border-bottom: '. $style_options['site']['border']['border-bottom'].' '.$style_options['site']['border']['border-style'].' '.$style_options['site']['border']['border-color'] .';
			--site-border-left: '. $style_options['site']['border']['border-left'].' '.$style_options['site']['border']['border-style'].' '.$style_options['site']['border']['border-color'] .';
			--site-border-color: '. $style_options['site']['border']['border-color'] .';
			--site-border-radius: '. kapee_get_option( 'site-border-radius', 0 ) .';
			--site-input-background: '. kapee_get_option( 'site-input-background', '#ffffff' ) .';
			--site-input-color: '. kapee_get_option( 'site-input-color', '#555555' ) .';			
		}
		
		/* Input Font */
		text,
		select, 
		textarea,
		number,
		div.nsl-container .nsl-button-default div.nsl-button-label-container{
			font-family: '.$style_options['font']['body']['font-family'].', sans-serif;
		}
		
		/* Placeholder Font */
		::-webkit-input-placeholder {
		   font-family: '.$style_options['font']['body']['font-family'].', sans-serif;
		}
		:-moz-placeholder { /* Firefox 18- */
		  font-family: '.$style_options['font']['body']['font-family'].', sans-serif;
		}
		::-moz-placeholder {  /* Firefox 19+ */
		   font-family: '.$style_options['font']['body']['font-family'].', sans-serif;
		}
		:-ms-input-placeholder {
		   font-family: '.$style_options['font']['body']['font-family'].', sans-serif;
		}
		
		/* 
		* page width
		*/
		.wrapper-boxed .site-wrapper, 
		.site-wrapper .container, 
		.wrapper-boxed .header-sticky{
			max-width:'.$style_options['site']['container_width'].';
		}
		.kapee-site-preloader {
			background-color:'.$style_options['site']['preloader_background'].';
			background-image: url('.$style_options['site']['preloader_image'].');
		}
		
		/**
		 * Site Logos Width
		 */
		.header-logo .logo,
		.header-logo .logo-light{
			max-width:'.$style_options['site']['logo_width'].'px;
		}
		.header-logo .sticky-logo{
			max-width:'.$style_options['site']['sticky_logo_width'].'px;
		}
		.header-logo .mobile-logo{
			max-width:'.$style_options['site']['mobile_logo_width'].'px;
		}
		@media (max-width:991px){
			.header-logo .logo,
			.header-logo .logo-light,
			.header-logo .mobile-logo{
				max-width:'.$style_options['site']['mobile_logo_width'].'px;
			}
		}
		
		/* 
		* Body color Scheme 
		*/
		body{
			color: '.$style_options['site']['text_color'].';
		}		
		
		select option,
		.kapee-ajax-search .search-field, 
		.kapee-ajax-search .product_cat,
		.search-results-wrapper .search-price del,
		.close-sidebar:before,
		.products .product-cats a,
		.products:not(.product-style-2) .whishlist-button a:before,
		.products.list-view .whishlist-button  a:before,
		.products .woocommerce-loop-category__title .product-count,
		.woocommerce div.product .kapee-breadcrumb,
		.woocommerce div.product .kapee-breadcrumb a,
		.product_meta > span span,
		.product_meta > span a,
		.multi-step-checkout .panel-heading,
		.kapee-tabs.tabs-classic .nav-tabs .nav-link,
		.kapee-tour.tour-classic .nav-tabs .nav-link,
		.kapee-accordion[class*="accordion-icon-"] .card-title a:after,
		.woocommerce table.wishlist_table tr td.product-remove a:before,
		.slick-slider button.slick-arrow,
		.owl-carousel .owl-nav button[class*="owl-"],
		.owl-nav-arrow .owl-carousel .owl-nav button[class*="owl-"],
		.owl-nav-arrow .owl-carousel .owl-nav button[class*="owl-"]:hover,
		.kapee-mobile-menu ul.mobile-main-menu li.menu-item-has-children > .menu-toggle{
			color: '.$style_options['site']['text_color'].';
		}
		
		/* Link Colors */
		a,
		label,
		thead th,
		.kapee-dropdown ul.sub-dropdown li a,
		div[class*="wpml-ls-legacy-dropdown"] .wpml-ls-sub-menu a,
		div[class*="wcml-dropdown"] .wcml-cs-submenu li a, 
		.woocommerce-currency-switcher-form .dd-options a.dd-option,
		.header-topbar ul li li a, 
		.header-topbar ul li li a:not([href]):not([tabindex]),
		.header-myaccount .myaccount-items li a,
		.search-results-wrapper .search-price,
		.search-results-wrapper .search-price ins,
		.trending-search-results,
		.kapee-ajax-search .trending-search-results ul li a, 
		.trending-search-results .recent-search-title,
		.trending-search-results .trending-title,
		.entry-date,
		.format-link .entry-content a,
		.woocommerce .widget_price_filter .price_label span,
		.woocommerce-or-login-with,
		.products-header .product-show span,
		.fancy-rating-summery .rating-avg,
		.rating-histogram .rating-star,
		div.product p.price, 
		div.product span.price,
		.product-buttons a:before,
		.whishlist-button a:before,
		.product-buttons a.compare:before,
		.woocommerce div.summary a.compare,
		.woocommerce div.summary .countdown-box .product-countdown > span span,
		.woocommerce div.summary .price-summary span,
		.woocommerce div.summary .product-offers-list .product-offer-item,
		.woocommerce div.summary .product_meta > span,
		.product_meta > span a:hover,
		.quantity input[type="button"],
		.woocommerce div.summary > .product-share .share-label,
		.woocommerce div.summary .items-total-price-button .item-price,
		.woocommerce div.summary .items-total-price-button .items-price,
		.woocommerce div.summary .items-total-price-button .total-price,		
		.kapee-deliver-return,
		.kapee-ask-questions,
		.kapee-delivery-label,
		.product-visitor-count,
		.kapee-product-trust-badge legend,
		.woocommerce-tabs .woocommerce-Tabs-panel--seller ul li span:not(.details),
		.single-product-page > .kapee-bought-together-products .items-total-price-button .item-price,
		.single-product-page > .kapee-bought-together-products .items-total-price-button .items-price,
		.single-product-page > .kapee-bought-together-products .items-total-price-button .total-price ,
		.single-product-page > .woocommerce-tabs .items-total-price-button .item-price,
		.single-product-page > .woocommerce-tabs .items-total-price-button .items-price,
		.single-product-page > .woocommerce-tabs .items-total-price-button .total-price,
		.woocommerce-cart .cart-totals .cart_totals tr th,
		.wcppec-checkout-buttons__separator,
		.multi-step-checkout .user-info span:last-child,
		.tabs-layout.tabs-normal .nav-tabs .nav-item.show .nav-link, 
		.tabs-layout.tabs-normal .nav-tabs .nav-link.active,
		.kapee-tabs.tabs-classic .nav-tabs .nav-link.active,
		.kapee-tour.tour-classic .nav-tabs .nav-link.active,
		.kapee-accordion.accordion-outline .card-header a,
		.kapee-accordion.accordion-outline .card-header a:after,
		.kapee-accordion.accordion-pills .card-header a,
		.wishlist_table .product-price,
		.mfp-close-btn-in .mfp-close,
		.woocommerce ul.cart_list li span.amount, 
		.woocommerce ul.product_list_widget li span.amount,
		.gallery-caption,
		.kapee-mobile-menu ul.mobile-main-menu li > a{
			color: '.$style_options['site']['link_color']['regular'].';
		}
		
		/* Link Hove Colors */
		a:hover,
		.header-topbar .header-col ul li li:hover a,
		.header-myaccount .myaccount-items li:hover a,
		.header-myaccount .myaccount-items li i,
		.kapee-ajax-search .trending-search-results ul li:hover a,
		.kapee-mobile-menu ul.mobile-main-menu li > a:hover, 
		.kapee-mobile-menu ul.mobile-main-menu li.active > a, 
		.mobile-topbar-wrapper span a:hover,
		.kapee-chekout-steps li.current > *,
		.products .product-cats a:hover,
		.woocommerce div.summary a.compare:hover,		
		.product_meta > span a:hover,
		.format-link .entry-content a:hover{
			color: '.$style_options['site']['link_color']['hover'].';
		}
		
		/* Primary Colors */		
		.ajax-search-style-3 .search-submit, 
		.ajax-search-style-4 .search-submit,
		.kapee-pagination .next, 
		.kapee-pagination .prev,
		.woocommerce-pagination .next,
		.woocommerce-pagination .prev,
		.fancy-square-date .entry-date .date-day,
		.entry-category a,
		.entry-post .post-highlight,
		.read-more-btn, 
		.read-more-btn .more-link,
		.read-more-button-fill .read-more-btn .more-link,
		.post-navigation a:hover .nav-title,
		.nav-archive:hover a,
		.format-link .entry-link:before,
		.format-quote .entry-quote:before,
		.format-quote .entry-quote:after,
		blockquote cite,
		blockquote cite a,
		.comment-reply-link,
		.widget .maxlist-more a,
		.widget_calendar tbody td a,
		.widget_calendar tfoot td a,
		.portfolio-post-loop .categories, 
		.portfolio-post-loop .categories a,
		.woocommerce form .woocommerce-rememberme-lost_password label,
		.woocommerce form .woocommerce-rememberme-lost_password a,
		.woocommerce-new-signup .button,
		.products-header .products-view a.active,
		.products .product-wrapper:hover .product-title a,
		.products:not(.product-style-2) .whishlist-button .yith-wcwl-wishlistaddedbrowse a:before,
		.products:not(.product-style-2) .whishlist-button .yith-wcwl-wishlistexistsbrowse a:before,
		.products.list-view .whishlist-button .yith-wcwl-wishlistaddedbrowse a:before,
		.products.list-view .whishlist-button .yith-wcwl-wishlistexistsbrowse a:before,
		.woocommerce div.product .kapee-breadcrumb a:hover,
		.woocommerce div.summary .countdown-box .product-countdown > span,
		.woocommerce div.product div.summary .sold-by a,
		.woocommerce-tabs .woocommerce-Tabs-panel--seller ul li.seller-name span.details a,
		.products .product-category.category-style-1:hover .woocommerce-loop-category__title,
		.woocommerce div.summary .product-term-text,
		.tab-content-wrap .accordion-title.open,
		.tab-content-wrap .accordion-title.open:after,
		table.shop_table td .amount,
		.woocommerce-cart .cart-totals .shipping-calculator-button,
		.woocommerce-MyAccount-navigation li a::before,
		.woocommerce-account .addresses .title .edit,
		.woocommerce-Pagination a.button,
		.woocommerce table.my_account_orders .woocommerce-orders-table__cell-order-number a,
		.woocommerce-checkout .woocommerce-info .showcoupon,
		.multi-step-checkout .panel.completed .panel-title:after,
		.multi-step-checkout .panel-title .step-numner,
		.multi-step-checkout .logged-in-user-info .user-logout,
		.multi-step-checkout .panel-heading .edit-action,
		.kapee-testimonials.image-middle-center .testimonial-description:before,
		.kapee-testimonials.image-middle-center .testimonial-description:after,
		.products-and-categories-box .section-title h3,
		.categories-sub-categories-box .sub-categories-content .show-all-cate a,
		.categories-sub-categories-vertical .show-all-cate a,
		.kapee-hot-deal-products.after-product-price .products .product-countdown > span,
		.kapee-hot-deal-products.after-product-price .products .product-countdown > span > span,
		.kapee-tabs.tabs-outline .nav-tabs .nav-link.active,
		.kapee-tour.tour-outline .nav-tabs .nav-link.active,
		.kapee-accordion.accordion-outline .card-header a:not(.collapsed),
		.kapee-accordion.accordion-outline .card-header a:not(.collapsed):after,
		.kapee-button .btn-style-outline.btn-color-primary,
		.kapee-button .btn-style-link.btn-color-primary,
		.mobile-nav-tabs li.active{
			color: '.$style_options['site']['primary_color'].';
		}

		/* Primary Inverse Colors */
		input[type="checkbox"]::before,
		.minicart-header .minicart-title,
		.minicart-header .close-sidebar:before,
		.header-cart-count, 
		.header-wishlist-count,		
		.header-compare-count,		
		.page-numbers.current,
		.page-links > span.current .page-number,
		.entry-date .date-year,
		.fancy-box2-date .entry-date,
		.post-share .meta-share-links .kapee-social a,
		.read-more-button .read-more-btn .more-link,
		.read-more-button-fill .read-more-btn .more-link:hover,
		.format-link .entry-link a,
		.format-quote .entry-quote,
		.format-quote .entry-quote .quote-author a,
		.widget .tagcloud a:hover,
		.widget .tagcloud a:focus,
		.widget.widget_tag_cloud a:hover,
		.widget.widget_tag_cloud a:focus,		
		.widget_calendar .wp-calendar-table caption,
		.wp_widget_tag_cloud a:hover,
		.wp_widget_tag_cloud a:focus,		
		.kapee-back-to-top,
		.kapee-posts-lists .post-categories a,
		.kapee-recent-posts .post-categories a,
		.widget.widget_layered_nav li.chosen a:after,
		.widget.widget_rating_filter li.chosen a:after,
		.filter-categories a.active,
		.portfolio-post-loop .action-icon a:before,
		.portfolio-style-3 .portfolio-post-loop .entry-content-wrapper .categories, 
		.portfolio-style-3 .portfolio-post-loop .entry-content-wrapper a, 
		.portfolio-style-4 .portfolio-post-loop .entry-content-wrapper .categories, 
		.portfolio-style-4 .portfolio-post-loop .entry-content-wrapper a, 
		.portfolio-style-5 .portfolio-post-loop .entry-content-wrapper .categories, 
		.portfolio-style-5 .portfolio-post-loop .entry-content-wrapper a, 
		.portfolio-style-6 .portfolio-post-loop .entry-content-wrapper .categories, 
		.portfolio-style-6 .portfolio-post-loop .entry-content-wrapper a, 
		.portfolio-style-7 .portfolio-post-loop .entry-content-wrapper .categories, 
		.portfolio-style-7 .portfolio-post-loop .entry-content-wrapper a,
		.customer-login-left,
		.customer-signup-left,
		.customer-login-left h2,
		.customer-signup-left h2,		
		.products.product-style-1.grid-view .product-buttons .whishlist-button a,
		.products.product-style-1.grid-view .product-buttons .compare-button a, 
		.products.product-style-1.grid-view .product-buttons .quickview-button a,
		.products:not(.product-style-2).grid-view .product-buttons .cart-button a,
		.products.list-view .product-buttons .cart-button a,
		.products .product .product-countdown > span,
		.products .product .product-countdown > span > span,
		.kapee-hot-deal-products .kapee-deal-date,
		.products.product-style-1.grid-view .product-buttons a:before,
		.products:not(.product-style-1):not(.product-style-2) .cart-button a:before,
		.woocommerce-product-gallery .single-product-images-btns a:hover,
		.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
		.woocommerce-account .user-info .display-name,
		.multi-step-checkout .panel.active .panel-heading,
		.multi-step-checkout .checkout-next-step a,
		.kapee-team.image-top-with-box .color-scheme-inherit .member-info,
		.kapee-team.image-top-with-box-2 .color-scheme-inherit .member-info,
		.kapee-team.image-top-with-box .color-scheme-inherit .member-info h3,
		.kapee-team.image-top-with-box-2 .color-scheme-inherit .member-info h3,
		.kapee-team .color-scheme-inherit .member-social a,
		.kapee-team.image-middle-swap-box .color-scheme-inherit .flip-front,
		.kapee-team.image-middle-swap-box .color-scheme-inherit .flip-front h3,
		.kapee-team.image-middle-swap-box .color-scheme-inherit .member-info,
		.kapee-team.image-middle-swap-box .color-scheme-inherit .member-info h3,
		.kapee-team.image-bottom-overlay .color-scheme-inherit .member-info
		.kapee-team.image-bottom-overlay .color-scheme-inherit .member-info h3,
		.kapee-tabs.tabs-pills .nav-tabs .nav-link.active,
		.kapee-tour.tour-pills .nav-tabs .nav-link.active,
		.kapee-accordion.accordion-pills .card-header a:not(.collapsed),
		.kapee-accordion.accordion-pills .card-header a:not(.collapsed):after,
		.kapee-social.icons-theme-colour a:hover i,
		.owl-carousel .owl-nav button[class*="owl-"]:hover,
		.kapee-button .btn-style-outline.btn-color-primary:hover,
		.mobile-menu-header a,
		.mobile-menu-header a:before,
		#yith-wcwl-popup-message,
		.mobile-menu-header a:hover{
			color: '.$style_options['site']['primary_inverse_color'].';
		}
		.woocommerce-new-signup .button,
		.kapee-video-player .video-play-btn,
		.mobile-nav-tabs li.active{
			background-color: '.$style_options['site']['primary_inverse_color'].';
		}
		
		/* Primary Background Colors */
		input[type="radio"]::before,
		input[type="checkbox"]::before,
		.header-cart-count, 
		.header-wishlist-count,
		.header-compare-count,
		.minicart-header,
		.page-numbers.current,
		.page-links > span.current .page-number,
		.entry-date .date-year,
		.fancy-box2-date .entry-date,
		.entry-meta .meta-share-links,
		.read-more-button .read-more-btn .more-link,
		.read-more-button-fill .read-more-btn .more-link:hover,
		.format-link .entry-link,
		.format-quote .entry-quote,
		.related.posts > h3:after,
		.related.portfolios > h3:after,
		.comment-respond > h3:after, 
		.comments-area > h3:after, 
		.portfolio-entry-summary h3:after,
		.widget-title-bordered-short .widget-title::before,
		.widget-title-bordered-full .widget-title::before,
		.widget .tagcloud a:hover,
		.widget .tagcloud a:focus,
		.widget.widget_tag_cloud a:hover,
		.widget.widget_tag_cloud a:focus,
		.wp_widget_tag_cloud a:hover,
		.wp_widget_tag_cloud a:focus,
		.widget_calendar .wp-calendar-table caption,
		.kapee-back-to-top,
		.kapee-posts-lists .post-categories a,
		.kapee-recent-posts .post-categories a,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
		.widget.widget_layered_nav li.chosen a:before,
		.widget.widget_rating_filter li.chosen a:before,
		.filter-categories a.active,		
		.customer-login-left,
		.customer-signup-left,
		.products.product-style-1.grid-view .product-buttons .whishlist-button a,
		.products.product-style-1.grid-view .product-buttons .compare-button a, 
		.products.product-style-1.grid-view .product-buttons .quickview-button a,
		.products:not(.product-style-2).grid-view .product-buttons .cart-button a,
		.products.list-view .product-buttons .cart-button a,
		.products .product .product-countdown > span,
		.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
		.woocommerce-product-gallery .single-product-images-btns a:hover,
		.tabs-layout .tabs li:after,
		section.related > h2::after,
		section.upsells > h2::after,
		div.cross-sells > h2::after,
		section.recently-viewed > h2::after,
		.woocommerce-account .kapee-user-profile,
		.multi-step-checkout .panel.active .panel-heading,
		.kapee-countdown.countdown-box .product-countdown > span,
		.kapee-hot-deal-products .kapee-deal-date,
		.kapee-hot-deal-products .progress-bar,
		.tabs-layout.tabs-line .nav-tabs .nav-link::after,
		.kapee-team.image-top-with-box-2 .member-info,
		.kapee-team.image-middle-swap-box .member-info,
		.kapee-team.image-top-with-box .member-info,
		.kapee-team.image-middle-swap-box .flip-front,
		.kapee-team.image-bottom-overlay .member-info,
		.kapee-team.image-bottom-overlay .member-info::before, 
		.kapee-team.image-bottom-overlay .member-info::after,
		.kapee-video-player .video-wrapper:hover .video-play-btn,
		.kapee-tabs.tabs-line .nav-tabs .nav-link::after,
		.kapee-tabs.tabs-pills .nav-tabs .nav-link.active,
		.kapee-tour.tour-line .nav-tabs .nav-link::after,
		.kapee-tour.tour-pills .nav-tabs .nav-link.active,
		.kapee-accordion.accordion-pills .card-header a:not(.collapsed),
		.kapee-social.icons-theme-colour a:hover i,
		.owl-carousel .owl-nav button[class*="owl-"]:hover,
		.owl-carousel .owl-dots .owl-dot.active span,
		.kapee-button .btn-style-flat.btn-color-primary,
		.kapee-button .btn-style-outline.btn-color-primary:hover,
		#yith-wcwl-popup-message,
		.mobile-menu-header,
		.slick-slider .slick-dots li.slick-active button{
			background-color: '.$style_options['site']['primary_color'].';
		}
						
		/* Site Wrapper Background Colors */
		.kapee-dropdown ul.sub-dropdown,
		div[class*="wpml-ls-legacy-dropdown"] .wpml-ls-sub-menu,
		div[class*="wcml-dropdown"] .wcml-cs-submenu,
		.woocommerce-currency-switcher-form .dd-options,
		.header-mini-search .kapee-mini-ajax-search,
		.entry-content-wrapper,
		.myaccount-items,
		.search-results-wrapper .autocomplete-suggestions, 
		.trending-search-results,
		.kapee-promo-bar,
		.kapee-search-popup .kapee-search-popup-wrap,
		.kapee-login-signup .social-log span,
		.entry-content-wrapper,
		.entry-date,
		.entry-post .post-highlight span:before,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle::after,
		.widget.widget_layered_nav li a:before,
		.widget.widget_rating_filter li a:before,
		.widget.kapee_widget_product_sorting li.chosen a:after,
		.widget.kapee_widget_price_filter_list li.chosen a:after,
		.widget.kapee_widget_product_sorting li.chosen a:after,
		.widget.kapee_widget_price_filter_list li.chosen a:after,
		.kapee-login-signup, 
		.kapee-signin-up-popup,
		.kapee-minicart-slide,
		.fancy-rating-summery,
		.product-style-2.grid-view .product-buttons a,
		.products.product-style-4.grid-view div.product:hover .product-info,
		.products.product-style-4.grid-view div.product:hover .product-variations,
		.products.product-style-5.grid-view .product-buttons-variations,
		.products:not(.product-style-5):not(.list-view) .product-variations,
		.kapee-quick-view,
		.woocommerce div.product div.images .woocommerce-product-gallery__trigger,
		.woocommerce-product-gallery .single-product-images-btns a,
		.product-navigation-share .kapee-social,
		.product-navigation .product-info-wrap,
		.woocommerce div.summary .countdown-box .product-countdown > span,
		.woocommerce div.summary .price-summary,
		.woocommerce div.summary .product-term-detail,
		.kapee-sticky-add-to-cart,
		.kapee-product-sizechart,
		.kapee-ajax-blok-content,
		.kapee-ask-questions-popup,
		.kapee-bought-together-products .kapee-out-of-stock,
		.multi-step-checkout .panel-title.active .step-numner,
		.tabs-layout.tabs-normal .nav-tabs .nav-item.show .nav-link, 
		.tabs-layout.tabs-normal .nav-tabs .nav-link.active,
		.kapee-tabs.tabs-classic .nav-tabs .nav-link.active,
		.kapee-tabs.tabs-classic .nav-tabs + .tab-content,
		.kapee-tour.tour-classic .nav-tabs .nav-link.active,
		.kapee-tour.tour-classic .nav-tabs + .tab-content .tab-pane,
		.slick-slider button.slick-arrow,
		.owl-carousel .owl-nav button[class*="owl-"],
		.kapee-canvas-sidebar,
		.kapee-mobile-menu,
		.kapee-mobile-navbar{
			background-color:'.$style_options['site']['wrapper_background']['background-color'].';
		}
		
		select option{
			background-color:'.$style_options['site']['wrapper_background']['background-color'].';
		}
		
		.header-topbar ul li li:hover a,
		.search-results-wrapper .autocomplete-selected,
		.trending-search-results ul li:hover a,
		.header-myaccount .myaccount-items li:hover a,
		.kapee-navigation ul.sub-menu > li:hover > a,
		.kapee-minicart-slide .mini_cart_item:hover,
		.woocommerce-MyAccount-navigation li.is-active a,
		.woocommerce-MyAccount-navigation li:hover a{
			background-color:'.$style_options['site']['hover_background_color'].';
		}
		
		.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
		.owl-carousel .owl-dots .owl-dot span{
			background-color:'.$style_options['site']['border']['border-color'].';
		}
		
		/* Hex RBG Color*/
		.portfolio-post-loop .post-thumbnail:after{
			background-color: rgba('.$style_options['site']['hex2rgb_color'].',0.4);
		}
		.portfolio-style-4 .portfolio-post-loop .post-thumbnail:after, 
		.portfolio-style-5 .portfolio-post-loop .post-thumbnail:after, 
		.portfolio-style-6 .portfolio-post-loop .post-thumbnail:after, 
		.portfolio-style-7 .portfolio-post-loop .post-thumbnail:after{
			background-color: rgba('.$style_options['site']['hex2rgb_color'].',0.7);
		}
		.portfolio-post-loop .action-icon a:hover:before,		
		.portfolio-style-3 .portfolio-post-loop .entry-content-wrapper,
		.portfolio-style-3 .portfolio-post-loop .action-icon a:hover:before{
			background-color: rgba('.$style_options['site']['hex2rgb_color'].',1);
		}
		
		/* Site Border */
		fieldset,
		input[type="text"],
		input[type="email"],
		input[type="url"],
		input[type="password"],
		input[type="search"],
		input[type="number"],
		input[type="tel"],
		input[type="range"],
		input[type="date"],
		input[type="month"],
		input[type="week"],
		input[type="time"],
		input[type="datetime"],
		input[type="datetime-local"],
		input[type="color"],
		textarea,
		select,
		input[type="checkbox"], 
		input[type="radio"],
		.exclamation-mark:before,
		.question-mark:before,
		.select2-container--default .select2-selection--multiple, 
		.select2-container--default .select2-selection--single,
		tr,
		.kapee-search-popup .kapee-ajax-search .searchform,
		.tag-social-share .single-tags a,
		.widget .tagcloud a,
		.widget.widget_tag_cloud a,
		.wp_widget_tag_cloud a,
		.widget_calendar table, 
		.widget_calendar td,
		.widget_calendar .wp-calendar-nav,
		.widget div[class*="wpml-ls-legacy-dropdown"] a.wpml-ls-item-toggle,
		.widget div[class*="wcml-dropdown"] .wcml-cs-item-toggle, 
		.widget .woocommerce-currency-switcher-form .dd-select .dd-selected,
		.widget.widget_layered_nav li a:before,
		.widget.widget_rating_filter li a:before,
		.products:not(.product-style-1):not(.product-style-2) .product-buttons .compare-button a,
		.products:not(.product-style-1):not(.product-style-2) .product-buttons .quickview-button a,
		.products.list-view .product-buttons .compare-button a,
		.products.list-view .product-buttons .quickview-button a,
		.kapee-swatches .swatch-color span,
		.woocommerce div.summary .kapee-bought-together-products,
		.single-product-page > .kapee-bought-together-products,
		.accordion-layout .tab-content-wrap,
		.toggle-layout .tab-content-wrap,
		.woocommerce-MyAccount-navigation ul,
		.products-and-categories-box .section-inner.row,
		.kapee-product-categories-thumbnails.categories-circle .category-image,
		.kapee-product-brands.brand-circle .brand-image,
		.kapee-tabs.tabs-classic .nav-tabs + .tab-content,
		.kapee-tour.tour-classic .nav-tabs .nav-link,
		.kapee-tour.tour-classic .nav-tabs + .tab-content .tab-pane,
		.kapee-accordion.accordion-classic .card,
		#wcfm_products_manage_form_wc_product_kapee_offer_expander .kapee_offer_option,
		#wcfm_products_manage_form_wc_product_kapee_offer_expander .kapee_service_option{
			border-top-width:'.$style_options['site']['border']['border-top'].';
			border-bottom-width:'.$style_options['site']['border']['border-bottom'].';
			border-left-width:'.$style_options['site']['border']['border-left'].';
			border-right-width:'.$style_options['site']['border']['border-right'].';
			border-style:'.$style_options['site']['border']['border-style'].';
			border-color:'.$style_options['site']['border']['border-color'].';
		}
		.kapee-pagination,
		.woocommerce-pagination,
		.post-navigation,
		.comment-list .children,
		.comment-navigation .nex-prev-nav,
		.woocommerce div.summary .price-summary .total-discount,
		.woocommerce div.summary .price-summary .overall-discount,
		.woocommerce div.summary .kapee-bought-together-products .items-total-price-button,
		.single-product-page > .kapee-bought-together-products .items-total-price-button .items-total-price > div:last-child,
		.single-product-page > .woocommerce-tabs .items-total-price-button .items-total-price > div:last-child,
		.woocommerce table.shop_table td,
		.woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info,
		.kapee-accordion.accordion-line .card,
		.kapee-mobile-menu ul.mobile-main-menu > li:first-child{
			border-top-width:'.$style_options['site']['border']['border-top'].';
			border-top-style:'.$style_options['site']['border']['border-style'].';
			border-top-color:'.$style_options['site']['border']['border-color'].';
		}
		.single-featured-image-header,
		.kapee-dropdown ul.sub-dropdown li a,
		div[class*="wpml-ls-legacy-dropdown"] .wpml-ls-sub-menu a,
		div[class*="wcml-dropdown"] .wcml-cs-submenu li a, 
		.woocommerce-currency-switcher-form .dd-options a.dd-option,
		.header-myaccount .myaccount-items li a,
		.post-navigation,
		.comment-list > li:not(:last-child),
		.comment-navigation .nex-prev-nav,
		.widget,
		.widget-title-bordered-full .widget-title,
		.widget_rss ul li:not(:last-child),
		.kapee-posts-lists .widget-post-item:not(:last-child),
		.kapee-recent-posts .widget-post-item:not(:last-child),
		.kapee-tab-posts .widget-post-item:not(:last-child),
		.kapee-widget-portfolios-list:not(.style-3) .widget-portfolio-item:not(:last-child),
		.kapee-recent-comments .post-comment:not(:last-child), 
		.kapee-tab-posts .post-comment:not(:last-child),
		.woocommerce ul.cart_list li:not(:last-child), 
		.woocommerce ul.product_list_widget li:not(:last-child),
		.woocommerce-or-login-with:after, 
		.woocommerce-or-login-with:before, 
		.woocommerce-or-login-with:after, 
		.woocommerce-or-login-with:before,
		.kapee-login-signup .social-log:after,
		.kapee-minicart-slide .mini_cart_item,
		.empty-cart-browse-categories .browse-categories-title,
		.products-header,
		.kapee-filter-widgets .kapee-filter-inner,
		.products.list-view div.product:not(.product-category) .product-wrapper,
		.kapee-product-sizechart .sizechart-header h2,
		.tabs-layout .tabs,
		.wishlist_table.mobile > li,
		.woocommerce-cart table.cart,
		.woocommerce-MyAccount-navigation li:not(:last-child) a,
		.woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info,
		.section-heading,
		.tabs-layout.tabs-normal .nav-tabs,
		.products-and-categories-box .section-title,
		.kapee-accordion.accordion-classic .card-header,
		.kapee-accordion.accordion-line .card:last-child,
		.kapee-mobile-menu ul.mobile-main-menu li a,
		.mobile-topbar > *:not(:last-child){
			border-bottom-width:'.$style_options['site']['border']['border-bottom'].';
			border-bottom-style:'.$style_options['site']['border']['border-style'].';
			border-bottom-color:'.$style_options['site']['border']['border-color'].';
		}
		
		.kapee-heading.separator-underline .separator-right{
			border-bottom-color:'.$style_options['site']['primary_color'].';
		}';
		
		
		if( is_rtl() ){
			$theme_css .= ' 
			.kapee-ajax-search .search-field,
			.kapee-ajax-search .product_cat,
			.products-and-categories-box .section-categories,
			.products-and-categories-box .section-banner,
			.kapee-tabs.tabs-classic .nav-tabs .nav-link{
				border-left-width:'.$style_options['site']['border']['border-left'].';
				border-left-style:'.$style_options['site']['border']['border-style'].';
				border-left-color:'.$style_options['site']['border']['border-color'].';
			}
			.kapee-mobile-menu ul.mobile-main-menu li.menu-item-has-children > .menu-toggle,
			.single-product-page > .kapee-bought-together-products .items-total-price-button,
			.single-product-page .woocommerce-tabs .kapee-bought-together-products .items-total-price-button,
			.kapee-tabs.tabs-classic .nav-tabs .nav-link{
				border-right-width:'.$style_options['site']['border']['border-right'].';
				border-right-style:'.$style_options['site']['border']['border-style'].';
				border-right-color:'.$style_options['site']['border']['border-color'].';
			}
			.kapee-tour.tour-classic.position-left .nav-tabs .nav-link.active,
			blockquote,
			.kapee-video-player .video-play-btn:before{
				border-right-color:'.$style_options['site']['primary_color'].';
			}
			.kapee-video-player .video-wrapper:hover .video-play-btn:before{
				border-right-color:'.$style_options['site']['primary_inverse_color'].';
			}
			.kapee-tour.tour-classic.position-right .nav-tabs .nav-link.active{
				border-left-color:'.$style_options['site']['primary_color'].';
			}';
		}else{
			$theme_css .= ' 
			.kapee-ajax-search .search-field,
			.kapee-ajax-search .product_cat,
			.products-and-categories-box .section-categories,
			.products-and-categories-box .section-banner,
			.kapee-tabs.tabs-classic .nav-tabs .nav-link{
				border-right-width:'.$style_options['site']['border']['border-right'].';
				border-right-style:'.$style_options['site']['border']['border-style'].';
				border-right-color:'.$style_options['site']['border']['border-color'].';
			}
			.kapee-mobile-menu ul.mobile-main-menu li.menu-item-has-children > .menu-toggle,
			.single-product-page > .kapee-bought-together-products .items-total-price-button,
			.single-product-page .woocommerce-tabs .kapee-bought-together-products .items-total-price-button,
			.kapee-tabs.tabs-classic .nav-tabs .nav-link,
			.widget_calendar .wp-calendar-nav .pad{
				border-left-width:'.$style_options['site']['border']['border-left'].';
				border-left-style:'.$style_options['site']['border']['border-style'].';
				border-left-color:'.$style_options['site']['border']['border-color'].';
			}
			.kapee-tour.tour-classic.position-left .nav-tabs .nav-link.active,
			blockquote,
			.wp-block-quote,
			.wp-block-quote[style*="text-align:right"],
			.kapee-video-player .video-play-btn:before{
				border-left-color:'.$style_options['site']['primary_color'].';
			}
			.kapee-video-player .video-wrapper:hover .video-play-btn:before{
				border-left-color:'.$style_options['site']['primary_inverse_color'].';
			}
			.kapee-tour.tour-classic.position-right .nav-tabs .nav-link.active{
				border-right-color:'.$style_options['site']['primary_color'].';
			}';
			
		}
		
		$theme_css .= ' 
		.kapee-social.icons-theme-colour a i,
		.kapee-spinner::before,
		.loading::before,
		.woocommerce .blockUI.blockOverlay::before,
		.widget_shopping_cart .widget_shopping_cart_footer,
		.dokan-report-abuse-button.working::before,
		.kapee-accordion.accordion-outline .card-header a,
		.kapee-vendors-list .store-product{
			border-color:'.$style_options['site']['border']['border-color'].';
		}
		.kapee-tabs.tabs-classic .nav-tabs .nav-link{
			border-top-color:'.$style_options['site']['border']['border-color'].';
		}
		.tabs-layout.tabs-normal .nav-tabs .nav-item.show .nav-link, 
		.tabs-layout.tabs-normal .nav-tabs .nav-link.active,
		.woocommerce ul.cart_list li dl, 
		.woocommerce ul.product_list_widget li dl{
			border-left-color:'.$style_options['site']['border']['border-color'].';
		}
		.tabs-layout.tabs-normal .nav-tabs .nav-item.show .nav-link, 
		.tabs-layout.tabs-normal .nav-tabs .nav-link.active{
			border-right-color:'.$style_options['site']['border']['border-color'].';
		}		
		.read-more-button-fill .read-more-btn .more-link,
		.tag-social-share .single-tags a:hover,
		.widget .tagcloud a:hover,
		.widget .tagcloud a:focus,
		.widget.widget_tag_cloud a:hover,
		.widget.widget_tag_cloud a:focus,
		.wp_widget_tag_cloud a:hover,
		.wp_widget_tag_cloud a:focus,
		.kapee-swatches .swatch.swatch-selected,
		.product-gallery-thumbnails .slick-slide.flex-active-slide img,
		.product-gallery-thumbnails .slick-slide:hover img,
		.woocommerce-checkout form.checkout_coupon,
		.tabs-layout.tabs-normal .nav-tabs .nav-item.show .nav-link,
		.kapee-tabs.tabs-outline .nav-tabs .nav-link.active,
		.kapee-tour.tour-outline .nav-tabs .nav-link.active,
		.kapee-accordion.accordion-outline .card-header a:not(.collapsed),
		.kapee-social.icons-theme-colour a:hover,
		.kapee-button .btn-style-outline.btn-color-primary,
		.kapee-button .btn-style-link.btn-color-primary,
		.kapee-hot-deal-products.highlighted-border{
			border-color:'.$style_options['site']['primary_color'].';
		}
		.widget.widget_layered_nav li.chosen a:before,
		.widget.widget_rating_filter li.chosen a:before,		
		.widget_calendar caption, 
		.kapee-element .section-heading h2:after,		
		.woocommerce-account .kapee-user-profile{
			border-top-width:'.$style_options['site']['border']['border-top'].';
			border-bottom-width:'.$style_options['site']['border']['border-bottom'].';
			border-left-width:'.$style_options['site']['border']['border-left'].';
			border-right-width:'.$style_options['site']['border']['border-right'].';
			border-style:'.$style_options['site']['border']['border-style'].';
			border-color:'.$style_options['site']['primary_color'].';
		}		
		.entry-meta .meta-share-links:after,
		.kapee-tabs.tabs-classic .nav-tabs .nav-link.active,
		.tabs-layout.tabs-normal .nav-tabs .nav-link.active,
		.kapee-spinner::before,
		.loading::before,
		.woocommerce .blockUI.blockOverlay::before,
		.dokan-report-abuse-button.working::before{
			border-top-color:'.$style_options['site']['primary_color'].';
		}		
		.kapee-arrow:after,
		#add_payment_method #payment div.payment_box::after,
		.woocommerce-cart #payment div.payment_box::after,
		.woocommerce-checkout #payment div.payment_box::after{
			border-bottom-color:'.$style_options['site']['wrapper_background']['background-color'].';
		}
		.entry-date .date-month:after{
			border-top-color:'.$style_options['site']['wrapper_background']['background-color'].';
		}		
		
		/* 
		* Button color Scheme 
		*/
		.button,
		.btn,
		button,
		input[type="button"],
		input[type="submit"],
		.button:not([href]):not([tabindex]),
		.btn:not([href]):not([tabindex]){
			color: '.$style_options['button']['color']['regular'].';
			background-color: '.$style_options['button']['background']['regular'].';
		}
		.kapee-button .btn-color-default.btn-style-outline,
		.kapee-button .btn-color-default.btn-style-link{
			color: '.$style_options['button']['background']['regular'].';
		}
		.kapee-button .btn-color-default.btn-style-outline,
		.kapee-button .btn-color-default.btn-style-link{
			border-color: '.$style_options['button']['background']['regular'].';
		}
		
		
		.button:hover,
		.btn:hover,
		button:hover,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:focus,
		.button:not([href]):not([tabindex]):hover,
		.btn:not([href]):not([tabindex]):hover,
		.kapee-button .btn-color-default.btn-style-outline:hover{
			color: '.$style_options['button']['color']['hover'].';
			background-color: '.$style_options['button']['background']['hover'].';
		}
		.kapee-button .btn-color-default.btn-style-link:hover{
			color: '.$style_options['button']['background']['hover'].';
		}
		.kapee-button .btn-color-default.btn-style-outline:hover,
		.kapee-button .btn-color-default.btn-style-link:hover{
			border-color: '.$style_options['button']['background']['hover'].';
		}
		
		/* Product Page Cart Button */
		div.summary form.cart .button{
			color: '.$style_options['button']['product_cart_color']['regular'].';
			background-color: '.$style_options['button']['product_cart_background']['regular'].';
		}
		div.summary form.cart .button:hover,
		div.summary form.cart .button:focus{
			color: '.$style_options['button']['product_cart_color']['hover'].';
			background-color: '.$style_options['button']['product_cart_background']['hover'].';
		}
		
		/* Buy Now Button */		
		.kapee-quick-buy .kapee_quick_buy_button,
		.kapee-bought-together-products .add-items-to-cart{
			color: '.$style_options['button']['buy_now_color']['regular'].';
			background-color: '.$style_options['button']['buy_now_background']['regular'].';
		}
		.kapee-quick-buy .kapee_quick_buy_button:hover,
		.kapee-quick-buy .kapee_quick_buy_button:focus,
		.kapee-bought-together-products .add-items-to-cart:hover,
		.kapee-bought-together-products .add-items-to-cart:focus{
			color: '.$style_options['button']['buy_now_color']['hover'].';
			background-color: '.$style_options['button']['buy_now_background']['hover'].';
		}
		
		/* Checkout & Palce Order Button */
		.widget_shopping_cart .button.checkout,
		.woocommerce-cart a.checkout-button,
		.woocommerce_checkout_login .checkout-next-step .btn,
		.woocommerce_checkout_login .checkout-next-step.btn,
		.woocommerce-checkout-payment #place_order{
			color: '.$style_options['button']['checkout_color']['regular'].';
			background-color: '.$style_options['button']['checkout_background']['regular'].';
		}
		.widget_shopping_cart .button.checkout:hover,
		.widget_shopping_cart .button.checkout:focus,
		.woocommerce-cart a.checkout-button:hover,
		.woocommerce-cart a.checkout-button:focus,
		.woocommerce_checkout_login .checkout-next-step .btn:hover,
		.woocommerce_checkout_login .checkout-next-step .btn:focus,
		.woocommerce_checkout_login .checkout-next-step.btn:hover,
		.woocommerce_checkout_login .checkout-next-step.btn:focus,
		.woocommerce-checkout-payment #place_order:hover,
		.woocommerce-checkout-payment #place_order:focus{
			color: '.$style_options['button']['checkout_color']['hover'].';
			background-color: '.$style_options['button']['checkout_background']['hover'].';
		}
		
		
		/* 
		* Input color Scheme 
		*/
		text,
		select, 
		textarea,
		number,
		.kapee-search-popup .searchform, 
		.kapee-search-popup .search-field, 
		.kapee-search-popup .search-categories > select{
			color:'.$style_options['site']['input_color'].';
			background-color:'.$style_options['site']['input_background'].';
		}
		.mc4wp-form-fields p:first-child::before{
			color:'.$style_options['site']['input_color'].';
		}
		
		/* Placeholder Colors */
		::-webkit-input-placeholder {
		   color:'.$style_options['site']['input_color'].';
		}
		:-moz-placeholder { /* Firefox 18- */
		  color:'.$style_options['site']['input_color'].';
		}
		::-moz-placeholder {  /* Firefox 19+ */
		   color:'.$style_options['site']['input_color'].';
		}
		:-ms-input-placeholder { 
		   color:'.$style_options['site']['input_color'].';
		}
		
		/* selection Colors */
		::-moz-selection { 
		  color: '.$style_options['site']['primary_inverse_color'].';
		  background: '.$style_options['site']['primary_color'].';
		}

		::selection {
		  color: '.$style_options['site']['primary_inverse_color'].';
		  background: '.$style_options['site']['primary_color'].';
		}
		
		/* 
		* Promo Bar Color Scheme 
		*/
		.promo-bar-wrapper{
			height: '.$style_options['promo_bar']['max_height'].'px;
		}
		.promo-bar-button .button{
			color: '.$style_options['promo_bar']['button_text']['regular'].';
			background-color: '.$style_options['promo_bar']['button_background']['regular'].';
		}
		.promo-bar-button .button:hover{
			color: '.$style_options['promo_bar']['button_text']['hover'].';
			background-color: '.$style_options['promo_bar']['button_background']['hover'].';
		}
		
		/* 
		* Topbar color Scheme 
		*/
		.header-topbar{
			color: '.$style_options['topbar']['text_color'].';
		}
		.header-topbar a,
		.header-topbar .wpml-ls-legacy-dropdown a {
			color: '.$style_options['topbar']['link_color']['regular'].';
		}
		.header-topbar a:hover,
		.header-topbar .wpml-ls-legacy-dropdown a:hover{
			color: '.$style_options['topbar']['link_color']['hover'].';
		}
		.header-topbar{
			border-bottom-width:'.$style_options['topbar']['border']['border-bottom'].';
			border-bottom-style:'.$style_options['topbar']['border']['border-style'].';
			border-bottom-color:'.$style_options['topbar']['border']['border-color'].';
		}';
		
		if( is_rtl() ){
			$theme_css .= '
			.header-topbar .header-col > *,
			.topbar-navigation ul.menu > li:not(:first-child){
				border-right-width:'.$style_options['topbar']['border']['border-right'].';
				border-right-style:'.$style_options['topbar']['border']['border-style'].';
				border-right-color:'.$style_options['topbar']['border']['border-color'].';
			}
			.header-topbar .header-col > *:last-child{
				border-left-width:'.$style_options['topbar']['border']['border-left'].';
				border-left-style:'.$style_options['topbar']['border']['border-style'].';
				border-left-color:'.$style_options['topbar']['border']['border-color'].';
			}';
		}else{
			$theme_css .= '
			.header-topbar .header-col > *,
			.topbar-navigation ul.menu > li:not(:first-child){
				border-left-width:'.$style_options['topbar']['border']['border-left'].';
				border-left-style:'.$style_options['topbar']['border']['border-style'].';
				border-left-color:'.$style_options['topbar']['border']['border-color'].';
			}
			.header-topbar .header-col > *:last-child{
				border-right-width:'.$style_options['topbar']['border']['border-right'].';
				border-right-style:'.$style_options['topbar']['border']['border-style'].';
				border-right-color:'.$style_options['topbar']['border']['border-color'].';
			}';
		}
		$theme_css .= '
		.header-topbar{
			max-height:'.$style_options['topbar']['max_height']['height'].'px;
		}
		.header-topbar .header-col > *{
			line-height:'.($style_options['topbar']['max_height']['height']-2).'px;
		}
		
		/* 
		* Header color Scheme 
		*/
		.header-main{
			color: '.$style_options['header']['text_color'].';
		}
		.header-main a{
			color: '.$style_options['header']['link_color']['regular'].';
		}
		.header-main a:hover{
			color: '.$style_options['header']['link_color']['hover'].';
		}		
		.header-main .kapee-ajax-search .searchform{
			border-top-width:'.$style_options['header']['border']['border-top'].';
			border-bottom-width:'.$style_options['header']['border']['border-bottom'].';
			border-left-width:'.$style_options['header']['border']['border-left'].';
			border-right-width:'.$style_options['header']['border']['border-right'].';
			border-style:'.$style_options['header']['border']['border-style'].';
			border-color:'.$style_options['header']['border']['border-color'].';
		}
		.header-main{
			height:'.$style_options['header']['min_height']['height'].'px;
		}		
		.header-main .search-field, 
		.header-main .search-categories > select{
			color:'.$style_options['header']['input_color'].';
		}
		.header-main .searchform, 
		.header-main .search-field, 
		.header-main .search-categories > select{
			background-color:'.$style_options['header']['input_background'].';
		}
		.header-main ::-webkit-input-placeholder {
		   color:'.$style_options['header']['input_color'].';
		}
		.header-main :-moz-placeholder { /* Firefox 18- */
		  color:'.$style_options['header']['input_color'].';
		}
		.header-main ::-moz-placeholder {  /* Firefox 19+ */
		   color:'.$style_options['header']['input_color'].';
		}
		.header-main :-ms-input-placeholder {
		   color:'.$style_options['header']['input_color'].';
		}
		
		/* 
		* Navigation color Scheme 
		*/
		.header-navigation{
			color: '.$style_options['navigation']['text_color'].';
		}
		.header-navigation a{
			color: '.$style_options['navigation']['link_color']['regular'].';
		}
		.header-navigation a:hover{
			color: '.$style_options['navigation']['link_color']['hover'].';
		}		
		.header-navigation .kapee-ajax-search .searchform{
			border-top-width:'.$style_options['navigation']['border']['border-top'].';
			border-bottom-width:'.$style_options['navigation']['border']['border-bottom'].';
			border-left-width:'.$style_options['navigation']['border']['border-left'].';
			border-right-width:'.$style_options['navigation']['border']['border-right'].';
			border-style:'.$style_options['navigation']['border']['border-style'].';
			border-color:'.$style_options['navigation']['border']['border-color'].';
		}
		.header-navigation{
			border-top-width:'.$style_options['navigation']['border']['border-top'].';
			border-top-style:'.$style_options['navigation']['border']['border-style'].';
			border-top-color:'.$style_options['navigation']['border']['border-color'].';
		}
		.header-navigation{
			border-bottom-width:'.$style_options['navigation']['border']['border-bottom'].';
			border-bottom-style:'.$style_options['navigation']['border']['border-style'].';
			border-bottom-color:'.$style_options['navigation']['border']['border-color'].';
		}
		.categories-menu-title{
			border-left-width:'.$style_options['navigation']['border']['border-left'].';
			border-left-style:'.$style_options['navigation']['border']['border-style'].';
			border-left-color:'.$style_options['navigation']['border']['border-color'].';
		}
		.categories-menu-title{
			border-right-width:'.$style_options['navigation']['border']['border-right'].';
			border-right-style:'.$style_options['navigation']['border']['border-style'].';
			border-right-color:'.$style_options['navigation']['border']['border-color'].';
		}
		.header-navigation,		
		.header-navigation .main-navigation ul.menu > li > a{
			height:'.$style_options['navigation']['min_height']['height'].'px;
		}
		.header-navigation .categories-menu-title{
			height:'.($style_options['navigation']['min_height']['height']).'px;
		}
		.header-navigation ::-webkit-input-placeholder {
		   color:'.$style_options['navigation']['input_color'].';
		}
		.header-navigation :-moz-placeholder { /* Firefox 18- */
		  color:'.$style_options['navigation']['input_color'].';
		}
		.header-navigation ::-moz-placeholder {  /* Firefox 19+ */
		   color:'.$style_options['navigation']['input_color'].';
		}
		.header-navigation :-ms-input-placeholder {  
		   color:'.$style_options['navigation']['input_color'].';
		}
		
		/* 
		* Header Sticky color Scheme 
		*/
		.header-sticky{
			color: '.$style_options['header_sticky']['text_color'].';
		}
		.header-sticky a{
			color: '.$style_options['header_sticky']['link_color']['regular'].';
		}
		.header-sticky a:hover{
			color: '.$style_options['header_sticky']['link_color']['hover'].';
		}		
		.header-sticky .kapee-ajax-search .searchform{
			border-top-width:'.$style_options['header_sticky']['border']['border-top'].';
			border-bottom-width:'.$style_options['header_sticky']['border']['border-bottom'].';
			border-left-width:'.$style_options['header_sticky']['border']['border-left'].';
			border-right-width:'.$style_options['header_sticky']['border']['border-right'].';
			border-style:'.$style_options['header_sticky']['border']['border-style'].';
			border-color:'.$style_options['header_sticky']['border']['border-color'].';
		}
		.header-sticky,
		.header-sticky .main-navigation ul.menu > li > a{
			height:'.$style_options['header_sticky']['min_height']['height'].'px;
		}
		.header-sticky .categories-menu-title{
			line-height:'.$style_options['header_sticky']['min_height']['height'].'px;
		}
		.header-sticky .search-field, 
		.header-main .search-categories > select{
			color:'.$style_options['header_sticky']['input_color'].';
		}
		.header-sticky .searchform, 
		.header-sticky .search-field, 
		.header-sticky .search-categories > select{
			background-color:'.$style_options['header_sticky']['input_background'].';
		}
		.header-sticky ::-webkit-input-placeholder {
		   color:'.$style_options['header_sticky']['input_color'].';
		}
		.header-sticky :-moz-placeholder { /* Firefox 18- */
		  color:'.$style_options['header_sticky']['input_color'].';
		}
		.header-sticky ::-moz-placeholder {  /* Firefox 19+ */
		   color:'.$style_options['header_sticky']['input_color'].';
		}
		.header-sticky :-ms-input-placeholder {  
		   color:'.$style_options['header_sticky']['input_color'].';
		}
		
		/* 
		* Menu color Scheme 
		*/
		
		/* Main Menu */
		.main-navigation ul.menu > li > a{
			color: '.$style_options['first_level_menu']['link_color']['regular'].';
		}
		.main-navigation ul.menu > li:hover > a{
			color: '.$style_options['first_level_menu']['link_color']['hover'].';
		}
		.main-navigation ul.menu > li:hover > a{
			background-color:'.$style_options['first_level_menu']['hover_background'].';
		}		
		
		/* Sticky Header */
		.header-sticky .main-navigation ul.menu > li > a{
			color: '.$style_options['first_level_sticky_menu']['link_color']['regular'].';
		}		
		.header-sticky .main-navigation ul.menu > li:hover > a{
			color: '.$style_options['first_level_sticky_menu']['link_color']['hover'].';
		}
		.header-sticky .main-navigation ul.menu > li:hover > a{
			background-color:'.$style_options['first_level_sticky_menu']['hover_background'].';
		}
		
		/* Categories menu */
		.categories-menu-title{
			background-color:'.$style_options['categories_menu']['title_background'].';
			color: '.$style_options['categories_menu']['title_color'].';
		}
		.categories-menu{
			background-color:'.$style_options['categories_menu']['wrapper_background'].';
		}
		.categories-menu ul.menu > li > a{
			color: '.$style_options['categories_menu']['link_color']['regular'].';
		}		
		.categories-menu ul.menu > li:hover > a{
			color: '.$style_options['categories_menu']['link_color']['hover'].';
		}
		.categories-menu ul.menu > li:hover > a{
			background-color:'.$style_options['categories_menu']['hover_background'].';
		}
		.categories-menu{
			border-top-width:'.$style_options['categories_menu']['border']['border-top'].';
			border-bottom-width:'.$style_options['categories_menu']['border']['border-bottom'].';
			border-left-width:'.$style_options['categories_menu']['border']['border-left'].';
			border-right-width:'.$style_options['categories_menu']['border']['border-right'].';
			border-style:'.$style_options['categories_menu']['border']['border-style'].';
			border-color:'.$style_options['categories_menu']['border']['border-color'].';
		}
		.categories-menu ul.menu > li:not(:last-child){
			border-bottom-width:'.$style_options['categories_menu']['border']['border-bottom'].';
			border-bottom-style:'.$style_options['categories_menu']['border']['border-style'].';
			border-bottom-color:'.$style_options['categories_menu']['border']['border-color'].';
		}
		
		/* Menu Popup */
		.site-header ul.menu ul.sub-menu a,
		.kapee-megamenu-wrapper a.nav-link{
			color: '.$style_options['popup_menu']['link_color']['regular'].';
		}
		.site-header ul.menu ul.sub-menu > li:hover > a,
		.kapee-megamenu-wrapper li.menu-item a:hover{
			color: '.$style_options['popup_menu']['link_color']['hover'].';
			background-color:'.$style_options['popup_menu']['hover_background'].';
		}
		
		/* 
		* Page Title color Scheme 
		*/
		#page-title{
			padding-top:'.$style_options['page_title']['padding']['padding-top'].';
			padding-bottom:'.$style_options['page_title']['padding']['padding-bottom'].';
		}	
		
		/*
		* Footer color Scheme
		*/
		.footer-main,
		.site-footer .caption{
			color: '.$style_options['footer']['text_color'].';			
		}		
		.site-footer .widget-title{
			color: '.$style_options['footer']['title_color'].';
		}
		.footer-main a,
		.footer-main label,
		.footer-main thead th{
			color: '.$style_options['footer']['link_color']['regular'].';
		}
		.footer-main a:hover{
			color: '.$style_options['footer']['link_color']['hover'].';
		}
		.site-footer text,
		.site-footer select, 
		.site-footer textarea,
		.site-footer number{
			color:'.$style_options['footer']['input_color'].';
			background-color:'.$style_options['footer']['input_background'].';
		}		
		.site-footer .mc4wp-form-fields p:first-child::before{
			color: '.$style_options['footer']['input_color'].';
		}
		.site-footer ::-webkit-input-placeholder {
		   color:'.$style_options['footer']['input_color'].';
		}
		.site-footer :-moz-placeholder { /* Firefox 18- */
		  color:'.$style_options['footer']['input_color'].';
		}
		.site-footer ::-moz-placeholder {  /* Firefox 19+ */
		   color:'.$style_options['footer']['input_color'].';
		}
		.site-footer :-ms-input-placeholder {
		   color:'.$style_options['footer']['input_color'].';
		}
		
		/*
		* Copyright color Scheme
		*/
		.footer-copyright{
			color: '.$style_options['copyright']['text_color'].';
		}
		.footer-copyright a{
			color: '.$style_options['copyright']['link_color']['regular'].';
		}
		.footer-copyright a:hover{
			color: '.$style_options['copyright']['link_color']['hover'].';
		}
		.footer-copyright{
			border-top-width:'.$style_options['copyright']['border']['border-top'].';
			border-top-style:'.$style_options['copyright']['border']['border-style'].';
			border-top-color:'.$style_options['copyright']['border']['border-color'].';
		}
		
		/*
		* Woocommece Color
		*/';
		
		if( $style_options['woocommece']['single_line_title'] ){
			$theme_css .= '
			.woocommerce ul.cart_list li .product-title, 
			.woocommerce ul.product_list_widget li .product-title,
			.widget.widget_layered_nav li .nav-title,
			.products .product-cats,
			.products.grid-view .product-title,
			.kapee-bought-together-products .product-title,
			.products .woocommerce-loop-category__title{
				text-overflow: ellipsis;
				white-space: nowrap;
				overflow: hidden;
			}';
		}
		
		$theme_css .= '
		.product-labels span.on-sale{
			background-color:'.$style_options['woocommece']['sale_label_color'].';
		}
		.products .product-info .on-sale, 
		div.summary .on-sale,
		.woocommerce div.summary .price-summary .discount span, 
		.woocommerce div.summary .price-summary .delivery span, 
		.woocommerce div.summary .price-summary .overall-discount span,
		.woocommerce div.summary .price-summary .overall-discount{
			color:'.$style_options['woocommece']['sale_label_color'].';
		}
		.product-labels span.new{
			background-color:'.$style_options['woocommece']['new_label_color'].';
		}
		.product-labels span.featured{
			background-color:'.$style_options['woocommece']['featured_label_color'].';
		}
		.product-labels span.out-of-stock{
			background-color:'.$style_options['woocommece']['outofstock_label_color'].';
		}		
		.freeshipping-bar {
			background-color:'.$style_options['free_shipping']['background'].';
		}
		.freeshipping-bar .progress-bar {
			background-color:'.$style_options['free_shipping']['color'].';
		}
		
		/*
		* Newsletter Color
		*/
		.kapee-newsletter-popup input[type="submit"]{
			color:'.$style_options['newsletter']['button_color']['regular'].';
			background-color:'.$style_options['newsletter']['button_background']['regular'].';
		}
		.kapee-newsletter-popup input[type="submit"]:hover{
			color:'.$style_options['newsletter']['button_color']['hover'].';
			background-color:'.$style_options['newsletter']['button_background']['hover'].';
		}
		
		/*
		* Responsive 
		*/
		@media (max-width:991px){
			.site-header .header-main,
			.site-header .header-navigation,
			.site-header .header-sticky{
				color: '.$style_options['mobile_header']['text_color'].';
				background-color: '.$style_options['mobile_header']['background'].';
			}
			.ajax-search-style-1 .search-submit, 
			.ajax-search-style-2 .search-submit,
			.ajax-search-style-3 .search-submit, 
			.ajax-search-style-4 .search-submit,
			.header-cart-icon .header-cart-count, 
			.header-wishlist-icon .header-wishlist-count,
			.header-compare-icon .header-compare-count{
				color: '.$style_options['mobile_header']['background'].';
				background-color: '.$style_options['mobile_header']['text_color'].';
			}
			.header-main a,
			.header-navigation a,
			.header-sticky a{				
				color: '.$style_options['mobile_header']['link_color']['regular'].';
			}
			.header-main a:hover,
			.header-navigation a:hover,
			.header-sticky a:hover{
				color: '.$style_options['mobile_header']['link_color']['regular'].';
			}
			.site-header .header-main,
			.site-header .header-navigation,
			.site-header .header-sticky{
				border-color: '.$style_options['mobile_header']['background'].';
			}
			.woocommerce div.summary .price-summary .price-summary-header,
			.woocommerce div.summary .product-term-detail .terms-header,
			.tabs-layout .tab-content-wrap:last-child{
				border-bottom-width:'.$style_options['site']['border']['border-bottom'].';
				border-bottom-style:'.$style_options['site']['border']['border-style'].';
				border-bottom-color:'.$style_options['site']['border']['border-color'].';
			}
			.tabs-layout .tab-content-wrap{
				border-top-width:'.$style_options['site']['border']['border-top'].';
				border-top-style:'.$style_options['site']['border']['border-style'].';
				border-top-color:'.$style_options['site']['border']['border-color'].';
			}
			.site-header text,
			.site-header select, 
			.site-header textarea,
			.site-header number,
			.site-header input[type="search"],
			.header-sticky .search-categories > select,
			.site-header .product_cat{
				color:'.$style_options['mobile_header']['input_color'].';
				background-color:'.$style_options['mobile_header']['input_background'].';
			}
			
			/* Placeholder Colors */
			.site-header ::-webkit-input-placeholder {
			   color:'.$style_options['mobile_header']['input_color'].';
			}
			.site-header :-moz-placeholder { /* Firefox 18- */
			  color:'.$style_options['mobile_header']['input_color'].';
			}
			.site-header ::-moz-placeholder {  /* Firefox 19+ */
			   color:'.$style_options['mobile_header']['input_color'].';
			}
			.site-header :-ms-input-placeholder { 
			   color:'.$style_options['mobile_header']['input_color'].';
			}
		}
		@media (max-width:767px){
			.widget-area{
				background-color:'.$style_options['site']['wrapper_background']['background-color'].';
			}
			.single-product-page > .kapee-bought-together-products .items-total-price-button, 
			.single-product-page .woocommerce-tabs .kapee-bought-together-products .items-total-price-button{
				border-top-width:'.$style_options['site']['border']['border-top'].';
				border-top-style:'.$style_options['site']['border']['border-style'].';
				border-top-color:'.$style_options['site']['border']['border-color'].';
			}
			.products-and-categories-box .section-categories,
			.woocommerce-cart table.cart tr{
				border-bottom-width:'.$style_options['site']['border']['border-bottom'].';
				border-bottom-style:'.$style_options['site']['border']['border-style'].';
				border-bottom-color:'.$style_options['site']['border']['border-color'].';
			}
			.nav-subtitle{
				color: '.$style_options['site']['link_color']['regular'].';
			}
		}		
		@media (max-width:576px){
			.kapee-signin-up-popup .mfp-close{
				color: '.$style_options['site']['primary_inverse_color'].';
			}
		}
	';
	
	$theme_css .= kapee_get_option( 'custom-css', '' );	
	$theme_css .= kapee_custom_font();
	$theme_css .= kapee_vc_fullrow_css();
	
	$theme_css = apply_filters( 'kapee_custom_css', $theme_css, $style_options );
	$theme_css = kapee_cleanup_css( $theme_css );
	return $theme_css;
}
endif;

if ( ! function_exists( 'kapee_custom_font' ) ) :
	function kapee_custom_font() {
		/* Custom Font Option */
		$enable_custom_font1 = kapee_get_option( 'custom-font1', 0 );
		$enable_custom_font2 = kapee_get_option( 'custom-font2', 0 );
		$enable_custom_font3 = kapee_get_option( 'custom-font3', 0 );
		$font_face = array();
		if( $enable_custom_font1 ){
			$font1_name 			= kapee_get_option( 'custom-font1-name',''); 
			$custom_font1_woff 		= kapee_get_custom_fonturl('custom-font1-woff');
			$custom_font1_woff2 	= kapee_get_custom_fonturl('custom-font1-woff2');
			$custom_font1_ttf 		= kapee_get_custom_fonturl('custom-font1-ttf');
			$custom_font1_svg		= kapee_get_custom_fonturl('custom-font1-svg');
			$custom_font1_eot 		= kapee_get_custom_fonturl('custom-font1-eot');
			if( !empty( $font1_name ) && ( $custom_font1_woff != '' || $custom_font1_woff2 != '' || $custom_font1_ttf != '' || $custom_font1_svg != '' || $custom_font1_eot != '' ) ){				
				$font_face[] = '@font-face {font-family: "'.$font1_name.'";
				  src: url("'.$custom_font1_eot.'"); /* IE9*/
				  src: url("'.$custom_font1_eot.'?#iefix") format("embedded-opentype"), /* IE6-IE8 */
				  url("'.$custom_font1_woff2.'") format("woff2"), /* chrome,firefox */
				  url("'.$custom_font1_woff.'") format("woff"), /* chrome,firefox */
				  url("'.$custom_font1_ttf.'") format("truetype"), /* chrome,firefox,opera,Safari, Android, iOS 4.2+*/
				  url("'.$custom_font1_svg.'#'.$font1_name.'") format("svg"); /* iOS 4.1- */
				}';
			}
		}
		if( $enable_custom_font2 ){
			$font2_name 			= kapee_get_option( 'custom-font2-name',''); 
			$custom_font2_woff 		= kapee_get_custom_fonturl('custom-font2-woff');
			$custom_font2_woff2 	= kapee_get_custom_fonturl('custom-font2-woff2');
			$custom_font2_ttf 		= kapee_get_custom_fonturl('custom-font2-ttf');
			$custom_font2_svg		= kapee_get_custom_fonturl('custom-font2-svg');
			$custom_font2_eot 		= kapee_get_custom_fonturl('custom-font2-eot');
			if( !empty($font2_name ) && ( $custom_font2_woff != '' || $custom_font2_woff2 != '' || $custom_font2_ttf != '' || $custom_font2_svg != '' || $custom_font2_eot != '' ) ){				
				$font_face[] = '@font-face {font-family: "'.$font2_name.'";
				  src: url("'.$custom_font2_eot.'"); /* IE9*/
				  src: url("'.$custom_font2_eot.'?#iefix") format("embedded-opentype"), /* IE6-IE8 */
				  url("'.$custom_font2_woff2.'") format("woff2"), /* chrome,firefox */
				  url("'.$custom_font2_woff.'") format("woff"), /* chrome,firefox */
				  url("'.$custom_font2_ttf.'") format("truetype"), /* chrome,firefox,opera,Safari, Android, iOS 4.2+*/
				  url("'.$custom_font2_svg.'#'.$font2_name.'") format("svg"); /* iOS 4.1- */
				}';
			}
		}
		if( $enable_custom_font3 ){
			$font3_name 			= kapee_get_option( 'custom-font3-name',''); 
			$custom_font3_woff 		= kapee_get_custom_fonturl('custom-font3-woff');
			$custom_font3_woff2 	= kapee_get_custom_fonturl('custom-font3-woff2');
			$custom_font3_ttf 		= kapee_get_custom_fonturl('custom-font3-ttf');
			$custom_font3_svg		= kapee_get_custom_fonturl('custom-font3-svg');
			$custom_font3_eot 		= kapee_get_custom_fonturl('custom-font3-eot');
			if( !empty( $font3_name) && ( $custom_font3_woff != '' || $custom_font3_woff2 != '' || $custom_font3_ttf != '' || $custom_font3_svg != '' || $custom_font3_eot != '' ) ){				
				$font_face[] = '@font-face {font-family: "'.$font3_name.'";
				  src: url("'.$custom_font3_eot.'"); /* IE9*/
				  src: url("'.$custom_font3_eot.'?#iefix") format("embedded-opentype"), /* IE6-IE8 */
				  url("'.$custom_font3_woff2.'") format("woff2"), /* chrome,firefox */
				  url("'.$custom_font3_woff.'") format("woff"), /* chrome,firefox */
				  url("'.$custom_font3_ttf.'") format("truetype"), /* chrome,firefox,opera,Safari, Android, iOS 4.2+*/
				  url("'.$custom_font3_svg.'#'.$font3_name.'") format("svg"); /* iOS 4.1- */
				}';
			}
		}
		return !empty( $font_face ) ? implode(' ', $font_face ) : '';
	}
endif;

function kapee_get_custom_fonturl( $font_type ){
	$custom_font_file = kapee_get_option( $font_type );
	return (isset($custom_font_file['url']) && !empty($custom_font_file['url'])) ? $custom_font_file['url'] : '';
}

function kapee_vc_fullrow_css(){
	
	if ( !defined( 'WPB_VC_VERSION' ) ) { return; }		
	
	$container_width = kapee_get_option( 'theme-container-width', 1200 );
	if( 'wide' == kapee_get_option( 'theme-layout', 'full' ) ) {
		$container_width = 1600;
	}
	
	ob_start();	?>
	[data-vc-full-width] {
		width: 100vw;
		left: -2.5vw; 
	}
	<?php if ( $container_width ){ ?>
	
		/* Site container width */		
		@media (min-width: <?php echo esc_attr( $container_width + 70 ); ?>px) {
			
			[data-vc-full-width] {
				<?php if ( is_rtl() ): ?>
					left: calc((100vw - <?php echo esc_attr( $container_width ); ?>px) / 2);
				<?php else: ?>
					left: calc((-100vw - -<?php echo esc_attr( $container_width ); ?>px) / 2);
				<?php endif; ?>
			}
			
			[data-vc-full-width]:not([data-vc-stretch-content]) {
				padding-left: calc(( 100vw - <?php echo esc_attr( $container_width ); ?>px) / 2);
				padding-right: calc(( 100vw - <?php echo esc_attr( $container_width ); ?>px) / 2);
			}
		}
	<?php }
	
	$style = ob_get_clean();
	return $style;
}