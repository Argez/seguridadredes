<?php
/**
 * Template part for displaying categories menu
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

if( ! kapee_get_option( 'categories-menu', 1 ) ) return;

$class = ( kapee_is_open_categories_menu() ) ? ' opened-categories' : '';

if ( has_nav_menu( 'categories-menu' ) ) { ?>		
	<div class="categories-menu-wrapper<?php echo esc_attr( $class );?>">
		<div class="categories-menu-title">
			<span class="title"><?php echo esc_html( kapee_get_option( 'shop-by-categories-title', 'Shop By Categories' ) );?></span>
			<span class="arrow-down-up"></span>
		</div>
		<?php wp_nav_menu( 
			array( 
				'theme_location' 	=> 'categories-menu',
				'container_class'   => 'categories-menu kapee-navigation',
				'walker' 			=> new Kapee_Mega_Menu_Walker()
			)
		);?>
	</div>	
<?php } ?>