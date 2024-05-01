<?php
/**
 * Action/filter hooks used for woocommerce functions/templates.
 *
 * @author 		PressLayouts
 * @package 	kapee/inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_theme_support( 'woocommerce');
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter('woocommerce_show_page_title', '__return_false');
add_filter( 'body_class', 'kapee_body_woocommerce_classes' );

/**
 * Kapee Header
 *
 * @see kapee_ajax_wishlist_count()
 * @see kapee_ajax_compare_count()
 * @see kapee_empty_mini_cart_button()
 */
add_action( 'wp_ajax_kapee_ajax_wishlist_count', 'kapee_ajax_wishlist_count' );
add_action( 'wp_ajax_nopriv_kapee_ajax_wishlist_count', 'kapee_ajax_wishlist_count' );
add_action( 'wp_ajax_kapee_ajax_compare_count', 'kapee_ajax_compare_count' );
add_action( 'wp_ajax_nopriv_kapee_ajax_compare_count', 'kapee_ajax_compare_count' );
add_action( 'kapee_after_empty_mini_cart', 'kapee_empty_mini_cart_button', 20 );

/**
 * Content Wrappers
 *
 * @see kapee_output_content_wrapper()
 * @see kapee_output_content_wrapper_end()
 * @see kapee_reset_loop()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'kapee_output_content_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'kapee_output_content_wrapper_end', 10 );

add_action( 'woocommerce_after_shop_loop', 'kapee_reset_loop', 999 );

/**
 * Products Loop.
 *
 * @see kapee_before_shop_loop()
 * @see kapee_shop_page_title()
 * @see kapee_product_loop_view()
 * @see kapee_product_loop_show()
 * @see kapee_product_filter_top()
 * @see kapee_filter_widgets()
 * @see kapee_active_filter_widgets()
 * @see kapee_clear_filters_btn()
 * @see kapee_loop_product_wrapper()
 * @see kapee_before_shop_loop_item_title()
 * @see kapee_output_product_labels()
 * @see kapee_product_loop_wishlist_button()
 * @see kapee_template_loop_product_thumbnail()
 * @see kapee_shop_loop_item_title()
 * @see kapee_product_price_buttons_wrapper()
 * @see kapee_after_shop_loop_item_title()
 * @see kapee_product_sale_percentage()
 * @see kapee_product_loop_buttons_variations()
 * @see kapee_template_loop_action_buttons()
 * @see kapee_product_loop_cart_button()
 * @see kapee_product_loop_compare_button()
 * @see kapee_product_loop_quick_view_button()
 * @see kapee_stock_progress_bar()
 * @see kapee_sale_product_countdown()
 * @see kapee_after_shop_loop_item()
 * @see kapee_product_wrapper_end()
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_before_shop_loop', 'kapee_before_shop_loop', 20 );
add_action( 'kapee_shop_loop_header_left', 'kapee_shop_page_title', 10 );
add_action( 'kapee_shop_loop_header_left', 'woocommerce_result_count', 20 );
add_action( 'kapee_shop_loop_header_right', 'kapee_product_loop_view', 20 );
add_action( 'kapee_shop_loop_header_right', 'kapee_product_loop_show', 25 );
add_action( 'kapee_shop_loop_header_right', 'woocommerce_catalog_ordering', 30 );
add_action( 'kapee_shop_loop_header_right', 'kapee_product_filter_top', 35 );
add_action( 'woocommerce_before_shop_loop', 'kapee_filter_widgets', 25 );
add_action( 'woocommerce_before_shop_loop', 'kapee_active_filter_widgets', 30 );
add_action( 'kapee_before_active_filters_widgets', 'kapee_clear_filters_btn', 30 );
add_action( 'woocommerce_before_shop_loop_item', 'kapee_loop_product_wrapper', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'kapee_before_shop_loop_item_title', 10 );
add_action( 'kapee_before_shop_loop_item_title', 'kapee_output_product_labels', 5 );
add_action( 'kapee_before_shop_loop_item_title', 'kapee_product_loop_wishlist_button', 8 );
add_action( 'kapee_before_shop_loop_item_title', 'kapee_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'kapee_shop_loop_item_title', 10 );
add_action( 'kapee_shop_loop_item_title', 'kapee_loop_product_info_wrapper', 5 );
add_action( 'kapee_shop_loop_item_title', 'kapee_product_title_rating_wrapper', 10 );
add_action( 'kapee_shop_loop_item_title', 'kapee_product_loop_categories', 15 );
add_action( 'kapee_shop_loop_item_title', 'woocommerce_template_loop_product_title', 20 );
add_action( 'kapee_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
add_action( 'kapee_shop_loop_item_title', 'woocommerce_template_single_excerpt', 30 );
add_action( 'kapee_shop_loop_item_title', 'kapee_product_wrapper_end', 50 );
add_action( 'woocommerce_after_shop_loop_item_title', 'kapee_product_price_buttons_wrapper', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'kapee_after_shop_loop_item_title', 10 );
add_action( 'kapee_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'kapee_after_shop_loop_item_title', 'kapee_product_sale_percentage', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'kapee_product_loop_buttons_variations', 10 );
add_action( 'kapee_product_loop_buttons_variations', 'kapee_template_loop_action_buttons', 10 );
add_action( 'kapee_template_loop_action_buttons', 'kapee_product_loop_cart_button', 10 );
add_action( 'kapee_product_loop_cart_button', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'kapee_template_loop_action_buttons', 'kapee_product_loop_quantity_field', 5 );
add_action( 'kapee_template_loop_action_buttons', 'kapee_product_loop_wishlist_button', 15 );
add_action( 'kapee_template_loop_action_buttons', 'kapee_product_loop_compare_button', 20 );
add_action( 'kapee_template_loop_action_buttons', 'kapee_product_loop_quick_view_button', 25 );
add_action( 'woocommerce_after_shop_loop_item', 'kapee_stock_progress_bar', 14 );
add_action( 'woocommerce_after_shop_loop_item', 'kapee_sale_product_countdown', 15 );
add_action( 'woocommerce_after_shop_loop_item', 'kapee_after_shop_loop_item', 50 );
add_action( 'kapee_after_shop_loop_item', 'kapee_product_wrapper_end', 10 );
add_action( 'kapee_after_shop_loop_item', 'kapee_product_wrapper_end', 20 );
add_action( 'kapee_after_shop_loop_item', 'kapee_product_wrapper_end', 30 );

/**
 * Categories Loop.
 *
 * @see kapee_loop_product_wrapper()
 * @see kapee_product_wrapper_end()
 */
