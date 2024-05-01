<?php
/**
 * Checkout Form, for multi-step checkout
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$enable_login_reminder  = 'yes' == get_option( 'woocommerce_enable_checkout_login_reminder', 'yes' );
$enable_signup_and_login  = 'yes' == get_option( 'woocommerce_enable_signup_and_login_from_checkout', 'yes' );
$is_logged_in           = is_user_logged_in();
$show_login_step        = ! $is_logged_in && $enable_login_reminder;
$login_message          = apply_filters( 'kapee_form_checkout_login_message', esc_html__( 'If you have already registered, please, enter your details in the boxes below. If you are a new customer, please, go to the Billing &amp; Shipping section.', 'kapee' ) );

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout ); 
$step = 1;
?>

<div id="multi-step-checkout" class="multi-step-checkout">
    <div id="checkout_coupon" class="woocommerce_checkout_coupon">
        <?php do_action( 'kapee_woocommerce_checkout_coupon', $checkout ); ?>
    </div>

    <?php if ( $enable_login_reminder ) { ?>
        <div id="checkout_login" data-step="<?php echo esc_attr($step);?>" data-steptitle="login" class="panel panel-default <?php echo esc_attr($step == 1) ? 'active':''?> <?php echo esc_attr($step > 1) ? 'hidden':''?> woocommerce_checkout_login">
			<div class="panel-heading">
				<h4 class="panel-title">					
					<span class="step-numner"><?php echo esc_html( $step ); ?></span>
					<span class="title"><?php esc_html_e('Login','kapee');?></span>
				</h4>
				<span class="edit-action" data-step="<?php echo esc_attr($step);?>"><?php esc_html_e('Change','kapee');?></span>
			</div>
			<div id="kapee-login" class="panel-collapse collapse <?php echo esc_attr($step == 1) ? 'show':''?>">
				<div class="panel-body">
				   <div class="checkout_login <?php echo esc_attr( $is_logged_in ) ? 'logged-in' : 'not-logged-in';?>">
						<?php if($is_logged_in) {
							$current_user = wp_get_current_user();
							$redirect = get_permalink();
							?>
							<div class="logged-in-user-info">
								<div class="user-info">
									<span><?php esc_html_e('Name','kapee');?></span>
									<span class="user-name"><?php echo esc_html( $current_user->display_name );?></span>
								</div>
								<div class="user-info">
									<span><?php esc_html_e('Email','kapee');?></span>
									<span class="user-email"><?php echo esc_html( $current_user->user_email );?></span>
								</div>
							</div>
							<div class="checkout-next-step" data-next="<?php echo esc_attr('step-').($step+1);?>">
								<a class="btn" href="javscript:void(0);"> <?php echo esc_html_e('Continue','kapee');?></a>
							</div>
						<?php } else { ?>
							<?php do_action( 'kapee_checkout_login_form', $login_message );
							if( $enable_signup_and_login ){ ?>
							<div class="btn checkout-next-step" data-next="<?php echo esc_attr('step-').($step+1 );?>"><?php esc_html_e('I don\'t have an account.', 'kapee');?></div>
						<?php }
						} ?>
					</div>
				</div>
			</div>
        </div>
    <?php $step++;
	} ?>

    <?php
    // If checkout registration is disabled and not logged in, the user cannot checkout
    if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
        echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in before proceeding to checkout.', 'kapee' ) );
        return;
    } ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <?php if ( sizeof( $checkout->checkout_fields ) > 0 ) { ?>

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<div id="step-<?php echo esc_attr($step);?>" class="panel panel-default <?php echo esc_attr($step == 1) ? 'active':''?> <?php echo esc_attr($step > 1) ? 'hidden':''?>" data-step="<?php echo esc_attr($step);?>" data-steptitle="billing">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="step-numner"><?php echo esc_html( $step ); ?></span>
						<span class="title"><?php esc_html_e('Billing Address','kapee');?></span>						
					</h4>
					<span class="edit-action" data-step="<?php echo esc_attr($step);?>"><?php esc_html_e('Change', 'kapee');?></span>
				</div>
				<div id="kapee-billing" class="panel-collapse collapse <?php echo esc_attr($step == 1) ? 'show':''?>">
					<div class="panel-body">
					   <div class="checkout_billing <?php echo esc_attr( $is_logged_in ) ? 'logged-in' : 'not-logged-in'; echo esc_attr($enable_login_reminder ) ? ' show-login-reminder' : ' hide-login-reminder'; ?>" id="customer_billing_details">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					  <div class="btn checkout-next-step" data-next="<?php echo esc_attr('step-').($step+1);?>"><?php echo esc_html_e('Continue','kapee');?></div>
					</div>
				</div>
				<?php $step++;?>
			</div>
            <div id="step-<?php echo esc_attr($step);?>" class="panel panel-default <?php echo esc_attr($step == 1) ? 'active':''?> <?php echo esc_attr($step > 1) ? 'hidden':''?>" data-step="<?php echo esc_attr($step);?>" data-steptitle="shipping">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="step-numner"><?php echo esc_html( $step ); ?></span>
						<span class="title"><?php esc_html_e('Shipping Address','kapee');?></span>
					</h4>
					<span class="edit-action" data-step="<?php echo esc_attr($step);?>"><?php esc_html_e('Change', 'kapee');?></span>
				</div>
				<div id="kapee-shipping" class="panel-collapse collapse <?php echo esc_attr($step == 1) ? 'show':''?>">
					<div class="panel-body">
						<div class="checkout_shipping" id="customer_shipping_details">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					  <div class="btn checkout-next-step" data-next="<?php echo esc_attr('step-').($step+1);?>"><?php echo esc_html_e('Continue','kapee');?></div>
					</div>
				</div>
				<?php $step++;?>
			</div>
			
            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        <?php } ?>
		
		<div id="step-<?php echo esc_attr($step);?>" class="panel panel-default <?php echo esc_attr($step == 1) ? 'active':''?> <?php echo esc_attr($step > 1) ? 'hidden':''?>" data-step="<?php echo esc_attr($step);?>" data-steptitle="payment">
			<div class="panel-heading">
				<h4 class="panel-title">
					<span class="step-numner"><?php echo esc_html( $step ); ?></span>
					<span class="title"><?php esc_html_e('Payment Options','kapee');?></span>
				</h4>
				<span class="edit-action pull-right" data-step="<?php echo esc_attr($step);?>"><?php esc_html_e('Change', 'kapee');?></span>
			</div>
            <div id="kapee-payment" class="panel-collapse collapse <?php echo esc_attr($step == 1) ? 'show':''?>">
                <div class="panel-body">
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                   <div id="order_review" class="woocommerce-checkout-review-order">
						<div id="order_info" class="woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
							<?php do_action( 'kapee_woocommerce_checkout_order_review' ); ?>
						</div>

						<div id="order_checkout_payment" class="owp-woocommerce-checkout-payment">
							<?php do_action( 'kapee_woocommerce_checkout_payment' ); ?>
						</div>
					</div>
                  <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>