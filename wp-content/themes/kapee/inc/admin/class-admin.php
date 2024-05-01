<?php 
class Kapee_Admin {
	public $prefix, $current_version, $api_url, $api_key;
	
	function __construct() {
		$this->prefix = KAPEE_PREFIX;
		$theme_data = wp_get_theme();
        $this->current_version = $theme_data->get('Version');
        $this->api_url = 'https://www.presslayouts.com/api/envato';
        $this->api_key = 'token';
		
		
		/*Admin menu*/
		add_action( 'admin_menu', array( $this, 'theme_page_menu' ) );
		
		
		// Register walker replacement
		add_filter( 'wp_edit_nav_menu_walker',   array( $this, 'nav_menu_walker')  );
		
		add_action('wp_update_nav_menu_item', array( $this, 'save_custom_fields' ), 10, 3 );
		
		add_action( 'wp_nav_menu_item_custom_fields',   array( $this, 'kapee_custom_menu_field'),10,4  );
	}
	
	public function theme_page_menu() {
        add_menu_page(
            esc_html__( 'Kapee', 'kapee' ),
            esc_html__( 'Kapee', 'kapee' ),
            'manage_options',
            'kapee-theme',
            array( $this, 'kapee_dashboard_page' ),
			KAPEE_URI.'/inc/admin/assets/images/menu-icon.png',
			25
        );
		add_submenu_page( 'kapee-theme',
            esc_html__( 'Welcome', 'kapee' ),
            esc_html__( 'Welcome', 'kapee' ),
            'manage_options',
            'kapee-theme',
            array( $this, 'kapee_dashboard_page' )
        );
		add_submenu_page( 'kapee-theme',
            esc_html__( 'System Status', 'kapee' ),
            esc_html__( 'System Status', 'kapee' ),
            'manage_options',
            'kapee-system-status',
            array( $this, 'kapee_system_status' )
        );
		
		
    }
	public function kapee_dashboard_page() {
		require( KAPEE_FRAMEWORK. '/admin/dashboard/welcome.php' );
	}
	
	public function kapee_system_status() {
		 
		require(KAPEE_FRAMEWORK. '/admin/dashboard/system_status.php' );
	}
	
	public function nav_menu_walker(){
		require_once KAPEE_FRAMEWORK . '/admin/class-walker-nav-menu.php';
		return 'Kapee_Walker_Nav_Menu_Edit_Custom';
	}
	
	public function save_custom_fields($menu_id, $menu_item_db_id, $args){
		
		$custom_fields = array('enable','design','width','height','custom_block','label_text','label_color','icon','thumbnail_url','attachment_id');

		foreach ( $custom_fields as $key ) {
			$value = isset($_REQUEST['menu-item-'.$key][$menu_item_db_id]) ? $_REQUEST['menu-item-'.$key][$menu_item_db_id] : '';
			update_post_meta( $menu_item_db_id, '_menu_item_kapee_'.$key, $value );
		}
	}
	
