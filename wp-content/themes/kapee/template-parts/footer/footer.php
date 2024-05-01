<?php
/**
 * Template part for displaying footer default layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/footer
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<footer id="footer" class="site-footer">	
	
	<?php do_action( 'kapee_footer_top' ); ?>
	
	<?php if( $site_footer ) { ?>
		<div class="footer-main footer-layout-<?php echo esc_attr( kapee_get_option( 'footer-layout', '2' ) );?>">
			<div class="container">
				<?php if( ! empty( $footer_layout_data ) ){ ?>
					<div class="row">
						<?php
						$collapse_class = kapee_get_option( 'footer-widget-collapse', 0 ) ? ' footer-widget-collapse' : '';
						foreach($footer_layout_data['class'] as $key => $classes){
							$count = $key + 1;
							?>
							<div class="footer-widget<?php echo esc_attr( $collapse_class ); ?> <?php echo esc_attr( $classes ); ?>">
								<?php dynamic_sidebar( 'footer-area-' . $count ); ?>
							</div>
							<?php
						} ?>
					</div>
				<?php } ?>
			</div><!-- .container -->	
		</div><!-- .footer-main -->
	<?php }?>
		
	<?php if( $footer_copyright ){ ?>
		<div class="footer-copyright copyright-<?php echo esc_attr( kapee_get_option( 'copyright-layout', 'columns' ) );?>">
			<div class="container">	
				<div class="row copyright-wrap">
					<div class="text-left reset-mb-10 col-12 col-md-6">
						<?php 
						$copyright_text = kapee_get_option('copyright-text','Kapee &copy; {current_year} by <a href="https://presslayouts.com/" target="_blank">PressLayouts</a> All Rights Reserved.');
						$current_year = date("Y"); 
						$copyright_text = str_replace( '{current_year}', $current_year, $copyright_text );
						echo wp_kses_post( $copyright_text ); ?>
					</div>
					<?php if(kapee_get_option( 'payment-logo', 0 ) ){ ?>
						<div class="text-right col-12 col-md-6">						
							<?php $payments_url = kapee_get_option( 'payment-logo-img', array( 'url' => KAPEE_IMAGES.'payments-method.png') );?>
							<img src="<?php echo esc_url( $payments_url['url'] );?>" alt="<?php echo esc_attr__('Payment logo','kapee');?>">
						</div>
					<?php }?>
				</div>
			</div>
		</div><!-- .footer-copyright -->
	<?php }?>
	
	<?php do_action( 'kapee_footer_bottom' ); ?>
	
</footer><!-- .site-footer -->