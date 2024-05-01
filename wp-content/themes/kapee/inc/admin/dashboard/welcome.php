<?php
/**
 * Kapee Admin Dashboard Tab
 *
 * @package Kapee
 * @since 1.0
 */
require_once KAPEE_FRAMEWORK.'admin/dashboard/header.php';
global $obj_kp_updatetheme, $wp_filesystem, $wpdb;;
$obj_kp_dash = new Kapee_Dashboard();
if ( isset( $_GET['tgmpa-deactivate'] ) && 'deactivate-plugin' == $_GET['tgmpa-deactivate'] ) {
	$plugins = TGM_Plugin_Activation::$instance->plugins;
	check_admin_referer( 'tgmpa-deactivate', 'tgmpa-deactivate-nonce' );
	foreach ( $plugins as $plugin ) {
		if ( $plugin['slug'] == $_GET['plugin'] ) {
			deactivate_plugins( $plugin['file_path'] );
		}
	}
}
if ( isset( $_GET['tgmpa-activate'] ) && 'activate-plugin' == $_GET['tgmpa-activate'] ) {
	check_admin_referer( 'tgmpa-activate', 'tgmpa-activate-nonce' );
	$plugins = TGM_Plugin_Activation::$instance->plugins;
	foreach ( $plugins as $plugin ) {
		if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {
			activate_plugin( $plugin['file_path'] );
		}
	}
}

