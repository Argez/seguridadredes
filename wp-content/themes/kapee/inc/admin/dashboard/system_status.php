<?php
/**
 * Kapee System Status Tab
 *
 * @package Kapee
 * @since 1.0
 */
require_once KAPEE_FRAMEWORK.'admin/dashboard/header.php';

global $wp_filesystem,$wpdb;
$obj_kp_dash 		= new Kapee_Dashboard();
$mark_yes 			= '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
$mark_no 			= '<mark class="no"><span class="dashicons dashicons-no-alt"></span></mark>';
$active_plugins 	= (array) get_option( 'active_plugins', array() );

if ( is_multisite() ) {
	$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
}?>

<div class="notice-success kapee-dashboard-notice">
    <p class="status-info">
		<span><?php esc_html_e( 'Please copy and paste this information in your ticket when contacting support:', 'kapee' ); ?></span>
		<a href="#" class="button debug-report"><?php esc_html_e('Get System Report','kapee');?></a>
	</p>
    <div id="kapee-debug-report">
        <textarea readonly="readonly"></textarea>
        <p class="copy-error"><?php esc_html_e( 'Please press Ctrl/Cmd+C to copy.', 'kapee' ); ?></p>
    </div>
</div>
<div id="kapee-system-status" class="kapee-content-body">
	<div class="kp-row">
		<div class="kp-col-md-6">
			<div class="kapee-box">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Theme Information','kapee');?></div>
				</div>
				<div class="kapee-box-body no-padding">	
					<table class="widefat" cellspacing="0">
						<tbody>
						<tr>
							<td data-export-label="Theme Name"><?php esc_html_e( 'Theme Name:', 'kapee' ); ?></td>
							<td><?php echo KAPEE_THEME_NAME; ?></td>
						</tr>
						<tr>
							<td data-export-label="Current Version"><?php esc_html_e( 'Current Version:', 'kapee' ); ?></td>
							<td><?php echo KAPEE_VERSION; ?></td>
						</tr>
						<tr>
							<td data-export-label="Installation Path"><?php esc_html_e( 'Installation Path:', 'kapee' ); ?></td>
							<td><code><?php echo esc_html( $obj_kp_dash->get_installation_path() ); ?></code></td>
						</tr>
						<tr>
							<td data-export-label="Child Theme"><?php esc_html_e( 'Child Theme:', 'kapee' ); ?></td>
							<td> <?php if(is_child_theme()) {?> <span class="yes">&#10004;</span> <?php } else echo esc_html__('No', 'kapee'); ?></td>
						</tr>
						 <?php if(is_child_theme()) {?> 
						<tr>
							<td data-export-label="Child Theme Directory"><?php esc_html_e( 'Child Theme Path:', 'kapee' ); ?></td>
							<td> <code><?php echo esc_html( $obj_kp_dash->get_child_theme_path() ); ?></code></td>
						</tr>
						 <?php } ?>
						<tr>
							<td data-export-label="License Activated"><?php esc_html_e( 'License Activated:', 'kapee' ); ?></td>
							<td> <?php if(kapee_is_license_activated()) {?> <span class="yes">&#10004;</span> <?php } else echo esc_html__('No', 'kapee') ?></td>
						</tr>
						<tr>
							<td data-export-label="Kapee Server Available"><?php esc_html_e( 'Kapee Server Available:', 'kapee' ); ?></td>
							<td>
							<?php if($obj_kp_dash->is_kapee_server_available()) {?> <span class="yes">&#10004;</span> <?php } else { echo esc_html__('No', 'kapee'); }?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="kp-col-md-6">
			<div class="kapee-box">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('WordPress Environment','kapee');?></div>
				</div>
				<div class="kapee-box-body no-padding">	
					<table class="widefat" cellspacing="0">
						<tbody>
						<tr>
							<td data-export-label="Home URL"><?php esc_html_e( 'Home URL:', 'kapee' ); ?></td>
							<td><?php echo esc_url( home_url( '/' ) ); ?></td>
						</tr>
						<tr>
							<td data-export-label="Site URL"><?php esc_html_e( 'Site URL:', 'kapee' ); ?></td>
							<td><?php echo site_url(); ?></td>
						</tr>
						<tr>
							<td data-export-label="WordPress Version"><?php esc_html_e( 'WordPress Version:', 'kapee' ); ?></td>
							<td><?php echo bloginfo( 'version' ); ?></td>
						</tr>
						<tr>
							<td data-export-label="WordPress Multisite"><?php esc_html_e( 'WordPress Multisite:', 'kapee' ); ?></td>
							<td><?php echo is_multisite() ? $mark_yes : '-'; ?></td>
						</tr>
						<tr>
							<td data-export-label="WordPress Memory Limit"><?php esc_html_e( 'WordPress Memory Limit:', 'kapee' ); ?></td>
							<td>
								
								<?php
								$memory = $obj_kp_dash->kapee_let_to_num( WP_MEMORY_LIMIT );
								if ( $memory < 128000000 ) {                        
									echo '<mark class="error">' . wp_kses(sprintf( __( '%1$s - We recommend setting memory to at least <strong>256MB</strong>. <br /> Please define memory limit in <strong>wp-config.php</strong> file. To learn how, see: <a href="%2$s" target="_blank">Increasing memory allocated to PHP.</a>', 'kapee' ), size_format( $memory ), 'https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php' ), array( 'strong' => array(), 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ) . '</mark>';
								} else {
									echo esc_html( size_format( $memory ) );
									if ( $memory < 256000000 ) {
										echo '<br /><mark class="error">' . wp_kses( __( 'Your current memory limit is sufficient, but if you installed many plugins or need to import demo content, the required memory limit is <strong>256MB.</strong>', 'kapee' ), array( 'strong' => array(),  ) ) . '</mark>';
									}
								}
								?>
							</td>
						</tr>
						<tr>
							<td data-export-label="WordPress Debug Mode"><?php esc_html_e( 'WordPress Debug Mode:', 'kapee' ); ?></td>
							<td><?php echo ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? $mark_yes : '-'; ?></td>
						</tr>
						<tr>
							<td data-export-label="Language"><?php esc_html_e( 'Language:', 'kapee' ); ?></td>
							<td><?php echo get_locale(); ?></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="kp-col-md-6">
			<div class="kapee-box">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Server Environment','kapee');?></div>
				</div>
				<div class="kapee-box-body no-padding">	
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
							<td><?php echo size_format( wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) ) );	?>	</td>
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
									$max_input_vars = ini_get( 'max_input_vars' );									
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
		<div class="kp-col-md-6">
			<div class="kapee-box">
				<div class="kapee-box-header">
					<div class="title"><?php esc_html_e('Active Plugins','kapee');?>(<?php echo count($active_plugins);?>)</div>
				</div>
				<div class="kapee-box-body no-padding">
					<table class="widefat" cellspacing="0">
						<tbody>
						<?php
							foreach ( $active_plugins as $plugin ) {
								$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin ); // PHPCS:Ignore Generic.PHP.NoSilencedErrors.Forbidden
	
								if ( empty( $plugin_data['Name'] ) ) {
									continue;
								}

								// Link the plugin name to the plugin url if available.
								$plugin_name = esc_html( $plugin_data['Name'] );
								if ( ! empty( $plugin_data['PluginURI'] ) ) {
									$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage', 'kapee' ) . '">' . $plugin_name . '</a>';
								}
								?>
								<tr>
									<td><?php echo wp_kses_post( $plugin_name ); ?></td>
									<td><?php
										printf( _x( 'by %s', 'admin status', 'kapee' ), $plugin_data['Author'] );
										echo ' &ndash; ' . esc_html( $plugin_data['Version'] );
										?></td>
								</tr>
								<?php
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
require_once KAPEE_FRAMEWORK.'admin/dashboard/footer.php';