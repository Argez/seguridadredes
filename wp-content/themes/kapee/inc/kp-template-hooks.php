<?php
/**
 * Action/filter hooks used for theme functions/templates.
 *
 * @author 		PressLayouts
 * @package 	kapee/inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'body_class', 'kapee_body_classes' );
add_filter( 'post_class', 'kapee_post_classes', 10, 3 );

add_action( 'kapee_body_top', 'kapee_site_loader', 1 );

/**
 * Content Wrappers.
 *
 * @see kapee_output_content_wrapper()
 * @see kapee_output_content_wrapper_end()
 */
add_action( 'kapee_before_main_content', 'kapee_output_content_wrapper', 10 );
add_action( 'kapee_after_main_content', 'kapee_output_content_wrapper_end', 10 );

/**
 * Header.
 *
 * @see kapee_template_header()
 * @see kapee_header_topbar_left()
 * @see kapee_header_topbar_right()
 * @see kapee_header_main_left()
 * @see kapee_header_main_center()
 * @see kapee_header_main_right()
 * @see kapee_header_navigation_left()
 * @see kapee_header_navigation_center()
 * @see kapee_header_navigation_right()
 */
add_action( 'kapee_header', 'kapee_template_header', 10 );
add_action( 'kapee_header_topbar_left', 'kapee_header_topbar_left', 10 );
add_action( 'kapee_header_topbar_right', 'kapee_header_topbar_right', 10 );
add_action( 'kapee_header_main_left', 'kapee_header_main_left', 10 );
add_action( 'kapee_header_main_center', 'kapee_header_main_center', 10 );
add_action( 'kapee_header_main_right', 'kapee_header_main_right', 10 );
add_action( 'kapee_header_navigation_left', 'kapee_header_navigation_left', 10 );
add_action( 'kapee_header_navigation_center', 'kapee_header_navigation_center', 10 );
add_action( 'kapee_header_navigation_right', 'kapee_header_navigation_right', 10 );
add_action( 'kapee_header_sticky_left', 'kapee_header_sticky_left', 10 );
add_action( 'kapee_header_sticky_center', 'kapee_header_sticky_center', 10 );
add_action( 'kapee_header_sticky_right', 'kapee_header_sticky_right', 10 );
add_action( 'kapee_header_mobile_left', 'kapee_header_mobile_left', 10 );
add_action( 'kapee_header_mobile_center', 'kapee_header_mobile_center', 10 );
add_action( 'kapee_header_mobile_right', 'kapee_header_mobile_right', 10 );
add_action( 'kapee_header_mobile_sticky_left', 'kapee_header_mobile_sticky_left', 10 );
add_action( 'kapee_header_mobile_sticky_center', 'kapee_header_mobile_sticky_center', 10 );
add_action( 'kapee_header_mobile_sticky_right', 'kapee_header_mobile_sticky_right', 10 );

/**
 * Page Title.
 *
 * @see kapee_template_page_title()
 * @see kapee_template_breadcrumbs()
 */
add_action( 'kapee_page_title', 'kapee_page_title', 10 );
add_action( 'kapee_inner_page_title', 'kapee_template_page_title', 10 );
add_action( 'kapee_inner_page_title', 'kapee_template_breadcrumbs', 20 );

/**
 * Sidebar.
 *
 * @see kapee_get_sidebar()
 */
add_action( 'kapee_sidebar', 'kapee_get_sidebar', 10 );

/**
 * Page
 *
 * @see kapee_template_page_content()
 * @kapee_template_page_comments()
 */
add_action( 'kapee_page_content', 'kapee_template_page_content', 10 );
add_action( 'kapee_after_page_entry', 'kapee_template_page_comments', 10 );

/**
 * Post Loop.
 *
 * @see kapee_post_wrapper()
 * @see kapee_template_loop_post_fancy_date()
 * @see kapee_template_loop_post_highlight()
 * @see kapee_template_loop_post_thumbnail()
 * @see kapee_template_loop_post_header()
 * @see kapee_template_loop_post_content()
 * @see kapee_template_loop_post_footer()
 * @see kapee_post_wrapper_end()
 * @see kapee_pagination()
 */