add_action( 'woocommerce_before_subcategory', 'kapee_loop_product_wrapper', 5 );
add_action( 'woocommerce_after_subcategory', 'kapee_product_wrapper_end', 10 );

/**
 * Single Product
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
 
/**
 * Single Products Div.
 *
 * @see kapee_output_product_labels()
 * @see kapee_single_product_video_btn()
 * @see kapee_single_product_degree360_btn()
 * @see kapee_single_product_photoswipe_btn()
 * @see kapee_template_breadcrumbs()
 * @see kapee_single_product_before_price()
 * @see kapee_single_product_share()
 * @see kapee_product_navigation_share()
 * @see kapee_single_product_navigation()
 * @see woocommerce_template_single_rating()
 * @see kapee_sale_product_countdown()
 * @see kapee_single_product_after_price()
 * @see kapee_single_product_price_discount()
 * @see kapee_single_product_price_summary()
 * @see kapee_single_product_stock_availability()
 * @see kapee_single_product_offers()
 * @see kapee_single_product_brands()
 * @see kapee_single_product_services()
 * @see kapee_single_product_size_chart()
 * @see kapee_single_product_share()
 * @see kapee_output_recently_viewed_products()
 */

add_action( 'kapee_product_gallery_top', 'kapee_output_product_labels', 10 ); 
add_action( 'kapee_product_gallery_bottom', 'kapee_single_product_video_btn', 10 );
add_action( 'kapee_product_gallery_bottom', 'kapee_single_product_degree360_btn', 15 );
add_action( 'kapee_product_gallery_bottom', 'kapee_single_product_photoswipe_btn', 20 );
add_action( 'woocommerce_single_product_summary', 'kapee_before_single_product_price', 6 );
add_action( 'kapee_before_single_product_price', 'kapee_product_navigation_share', 10 );
add_action( 'kapee_product_navigation_share', 'kapee_single_product_navigation', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 8);
add_action( 'woocommerce_single_product_summary', 'kapee_sale_product_countdown', 9);
add_action( 'woocommerce_single_product_summary', 'kapee_after_single_product_price', 12);
add_action( 'kapee_after_single_product_price', 'kapee_single_product_price_discount', 5 );
add_action( 'kapee_after_single_product_price', 'kapee_single_product_price_summary', 5 );
add_action( 'kapee_after_single_product_price', 'kapee_single_product_stock_availability', 6 );
add_action( 'kapee_after_single_product_price', 'kapee_single_product_offers', 10 );
add_action( 'kapee_after_single_product_price', 'kapee_single_product_brands', 15 );
add_action( 'kapee_after_single_product_price', 'kapee_single_product_services', 25 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_size_chart', 35 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_delivery_return_ask_question', 36 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_estimated_delivery', 37 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_visitor_count', 38 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_trust_badge', 39 );
add_action( 'woocommerce_single_product_summary', 'kapee_single_product_share', 50 );
add_action( 'woocommerce_after_single_product_summary', 'kapee_output_recently_viewed_products', 25 );

/**
 * Quick Buy
 *
 * @see kapee_add_quick_buy_pid()
 * @see kapee_add_quick_buy_button()
 * @see kapee_quick_buy_redirect()
 */
add_action( 'woocommerce_after_add_to_cart_button', 'kapee_add_quick_buy_pid' );
add_action( 'woocommerce_after_add_to_cart_button', 'kapee_add_quick_buy_button', 99 );
add_filter( 'woocommerce_add_to_cart_redirect', 'kapee_quick_buy_redirect', 99 );

/**
 * Quantity Buttons
 *
 * @see kapee_quantity_button_minus()
 * @see kapee_quantity_button_plus()
 */
add_action( 'woocommerce_before_quantity_input_field', 'kapee_quantity_button_minus', 10 );
add_action( 'woocommerce_after_quantity_input_field', 'kapee_quantity_button_plus', 10 );

/**
 * My Account Page
 *
 * @see wc_registration_privacy_policy_text()
 * @see kapee_before_account_navigation()
 * @see kapee_after_account_navigation()
 * @see kapee_woocommerce_before_account_orders()
 * @see kapee_woocommerce_before_account_downloads()
 * @see kapee_woocommerce_my_account_my_address_description()
 * @see kapee_woocommerce_myaccount_edit_account_heading()
 */
remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

add_action( 'kapee_before_signup_form', 'wc_registration_privacy_policy_text', 10 );
add_action( 'woocommerce_before_account_navigation', 'kapee_before_account_navigation' );
add_action( 'woocommerce_after_account_navigation', 'kapee_after_account_navigation' );
add_action( 'woocommerce_before_account_orders', 'kapee_woocommerce_before_account_orders', 10 );
add_action( 'woocommerce_before_account_downloads', 'kapee_woocommerce_before_account_downloads', 10 );
add_filter( 'woocommerce_my_account_my_address_description', 'kapee_woocommerce_my_account_my_address_description', 10 );
add_action( 'woocommerce_before_edit_account_form', 'kapee_woocommerce_myaccount_edit_account_heading', 10 );

/**
 * Cart Page
 *
 * @see kapee_free_shipping_bar()
 * @see kapee_woocommerce_cart_page_wrapper()
 * @see kapee_woocommerce_cart_page_wrapper_end()
 * @see woocommerce_cross_sell_display()
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_action( 'woocommerce_proceed_to_checkout', 'kapee_free_shipping_bar', 10 );
add_action( 'woocommerce_before_cart', 'kapee_woocommerce_cart_page_wrapper', 10 );
add_action( 'woocommerce_after_cart', 'kapee_woocommerce_cart_page_wrapper_end', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 20 );

 /**
 * Mini Cart
 *
 * @see kapee_free_shipping_bar()
 */
add_action( 'woocommerce_widget_shopping_cart_total', 'kapee_free_shipping_bar', 20 );


/**
 * Footer
 *
 * @see kapee_login_signup_popup()
 * @see kapee_minicart_slide()
 * @see kapee_canvas_sidebar()
 * @see kapee_single_product_360_degree_content()
 * @see kapee_sticky_add_to_cart_button()
 */
add_action( 'kapee_body_bottom', 'kapee_login_signup_popup', 50 );
add_action( 'kapee_body_bottom', 'kapee_minicart_slide', 55 );
add_action( 'kapee_body_bottom', 'kapee_canvas_sidebar', 60 );
add_action( 'kapee_body_bottom', 'kapee_single_product_360_degree_content', 65 );
add_action( 'kapee_body_bottom', 'kapee_sticky_add_to_cart_button', 70 );