$plugins 				= TGM_Plugin_Activation::$instance->plugins;
$tgm_plugins_required 	= 0;
$tgm_plugins_action 	= array();
foreach ( $plugins as $plugin ) {
	$tgm_plugins_action[ $plugin['slug'] ] = $obj_kp_dash->plugin_action( $plugin );
}
$is_theme_active 		= kapee_is_license_activated();
$active_button_txt 		= esc_html__('Activate Theme', 'kapee');
$active_button_class 	= 'kapee-activate-btn';
$input_attr 			= '';
$theme_activate 		= 'theme-deactivated';
$status_txt 			= esc_html__('No Activated', 'kapee');
$purchase_code 			= '';
$readonly 				= 'false';
$status_activate_class 	= ' red';
if( $is_theme_active ){
	$purchase_code 			= kapee_get_purchase_code();
	$active_button_txt 		= esc_html__('Deactivate Theme', 'kapee');
	$active_button_class 	= 'kapee-deactivate-btn';
	$input_attr 			= ' value="'.$purchase_code.'" readonly="true"';
	$readonly				= 'true';
	$theme_activate 		= 'theme-activated';
	$status_txt 			= esc_html__('Activated', 'kapee');
	$status_activate_class 	= ' green';
}
?>
<div class="kapee-content-body">
	<div class="kp-row">
		<div class="kp-col-12">
			<div class="kapee-box theme-activate <?php echo esc_attr($theme_activate);?>">
				<div class="kapee-box-header">
					<div class="title"> <?php esc_html_e('Purchase Code', 'kapee')?></div>
					<div class="kapee-button<?php echo esc_attr($status_activate_class);?>"> <?php echo esc_html( $status_txt );?></div>
				</div>
				<div class="kapee-box-body">
					<form action="" method="post">
						<?php if( $is_theme_active ){ ?>
						<input name="purchase-code" class="purchase-code" type="text" placeholder="<?php esc_attr_e('Purchase code','kapee');?>" value="<?php echo esc_attr($purchase_code); ?>" readonly = "true">
						<?php } else { ?>
						<input name="purchase-code" class="purchase-code" type="text" placeholder="<?php esc_attr_e('Purchase code','kapee');?>">
						<?php } ?>
						<button type="button"  id="kapee-activate-theme"  class="button action <?php echo esc_attr($active_button_class);?>"><?php echo esc_html( $active_button_txt );?></button>
						
					</form>
					<div class="purchase-desc">
						<?php echo wp_kses ( sprintf( __( 'You can learn how to find your purchase key <a href="%s" target="_blank"> here </a>', 'kapee' ),'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code' ), kapee_allowed_html( 'a' ) );?>
					</div>
				</div>
			</div>
		</div>
	</div>		
	<div class="kp-row">
		<div class="kp-col-md-6">
			<div class="kapee-box docs">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Documentation','kapee');?></div>
				</div>
				<div class="kapee-box-body">	
					<p><?php esc_html_e('Our documentation is simple and functional wit full details and cover all essential aspects from beginning to the most advanced parts.','kapee');?> </p>
					<div class="s-button">
						<a class="button" href="https://docs.presslayouts.com/kapee" target="_blank"><?php esc_html_e('Documentation','kapee');?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="kp-col-md-6">
			<div class="kapee-box support">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Support','kapee');?></div>
				</div>
				<div class="kapee-box-body">	
					<p><?php esc_html_e('Kapee theme comes with 6 months of free support for every license you purchase. Support can be extended through subscriptions via ThemeForest.','kapee');?> </p>
					<div class="s-button">
						<a class="button" href="https://1.envato.market/BXBboq" target="_blank"><?php esc_html_e('Send Request','kapee');?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="kp-row">
		<div class="kp-col-12">
			<div class="kapee-box system-requirements">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('System Requirements','kapee');?></div>
				</div>
				<div class="kapee-box-body">
					<table class="widefat" cellspacing="0">
						<tbody>
							<?php if( function_exists( 'kapee_get_server_info' ) ) { ?>
							<tr>
								<td data-export-label="Server Info"><?php esc_html_e( 'Server Info:', 'kapee' ); ?></td>
								<td><?php echo esc_html( kapee_get_server_info() ); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td data-export-label="PHP Version"><?php esc_html_e( 'PHP Version:', 'kapee' ); ?></td>
								<td>
									<?php 
									if ( function_exists( 'phpversion' ) ) { 
										$php_version = phpversion();
										if( version_compare(phpversion(), '5.6', '<') ){ 
										echo esc_html__('Currently:','kapee').' '. phpversion().' ';  
										esc_html_e('(min: 5.6)','kapee') ?> 
										<label class="hero button" for="php-version"> <?php esc_html_e('Please contact Host provider to fix it.','kapee') ?> </label>
									<?php } else { 
										echo esc_html__('Currently:','kapee').' '. phpversion() ?> </span>
									<?php }
									}else{
										echo  esc_html__('Couldn\'t determine PHP version because phpversion() doesn\'t exist.','kapee');
									}
									?>
								</td>
							</tr>
							<tr>
								<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP Post Max Size:', 'kapee' ); ?></td>
								<td><?php echo size_format( wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) ) ); ?></td>
							</tr>
							<tr>
								<td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP Time Limit:', 'kapee' ); ?></td>
								<td>
									<?php
									$time_limit = ini_get('max_execution_time');

									if ( $time_limit < 180 && $time_limit != 0 ) {
										echo '<mark class="error">' . wp_kses(sprintf( __( '%1$s - We recommend setting max execution time to at least 600. <br /> To import demo content, <strong>600</strong> seconds of max execution time is required.<br />See: <a href="%2$s" target="_blank">Increasing max execution to PHP</a>', 'kapee' ), $time_limit, 'https://wordpress.org/support/article/common-wordpress-errors/#php-errors' ), array( 'strong' => array(), 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ) . '</mark>';
									} else {
										echo  esc_html( $time_limit );
										if ( $time_limit < 600 && $time_limit != 0 ) {
											echo '<br /><mark class="error">' . wp_kses(__( 'Current time limit is sufficient, but if you need import demo content, the required time is <strong>600</strong>.', 'kapee' ), array( 'strong' => array(),  ) ) . '</mark>';
										}
									}
									?>
								</td>
							</tr>
							<tr>
								<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP Max Input Vars:', 'kapee' ); ?></td>
								<td>
									<?php 
									$registered_navs = get_nav_menu_locations();
									$menu_items_count = array( '0' => '0' );
									foreach ( $registered_navs as $handle => $registered_nav ) {
										$menu = wp_get_nav_menu_object( $registered_nav );
										if ( $menu ) {
											$menu_items_count[] = $menu->count;
										}
									}

									$max_items = max( $menu_items_count );
									$required_input_vars = $max_items * 20;
									$max_input_vars = ini_get( 'max_input_vars' );
									$required_input_vars = $required_input_vars + ( 500 + 1000 );
									echo esc_html( $max_input_vars );
									?>
								</td>
							</tr>
							 <tr>
								<td data-export-label="ZipArchive"><?php esc_html_e( 'ZipArchive:', 'kapee' ); ?></td>
								<td><?php echo class_exists( 'ZipArchive' ) ? '<span class="yes">&#10004;</span>' : '<span class="error">No.</span>'; ?></td>
							</tr>
							<tr>
								<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max Upload Size:', 'kapee' ); ?></td>
								<td><?php echo size_format( wp_max_upload_size() ); ?></td>
							</tr>
							<tr>
								<td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL Version:', 'kapee' ); ?></td>
								<td><?php echo esc_html( $wpdb->db_version() ); ?></td>
							</tr>
							<tr>
								<td data-export-label="GD Library"><?php esc_html_e( 'GD Library:', 'kapee' ); ?></td>
								<td>
									<?php
									$info = esc_attr__( 'Not Installed', 'kapee' );
									if ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
										$info = esc_attr__( 'Installed', 'kapee' );
										$gd_info = gd_info();
										if ( isset( $gd_info['GD Version'] ) ) {
											$info = $gd_info['GD Version'];
										}
									}
									echo esc_html( $info );
									?>
								</td>
							</tr>
							<tr>
								<td data-export-label="cURL"><?php esc_html_e( 'cURL:', 'kapee' ); ?></td>
								<td>
									<?php
									$info = esc_attr__( 'Not Enabled', 'kapee' );
									if ( function_exists( 'curl_version' ) ) {
										$curl_info = curl_version();
										$info = $curl_info['version'];
									}
									echo esc_html( $info );
									?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>		
	</div>
	<div class="kp-row">
		<div class="kp-col-12">
			<div class="kapee-box install-plugin ">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Installation Required Plugins','kapee');?></div>
				</div>
				<div class="kapee-box-body">
					<table class="widefat">
						<thead>
							<tr>
								<th> <?php esc_html_e('Plugin', 'kapee');?> </th>
								<th> <?php esc_html_e('Version','kapee');?> </th>
								<th> <?php esc_html_e('Type', 'kapee');?> </th>
								<th> <?php esc_html_e('Action', 'kapee');?> </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $plugins as $tgm_plugin ) { ?>
								<tr>
									<td>
										<?php
										//$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
										if ( isset( $tgm_plugin['required'] ) && ( $tgm_plugin['required'] == true ) ) {
											if ( ! kapee_tgmpa_is_plugin_check_active( $tgm_plugin['slug'] ) ){
												echo '<span>' . $tgm_plugin['name'] . '</span>';
												$tgm_plugins_required ++;
											} else {
												echo '<span class="actived">' . $tgm_plugin['name'] . '</span>';
											}
										} else {
											echo esc_html( $tgm_plugin['name'] );
										}?>
									</td>
									<td><?php echo( isset( $tgm_plugin['version'] ) ? $tgm_plugin['version'] : '' ); ?></td>
									<td><?php echo( isset( $tgm_plugin['required'] ) && ( $tgm_plugin['required'] == true ) ? 'Required' : 'Recommended' ); ?></td>
									<td>
										<?php echo wp_kses_post( $tgm_plugins_action[ $tgm_plugin['slug'] ] ); ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
require_once KAPEE_FRAMEWORK.'admin/dashboard/footer.php';