add_action( 'kapee_loop_post_entry_top', 'kapee_post_wrapper', 10 );
add_action( 'kapee_loop_post_thumbnail', 'kapee_template_loop_post_fancy_date', 10 );
add_action( 'kapee_loop_post_thumbnail', 'kapee_template_loop_post_highlight', 20 );
add_action( 'kapee_loop_post_thumbnail', 'kapee_template_loop_post_thumbnail', 30 );
add_action( 'kapee_loop_post_content', 'kapee_template_loop_post_header', 10 );
add_action( 'kapee_loop_post_content', 'kapee_template_loop_post_content', 20 );
add_action( 'kapee_loop_post_content', 'kapee_template_loop_post_footer', 30 );
add_action( 'kapee_loop_post_entry_bottom', 'kapee_post_wrapper_end', 10 );
add_action( 'kapee_after_loop_post', 'kapee_pagination', 10 );

//Inner hook
add_action( 'kapee_loop_post_header', 'kapee_template_loop_post_category', 5 );
add_action( 'kapee_loop_post_header', 'kapee_template_loop_post_title', 10 );
add_action( 'kapee_loop_post_header', 'kapee_template_loop_post_meta', 20 );
add_action( 'kapee_loop_post_footer', 'kapee_template_read_more_link', 10 );

/**
 * Single Post.
 *
 * @see kapee_post_wrapper()
 * @see kapee_template_single_post_fancy_date()
 * @see kapee_template_single_post_highlight()
 * @see kapee_template_single_post_thumbnail()
 * @see kapee_template_single_post_header()
 * @see kapee_template_single_post_content()
 * @see kapee_post_wrapper_end()
 * @see kapee_template_single_tag_social_share()
 * @see kapee_template_single_post_author_bios()
 * @see kapee_template_single_post_navigation()
 * @see kapee_template_single_post_related()
 * @see kapee_template_single_post_comments()
 * @see kapee_template_single_post_title()
 * @see kapee_template_single_post_meta()
 */
add_action( 'kapee_single_post_entry_top', 'kapee_post_wrapper', 10 );
add_action( 'kapee_single_post_entry_top', 'kapee_template_single_post_header', 15 );
add_action( 'kapee_single_post_thumbnail', 'kapee_template_single_post_fancy_date', 10 );
add_action( 'kapee_single_post_thumbnail', 'kapee_template_single_post_highlight', 20 );
add_action( 'kapee_single_post_thumbnail', 'kapee_template_single_post_thumbnail', 30 );
add_action( 'kapee_single_post_content', 'kapee_template_single_post_content', 20 );
add_action( 'kapee_single_post_entry_bottom', 'kapee_post_wrapper_end', 10 );
add_action( 'kapee_after_single_post_entry', 'kapee_template_single_post_author_bios', 10 );
add_action( 'kapee_after_single_post_entry', 'kapee_template_single_tag_social_share', 20 );
add_action( 'kapee_after_single_post_entry', 'kapee_template_single_post_navigation', 30 );
add_action( 'kapee_after_single_post_entry', 'kapee_template_single_post_related', 40 );
add_action( 'kapee_after_single_post_entry', 'kapee_template_single_post_comments', 50 );

//Inner hook
add_action( 'kapee_single_post_header', 'kapee_template_single_post_category', 5 );
add_action( 'kapee_single_post_header', 'kapee_template_single_post_title', 10 );
add_action( 'kapee_single_post_header', 'kapee_template_single_post_meta', 20 );
 
