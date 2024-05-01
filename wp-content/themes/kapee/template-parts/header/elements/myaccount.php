<?php
/**
 * Template part for displaying my account
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/header
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! kapee_get_option( 'header-login-register', 1 ) || ! KAPEE_WOOCOMMERCE_ACTIVE ) { return; }

$user_data 					= wp_get_current_user();
$myaccount_menu_location	= apply_filters( 'kapee_header_myaccount_menu_location', 'myaccount-menu' );
$current_user 				= apply_filters( 'kapee_header_myaccount_username', $user_data->user_login );	
$user_logged_in 			= apply_filters( 'kapee_header_myaccount_logged_in', is_user_logged_in() );
$signinupText  				= apply_filters( 'kapee_header_myaccount_signinup_text', esc_html__( 'Sign In', 'kapee' ) );
$orders  					= get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
$account_page_id 			= get_option( 'woocommerce_myaccount_page_id' );
$account_page_url 			= !empty( $account_page_id ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '#';
if ( !empty( $account_page_id ) && substr( $account_page_url, - 1, 1 ) != '/' ) {
	$account_page_url .= '/';
}
$orders_url   				= $account_page_url . $orders;
$dashboard_url				= apply_filters( 'kapee_header_myaccount_dashboard_url', $account_page_url );
$myaccount_menu 			= kapee_get_myaccount_menu();
$myaccount_style			= kapee_get_option( 'header-myaccount-style', 1 );
?>			

<div class="header-myaccount myaccount-style-<?php echo esc_attr($myaccount_style); ?>">
	
	<?php 	
	ob_start();
	switch ( $myaccount_style ) {
		case 1:?>
			<div class="myaccount-wrap">
				<small><?php esc_html_e('Hello,', 'kapee');?></small>
				<span><?php echo ( ! is_user_logged_in() ) ? esc_html($signinupText) : esc_html($current_user);?></span>
			</div><?php
			break;
		default:
	}
	$cart_html = ob_get_clean();?>
	
	<?php if( $user_logged_in ):
		$myaccount_class = is_user_logged_in() ? 'user-myaccount' : 'customer-signinup' ;?>
		<a class="<?php echo esc_attr($myaccount_class);?>" href="<?php echo esc_url($dashboard_url);?>"><?php echo wp_kses_post($cart_html); ?></a>
		<?php if( has_nav_menu( $myaccount_menu_location ) ):
			wp_nav_menu( array( 
				'theme_location' 	=> $myaccount_menu_location,
				'menu_class'      	=> 'myaccount-items kapee-arrow',
				'container'   		=> false,
				'fallback_cb' 		=> '',
				'walker' 			=> new Kapee_Menu_Walker()
			) );?>
		<?php else:?>
			<ul class="myaccount-items kapee-arrow">
				<?php 
				foreach( $myaccount_menu as $menu_item ){
					$class = ( isset( $menu_item['class'] ) && !empty( $menu_item['class'] ) ) ? $menu_item['class'] : '';?>
					<li>
						<a class="<?php echo esc_attr($class);?>" href="<?php echo esc_url($menu_item['link']);?>">
							<i class="<?php echo esc_attr($menu_item['icon']);?>"></i><?php echo esc_html($menu_item['label']);?>
						</a>
					</li>
					<?php
				}?>
			</ul>
		<?php endif;?>
	<?php else:?>
		<a class="customer-signinup" href="<?php echo esc_url($dashboard_url);?>"><?php echo wp_kses_post($cart_html); ?></a>
	<?php endif;?>
</div>