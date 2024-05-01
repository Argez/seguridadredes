<?php
/**
 * Template for displaying search forms in Kapee
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */

?>

<?php $unique_id = esc_attr( kapee_uniqid('search-form-') ); ?>
<div class="kapee-mini-ajax-search kapee-arrow">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php esc_attr_e('Search &hellip;','kapee');?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
		<button type="submit" class="search-submit"><?php esc_html_e('Search','kapee');?></button>
	</form>
	<div class="search-results-wrapper woocommerce"></div>
</div>
