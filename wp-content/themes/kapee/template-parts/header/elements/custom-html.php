<?php
/**
 * Template part for displaying header logo
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package /template-parts/header
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
		
if( !isset( $custom_html ) ){
	return;
}
$custom_html = kapee_get_option( $custom_html, '' );
?>
<div class="kapee-header-custom-html">
	<?php
		echo do_shortcode($custom_html);
	?>
</div>
<?php