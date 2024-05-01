<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="kapee-login-signup" id="customer_login">
	<div class="customer-login active">
		<div class="customer-login-left">
			<h2><?php esc_html_e( 'Login', 'kapee' ); ?></h2>			
			<p><?php $content = kapee_get_option('login-information', 'Get access to your Orders, Wishlist and Recommendations.');
			echo do_shortcode($content);?></p>
			
			<?php do_action( 'kapee_before_login_form' ); ?>
			
		</div>		
		<div class="customer-login-right">
			<form class="woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url( $account_link );?>">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">					
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e( 'Enter Username/Email address', 'kapee' ); ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">					
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" placeholder="<?php esc_attr_e( 'Enter Password', 'kapee' ); ?>" autocomplete="current-password" />
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row woocommerce-rememberme-lost_password">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'kapee' ); ?></span>
					</label>
					<a class="woocommerce-LostPassword" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'kapee' ); ?></a>
				</p>
				
				<p class="woocommerce-login-button">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'kapee' ); ?>"><?php esc_html_e( 'Log in', 'kapee' ); ?></button>			
				</p>
				<?php do_action( 'woocommerce_login_form_end' ); ?>
				<?php
				
				if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<p class="woocommerce-new-signup">
					<?php 
					$site_title = get_bloginfo( 'name' );
					if( KAPEE_DOKAN_ACTIVE && !is_account_page() ){
					$account_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
					echo sprintf( __("<a class='button' href='%s'> New to %s? Sign up </a>", 'kapee'), esc_url($account_page_url) , $site_title);
					} else {
					?>
					<a class="new-signup button" href="#"><?php  echo sprintf( esc_html__(' New to %s? Sign up','kapee'),$site_title );?></a>
					<?php } ?>
				</p>
				<?php endif; ?>
				

			</form>
		</div>
	</div>
	
	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
		<div class="customer-signup">
			<div class="customer-signup-left">
				<h2><?php esc_html_e( 'Signup', 'kapee' ); ?></h2>				
				
				<?php do_action( 'kapee_before_signup_form' ); ?>
				
			</div>			
			<div class="customer-signup-right">
				<form method="post" class="woocommerce-form woocommerce-form-register register" action="<?php echo esc_url( $account_link );?>" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" placeholder="<?php esc_attr_e( 'Enter Username', 'kapee' ); ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php esc_attr_e( 'Enter Email address', 'kapee' ); ?>" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Enter Password', 'kapee' ); ?>" />
						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'kapee' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'kapee' ); ?>"><?php esc_html_e( 'Register', 'kapee' ); ?></button>
					</p>
					<?php do_action( 'woocommerce_register_form_end' ); ?>
					<p class="woocommerce-new-signup">
						<a class="user-signin button" href="#"><?php esc_html_e( 'Existing User? Log in', 'kapee' ); ?></a>
					</p>

					

				</form>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>