	public function kapee_custom_menu_field($item_id, $item, $depth, $args ){
		
		$enable  		= get_post_meta( $item_id, '_menu_item_kapee_enable',  true );
		$design  		= get_post_meta( $item_id, '_menu_item_kapee_design',  true );
		$custom_block  	= get_post_meta( $item_id, '_menu_item_kapee_custom_block',  true );
		$height  		= get_post_meta( $item_id, '_menu_item_kapee_height',  true );
		$width   		= get_post_meta( $item_id, '_menu_item_kapee_width',   true );
		$label_text   	= get_post_meta( $item_id, '_menu_item_kapee_label_text',  true );
		$label_color   	= get_post_meta( $item_id, '_menu_item_kapee_label_color',  true );
		$icon    		= get_post_meta( $item_id, '_menu_item_kapee_icon',    true );		
		$attachment_id  = get_post_meta( $item_id, '_menu_item_kapee_attachment_id',  true );
		$thumbnail_url  = get_post_meta( $item_id, '_menu_item_kapee_thumbnail_url',  true );
		$icon_btn_text = (!empty($thumbnail_url)) ? esc_html__('Change Custom Icon','kapee') : esc_html__('Upload Custom Icon','kapee');
		$megamenu_class = ($enable != 'enabled') ? 'hidden-field' : '';
		$img_remove_cls = (empty($thumbnail_url)) ? 'hidden-field' : '';
		$custom_size_class = (($design == 'custom-size') && ($enable == 'enabled')) ? '' : 'hidden-field';
		$custom_blocks = kapee_get_posts_by_post_type('block');
		$custom_block_edit_link = !empty($custom_block) ? admin_url( 'post.php?post='.$custom_block.'&action=edit' ) : 'javascript:void();';
	?>
		<!--  Kapee custom fields-->
		<div id="kapee-custom-fields" class="kapee-custom-fields">
			<p class="description description-wide kapee-megamenu-enable">
				<label for="edit-menu-item-megamenu-enable-<?php echo esc_attr( $item_id ); ?>">
					<input type="checkbox" id="edit-menu-item-megamenu-enable-<?php echo esc_attr( $item_id ); ?>" data-itemid=<?php echo esc_attr( $item_id ); ?> class="widefat code edit-menu-item-megamenu-enable" name="menu-item-enable[<?php echo esc_attr( $item_id ); ?>]" value="enabled" <?php checked($enable,'enabled')?> />
					<strong><?php esc_html_e( 'Enable Mega Menu (only for main menu)', 'kapee' ); ?></strong>
				</label>
			</p>
			<p class="description description-wide kapee-menu-design megamenu-field <?php echo esc_attr($megamenu_class);?>">
				<label for="edit-menu-item-design-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e('Design', 'kapee'); ?><br>
					<select id="edit-menu-item-design-<?php echo esc_attr( $item_id ); ?>" data-field="kapee-menu-design" data-itemid="<?php echo esc_attr( $item_id ); ?>" class="widefat kapee-menu-design" name="menu-item-design[<?php echo esc_attr( $item_id ); ?>]">
						<option value="full-width" <?php selected( esc_attr( $design ), 'full-width', true); ?>><?php esc_html_e('Full width', 'kapee'); ?></option>
						<option value="custom-size" <?php selected( esc_attr( $design ), 'custom-size', true); ?>><?php esc_html_e('Custom sizes', 'kapee'); ?></option>
					</select>
				</label>
			</p>
			<div id="kapee-custom-design-block-<?php echo esc_attr( $item_id ); ?>" class="kapee-custom-design-block <?php echo esc_attr($custom_size_class);?>">
			<p class="description description-thin kapee-menu-width">
				<label for="edit-menu-item-width-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e('Width', 'kapee'); ?><br>
					<input type="number" id="edit-menu-item-width-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($width);?>">
				</label>
			</p>			
			<p class="description description-thin kapee-menu-height ">
				<label for="edit-menu-item-height-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e('Height', 'kapee'); ?><br>
					<input type="number" id="edit-menu-item-height-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-height[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($height);?>">
				</label>
			</p>
			</div>
			<p class="description description-wide kapee-menu-custom-block megamenu-field <?php echo esc_attr($megamenu_class);?>">
				<label for="edit-menu-item-custom-block-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e('Select block', 'kapee'); ?><br>
					<select id="edit-menu-item-custom-block-<?php echo esc_attr( $item_id ); ?>" data-field="kapee-menu-custom-block" class="widefat kapee-custom-block select" name="menu-item-custom_block[<?php echo esc_attr( $item_id ); ?>]">
						<option value=""><?php esc_attr_e('Select block','kapee');?></option>
						<?php
						if(!empty($custom_blocks)){
							foreach ($custom_blocks as $id => $title) {
							$edit_link = admin_url( 'post.php?post='.$id.'&action=edit' );
							?>
							<option value="<?php echo esc_attr($id);?>" <?php selected($custom_block,$id); ?> data-block-link="<?php echo esc_url($edit_link);?>"><?php echo esc_html($title);?></option>
							<?php
							}
						}
						?>
					</select>
					<?php if(!empty( $custom_block ) ){?>
					<a href="<?php echo esc_url($custom_block_edit_link);?>" class="edit-block-link" target="_blank"><?php esc_html_e( 'Edit megamenu block', 'kapee' ); ?></a> | 
					<?php } ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=block' ) ); ?>" class="add-block-link" target="_blank"><?php esc_html_e( 'Add megamenu block', 'kapee' ); ?></a>
				</label>
			</p>
			
			<p class="description description-thin kapee-label-text">
				<label for="edit-menu-item-label-text-<?php echo esc_attr( $item_id ); ?>">					
					<?php esc_html_e('Label text','kapee');?><br>
					<input id="edit-menu-item-label-text-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-label_text[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($label_text);?>" type="text">
				
			</p>
			<p class="description description-thin kapee-label-color">
				<label for="edit-menu-item-label-color-<?php echo esc_attr( $item_id ); ?>">					
					<?php esc_html_e('Label color','kapee');?></label><br>
					<input id="edit-menu-item-label-color-<?php echo esc_attr( $item_id ); ?>" class="widefat kapee-color-box" name="menu-item-label_color[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($label_color);?>" type="text">
				
			</p>
			<p class="description description-thin kapee-menu-icon">
				<label for="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>">
					<a href="#" class="button-secondary pick-icon"><i class=" fa <?php echo esc_attr($icon);?>"></i> <?php esc_html_e( 'Menu Icon', 'kapee' ) ?></a>
					<span class="icons-block">
						<input type="text" class="search-icon" placeholder="<?php esc_attr_e( 'Quick search', 'kapee' ) ?>">
						<span class="kapee-icon-close"> X </span>
						<span class="icon-selector">
							<i data-icon="">&nbsp;</i>
							<?php echo implode( "\n", kapee_get_font_awesome_icons($icon) ); ?>
						</span>
					</span>
					<input type="hidden" name="menu-item-icon[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($icon);?>">
				</label>
			</p>			
			<p class="description description-thin kapee-menu-icon-img">				
				<label for="edit-menu-item-megamenu-thumbnail-<?php echo esc_attr( $item_id ); ?>">
					<span class="img-wrp">
						<?php if(!empty($thumbnail_url)){?>
						<img src="<?php echo esc_url($thumbnail_url);?>" id="kapee-media-img-<?php echo esc_attr( $item_id ); ?>" data-itemid = "<?php echo esc_attr( $item_id ); ?>" class="kapee-megamenu-thumbnail-image kapee-attr-img" height="32" width="32" align="left" alt="<?php echo esc_attr__('Menu icon','kapee');?>"/>
						<span data-itemid = "<?php echo esc_attr( $item_id ); ?>" class="kapee-menu-image-clear"></span>
						<?php }?>
					</span>					
					<a href="#" id="kapee-media-upload-<?php echo esc_attr( $item_id ); ?>" data-itemid = "<?php echo esc_attr( $item_id ); ?>" class="kapee-menu-image-upload button button-primary"><?php echo esc_html($icon_btn_text ); ?></a>
				</label>
				<input type="hidden" id="edit-menu-item-thumbnail-url-<?php echo esc_attr( $item_id ); ?>" data-itemid = "<?php echo esc_attr( $item_id ); ?>" name="menu-item-thumbnail_url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($thumbnail_url);?>" />
				<input type="hidden" id="kapee-attachment-<?php echo esc_attr( $item_id ); ?>" data-itemid = "<?php echo esc_attr( $item_id ); ?>" name="menu-item-attachment_id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($attachment_id);?>" />
			</p>
			
		</div><!-- End #kapee-custom-fields custom fields Block. -->
		
	<?php
	}		
}

$obj_kapee_admin = new Kapee_Admin();
