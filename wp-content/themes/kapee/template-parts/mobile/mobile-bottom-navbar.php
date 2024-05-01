<?php
/**
 * Template part for displaying mobile footer navbar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/footer
 * @since 1.1.6
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="kapee-mobile-navbar<?php echo esc_attr( $navbar_class );?>">
	<?php 
	foreach( $elements as $element => $menu_item ){
		if( empty( $menu_item ) ){
			continue;
		}
		$class = ( isset( $menu_item['class'] ) && !empty( $menu_item['class'] ) ) ? $menu_item['class'] : '';?>
		<div class="mobile-element mobile-element-<?php echo esc_attr( $element ); ?>">
			<a href="<?php echo esc_url( $menu_item['link'] );?>" class="<?php echo esc_attr($class); ?>">
				<span class="navbar-icon <?php echo esc_attr( $menu_item['icon'] );?>">
					<?php if( isset( $menu_item['count'] ) ){ ?>
						<span class="header-<?php echo esc_attr($element);?>-count"><?php echo esc_html($menu_item['count']);?></span>
					<?php } ?>
				</span>
				<span class="navbar-label"><?php echo esc_html( $menu_item['label'] );?></span>
			</a>
		</div>
	<?php } ?>	
</div>