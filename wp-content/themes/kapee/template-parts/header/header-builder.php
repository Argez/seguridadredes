<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/header
 * @since 1.0
 * @version 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$header =array();
$header['header_topbar']['left']		= kapee_get_responsive_class( kapee_get_option( 'header-topbar-left', '5' ) );
$header['header_topbar']['right']		= kapee_get_responsive_class( kapee_get_option( 'header-topbar-right', '7' ) );
$header['header_main']['left']			= kapee_get_responsive_class( kapee_get_option( 'header-main-left', '3' ) );
$header['header_main']['center']		= kapee_get_responsive_class( kapee_get_option( 'header-main-center', '6' ) );
$header['header_main']['right']			= kapee_get_responsive_class( kapee_get_option( 'header-main-right', '3' ) );
$header['header_navigation']['left']	= kapee_get_responsive_class( kapee_get_option( 'header-navigation-left', '3' ) );
$header['header_navigation']['center']	= kapee_get_responsive_class( kapee_get_option( 'header-navigation-center', '9' ) );
$header['header_navigation']['right']	= kapee_get_responsive_class( kapee_get_option( 'header-navigation-right', '3' ) );
$header['header_sticky']['left']		= kapee_get_responsive_class( kapee_get_option( 'header-sticky-left', '3' ) );
$header['header_sticky']['center']		= kapee_get_responsive_class( kapee_get_option( 'header-sticky-center', '6' ) );
$header['header_sticky']['right']		= kapee_get_responsive_class( kapee_get_option( 'header-sticky-right', '3' ) );
$header['header_mobile']['left']		= kapee_get_option( 'header-mobile-left', '3' );
$header['header_mobile']['center']		= kapee_get_option( 'header-mobile-center', '9' );
$header['header_mobile']['right']		= kapee_get_option( 'header-mobile-right', '3' );
$header['header_mobile_sticky']['left']		= kapee_get_option( 'header-mobile-sticky-left', '3' );
$header['header_mobile_sticky']['center'] 	= kapee_get_option( 'header-mobile-sticky-center', '6' );
$header['header_mobile_sticky']['right']	= kapee_get_option( 'header-mobile-sticky-right', '3' );
?>
<?php if ( $header_top ) : ?>
	<div class="header-topbar">
		<div class="container">
			<div class="row">
				<?php 
				if( !empty( $header['header_topbar'] ) ){
					foreach( $header['header_topbar'] as $position => $header_class ){
						if( empty( $header_class ) ) continue; ?>
						<div class="header-col header-col-<?php echo esc_attr($position);?> <?php echo esc_attr($header_class);?>">
							<?php do_action( 'kapee_header_topbar_'.$position );?>
						</div>
					<?php }
				} ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="header-main">
	<div class="container">
		<div class="row">
			<?php 
			if( !empty( $header['header_main'] ) ){
				foreach( $header['header_main'] as $position => $header_class ){					
					if( empty( $header_class ) ) continue; 					
					$alignment_class = '';
					if($position == 'center' && kapee_get_option('header-main-align', 0 ) ) {
						$alignment_class = ' justify-content-center';
					}?>
					<div class="header-col header-col-<?php echo esc_attr($position);?> <?php echo esc_attr($header_class);?><?php echo esc_attr($alignment_class);?>">
						<?php do_action( 'kapee_header_main_'.$position );?>
					</div>
				<?php }
			} 
			if( !empty( $header['header_mobile'] ) ){
				foreach( $header['header_mobile'] as $position => $header_class ){					
					if( empty( $header_class ) ) continue; 					
					$alignment_class = '';
					if($position == 'center' && kapee_get_option('header-mobile-align', 1 ) ) {
						$alignment_class = ' justify-content-center';
					}?>
					<div class="header-col header-col-<?php echo esc_attr($position);?> col-<?php echo esc_attr($header_class);?><?php echo esc_attr($alignment_class);?> d-flex d-lg-none d-xl-none">
						<?php do_action( 'kapee_header_mobile_'.$position );?>
					</div>
				<?php }
			}			
			?>
		</div>
	</div>
</div>
<?php
if( kapee_get_option( 'header-navigation', 1 ) || kapee_get_option( 'header-mobile-search', 1 ) ):
	$nav_classes	='';
	if( ! kapee_get_option( 'header-navigation', 1 ) && kapee_get_option( 'header-mobile-search', 1 ) ) {
		$nav_classes	= ' d-flex d-lg-none d-xl-none';
	}elseif( kapee_get_option( 'header-navigation', 1 ) && ! kapee_get_option( 'header-mobile-search', 1 ) ){
		$nav_classes	= ' d-none d-lg-flex d-xl-flex';
	}?>
	<div class="header-navigation<?php echo esc_attr($nav_classes)?>">
		<div class="container">
			<div class="row">
				<?php 
				if( !empty( $header['header_navigation'] ) ){
					foreach( $header['header_navigation'] as $position => $header_class ){						
						if( empty( $header_class ) ) continue;						
						$alignment_class = '';
						if($position == 'center' && kapee_get_option('header-navigation-align', 0 ) ) {
							$alignment_class = ' justify-content-center';
						}?>
						<div class="header-col header-col-<?php echo esc_attr($position);?><?php echo esc_attr($alignment_class);?> <?php echo esc_attr($header_class);?>">
							<?php do_action( 'kapee_header_navigation_'.$position );?>
						</div>
					<?php }
				} ?>
				<?php if( kapee_get_option( 'header-mobile-search', 1 ) ){ ?>
					<div class="header-col header-col-center col-12 d-flex d-lg-none d-xl-none">
						<?php kapee_get_template( 'template-parts/header/elements/ajax-search' );?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php endif;?>

<?php if ( $sticky_header || $sticky_header_table || $sticky_header_mobile ) : ?>
<div class="header-sticky">
	<div class="container">
		<div class="row">
			<?php if ( $sticky_header ) :
				if( !empty( $header['header_sticky'] ) ){
					foreach( $header['header_sticky'] as $position => $header_class ){					
						if( empty( $header_class ) ) continue; 					
						$alignment_class = '';
						if($position == 'center' && kapee_get_option('header-sticky-align', 0 ) ) {
							$alignment_class = ' justify-content-center';
						}?>
						<div class="header-col header-col-<?php echo esc_attr($position);?> <?php echo esc_attr($header_class);?><?php echo esc_attr($alignment_class);?>">
							<?php do_action( 'kapee_header_sticky_'.$position );?>
						</div>
					<?php }
				} 
			endif;
			
			if ( $sticky_header_table || $sticky_header_mobile ) :
				if( !empty( $header['header_mobile_sticky'] ) ){
					foreach( $header['header_mobile_sticky'] as $position => $header_class ){
						if( empty( $header_class ) ) continue; 					
						$alignment_class = '';
						if($position == 'center' && kapee_get_option('header-mobile-sticky-align', 1 ) ) {
							$alignment_class = ' justify-content-center';
						}?>
						<div class="header-col header-col-<?php echo esc_attr($position);?> col-<?php echo esc_attr($header_class);?><?php echo esc_attr($alignment_class);?> d-flex d-lg-none d-xl-none">
							<?php do_action( 'kapee_header_mobile_sticky_'.$position );?>
						</div>
					<?php }
				} 
			endif;?>
		</div>
	</div>
</div>
<?php endif; ?>