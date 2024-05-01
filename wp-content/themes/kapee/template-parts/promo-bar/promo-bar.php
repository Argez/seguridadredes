<?php
/**
 * Template part for displaying promo bar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/promo-bar
 * @since 1.4.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="kapee-promo-bar position-<?php echo esc_attr( $promo_position );?> position-type-<?php echo esc_attr( $promo_position_type );?>" data-position_type="<?php echo esc_attr( $promo_position_type );?>" data-position="<?php echo esc_attr( $promo_position );?>">
	<div class="container">
		<div class="promo-bar-wrapper">
			<?php if( !empty( trim( $promo_message ) ) ) { ?>
				<div class="promo-bar-msg">
					<?php echo do_shortcode( $promo_message );?>
				</div>
			<?php }
			if( $promo_link_btn && ! empty( trim( $promo_link_text ) ) ) { ?>
				<div class="promo-bar-button">
					<a href="<?php echo esc_url( $promo_link_url );?>" target="<?php echo esc_attr( $target );?>" class="button"> <?php echo esc_html($promo_link_text); ?> </a>
				</div>
			<?php }
			if( $promo_close_btn ){ ?>
				<a href="#" class="promo-bar-close <?php echo esc_attr( $promo_dismiss_class );?>"></a>
			<?php } ?> 
		</div>
	</div>
</div>