/**
 * Portfolio Loop.
 *
 * @see kapee_template_portfolio_filter()
 * @see kapee_post_wrapper()
 * @see kapee_template_portfolio_loop_thumbnail()
 * @see kapee_template_portfolio_loop_action_icon()
 * @see kapee_template_portfolio_loop_header()
 * @see kapee_post_wrapper_end()
 * @see kapee_template_portfolio_loop_categories()
 * @see kapee_template_portfolio_loop_title()
 * @see kapee_portfolio_pagination()
 */
add_action( 'kapee_before_portfolio_loop', 'kapee_template_portfolio_filter', 10 );
add_action( 'kapee_portfolio_loop_entry_top', 'kapee_post_wrapper', 10 );
add_action( 'kapee_portfolio_loop_thumbnail', 'kapee_template_portfolio_loop_thumbnail', 10 );
add_action( 'kapee_portfolio_loop_thumbnail', 'kapee_template_portfolio_loop_action_icon', 20 );
add_action( 'kapee_portfolio_loop_content', 'kapee_template_portfolio_loop_header', 10 );
add_action( 'kapee_portfolio_loop_entry_bottom', 'kapee_post_wrapper_end', 10 );
add_action( 'kapee_after_portfolio_loop', 'kapee_portfolio_pagination', 10 );

//Inner hook 
add_action( 'kapee_portfolio_loop_header', 'kapee_template_portfolio_loop_categories',10 );
add_action( 'kapee_portfolio_loop_header', 'kapee_template_portfolio_loop_title',20 );;

/**
 * Single Portfolio
 *
 * @see kapee_post_wrapper()
 * @see kapee_template_single_portfolio_image()
 * @see kapee_template_single_portfolio_title()
 * @see kapee_template_single_portfolio_content()
 * @see kapee_template_single_portfolio_client()
 * @see kapee_template_single_portfolio_date()
 * @see kapee_template_single_portfolio_category()
 * @see kapee_template_single_portfolio_skill()
 * @see kapee_template_single_portfolio_share()
 * @see kapee_template_single_portfolio_navigation()
 * @see kapee_template_single_related_portfolio()
 * @see kapee_template_single_portfolio_comments()
 * @see kapee_post_wrapper_end()
 */
add_action( 'kapee_single_portfolio_entry_top', 'kapee_post_wrapper', 10 );
add_action( 'kapee_single_portfolio_image', 'kapee_template_single_portfolio_image', 10 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_title', 5 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_content', 10 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_preview', 15 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_client', 20 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_date', 25 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_category', 30 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_skill', 35 );
add_action( 'kapee_single_portfolio_summary', 'kapee_template_single_portfolio_share', 40 );
add_action( 'kapee_after_single_portfolio_entry', 'kapee_template_single_portfolio_navigation', 10 );
add_action( 'kapee_after_single_portfolio_entry', 'kapee_template_single_related_portfolio', 20 );
add_action( 'kapee_after_single_portfolio_entry', 'kapee_template_single_portfolio_comments', 30 );
add_action( 'kapee_single_portfolio_entry_bottom', 'kapee_post_wrapper_end', 10 );

/* Comming Soon */
add_action( 'template_redirect', 'kapee_coming_soon_redirect' );

/**
 * Footer.
 *
 * @see kapee_template_footer()
 * @see kapee_back_to_top()
 * @see kapee_mobile_menu()
 * @see kapee_search_popup()
 * @see kapee_newsletter_popup()
 * @see kapee_mobile_bottom_navbar()
 * @see kapee_promo_bar()
 * @see kapee_mask_overaly()
 */
add_action( 'kapee_footer', 'kapee_template_footer', 10 );
add_action( 'kapee_body_bottom', 'kapee_back_to_top', 10 );
add_action( 'kapee_body_bottom', 'kapee_mobile_menu', 20 );
add_action( 'kapee_body_bottom', 'kapee_search_popup', 25 );
add_action( 'kapee_body_bottom', 'kapee_newsletter_popup', 30 );
add_action( 'kapee_body_bottom', 'kapee_mobile_bottom_navbar', 40 );
add_action( 'kapee_body_bottom', 'kapee_mask_overaly', 100 );