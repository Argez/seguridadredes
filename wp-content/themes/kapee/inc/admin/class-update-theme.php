<?php 
class Kapee_Update_Theme {
	public $prefix, $theme_data, $current_version, $api_url, $token_key, $purchase_code, $item_name, $slug, $item_id, $changelog_link;
	public $option_name = 'envato_purchase_code_24187521';
	function __construct($purchase_code = null) {
		$this->prefix = KAPEE_PREFIX;
		$this->theme_data = $this->get_theme_data();
		$this->current_version = $this->theme_data->get('Version');
        $this->api_url = 'https://www.presslayouts.com/api/envato';
        $this->token_key = $this->get_token_key();
        if($purchase_code)		{
			$this->purchase_code = $purchase_code;
		}else {
			$this->purchase_code = $this->get_purchase_code();
		}
        $this->item_name 	= 'Kapee - Fashion Store WooCommerce Theme';
        $this->slug 		= 'kapee';
		$this->item_id 		= '24187521';
		
		$this->changelog_link = 'https://kapee.presslayouts.com';        
     
		/* Theme Update */
		add_action( 'wp_ajax_activate_theme', array( $this, 'activate_theme' ) );
		
		/* Theme Deactivate */
		add_action( 'wp_ajax_deactivate_theme', array( $this, 'deactivate_theme_data' ) );
		
		/* Admin Notice */
		add_action( 'admin_notices', array( $this, 'check_theme_license_activate' ), 90);
		
		add_action( 'admin_init', array( $this, 'theme_token_key_exist' ), 10 );
	}
	
	public function activate_theme(){
		check_ajax_referer( 'kapee_nonce', 'nonce' );
		$purchase_code = $_REQUEST['purchase_code'];
		$theme_data = $this->get_activate_theme_data($purchase_code);
		$data = json_decode($theme_data,true);
		$data['purchase_code'] = $purchase_code;
		$response = array('message'=> $data['message'],'success'=>0);
		if($data['success']){			
			$this->update_theme_data($data);
			$response = array('message'=> $data['message'],'success'=>1);
		}		
		echo json_encode($response);
		die();
	}
	
	public function update_theme_data($data){
		update_option( 'kapee_token_key',$data['token'] );
		update_option( 'kapee_plugin_file', $data['file'] );
		update_option( 'kapee_is_activated', true );
		update_option( $this->option_name,$data['purchase_code'] );
	}
	
	public function deactivate_theme_data(){
		check_ajax_referer( 'kapee_nonce', 'nonce' );
		$purchase_code = $_REQUEST['purchase_code'];
		$theme_data = $this->deactivate_theme($purchase_code);
		$data = json_decode($theme_data,true);
		$data['purchase_code'] = $purchase_code;
		$response = array('message'=> $data['message'],'success'=>0);
		if($data['success']){			
			$this->remove_theme_data();
			$response = array('message'=> $data['message'],'success'=>1);
		}		
		echo json_encode($response);
		die();
	}
	
	public function remove_theme_data(){
		delete_option( 'kapee_token_key' );
		delete_option( 'kapee_is_activated');
		delete_option( 'kapee_plugin_file');
		delete_option( $this->option_name );
	}
	
	public function get_activate_theme_data($purchase_code){
		global $wp_version;		
		$item_id = $this->item_id;		
		$domain = $this->get_domain();
		$response = wp_remote_request($this->api_url.'/activate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '. home_url( '/' ) ,
				'sslverify' => false,
				'method' => 'POST',
				'body' => array(
					'purchase_code' => urlencode($purchase_code),
					'item_id' => urlencode($item_id),
					'domain' => urlencode($domain),
				)
			)
		);

        $response_code = wp_remote_retrieve_response_code( $response );
        $activate_info = wp_remote_retrieve_body( $response );

