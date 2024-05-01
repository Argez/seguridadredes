<?php
/**
 * Template part for displaying customer support
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
}?>			

<?php if( ! empty( kapee_get_option( 'header-phone-number', '(+123) 4567 890' ) )  || ! empty( kapee_get_option( 'header-email','sales@example.com' ) ) ){ ?>
	<div class="customer-support">
		<div class="customer-support-wrap">
			<?php if( ! empty( kapee_get_option( 'header-phone-number', '(+123) 4567 890' ) ) ){ ?>
				<span class="contact-phone"><strong><?php esc_html_e('Support: ', 'kapee');?></strong><?php echo esc_html( kapee_get_option( 'header-phone-number', '(+123) 4567 890' ) );?></span>
			<?php } ?>
			<?php if( ! empty( kapee_get_option( 'header-email','sales@example.com' ) ) ){ ?>
				<span class="contact-email"><strong><?php esc_html_e('Email: ', 'kapee');?></strong><?php echo esc_html( kapee_get_option( 'header-email','sales@example.com' ) );?></span>
			<?php } ?>
		</div>
	</div>
<?php } ?>
