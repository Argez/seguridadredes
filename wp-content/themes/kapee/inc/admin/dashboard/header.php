<?php
/**
 * Kapee Dashboard
 *
 * Handles the about us page HTML
 *
 * @package Kapee
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$kapee_tabs = apply_filters('kapee_dashboard_tabs', array(
					'kapee-theme' 			=> esc_html__("Dashboard", 'kapee'),
					'kapee-system-status' 	=> esc_html__("System Status", 'kapee'),
					'kapee-theme-option' 	=> esc_html__("Theme Options", 'kapee'),
				));
$active_tab 	= isset($_GET['page']) ? $_GET['page'] : 'kapee-theme';
?>
<div class="wrap about-wrap kapee-admin-wrap kapee-dashboard-wrap">
	<h1><?php echo esc_html__('Welcome to', 'kapee').' Kapee'; ?></h1>
	<div class="about-text">
		<?php echo sprintf( esc_html__('Thank you for purchasing our premium Kapee theme. Here you are able
            to start creating your awesome web store by importing our dummy content and theme options.', 'kapee')); ?>
	</div>
	<div class="wp-badge kapee-page-logo"><?php echo esc_html__('Version', 'kapee') .' '.KAPEE_VERSION; ?></div>
	<p class="kapee-actions">
		<a href="https://docs.presslayouts.com/kapee/" target="_blank" class="btn-docs button"><?php esc_html_e('Documentation','kapee');?></a>
		<a href="https://1.envato.market/BXBboq" target="_blank" class="btn-docs button"><?php esc_html_e('Support','kapee');?></a>
		<a href="https://themeforest.net/downloads" class="btn-rate button" target="_blank"><?php esc_html_e('Rate our theme','kapee');?></a>
    </p>
	<?php if( !empty( $kapee_tabs ) ) { ?>
		<h2 class="nav-tab-wrapper">
			<?php foreach ($kapee_tabs as $tab_key => $tab_val) { 

				if( empty($tab_key) ) {
					continue;
				}
				if( !defined( 'KAPEE_EXTENSIONS_VERSION' ) && $tab_key == 'kapee-theme-option') {
					continue;
				}
				$active_tab_cls	= ( $active_tab == $tab_key ) ? ' nav-tab-active' : '';
				$tab_link 		= add_query_arg( array( 'page' => $tab_key ), admin_url('admin.php') );
				?>
				<a class="nav-tab<?php echo esc_attr( $active_tab_cls ); ?>" href="<?php echo esc_url( $tab_link ); ?>"><?php echo esc_html( $tab_val ); ?></a>
			<?php } ?>
		</h2>
	<?php } ?>
	<div id="kapee-dashboard" class="kapee-dashboard wp-clearfix">
	