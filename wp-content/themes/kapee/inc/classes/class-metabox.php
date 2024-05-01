<?php  
if ( ! defined('KAPEE_DIR')) exit('No direct script access allowed');
/**
 * Kapee Loop
 * @author 		PressLayouts
 * @package 	kapee/inc
 * @version     1.0
 */
 
if ( ! class_exists( 'Kapee_Metabox' ) ) :

	/**
	 * Kapee_Metabox
	 *
	 * @since 1.0
	 */
	class Kapee_Metabox {
		
		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class object.
		 */
		private static $instance;
		
		private $prefix = KAPEE_PREFIX;
		
		public $post_types;
		
		/**
		 * Initiator
		 *
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		/**
		 * Constructor
		 */
		public function __construct() {
			$this->post_types = array('post','page','portfolio','product');	
			add_action('admin_init',array($this,'register_metaboxes'));
			add_action('admin_enqueue_scripts',array($this,'kapee_admin_js_var'));
		}
		
		
		public function kapee_meta_boxes(){
			$prefix 	= KAPEE_PREFIX;
			$meta_box 	= array();
			$size_guide = kapee_get_posts_by_post_type('kp_size_chart',esc_html__('Select Size Chart','kapee'));
			// POST FORMAT
			//--------------------------------------------------
			$meta_boxes[] = array(
				'title' 		=> esc_html__('Post Format', 'kapee'),
				'id' 			=> $prefix .'meta_box_post_format',
				'post_types' 	=> array('post'),
				'tab'   		=> true,
				'fields' 		=> array(
					array(
						'name' 				=> esc_html__('Images', 'kapee'),
						'label_description' => esc_html__( 'Upload images.This setting is used for your gallery post formats.', 'kapee' ),
						'id' 				=> $prefix . 'post_format_gallery',
						'type' 				=> 'image_advanced',
					),
					array(
						'name' 				=> esc_html__( 'Video URL or Embeded Code', 'kapee' ),
						'label_description' => esc_html__( 'Enter the URL or embed code of Vimeo.com or YouTube.com streaming services.<br>To get the code, go to the external video page, click "share" button and copy the Embed code.This setting is used for your video post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_video',
						'type' 				=> 'textarea',
					),
					array(
						'name' 				=> esc_html__( 'Audio URL or Embeded Code', 'kapee' ),
						'label_description' => esc_html__( 'Enter the URL or Embeded code of the audio.This setting is used for your audio post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_audio',
						'type' 				=> 'textarea',
					),
					array(
						'name' 				=> esc_html__( 'Quote', 'kapee' ),
						'label_description' => esc_html__( 'Enter your quote.This setting is used for your quote post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_quote',
						'type' 				=> 'textarea',
					),
					array(
						'name' 				=> esc_html__( 'Author', 'kapee' ),
						'label_description' => esc_html__( 'Enter quote author.This setting is used for your quote post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_quote_author',
						'type' 				=> 'text',
					),
					array(
						'name' 				=> esc_html__( 'Author URL', 'kapee' ),
						'label_description' => esc_html__( 'Enter quote author url.This setting is used for your quote post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_quote_author_url',
						'type' 				=> 'url',
					),
					array(
						'name' 				=> esc_html__( 'Link', 'kapee' ),
						'label_description' => esc_html__( 'Enter your external url.This setting is used for your link post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_link_url',
						'type' 				=> 'url',
					),					
					array(
						'name' 				=> esc_html__( 'Text', 'kapee' ),
						'label_description' => esc_html__( 'Enter link text for link.This setting is used for your link post formats.', 'kapee' ),
						'id'   				=> $prefix . 'post_format_link_text',
						'type' 				=> 'text',
					),
				),
			);
			if( defined( 'KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE' ) ) {
				$meta_boxes[] 	= array( 
					'id'			=> $prefix.'portfolio_gallery',
					'title'			=> esc_html__( 'Portfolio', 'kapee' ),
					'post_types' 	=> KAPEE_EXTENSIONS_PORTFOLIO_POST_TYPE,
					'tab'   		=> true,
					'fields'     	=> array(
						array(
							'name'  			=> esc_html__( 'Portfolio Layout', 'kapee' ),
							'label_description' => esc_html__( 'Select portfolio layout', 'kapee' ),
							'id'    			=> "{$prefix}portfolio_style",
							'type'  		=> 'image_set',
							'allowClear' 	=> false,
							'options' 		=> array(
								'default'	=> KAPEE_ADMIN_IMAGES . 'layout/default.png',
								'4'	  		=> KAPEE_ADMIN_IMAGES . 'layout/portfolio/4_8-layout.png',
								'6'	  		=> KAPEE_ADMIN_IMAGES . 'layout/portfolio/6_6-layout.png',
								'8'	  		=> KAPEE_ADMIN_IMAGES . 'layout/portfolio/8_4-layout.png',
								'12'		=> KAPEE_ADMIN_IMAGES . 'layout/portfolio/12_12-layout.png',
							),
							'std'			=> 'default',
							'multiple' 		=> false,							
						),
						array(
							'name'  			=> esc_html__( 'Client Name', 'kapee' ),
							'label_description' => esc_html__( 'Enter client name.', 'kapee' ),
							'id'    			=> "{$prefix}client_name",
							'type'  			=> 'text',
						),
						array(
							'name'  			=> esc_html__( 'Website', 'kapee' ),
							'label_description' => esc_html__( 'Website link.', 'kapee' ),
							'id'    			=> "{$prefix}website_url",
							'type'  			=> 'text',
						),
						array(
							'id'               	=> "{$prefix}gallery_images",
							'name'             	=> esc_html__( 'Portfolio Images Upload', 'kapee' ),
							'label_description'	=> esc_html__( 'Upload portfolio images.', 'kapee' ),
							'type'             	=> 'image_advanced',
							'force_delete'     	=> false,
						),
						array(
							'name'  			=> esc_html__( 'Thumbnail/Gallery', 'kapee' ),
							'label_description' => esc_html__( 'Show gallery Or thumbnail.', 'kapee' ),
							'id'    			=> $prefix.'show_portfolio_gallery',
							'type'     			=> 'button_group',
							'options'  			=> array(
								'default'	=> esc_html__( 'Default', 'kapee' ),
								'gallery'	=> esc_html__( 'Gallery', 'kapee' ),
								'thumbnail'	=> esc_html__( 'Thumbnail', 'kapee' ),
							),
							'inline'   			=> 	true,
							'multiple' 			=> 	false,
							'std'				=>	'default',							
						),
						array(
							'name'  			=> esc_html__( 'Gallery Style', 'kapee' ),
							'label_description' => esc_html__( 'Select portfolio gallery style.', 'kapee' ),
							'id'    			=> $prefix.'portfolio_gallery_style',
							'type'     			=> 'button_group',
							'options'  			=> array(
								'default'		=> esc_html__( 'Default', 'kapee' ),
								'slider'     	=> esc_html__( 'Slider', 'kapee' ),
								'grid'     		=> esc_html__( 'Grid', 'kapee' ),
								'one-column'    => esc_html__( 'One Column', 'kapee' ),
							),
							'inline'   			=> 	true,
							'multiple' 			=> 	false,
							'std'				=>	'default',							
						),
						
					),
				);
			}
			$meta_boxes[] = array(
				'id' 			=> $prefix . 'product_setting_meta_box',
				'title' 		=> esc_html__('Product setting', 'kapee'),
				'post_types' 	=> array('product'),
				'tab' => true,
				'fields' => array(
					array(
						'name'  			=> esc_html__( 'Product Page Layout', 'kapee' ),
						'label_description'	=> esc_html__( 'Select product page  layout.', 'kapee' ),
						'id'    			=> $prefix.'single_product_layout',
						'type'  			=> 'image_set',
						'allowClear' 		=> true,
						'options' 			=> array(
							'product-gallery-left'	  		=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-left.png',
							'product-gallery-bottom'		=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-bottom.png',
							'product-gallery-horizontal'	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-horizontal.png',
							'product-gallery-center'		=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-center.png',
							'product-gallery-grid'			=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-grid.png',
							'product-sticky-info'			=> KAPEE_ADMIN_IMAGES . 'product-page/product-sticky-info.png',
						),
						'std'				=> '',
						'multiple' 			=> false,
						'required' 			=> true,
					),
					array(
						'name' 				=> esc_html__( 'Product Video url', 'kapee' ),
						'id'   				=> $prefix . 'product_video',
						'label_description'	=> esc_html__( 'Youtube, Vimeo embaded link', 'kapee' ),
						'type' 				=> 'text',
					),
					array(
						'name' 				=> esc_html__( 'Product Size Guide', 'kapee' ),
						'label_description'	=> esc_html__( 'Select product size guide.', 'kapee' ),
						'id'   				=> $prefix . 'size_guide',
						'type' 				=> 'select',
						'options'			=> $size_guide,
						'max_file_uploads' 	=> 1,
					),
					array(
						'id'               	=> $prefix . 'product_360_degree_images',
						'name'             	=> esc_html__( 'Product 360 Degree Images', 'kapee' ),
						'label_description'	=> esc_html__( 'Upload 360 degree images.', 'kapee' ),
						'type'             	=> 'image_advanced',
						'force_delete'     	=> false,
					),
				)
			);
			$meta_boxes[] = array(
				'id' 			=> $prefix . 'product_custom_tab_meta',
				'title' 		=> esc_html__('Product Custom Tab', 'kapee'),
				'post_types' 	=> array('product'),
				
				'fields' => array(
					
					array(
						'name'  			=> esc_html__( 'Enable Custom Tab.', 'kapee' ),
						'label_description'	=> esc_html__( 'Check this for enable custom tab.', 'kapee' ),
						'id'    			=> $prefix . 'enable_custom_tab',
						'type'  			=> 'checkbox',
						'std'				=> 0,
					),
					array (
						'name' 				=> esc_html__('Custom Tab Title', 'kapee'),
						'label_description' => esc_html__( 'Enter tab title.', 'kapee' ),
						'id' 				=> $prefix . 'product_custom_tab_heading',
						'type' 				=> 'text',
						'std' 				=> '',
						'required-field' 	=> array($prefix . 'enable_custom_tab','=',array('1')),
					),
					array(
						'name'  			=> esc_html__( 'Custom Tab Content.', 'kapee' ),
						'label_description' => esc_html__( 'Enter tab content.', 'kapee' ),
						'id'    			=> $prefix . 'product_custom_tab_content',
						'type'  			=> 'wysiwyg',
						'raw'     			=> false,
						'options' 			=> array(
							'textarea_rows' => 4,
							'teeny'         => true,
						),
						'required-field' 	=> array($prefix . 'enable_custom_tab','=',array('1')),
					), 
				)
			);
			/* Page  Options */
			$meta_boxes[] = array(
				'title' 		=> 	esc_html__('Page Layout', 'kapee'),
				'id' 			=> $prefix.'layout_options',
				'post_types' 	=> $this->post_types,
				'tab' 			=> 	true,
				'fields' 		=> 	array(
					array(
						'name'  		=> esc_html__( 'Page Sidebar', 'kapee' ),
						'id'    		=> $prefix.'layout',
						'type'  		=> 'image_set',
						'allowClear' 	=> true,
						'options' 		=> array(
							'full-width'	  => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
							'left-sidebar'	  => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
							'right-sidebar'	  => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
						),
						'std'			=> '',
						'multiple' 		=> false,
						'required' 		=> true,
					),
					array(
						'name'  		=> esc_html__( 'Sidebar Width', 'kapee' ),
						'id'    		=> $prefix.'sidebar_width',
						'type'     		=> 'button_group',
						'options'  		=> array(
							'default'     	=> esc_html__( 'Default', 'kapee' ),
							'3'     		=> esc_html__( 'Medium', 'kapee' ),
							'4'    			=> esc_html__( 'Large', 'kapee' ),
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std'			=>	'default',
						'required-field'=> array($prefix . 'layout','=',array('left-sidebar','right-sidebar')),
						
					),
					array (
						'name' 				=> esc_html__('Sidebar Widget', 'kapee'),
						'id' 				=> $prefix.'sidebar_widget',
						'type' 				=> 'sidebar',
						'field_type'  		=> 'select_advanced',
						'placeholder' 		=> esc_attr__('Select Sidebar','kapee'),
						'std' 				=> '',	
						'required-field' 	=> array($prefix . 'layout','=',array('left-sidebar','right-sidebar')),
						'desc' 				=> esc_html__('Select sidebar. If empty then it take value from theme options.','kapee'),																
					),										
				),
			);
			/* End Page Options */
			
			/* Header Options */
			$meta_boxes[] = array(
				'title' 		=> esc_html__('Header', 'kapee'),
				'id' 			=> $prefix .'header_options',
				'post_types' 	=> array('post','page','portfolio','product'),
				'tab' 			=> true,
				'fields' 		=> 	array(
					array(
						'name'  			=> esc_html__( 'Header Top', 'kapee' ),
						'label_description'	=> esc_html__( 'Enable or disable the top bar.', 'kapee' ),
						'id'    			=> $prefix . 'header_top',
						'type'  			=> 'button_group',
						'options' 			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std'			=> 'default',
						'multiple' 		=> false,
					),
					array(
						'name'  			=> esc_html__( 'Header', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable the header.', 'kapee' ),
						'id'    			=> $prefix . 'header',
						'type'  			=> 'button_group',
						'options' 			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std'			=> 'default',
						'multiple' 		=> false,
					),
					array(
						'name'  			=> esc_html__( 'Select Header Style', 'kapee' ),
						'label_description' => esc_html__( 'Select header style.', 'kapee' ),
						'id'    			=> $prefix.'header_style',
						'type'     			=> 'select',
						'options'  			=> array(
							'default'		=> esc_html__( 'Default', 'kapee' ),
							'1'      		=> esc_html__( 'Header 1', 'kapee' ),
							'2'   			=> esc_html__( 'Header 2', 'kapee' ),
							'3' 			=> esc_html__( 'Header 3', 'kapee' ),
							'4'				=> esc_html__( 'Header 4', 'kapee' ),
							'5'				=> esc_html__( 'Header 5', 'kapee' ),
							'6'				=> esc_html__( 'Header 6', 'kapee' ),
							'7'				=> esc_html__( 'Header 7', 'kapee' ),
						),
						'inline'   			=> 	true,
						'multiple' 			=> 	false,
						'std'				=>	'default',
					),
					array(
						'name'  			=> esc_html__( 'Header Transparent', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable the header transparent/overlay.', 'kapee' ),
						'id'    			=> $prefix . 'header_transparent',
						'type'  			=> 'button_group',
						'options' 			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std'			=> 'default',
						'multiple' 		=> false,
					),
				),
			);
			/* End Header Options */
			
			/* Title Options */
			$meta_boxes[] = array(
				'title' 		=> esc_html__('Page Title', 'kapee'),
				'id' 			=> $prefix.'page_title_options',
				'post_types' 	=> array('post','page','portfolio'),
				'tab' 			=> true,
				'fields' 		=> 	array(
					array(
						'name'  			=> esc_html__( 'Page Title', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable the page title.', 'kapee' ),
						'id'    			=> $prefix.'page_title_section',
						'type'     			=> 'button_group',
						'options'  			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable'	=> esc_html__('Enable','kapee'),
							'disable'	=> esc_html__('Disable','kapee'),
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std' 			=> 'default',
					),
					array(
						'name'  			=> esc_html__( 'Heading', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable the heading.', 'kapee' ),
						'id'    			=> $prefix.'page_heading',
						'type'     			=> 'button_group',
						'options'  			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std' 			=> 'default',
					),
					array(
					   'name' 				=> esc_html__( 'Custom Header Title', 'kapee' ),
					   'label_description'  => esc_html__( 'Alter the main title display.', 'kapee' ),
					   'desc' 				=> '',
					   'id' 				=> $prefix . 'custom_page_title',
					   'type' 				=> 'text',
					),
					array(
						'name'  			=> esc_html__( 'Title Style', 'kapee' ),
						'label_description' => esc_html__( 'Select a page title style.', 'kapee' ),
						'id'    			=> $prefix.'page_title_style',
						'type'     			=> 'button_group',
						'options'  			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'left' 		=> esc_html__('Left','kapee'),
							'center'	=> esc_html__('Centered','kapee'),							
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std' 			=> 'default',
					),
					array(
						'name'  			=> esc_html__( 'Header Font Size', 'kapee' ),
						'label_description' => esc_html__( 'Select page title font size.', 'kapee' ),
						'id'    			=> $prefix.'title_font_size',
						'type'     			=> 'button_group',
						'options'  			=> array(
							'default'	=> esc_html__( 'Default', 'kapee' ),
							'small'    	=> esc_html__( 'Small', 'kapee' ),
							'large'		=> esc_html__( 'Large', 'kapee' ),						
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std'			=> 'default',
					),
					array(
					   'name' 				=> esc_html__( 'Padding Top', 'kapee' ),
					   'desc' 				=> '',
					   'id' 				=> $prefix.'title_padding_top',
					   'type' 				=> 'number',
					),
					array(
					   'name' 				=> esc_html__( 'Padding Bottom', 'kapee' ),
					   'desc' 				=> '',
					   'id' 				=> $prefix.'title_padding_bottom',
					   'type' 				=> 'number',
					),
					array(
						'name'  			=> esc_html__( 'Background Color', 'kapee' ),
						'label_description' => esc_html__( 'Select a background color for title.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_color',
						'type'  			=> 'color',
					),
					array(
					   'name' 				=> esc_html__( 'Color', 'kapee' ),
					   'label_description'  => esc_html__( 'Select a title color.', 'kapee' ),
					   'desc' 				=> '',
					   'id' 				=> $prefix.'title_color',
					   'type'     			=> 'button_group',
					   'options'  			=> array(
							'default'	=> esc_html__( 'Default', 'kapee' ),
							'light'    	=> esc_html__( 'Light', 'kapee' ),
							'dark' 		=> esc_html__( 'Dark', 'kapee' ),
						),
						'inline'   		=> 	true,
						'multiple' 		=> 	false,
						'std' 			=> 'default',
					),
					array(
						'name'  			=> esc_html__( 'Background Image', 'kapee' ),
						'label_description' => esc_html__( 'Select a custom image for your main title.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_img',
						'type'  			=> 'single_image',
					),
					array(
						'name'  			=> esc_html__( 'Position', 'kapee' ),
						'label_description' => esc_html__( 'Select your background image position.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_position',
						'type'     			=> 'select',
						'options'  			=> array(
							'default'		=> esc_html__( 'Default', 'kapee' ),
							'left-top'      => esc_html__( 'Left Top', 'kapee' ),
							'left-center'   => esc_html__( 'Left Center', 'kapee' ),
							'left-bottom' 	=> esc_html__( 'Left Bottom', 'kapee' ),
							'right-top'		=> esc_html__( 'Right Top', 'kapee' ),
							'right-center'	=> esc_html__( 'Right Center', 'kapee' ),
							'right-bottom'	=> esc_html__( 'Right Bottom', 'kapee' ),
							'center-top'	=> esc_html__( 'Center Top', 'kapee' ),
							'center-center'	=> esc_html__( 'Center Center', 'kapee' ),
							'center-bottom'	=> esc_html__( 'Center Bottom', 'kapee' ),
						),
						'inline'   			=> 	true,
						'multiple' 			=> 	false,
						'std'				=>	'default',
					),
					array(
						'name'  			=> esc_html__( 'Attachment', 'kapee' ),
						'label_description' => esc_html__( 'Select your background image attachment.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_attachment',
						'type'     			=> 'select',
						'options'  			=> array(
							'default'	=> esc_html__( 'Default', 'kapee' ),
							'scroll'    => esc_html__( 'Scroll', 'kapee' ),
							'fixed' 	=> esc_html__( 'Fixed', 'kapee' ),
						),
						'inline'   			=> 	true,
						'multiple' 			=> 	false,
						'std'				=>	'default',
					),
					array(
						'name'  			=> esc_html__( 'Repeat', 'kapee' ),
						'label_description' => esc_html__( 'Select your background image repeat.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_repeat',
						'type'     			=> 'select',
						'options'  			=> array(
							'default'	=> esc_html__( 'Default', 'kapee' ),
							'no-repeat'	=> esc_html__( 'No-Repeat', 'kapee' ),
							'repeat'    => esc_html__( 'Repeat', 'kapee' ),
							'repeat-x'  => esc_html__( 'Repeat-X', 'kapee' ),
							'repeat-y' 	=> esc_html__( 'Repeat-Y', 'kapee' ),
							
						),
						'inline'   			=> 	true,
						'multiple' 			=> 	false,
						'std'				=>	'default',
					),
					array(
						'name'  			=> esc_html__( 'Size', 'kapee' ),
						'label_description' => esc_html__( 'Select your background image size.', 'kapee' ),
						'id'    			=> $prefix.'title_bg_size',
						'type'     			=> 'select',
						'options'  			=> array(
							'default'	=> esc_html__( 'Default', 'kapee' ),
							'auto'		=> esc_html__( 'Auto', 'kapee' ),
							'cover'     => esc_html__( 'Cover', 'kapee' ),
							'contain'   => esc_html__( 'contain', 'kapee' ),
							
						),
						'inline'   			=> 	true,
						'multiple' 			=> 	false,
						'std'				=>	'default',
					),
					array(
						'name' 				=> esc_html__( 'Background Opacity', 'kapee' ),
						'label_description' => esc_html__( 'Enter a number between 0.1 to 1. Default is 0.5.', 'kapee' ),
						'desc' 				=> '',
						'id' 				=> $prefix . 'title_bg_opacity',
						'type' 				=> 'number',
						'min'  				=> 0,
						'max'  				=> 1,
						'step' 				=> 0.1,
					),
					array(
						'type'     			=> 'button_group',
						'id'    			=> $prefix.'breadcrumb',
						'name'  			=> esc_html__( 'Show Breadcrubm', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable the page title breadcrumbs.', 'kapee' ),
						'options'  			=> array(
							'default'   => esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std' 				=> 'default',
					),	
				),
			);
			/* End Title Options */
			
			/* Footer Options */
			$meta_boxes[] = array(
				'title' 		=> esc_html__('Footer', 'kapee'),
				'id' 			=> $prefix .'footer_options',
				'post_types' 	=> array('post','page','portfolio','product'),
				'tab' 			=> true,
				'fields' 		=> 	array(
					array(
						'name'  			=> esc_html__( 'Footer', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable footer.', 'kapee' ),
						'id'    			=> $prefix . 'site_footer',
						'type'  			=> 'button_group',
						'options' 			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std'				=> 'default',
						'multiple' 			=> false,
					),
					array(
						'name'  			=> esc_html__( 'Copyright', 'kapee' ),
						'label_description' => esc_html__( 'Enable or disable copyright.', 'kapee' ),
						'id'    			=> $prefix.'footer_copyright',
						'type'  			=> 'button_group',
						'options' 			=> array(
							'default'	=> esc_html__('Default','kapee'),
							'enable' 	=> esc_html__('Enable','kapee'),
							'disable'  	=> esc_html__('Disable','kapee'),
						),
						'std'				=> 'default',
					),
				),
			);
			/* End Footer Options */
			
			return $meta_boxes;
			
		}
		public function register_metaboxes(){
			$meta_boxes = $this->kapee_meta_boxes();
			// Make sure there's no errors when the plugin is deactivated or during upgrade
			if (class_exists('RW_Meta_Box')) {
					foreach ($meta_boxes as $meta_box) {
							new RW_Meta_Box($meta_box);
					}
			}
		}
		public function kapee_admin_js_var(){
			$meta_boxes = $this->kapee_meta_boxes();
			$meta_box_id = '';
			foreach ($meta_boxes as $box) {
				if (!isset($box['tab'])) {
					continue;
				}
				if (!empty($meta_box_id)) {
					$meta_box_id .= ',';
				}
				$meta_box_id .= '#' . $box['id'];
			}
			$kapee_option_string = esc_html__('Kapee Options','kapee');
			wp_enqueue_script( 'kapee-meta-box', KAPEE_FRAMEWORK_URI . '/admin/assets/js/meta-box.js');
			wp_localize_script( 'kapee-meta-box' , 'kp_meta_box_ids' , array( $meta_box_id ) );
			wp_localize_script( 'kapee-meta-box' , 'kp_meta_box_title' , array( $kapee_option_string ) );
		}		
	}

	/**
	 * Initialize class object with 'get_instance()' method
	 */
	Kapee_Metabox::get_instance();

endif;