        if ( $response_code != 200 || is_wp_error( $activate_info ) ) {
			return json_encode(array("message"=>"Registration Connection error",'success'=>0));
        }
		return $activate_info;
	}
	
	public function deactivate_theme($purchase_code){
		global $wp_version;		
		$token_key = $this->get_token_key();
		$item_id = $this->item_id;
		$response = wp_remote_request($this->api_url.'/deactivate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '. home_url( '/' ) ,
				'method' => 'POST',
				'sslverify' => false,
				'body' => array(
					'purchase_code' => urlencode($purchase_code),
					'token_key' 	=> urlencode($token_key),
					'item_id' 		=> urlencode($item_id),
				)
			)
		);

        $response_code = wp_remote_retrieve_response_code( $response );
        $activate_info = wp_remote_retrieve_body( $response );

        if ( $response_code != 200 || is_wp_error( $activate_info ) ) {
            return json_encode(array("message"=>"Registration Connection error",'success'=>0));
        }
		if(  $response_code == 200 ){
			return json_encode( array( "message"=>"Successfully deactivate theme license.",'success'=> 1 ) ) ;
		}
		return $activate_info;
	}
	
	public function get_domain() {
        $domain = get_option('siteurl'); //or home
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www', '', $domain); //add the . after the www if you don't want it
        return $domain;
    }
	public function get_theme_data(){
		return wp_get_theme();
	}
	
	public function get_current_version(){
		return $this->current_version;
	}
	
	public function get_token_key(){
		return get_option( 'kapee_token_key');
	}
	
	public function get_file_path(){
		return get_option( 'kapee_plugin_file');
	}
	
	public function get_purchase_code(){
		return get_option( $this->option_name);
	}
	
	public function check_for_update( $transient = '') {

		if ( empty( $transient->checked ) ) {
			return $transient;
		}
		
		$update = $this->check_theme_update();

		if ( $update ) {
			
			$theme_data = wp_get_theme();
			$theme_slug = $theme_data->get_template();
			$transient->response[ $theme_slug ] = $update;
			$transient->response[ $theme_slug ]['url'] = $update['url'];
			//if purchase code is verified
			if ( $this->kapee_is_license_activated() ) {
				$transient->response[ $theme_slug ]['package'] = $update['package'];
				
			} else {
				if(isset($transient->response[ $theme_slug ]['package'])){
					unset( $transient->response[ $theme_slug ]['package'] );
				}
			}

		}

		return $transient;
	}
	
	public function check_valid_update(){
		return true;
	}
	
	public function check_theme_update(){
		$update_data = array();
		global $wp_version;
		$purchase_code = $this->get_purchase_code();
		$update_info = get_transient( 'kapee_update_info' );
		$has_update  = false;
		if ( $this->api_url != '') {
			if(false === $update_info){				
				$request = wp_remote_post($this->api_url.'/update.php', array(
					'user-agent' => 'WordPress/'.$wp_version.'; '. home_url( '/' ) ,
					'sslverify' => false,
					'headers' => array('token'=>$this->token_key),
					'body' => array(
						'purchase_code' => urlencode($purchase_code),
					),
				));
				if ( is_wp_error( $request ) ) {
					return;
				}			
				$updates = json_decode( wp_remote_retrieve_body( $request ), true );
				if(empty($updates)) return;
				foreach($updates as $version=> $theme_data){
					if ( is_array( $theme_data ) ) {
						if ( version_compare( $theme_data['new_version'], KAPEE_VERSION ) == 1 ) {
							$update_data['new_version'] = $theme_data['new_version'];
							$update_data['package']     = $this->api_url . '/' . $theme_data['package'];
							$update_data['url']        = 'https://kapee.presslayouts.com';
							$has_update                 = true;								
							set_transient( 'kapee_update_info', $update_data, 60);
						}
					} 
					break;
				}
			}else{
				$update_data = $update_info;
				if ( version_compare( $update_data['new_version'], KAPEE_VERSION ) == 1 ) {
					$has_update                 = true;	
				}
			}
		}
		
		if ( $has_update ) {
			return $update_data;
		} else {
			return false;
		}
	}
	//Check update forcefully
	public function is_update_available(){
		$update_info = delete_transient( 'kapee_update_info' );
		$update_data = $this->check_theme_update();
		if($update_data ){
			return $update_data;
		}
		return false;
	}
	
	public function kapee_is_license_activated(){ 
		if(get_option('kapee_is_activated') && get_option($this->option_name)){
			return true;
		}
		return false;
	}

	public function check_theme_license_activate(){
            
		if( kapee_is_license_activated() ){
			return;
		}
		$theme_details = wp_get_theme();
		$activate_page_link = admin_url( 'admin.php?page=kapee-theme' );

		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php 
					echo sprintf( esc_html__( ' %1$s Theme is not activated! Please activate your theme and enjoy all features of the %2$s theme', 'kapee'), 'Kapee','Kapee' );
					?>
			</p>
			<p>
				<strong style="color:red"><?php esc_html_e( 'Please activate the theme!', 'kapee' ); ?></strong> -
				<a href="<?php echo esc_url(( $activate_page_link )); ?>">
					<?php esc_html_e( 'Activate Now','kapee' ); ?> 
				</a> 
			</p>
		</div>

	<?php
	}
	
	public function theme_token_key_exist(){
		
		$transient_key = 'kapee_verify_code';
		$is_verify = get_transient($transient_key);
		if( false !== $is_verify ){
			return;
		}
		
		global $wp_version;	
		$purchase_code	= $this->get_purchase_code();
		$token_key 		= $this->get_token_key();
		$file_path 		= $this->get_file_path();
		$item_id 		= $this->item_id;
		$domain 		= $this->get_domain();
		
		if( empty($token_key) ){
			delete_option( 'kapee_token_key' );
			delete_option( 'kapee_is_activated');
			delete_option( $this->option_name );
			return;
		}
		$response = wp_remote_request($this->api_url.'/verify-purchasecode.php', array(
				'user-agent'	=> 'WordPress/'.$wp_version.'; '. home_url( '/' ) ,
				'method'		=> 'POST',
				'sslverify' => false,
				'body' => array(
					'purchase_code'	=> urlencode($purchase_code),
					'token_key'		=> urlencode($token_key),
					'item_id'		=> urlencode($item_id),
					'domain'		=> urlencode($domain),
				)
			)
		);
		$response_code = wp_remote_retrieve_response_code( $response );
		$activate_info = wp_remote_retrieve_body( $response );
		$return = false;
		if ( $response_code != 200 || is_wp_error( $activate_info ) ) {
			$return = true;
		}
		if(  $response_code == 200 ){
			$data = json_decode($activate_info,true);				
			if($data['success'] == 1){
				set_transient( $transient_key, 'yes', WEEK_IN_SECONDS );
				if(empty( $file_path )){
					update_option( 'kapee_plugin_file', $data['file'] );
				}					
				$return = true;
			}else{
				set_transient( $transient_key, 'yes', DAY_IN_SECONDS );
			}
		}
		if( !$return ){
			delete_option( 'kapee_token_key' );
			delete_option( 'kapee_is_activated');
			delete_option( 'kapee_plugin_file');
			delete_option( $this->option_name );
		}
	}
	
}
global $obj_kp_updatetheme;
$obj_kp_updatetheme = new Kapee_Update_Theme();
?>