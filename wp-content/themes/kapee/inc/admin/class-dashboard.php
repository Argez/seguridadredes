<?php 
class Kapee_Dashboard {
	public $prefix, $theme_data, $current_version, $profile_link, $support_link, $rating_link, $doc_link, $demo_preview_link, $changelog_link, $api_url;
	function __construct() {
		$this->prefix 				= KAPEE_PREFIX;
		$this->theme_data 			= $this->get_theme_data();
		$this->current_version 		= $this->theme_data->get('Version');
		$this->profile_link 		= 'https://themeforest.net/user/presslayouts/portfolio';
        $this->support_link 		= 'https://themeforest.net/user/presslayouts/portfolio';
		$this->rating_link 			= 'https://themeforest.net/downloads';
        $this->doc_link 			= 'http://docs.presslayouts.com/kapee';
        $this->demo_preview_link 	= 'https://demo.presslayouts.com/kapee';
        $this->changelog_link 		= 'https://demo.presslayouts.com/kapee'; 
		$this->api_url 				= 'https://www.presslayouts.com/api/envato';
	}
	
	public function get_theme_data(){
		return wp_get_theme();
	}
	
	public function get_current_version(){
		return $this->current_version;
	}
	
	public function get_installation_path(){
		return get_template_directory();
	}
	
	public function get_child_theme_path(){
		return get_stylesheet_directory();
	}
	
	public function is_kapee_server_available(){
		global $wp_version;
		$request = wp_remote_post($this->api_url.'/update.php', array(
			'user-agent' => 'WordPress/'.$wp_version.'; '. home_url( '/' ) ,
			'sslverify' => false,
			'body' => array(
				'test' => 'server check',
			),
		));
		if ( is_wp_error( $request ) ) {
			return false;
		}
		$response_code = wp_remote_retrieve_response_code( $request );
		
		if ( $response_code != 200 ) {
			return false;
		}
		return true;
	}
	
	// Get action link for each plugin
	public function plugin_action( $item ) {
		$installed_plugins        = get_plugins();
		$item['sanitized_plugin'] = $item['name'];
		$actions                  = array();
		// We have a repo plugin
		if ( ! $item['version'] ) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
		}
		if ( ! isset( $installed_plugins[ $item['file_path'] ] ) ) {
			// Display install link
			$actions = sprintf( '<a href="%1$s" title="%2$s">Install</a>',
				esc_url( wp_nonce_url( add_query_arg( array(
					'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
					'plugin'        => urlencode( $item['slug'] ),
					'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
					'plugin_source' => urlencode( $item['source'] ),
					'tgmpa-install' => 'install-plugin',
				),
					TGM_Plugin_Activation::$instance->get_tgmpa_url() ),
					'tgmpa-install',
					'tgmpa-nonce' ) ),
				$item['sanitized_plugin'] );
		} elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			// Display activate link
			$actions = sprintf( '<a href="%1$s" title="%2$s">Activate</a>',
				esc_url( add_query_arg( array(
					'plugin'               => urlencode( $item['slug'] ),
					'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
					'plugin_source'        => urlencode( $item['source'] ),
					'tgmpa-activate'       => 'activate-plugin',
					'tgmpa-activate-nonce' => wp_create_nonce( 'tgmpa-activate' ),
				),
					admin_url( 'admin.php?page=kapee-theme' ) ) ),
				$item['sanitized_plugin'] );
		} elseif ( version_compare( $installed_plugins[ $item['file_path'] ]['Version'], $item['version'], '<' ) ) {
			// Display update link
			$actions = sprintf( '<a href="%1$s" title="%2$s">Update</a>',
				wp_nonce_url( add_query_arg( array(
					'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
					'plugin'        => urlencode( $item['slug'] ),
					'tgmpa-update'  => 'update-plugin',
					'plugin_source' => urlencode( $item['source'] ),
					'version'       => urlencode( $item['version'] ),
				),
					TGM_Plugin_Activation::$instance->get_tgmpa_url() ),
					'tgmpa-update',
					'tgmpa-nonce' ),
				$item['sanitized_plugin'] );
		} elseif ( kapee_check_plugin_active( $item['file_path'] ) ) {
			// Display deactivate link
			$actions = sprintf( '<a href="%1$s" title="%2$s">Deactivate</a>',
				esc_url( add_query_arg( array(
					'plugin'                 => urlencode( $item['slug'] ),
					'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
					'plugin_source'          => urlencode( $item['source'] ),
					'tgmpa-deactivate'       => 'deactivate-plugin',
					'tgmpa-deactivate-nonce' => wp_create_nonce( 'tgmpa-deactivate' ),
				),
					admin_url( 'admin.php?page=kapee-theme' ) ) ),
				$item['sanitized_plugin'] );
		}
		return $actions;
	}
	
	public function kapee_let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
}
$obj_kp_dash = new Kapee_Dashboard();
?>