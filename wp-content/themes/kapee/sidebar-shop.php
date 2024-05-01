<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */

$layout = kapee_get_layout();
if($layout == 'full-width'){
	return;
}
$sidebar_name = kapee_get_sidebar_name();

if ( ! is_active_sidebar( $sidebar_name ) ) {
	return;
}
?>

<div id="secondary" <?php kapee_sidebar_class();?>>
	<div class="sidebar-inner">
		<?php dynamic_sidebar( $sidebar_name ); ?>
	</div>
</div><!-- #secondary -->
