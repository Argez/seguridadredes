<?php
/**
 * Kapee Theme Options
 */
	
if ( ! class_exists( 'Redux' ) ) {
	return;
}

    $opt_name = "kapee_options";

    /*SET ARGUMENTS */

    $theme = wp_get_theme('kapee'); // For use with some settings. Not necessary.
	$theme_slug = '';
	if( is_customize_preview() ){
		$theme_slug = ' ('.$theme.')';
	}
    $args = array(
        'opt_name'             		=> $opt_name,
        'display_name'         		=> $theme->get( 'Name' ),
        'display_version'      		=> $theme->get( 'Version' ),
        'menu_type'            		=> 'submenu',
        'allow_sub_menu'       		=> true,
        'menu_title'           		=> esc_html__( 'Theme Options', 'kapee' ),
        'page_title'           		=> esc_html__( 'Theme Options', 'kapee' ),
        'google_api_key'       		=> '',
        'google_update_weekly' 		=> false,
        'async_typography'     		=> false,
        'global_variable'      		=> '',
        'dev_mode'             		=> false,
        'customizer'          		=> true,
        'page_priority'       		=> null,
        'page_parent'          		=> 'kapee-theme',
        'page_permissions'     		=> 'manage_options',
        'menu_icon'            		=> '',
        'page_icon'            		=> 'icon-themes',
        'page_slug'            		=> 'kapee-theme-option',
        'save_defaults'        		=> true,
        'default_show'         		=> false,
        'default_mark'         		=> '',
        'show_import_export'   		=> true,
        'transient_time'       		=> 60 * MINUTE_IN_SECONDS,
        'output'               		=> true,
        'output_tag'           		=> true,
		'footer_credit'             => ' ',
		
    );
	
    Redux::setArgs( $opt_name, $args );

    /* END ARGUMENTS */

	
    /* START SECTIONS  */

    // -> START Basic Fields
	
	/*
	* General
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'General', 'kapee' ),
        'id'         => 'general-options',
		'icon'		 => 'el el-home',
        'fields'     => array(	
			array(
                'id'       		=> 'theme-layout',
                'type'     		=> 'image_select',
                'title'    		=> esc_html__( 'Theme Layout', 'kapee' ),
				'subtitle' 		=> esc_html__( 'Select layout of site.', 'kapee' ),
                'options'  		=> array(
					'wide' => array(
                        'title' 	=> esc_html__('Wide', 'kapee' ),
                        'alt' 		=> esc_html__('Wide', 'kapee' ),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/wide.png',
                    ),  
					'full' => array(
                        'title' 	=> esc_html__('Full', 'kapee' ),
                        'alt' 		=> esc_html__('Full', 'kapee' ),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/full.png',
                    ),                   
                    'boxed' => array(
                        'title' 	=>  esc_html__('Boxed', 'kapee' ),
                        'alt' 		=>  esc_html__('Boxed', 'kapee' ),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/box.png',
                    ),
                ),
                'default'  		=> 'full',
            ),
			array(
                'id'            	=> 'theme-container-width',
                'type'          	=> 'slider',
                'title'         	=> esc_html__('Container Width (px)','kapee'),
				'subtitle'          => esc_html__('Theme Container width in pixels','kapee'),
                'default'       	=> 1200,
                'min'           	=> 1025,
                'step'          	=> 1,
                'max'           	=> 1920,
				'required' 			=> array( 'theme-layout', '=', array( 'full', 'boxed' ) ),
            ),
			array(
                'id'       			=> 'header-logo',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Logo', 'kapee' ),
				'subtitle'          => esc_html__('Upload header logo.','kapee'),
                'compiler' 			=> 'true',
                'default'  			=> array(),
			),
			array(
                'id'       			=> 'header-logo-light',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Logo Light Version', 'kapee' ),
				'subtitle'          => esc_html__('Upload an alternative light logo that will be used on dark and transparent header.','kapee'),
                'compiler' 			=> 'true',
               'default'  			=> array(),
			),
			array(
                'id'            	=> 'header-logo-width',
                'type'          	=> 'slider',
                'title'         	=> esc_html__('Logo Width','kapee'),
				'subtitle'          	=> esc_html__('Logo width in pixels','kapee'),
                'default'       	=> 126,
                'min'           	=> 50,
                'step'          	=> 1,
                'max'           	=> 500,
                'display_value' 	=> 'text',
            ),
			array(
                'id'      			=> 'sticky-header-logo',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Sticky Header Logo', 'kapee' ),
				'subtitle'          => esc_html__('Upload sticky header logo','kapee'),
                'compiler' 			=> 'true',
				'default'  			=> array(),
			),
			array(
                'id'            	=> 'sticky-header-logo-width',
                'type'          	=> 'slider',
                'title'         	=> esc_html__('Sticky Header Logo Width','kapee'),				
				'subtitle'          => esc_html__('Logo max width in pixels','kapee'),
                'default'       	=> 98,
                'min'           	=> 50,
                'step'          	=> 1,
                'max'           	=> 500,
                'display_value' 	=> 'text',
            ),
			array(
                'id'      			=> 'mobile-header-logo',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Mobile Header Logo', 'kapee' ),
				'subtitle'          => esc_html__('Upload mobile header logo','kapee'),
                'compiler' 			=> 'true',
				'default'  			=> array(),
			),
			array(
                'id'            	=> 'mobile-header-logo-width',
                'type'          	=> 'slider',
                'title'         	=> esc_html__('Mobile Header Logo Width','kapee'),				
				'subtitle'          => esc_html__('Logo max width in pixels','kapee'),
                'default'       	=> 90,
                'min'           	=> 40,
                'step'          	=> 1,
                'max'           	=> 500,
                'display_value' 	=> 'text',
            ),	
			array(
                'id'       			=> 'theme-favicon',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Favicon', 'kapee' ),
				'subtitle'     		=> esc_html__('Upload favicon.Optimal dimension: 32px x 32px','kapee'),
                'compiler' 			=> 'true',
                'default'  			=> array(),
			),
			array(
                'id'       			=> 'theme-favicon-appple-touch',
                'type'     			=> 'media',
                'url'      			=> false,
                'title'    			=> esc_html__( 'Apple Touch Icon', 'kapee' ),
				'subtitle'     		=> esc_html__('The Apple Touch Icon is a file used for a web page icon on the Apple iPhone, iPod Touch, and iPad. When someone bookmarks your web page or adds your web page to their home screen this icon is used.Optimal dimension: 152px x 152px','kapee'),
                'compiler' 			=> 'true',
				'default'  			=> array(),
			),
		),
	) );
	
	/*
	* Skeleton Options
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Skeleton Effect', 'kapee' ),
        'id'         		=> 'section-skeleton',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'skeleton-effect',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Skeleton Effect', 'kapee' ),
				'subtitle'		=> esc_html__('Enable/Disable skeleton effect. Note: Please disable it, If third part plugin caues any issue.', 'kapee' ),
                'default'  		=> 0,
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
            )
		)
	) );
	
	/**
	* Site Preloader
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Site Preloader', 'kapee' ),
        'id'         		=> 'section-site-preloader',
		'subsection'		=> true,
        'fields'     => array(
			array(
                'id'       		=> 'site-preloader',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Site Preloader', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Enable/disable preloader on your website', 'kapee' ),
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
                'default'  		=> 0,
            ),
			array(
                'id'       		=> 'preloader-background',
                'type'    => 'color',
				'title'   => esc_html__('Preloader Background', 'kapee' ),
				'subtitle'=> esc_html__('Set preloader background color.', 'kapee' ),				
				'transparent'=> false,
				'default'    => '#2370f4',
				'required' => array( 'site-preloader', '=', 1 ),
            ),
			array(
				'id'      => 'preloader-image',
				'type'    => 'button_set',
				'title'   => esc_html__('Preloader Image', 'kapee' ),
				'subtitle'=> esc_html__('Set preloader type as per your need.', 'kapee' ),
				'options' => array(
					'predefine-loader'=> esc_html__('Predefined Loader', 'kapee' ),
					'custom'          => esc_html__('Custom', 'kapee' ),
				),
				'default' => 'predefine-loader',
				'required' => array( 'site-preloader', '=', 1 ),
			),
			array(
                'id'       => 'predefine-loader-style',
                'type'     => 'select',
				'title'   => esc_html__('Choose Preloader Style', 'kapee' ),
				'subtitle'=> esc_html__('Set preloader type as per your need.', 'kapee' ),
                'options'  => array(
                    '1' => 'Style 1',
                    '2' => 'Style 2',
                    '3' => 'Style 3',
                    '4' => 'Style 4',
                    '5' => 'Style 5',
                ),
                'default'  => '1',
				'required' => array( 'site-preloader', '=', 1 ),
            ),
			array(
				'id'      		=> 'preloader-custom-image',
				'type'    		=> 'media',
				'url'     		=> false,
				'title'   		=> esc_html__('Upload Preloader Image', 'kapee' ),   
				'subtitle'		=> esc_html__('Upload preloader image.', 'kapee' ),
				'library_filter'=> array('gif','jpg','jpeg','png'),
				'required'      => array( 'preloader-image', '=', 'custom' ),
			),
		)
	) );
	
	/*
	* Back to top options
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Back To Top Button', 'kapee' ),
        'id'         		=> 'section-back-to-top',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'back-to-top',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Button', 'kapee' ),
				'subtitle'		=> esc_html__('Enable/disable back to top button.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
            ),
			array(
                'id'       		=> 'back-to-top-mobile',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Button In Mobile', 'kapee' ),
				'subtitle'		=> esc_html__('Enable/disable back to top button in mobile device.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
            ),
		)
	) );	
	
	/*
	* Promo Bar
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Promo Bar', 'kapee' ),
        'id'         		=> 'section-promo-bar',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'promo-bar',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Promo Bar', 'kapee' ),
				'subtitle'		=> esc_html__('Enable/disable promo bar.', 'kapee' ),
                'default'  		=> 0,
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
			),			
			array(
                'id'            	=> 'promo-bar-height',
                'type'          	=> 'slider',
                'title'         	=> esc_html__('Height','kapee'),
				'subtitle'          	=> esc_html__('Promo bar height in pixels.','kapee'),
                'default'       	=> 60,
                'min'           	=> 10,
                'step'          	=> 1,
                'max'           	=> 500,
                'display_value' 	=> 'text',
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-position',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Position', 'kapee' ),
                'subtitle' => esc_html__( 'Select location for promo bar.', 'kapee' ),
                'options'  => array(
                    'top' 		=> esc_html__('Top', 'kapee'),
                    'bottom' 	=> esc_html__('Bottom', 'kapee'),
                ),
                'default'  => 'top',
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-position-type',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Position Type', 'kapee' ),
                'subtitle' => esc_html__( 'Select position type for promo bar.', 'kapee' ),
                'options'  => array(
                    'absolute' 	=> esc_html__( 'Absolute', 'kapee' ),
                    'fixed' 	=> esc_html__( 'Fixed', 'kapee' ),
                ),
                'default'  => 'absolute',
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-message-text',
                'type'     => 'editor',
                'title'    => esc_html__('Message','kapee'),
				'subtitle' => esc_html__('Enter promo message.','kapee'),
				'default'  => esc_html__('SUMMER SALE, Get 40% Off for all products.','kapee'),
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-link-btn',
                'type'     => 'switch',
                'title'    => esc_html__('Button','kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Enable link button in promo bar.','kapee'),
				'default'  => 1,
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-link-btn-text',
                'type'     => 'text',
                'title'    =>  esc_html__('Button Text','kapee'),
                'subtitle' => esc_html__('The text of the more info button.','kapee'),
				'default'  => esc_html__('Click Here','kapee'),
				'required' => array( 'promo-bar-link-btn', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-link-btn-url',
                'type'     => 'text',
                'title'    => esc_html__('Enter Url','kapee'),
                'subtitle' => esc_html__('The text of the more info button.','kapee'),
				'default'  => '#',
				'required' => array( 'promo-bar-link-btn', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-link-open-new-tab',
                'type'     => 'switch',
                'title'    => esc_html__( 'Open link in New Tab', 'kapee' ),
                'subtitle' => esc_html__( 'Select the link target for more info page.', 'kapee' ),
				'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
                'default'  => 1,
				'required' => array( 'promo-bar-link-btn', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-close-btn',
                'type'     => 'switch',
                'title'    => esc_html__('Close Button','kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Enable close button.','kapee'),
				'default'  => 1,
				'required' => array( 'promo-bar', '=', 1 ),
            ),
			array(
                'id'       => 'promo-bar-dismiss',
                'type'     => 'switch',
                'title'    => esc_html__('Promo Bar Dismissing','kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Enable/Disable promo bar dismissing on button close.','kapee'),
				'default'  => 0,
				'required' => array( 'promo-bar-close-btn', '=', 1 ),
            ),
			array(
                'id'    => 'promo-notice1',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Promo Bar Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'promo-bar-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__( 'Background', 'kapee' ),
				'subtitle' 		=> esc_html__( 'Promo bar background image or color', 'kapee'),
				'output' 		=> array('body .kapee-promo-bar'),
				'default'  		=> array(
					'background-color'	 	=> '#191919',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'promo-button-text-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Text Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Set button text color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#fcfcfc',
                )
            ),
			array(
                'id'       		=> 'promo-button-background',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Background Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Set button background color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#2370F4',
                    'hover'   	=> '#337af4',
                )
            ),
			array(
				'id'          		=> 'promo-bar-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__( 'Promo Bar Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__( 'These settings control the typography for promo bar.', 'kapee' ),
				'output' 			=> array('.promo-bar-msg, .promo-bar-close'),
				'default'     		=> array(
					'color'       		=> '#ffffff', 
					'font-weight'  		=> '400', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '14px', 
					'letter-spacing'	=> '',
				),
			),
		)
	) );
	
	/*
	* Lazyload Options
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Lazy Load Images', 'kapee' ),
        'id'         		=> 'section-lazy-load',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'lazy-load',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Lazy Load Images', 'kapee' ),
				'subtitle'		=> esc_html__('Enables lazy load to reduce page requests.', 'kapee' ),
                'on'       		=> esc_html__('Enable','kapee'),
                'off'      		=> esc_html__('Disable','kapee'),
                'default'  		=> 0,
            ),
		)
	) );
	
	/*
	* Google Map API
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Google Map API', 'kapee' ),
        'id'         		=> 'section-google-map-api',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'   				=> 'google-map-api',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'API Key', 'kapee' ),
				'subtitle'			=> wp_kses( __('You should create an API for yourself and put code here. read below link to more info: <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.', 'kapee'), array( 'a' => array( 'href' => true, 'target' => true, ), 'br' => array(), 'strong' => array() ) ),
				'default'  			=> '',
            ),
		),
	) );
	
	/*
	* Mobile
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Mobile', 'kapee' ),
        'id'         => 'section-mobile',
		'icon'		 => 'el el-iphone-home',
        'fields'     => array(			
			array(
                'id'       			=> 'header-mobile-search',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Ajax Search', 'kapee' ),
                'subtitle' 			=> esc_html__( 'Show ajax search in mobile header.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'mobile-categories-menu',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Categories Menu', 'kapee' ),
                'subtitle' 			=> esc_html__( 'Show categories menu in mobile.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'mobile-menu-header-login-register',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Login/Register','kapee'),
                'subtitle' 			=> esc_html__('Show login/register on mobile menu header.', 'kapee' ),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),			
			/* array(
                'id'       		=> 'products-view-mode-mobile',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Product View Mode', 'kapee' ),
                'subtitle'      => esc_html__('Select product view mode in mobile layout.', 'kapee' ),
                'options'  		=> array(
                    'grid-view'		=> esc_html__('Grid', 'kapee' ),
                    'list-view' 	=> esc_html__('List', 'kapee' ),
                ),
                'default'  		=> 'grid-view',
            ), */
			array(
                'id'       			=> 'mobile-menu-social-profile',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Social Profile', 'kapee' ),
                'subtitle' 			=> esc_html__( 'Show social profile in mobile menu.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'product-hover-mobile',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Product Hover', 'kapee' ),
                'subtitle' 			=> esc_html__( 'By default display product hover in mobile.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),
			array(
                'id'       		=> 'products-columns-mobile',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Product Columns On Mobile', 'kapee' ),
				'subtitle'      => esc_html__( 'How many product you want to show per row on mobile?', 'kapee' ),
                'options'  		=> array(
                    1		=> esc_html__('1', 'kapee' ),
                    2	 	=> esc_html__('2', 'kapee' ),
                ),
                'default'  		=> 2,
            ),
			array(
                'id'       			=> 'mobile-product-hover-image',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Hover Image In Mobile', 'kapee' ),
                'subtitle' 			=> esc_html__( 'Show product hover image in mobile layout.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),
		),
	) );
	
	/*
	* Mobile Navbar
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Footer Navbar', 'kapee' ),
        'id'         		=> 'section-mobile-navbar',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'mobile-bottom-navbar',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Mobile Bottom Navbar','kapee'),
				'subtitle'    	=> esc_html__( 'Show mobile bottom navbar in mobile device.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1
            ),
			array(
                'id'       		=> 'mobile-navbar-label',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Navbar Label','kapee'),
				'subtitle'    	=> esc_html__( 'Show navbar label.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'mobile-navbar-color',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Navbar Color', 'kapee' ),
				'subtitle' 		=> esc_html__( 'Select navbar color style.', 'kapee' ),
                'options'  		=> array(
					'light'	=> esc_html__( 'Light', 'kapee' ),
					'dark'	=> esc_html__( 'Dark', 'kapee' ),
				),
				'default'  		=> 'light',
            ),
			array(
                'id'       		=> 'mobile-product-page-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Page Button','kapee'),
				'subtitle'    	=> esc_html__( 'Enable/Disable Sticky Add to Cart/Buy Now button on single product page.', 'kapee' ),
                'on'       		=> esc_html__('Enable','kapee'),
				'off'      		=> esc_html__('Disable','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'mobile-cart-page-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Cart Page Button','kapee'),
				'subtitle'    	=> esc_html__( 'Enable/Disable Sticky Proceed To Checkout button on cart page.', 'kapee' ),
                'on'       		=> esc_html__('Enable','kapee'),
				'off'      		=> esc_html__('Disable','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'mobile-checkout-page-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Checkout Page Button','kapee'),
				'subtitle'    	=> esc_html__( 'Enable/Disable Sticky Place Order button on checkout page.', 'kapee' ),
                'on'       		=> esc_html__('Enable','kapee'),
				'off'      		=> esc_html__('Disable','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       	=> 'mobile-navbar-elements',
                'type'     	=> 'sorter',
                'title'    	=> esc_html__( 'Navbar Elements', 'kapee' ),
                'compiler' 	=> 'true',
                'options'  	=> array(
                    'enabled'  => array(
						'shop'  		=> esc_html__( 'Shop', 'kapee' ),
						'sidebar'  		=> esc_html__( 'Sidebar/Filters', 'kapee' ),
						'wishlist' 		=> esc_html__( 'Wishlist', 'kapee' ),
						'cart'     		=> esc_html__( 'Cart', 'kapee' ),
						'account'  		=> esc_html__( 'Account', 'kapee' ),
                    ),
                    'disabled' => array(						
                        'home'     		=> esc_html__( 'Home', 'kapee' ),
						'menu'  		=> esc_html__( 'Menu', 'kapee' ),
						'compare'  		=> esc_html__( 'Compare', 'kapee' ),
						'order'			=> esc_html__( 'Order', 'kapee' ),
						'order-tracking'=> esc_html__( 'Order Tracking', 'kapee' ),
						'blog'  		=> esc_html__( 'Blog', 'kapee' ),
						'custom_link1'  => esc_html__( 'Custom Link 1', 'kapee' ),
						'custom_link2'  => esc_html__( 'Custom Link 2', 'kapee' ),
						'custom_link3'  => esc_html__( 'Custom Link 3', 'kapee' ),
					),
                ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-shop',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Shop Label','kapee'),
                'subtitle'     		=> esc_html__('Enter shop navbar label','kapee'),
				'default'  			=> esc_html__( 'Shop', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-shop',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Shop Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-home','kapee'),
				'default'  			=> esc_html__( 'pls-home', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-wishlist',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Wishlist Label','kapee'),
                'subtitle'     		=> esc_html__('Enter wishlist navbar label','kapee'),
				'default'  			=> esc_html__( 'Wishlist', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-wishlist',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Wishlist Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-heart','kapee'),
				'default'  			=> esc_html__( 'pls-heart', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-cart',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Cart Label','kapee'),
                'subtitle'     		=> esc_html__('Enter cart navbar label','kapee'),
				'default'  			=> esc_html__( 'Cart', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-cart',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Cart Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-handbag','kapee'),
				'default'  			=> esc_html__( 'pls-handbag', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-account',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Account Label','kapee'),
                'subtitle'     		=> esc_html__('Enter account navbar label','kapee'),
				'default'  			=> esc_html__( 'Account', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-account',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Account Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-user','kapee'),
				'default'  			=> esc_html__( 'pls-user', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-home',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Home Label','kapee'),
                'subtitle'     		=> esc_html__('Enter home navbar label','kapee'),
				'default'  			=> esc_html__( 'Home', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-home',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Home Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-home','kapee'),
				'default'  			=> esc_html__( 'pls-home', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-menu',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Menu Label','kapee'),
                'subtitle'     		=> esc_html__('Enter menu navbar label','kapee'),
				'default'  			=> esc_html__( 'Menu', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-menu',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Menu Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-menu','kapee'),
				'default'  			=> esc_html__( 'pls-menu', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-compare',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Compare Label','kapee'),
                'subtitle'     		=> esc_html__('Enter compare navbar label','kapee'),
				'default'  			=> esc_html__( 'Compare', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-compare',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Compare Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-shuffle','kapee'),
				'default'  			=> esc_html__( 'pls-shuffle', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-filter',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Filter Label','kapee'),
                'subtitle'     		=> esc_html__('Enter filter navbar label','kapee'),
				'default'  			=> esc_html__( 'Filters', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-filter',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Filter Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-equalizer','kapee'),
				'default'  			=> esc_html__( 'pls-equalizer', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-order',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Order Label','kapee'),
                'subtitle'     		=> esc_html__('Enter order navbar label','kapee'),
				'default'  			=> esc_html__( 'Order', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-order',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Order Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-letter','kapee'),
				'default'  			=> esc_html__( 'pls-letter', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-order-tracking',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Order Tracking Label','kapee'),
                'subtitle'     		=> esc_html__('Enter order tracking navbar label','kapee'),
				'default'  			=> esc_html__( 'Order Tracking', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-order-tracking',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Order Tracking Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-plane','kapee'),
				'default'  			=> esc_html__( 'pls-plane', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-sidebar',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Sidebar Label','kapee'),
                'subtitle'     		=> esc_html__('Enter sidebar navbar label','kapee'),
				'default'  			=> esc_html__( 'Sidebar', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-sidebar',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Sidebar Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-sidebar','kapee'),
				'default'  			=> esc_html__( 'pls-sidebar', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-blog',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Blog Label','kapee'),
                'subtitle'     		=> esc_html__('Enter blog navbar label','kapee'),
				'default'  			=> esc_html__( 'Blog', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-label-icon-blog',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Blog Label Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class. Ex. pls-note','kapee'),
				'default'  			=> esc_html__( 'pls-note', 'kapee' ),
            ),
			array(
                'id'    => 'custom-link-options',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Custom Links', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link1-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 1 Label','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 1 label.','kapee'),
				'default'  			=> esc_html__( 'Custom 1', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link1-icon',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 1 Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class.','kapee'),
				'default'  			=> 'pls-home',
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link1-url',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 1 URL','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 1 url.','kapee'),
				'default'  			=> '#',
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link2-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 2 Label','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 2 label.','kapee'),
				'default'  			=> esc_html__( 'Custom 2', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link2-icon',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 2 Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class.','kapee'),
				'default'  			=> 'pls-home',
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link2-url',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 2 URL','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 2 url.','kapee'),
				'default'  			=> '#',
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link3-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 3 Label','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 3 label.','kapee'),
				'default'  			=> esc_html__( 'Custom 3', 'kapee' ),
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link3-icon',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 3 Icon','kapee'),
                'subtitle'     		=> esc_html__('Enter pls font icon class.','kapee'),
				'default'  			=> 'pls-home',
            ),
			array(
                'id'       			=> 'mobile-navbar-custom-link3-url',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Custom Link 3 URL','kapee'),
                'subtitle'     		=> esc_html__('Enter custom link 3 url.','kapee'),
				'default'  			=> '#',
            ),
		)
	) );
	
	/*
	* Mobile colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Colors', 'kapee' ),
        'id'         	=> 'section-mobile-colors',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'    => 'header-mobile-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Mobile Header Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'header-mobile-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Background','kapee'),
				'subtitle' 		=> esc_html__('Mobile header background color', 'kapee'),
                'default'  		=> '#2370F4',
            ),	
			array(
                'id'       		=> 'header-mobile-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Mobile header text color', 'kapee'),
                'default'  		=> '#FFFFFF',
            ),			
			array(
                'id'       		=> 'header-mobile-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Mobile header link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#FFFFFF',
                    'hover'   	=> '#F1F1F1',
                )
            ),
			array(
                'id'       		=> 'header-mobile-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'header-mobile-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
			array(
				'id'       		=> 'google-theme-color',
				'type'     		=> 'color',
				'title'    		=> esc_html__( 'Google Theme Color', 'kapee' ), 				
				'subtitle'   		=> wp_kses( sprintf( __( 'Applied only on mobile devices Android on chrome browser toolbar, <a href="%s" target="_blank">click here</a> plugin.', 'kapee' ), esc_url( 'http://updates.html5rocks.com/2014/11/Support-for-theme-color-in-Chrome-39-for-Android/' ) ),
				array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),
				'validate' 		=> 'color',
				'default'  		=> '#2370F4'
			),			
		),
	) );
	
	/*
	* Theme Typography
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Typography', 'kapee' ),
        'id'         => 'section-typography',
		'icon'		 => 'el el-font',
        'fields'     => array(
			array(
				'id'          		=> 'body-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('Body Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'color'  			=> false,
				'letter-spacing' 	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all body text.', 'kapee'),
				'output' 			=> array('body'),
				'default'     		=> array(
					'font-weight'  		=> '400', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '14px',
					'letter-spacing'	=> '',
				),
			),
			array(
				'id'          		=> 'paragraph-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('(P)Paragraph Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'color'  			=> false,
				'letter-spacing' 	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all (P) Paragraph.', 'kapee'),
				'output' 			=> array('p'),
				'default'     		=> array(
					'font-weight'  		=> '400', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '14px', 
					'letter-spacing'	=> '',
				),
			),			
			array(
				'id'          		=> 'h1-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H1 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H1 Headings.', 'kapee'),
				'output' 			=> array('h1, .h1'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '28px',
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'h2-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H2 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H2 Headings.', 'kapee'),
				'output' 			=> array('h2, .h2'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '26px',
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'h3-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H3 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H3 Headings.', 'kapee'),
				'output' 			=> array('h3, .h3'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '24px',
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'h4-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H4 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H4 Headings.', 'kapee'),
				'output' 			=> array('h4, .h4'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '20px',
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'h5-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H5 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H5 Headings.', 'kapee'),
				'output' 			=> array('h5, .h5'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '16px', 
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'h6-headings-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('H6 Headings Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for all H6 Headings.', 'kapee'),
				'output' 			=> array('h6, .h6'),
				'default'     		=> array(
					'color'       		=> '#333333', 
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '14px', 
					'letter-spacing'	=> '',
					'text-transform'	=> 'inherit'
				),
			),
			array(
				'id'          		=> 'main-menu-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('Main Menu Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'color'				=> false,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for header main navigation.', 'kapee'),
				'output' 			=> array('.main-navigation ul.menu > li > a'),
				'default'     		=> array(
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '13px', 
					'letter-spacing'	=> '.2px',
					'text-transform'	=> 'uppercase'
				),
			),
			array(
				'id'          		=> 'categories-menu-font',
				'type'        		=> 'typography',
				'title'       		=> esc_html__('Categories Menu Font', 'kapee'),
				'all_styles'  		=> true,
				'font-backup' 		=> true,
				'color'				=> false,
				'text-align'  		=> false,
				'line-height' 		=> false,
				'letter-spacing' 	=> true,
				'text-transform'	=> true,
				'units'       		=>'px',
				'subtitle'    		=> esc_html__('These settings control the typography for categories menu.', 'kapee'),
				'output' 			=> array('.categories-menu ul.menu > li > a'),
				'default'     		=> array(
					'font-weight'  		=> '700', 
					'font-family' 		=> 'Lato', 
					'google'      		=> true,
					'font-backup' 		=> 'Arial, Helvetica, sans-serif',
					'font-size'   		=> '14px', 
					'letter-spacing'	=> '.2px',
					'text-transform'	=> 'inherit'
				),
			),
		),
	) );
	
	/*
	* Custom Fonts
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Custom Fonts', 'kapee' ),
        'id'         	=> 'section-custom-font',
		'desc'  		=> esc_html__( 'After uploading your fonts,you will have to save Theme Settings and RELOAD this page , Then you should select font family (custom font family)from dropdown list in (Body/Paragraph/Headings/Navigation) Typography section.', 'kapee' ),
        'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'       			=> 'custom-font1',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Custom Font1','kapee'),
                'subtitle' 	   		=> esc_html__('Please enable this option to use Custom Font 1.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'type'      		=> 'text',
                'id'        		=> 'custom-font1-name',
                'title'     		=> esc_html__( 'Font1 Name', 'kapee' ),
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font1-woff',
                'title'     		=> esc_html__( 'Font1 (.woff)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font1-woff2',
                'title'     		=> esc_html__( 'Font1 (.woff2)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font1-ttf',
                'title'     		=> esc_html__( 'Font1 (.ttf)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font1-svg',
                'title'     		=> esc_html__( 'Font1 (.svg)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font1-eot',
                'title'     		=> esc_html__( 'Font1 (.eot)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font1', '=', '1' ),
            ),
			array(
                'id'       			=> 'custom-font2',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Custom Font2','kapee'),
                'subtitle' 	   		=> esc_html__('Please enable this option to use Custom Font 2.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'type'      		=> 'text',
                'id'        		=> 'custom-font2-name',
                'title'     		=> esc_html__( 'Font2 Name', 'kapee' ),
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font2-woff',
                'title'     		=> esc_html__( 'Font2 (.woff)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font2-woff2',
                'title'     		=> esc_html__( 'Font2 (.woff2)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font2-ttf',
                'title'     		=> esc_html__( 'Font2 (.ttf)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font2-svg',
                'title'     		=> esc_html__( 'Font2 (.svg)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font2-eot',
                'title'     		=> esc_html__( 'Font2 (.eot)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font2', '=', '1' ),
            ),
			array(
                'id'       			=> 'custom-font3',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Custom Font3','kapee'),
                'subtitle' 	   		=> esc_html__('Please enable this option to use Custom Font 3.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'type'      		=> 'text',
                'id'        		=> 'custom-font3-name',
                'title'     		=> esc_html__( 'Font3 Name', 'kapee' ),
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font3-woff',
                'title'     		=> esc_html__( 'Font3 (.woff)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font3-woff2',
                'title'     		=> esc_html__( 'Font3 (.woff2)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font3-ttf',
                'title'     		=> esc_html__( 'Font3 (.ttf)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font3-svg',
                'title'     		=> esc_html__( 'Font3 (.svg)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
			array(
                'type'      		=> 'media',
                'id'        		=> 'custom-font3-eot',
                'title'     		=> esc_html__( 'Font3 (.eot)', 'kapee' ),
                'mode'       		=> false,
                'preview'  			=> false,
                'url'       		=> true,
                'required'  		=> array( 'custom-font3', '=', '1' ),
            ),
		),
	) );
	
	/*
	* Typekit Font
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Adobe Typekit Font', 'kapee' ),
        'id'         	=> 'section-typekit-font',
        'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'       			=> 'typekit-font',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Adobe Typekit Font','kapee'),
                'subtitle' 	   		=> esc_html__('Please enable this option to use Adobe Typekit.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'id'   				=> 'typekit-kit-id',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Typekit Kit ID', 'kapee' ),
				'subtitle' 			=> esc_html__('Enter your ', 'kapee') . '<a target="_blank" href="https://typekit.com/account/kits">Typekit Kit ID</a>.',
				'required'  		=> array( 'typekit-font', '=', '1' ),
            ),
			array(
                'id'   				=> 'typekit-kit-family',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Typekit Font Family', 'kapee' ),
				'subtitle' 			=> esc_html__('Enter all custom fonts you will use separated with coma.', 'kapee'),
				'required'  		=> array( 'typekit-font', '=', '1' ),
            ),
		),
	) );
	
	/*
	* Theme Styling and colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Styling and Colors', 'kapee' ),
        'id'         	=> 'section-styling-colors',
		'icon'		 	=> 'el el-brush',
        'fields'     	=> array(			
		),
	) );
	
	/*
	* Body colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Body', 'kapee' ),
        'id'         	=> 'section-body-color',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
				'id'       		=> 'primary-color',
				'type'     		=> 'color',
				'title'    		=> esc_html__('Primary Color', 'kapee'),
				'validate' 		=> 'color',
				'default'  		=> '#2370F4'
			),
			array(
				'id'       		=> 'primary-inverse-color',
				'type'     		=> 'color',
				'title'    		=> esc_html__( 'Primary Inverse Color', 'kapee' ), 
				'validate' 		=> 'color',
				'default'  		=> '#ffffff'
			),
			array(
				'id'       		=> 'theme-hover-background-color',
				'type'     		=> 'color',
				'title'    		=> esc_html__( 'Hover Background Color', 'kapee' ), 
				'subtitle' 		=> esc_html__( 'Apply theme hover background color for ul li menu, list, etc....', 'kapee' ),
				'validate' 		=> 'color',
				'default'  		=> '#f5faff'
			),
			array (
				'id'       		=> 'site-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Body Background', 'kapee'),
				'subtitle' 		=> esc_html__('Body background image or color. Only for work in Boxed layout', 'kapee'),
				'output' 		=> array('body'),
				'default'  		=> array(
					'background-color'	 	=> '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array (
				'id'       		=> 'site-wrapper-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Wrapper Background', 'kapee'),
				'output' 		=> array('.site-wrapper'),
				'default'  		=> array(
					'background-color'	 	=> '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'site-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Site text color', 'kapee'),
                'default'  		=> '#555555',
            ),			
			array(
                'id'       		=> 'site-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Site link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'       		=> 'site-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Site border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'site-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'site-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),			
		),
	) );
	
	/*
	* Topbar colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Topbar', 'kapee' ),
        'id'         	=> 'section-topbar',
		'subsection'   	=> true,
        'fields'     	=> array(
			array (
				'id'       		=> 'topbar-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Topbar background image or color.', 'kapee'),
				'output' 		=> array('.header-topbar'),
				'default'  		=> array(
					'background-color'	 	=> '#2370F4',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'topbar-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Topbar text color', 'kapee'),
                'default'  		=> '#FFFFFF',
            ),			
			array(
                'id'       		=> 'topbar-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Topbar link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#FFFFFF',
                    'hover'   	=> '#F1F1F1',
                )
            ),
			array(
                'id'       		=> 'topbar-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Topbar border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#3885fe',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'topbar-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'topbar-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
			array(
                'id'          		=> 'topbar-max-height',
                'type'          	=> 'dimensions',
                'title'          	=> esc_html__( 'Max Height', 'kapee' ),
				'subtitle'    		=> esc_html__( 'Set max height for topbar.', 'kapee' ),
                'units_extended'	=> false,
                'width'        	 	=> false,
                'default'        	=> array(
                    'height' 		=> 42,
                )
            ),
		),
	) );
	
	/*
	* Header colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Header & Sticky', 'kapee' ),
        'id'         	=> 'section-header',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'    => 'header-notice1',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Header Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'header-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Header background image or color', 'kapee'),
				'output' 		=> array('.header-main'),
				'default'  		=> array(
					'background-color'	 	=> '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'header-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Header text color', 'kapee'),
                'default'  		=> '#555555',
            ),			
			array(
                'id'       		=> 'header-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Header link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370f4',
                )
            ),
			array(
                'id'       		=> 'header-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Header border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'header-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'header-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
			array(
                'id'          		=> 'header-min-height',
                'type'          	=> 'dimensions',
                'title'          	=> esc_html__( 'Min Height', 'kapee' ),
				'subtitle'    		=> esc_html__( 'Set min height for header.', 'kapee' ),
				'units_extended'	=> false,
                'width'        	 	=> false,
                'default'        	=> array(
                    'height' 		=> 100,
                )
            ),
			array(
                'id'    => 'header-notice2',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Header Transparent Colors', 'kapee' ),
            ),
			array(
                'id'       			=> 'header-transparent-color',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Header Transparent Color','kapee'),
                'subtitle' 	   		=> esc_html__('This color will work when header transparent/overlay enable.','kapee'),
                'options'  			=> array(
                    'light' 	=> esc_html__('Light', 'kapee' ),
                    'dark' 		=> esc_html__('Dark', 'kapee' ),
                ),
                'default'  			=> 'light',
            ),
			
			array(
                'id'    => 'header-notice3',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Header Sticky Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'header-sticky-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Header Sticky background image or color', 'kapee'),
				'output' 		=> array('.header-sticky'),
				'default'  		=> array(
					'background-color'	 => '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'header-sticky-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Header Sticky text color', 'kapee'),
                'default'  		=> '#555555',
            ),			
			array(
                'id'       		=> 'header-sticky-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Header Sticky link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370f4',
                )
            ),
			array(
                'id'       		=> 'header-sticky-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Header Sticky border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'header-sticky-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'header-sticky-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
		),
	) );
	
	/*
	* Navigation Bar Colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Navigation Bar', 'kapee' ),
        'id'         	=> 'section-navigation-bar',
		'subsection'   	=> true,
        'fields'     	=> array(			
			array (
				'id'       		=> 'navigation-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Navigation bar background image or color', 'kapee'),
				'output' 		=> array('.header-navigation'),
				'default'  		=> array(
					'background-color'	 => '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'navigation-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Navigation bar text color', 'kapee'),
                'default'  		=> '#555555',
            ),			
			array(
                'id'       		=> 'navigation-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Navigation bar link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'       		=> 'navigation-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Navigation bar border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'navigation-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'navigation-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
			array(
                'id'          		=> 'navigation-min-height',
                'type'          	=> 'dimensions',
                'title'          	=> esc_html__( 'Min Height', 'kapee' ),
				'subtitle'    		=> esc_html__( 'Set min height for navigation bar.', 'kapee' ),
                'units_extended'	=> false,
                'width'        	 	=> false,
                'default'        	=> array(
                    'height' 		=> 50,
                )
            ),
		),
	) );
	
	/*
	* Menu Colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Menu & Categories menu', 'kapee' ),
        'id'         	=> 'section-menu',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'    => 'frist-level-menu-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'First Level Menu Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'first-level-menu-background-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Hover Background Color','kapee'),
				'subtitle' 		=> esc_html__('First level menu hover background color', 'kapee'),
                'default'  		=> 'transparent',
            ),		
			array(
                'id'       		=> 'first-level-menu-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('First level menu link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'    => 'frist-level-sticky-menu-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'First Level Header Sticky Menu Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'first-level-sticky-menu-background-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Hover Background Color','kapee'),
				'subtitle' 		=> esc_html__('First level sticky header menu hover background color', 'kapee'),
                'validate' 		=> 'color',
                'default' 		=> 'transparent',
            ),		
			array(
                'id'       		=> 'first-level-sticky-menu-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('First level sticky header menu link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'    => 'categories-menu-title-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Categories Menu Title Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'categories-menu-title-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Background Color','kapee'),
				'subtitle' 		=> esc_html__('Categories menu title background color', 'kapee'),
                'validate' 		=> 'color',
                'default' 		=> '#2370F4',
            ),		
			array(
                'id'       		=> 'categories-menu-title-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Title Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Categories menu title color.','kapee'),
                'active'    	=> false,
                'default' 		=> '#ffffff',
            ),
			array(
                'id'    => 'categories-menu-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Categories Area & Menu Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'categories-menu-wrapper-background',
				'type'     		=> 'color',
				'title'    		=> esc_html__('Background Color', 'kapee'),
				'subtitle' 		=> esc_html__('Categories menu wrapper/area background color', 'kapee'),
				'default'  		=> '#ffffff',
			),
			array(
                'id'       		=> 'categories-menu-hover-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Hover Background Color','kapee'),
				'subtitle' 		=> esc_html__('Categories menu hover background color', 'kapee'),
                'validate' 		=> 'color',
                'default' 		=> '#f5faff',
            ),
			array(
                'id'       		=> 'categories-menu-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Categories menu link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'       		=> 'categories-menu-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Categories menu border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'    => 'menu-popup-notice',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Main & Categories menu Popup Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'popup-menu-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Popup menu background image or color', 'kapee'),
				'output' 		=> array('.kapee-navigation ul.menu ul.sub-menu, .kapee-navigation .kapee-megamenu-wrapper'),
				'default'  		=> array(
					'background-color'	 => '#ffffff',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'popup-menu-hover-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Hover Background Color','kapee'),
				'subtitle' 		=> esc_html__('Popup menu hover background color', 'kapee'),
                'validate' 		=> 'color',
                'default' 		=> '#f5faff',
            ),
			array(
                'id'       		=> 'popup-menu-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Popup menu text color', 'kapee'),
                'default'  		=> '#555555',
            ),			
			array(
                'id'       		=> 'popup-menu-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Popup menu link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#333333',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'       		=> 'popup-menu-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Popup menu border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#e9e9e9',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
		),
	) );
	
	/*
	* Page Title colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Page Title', 'kapee' ),
        'id'         	=> 'section-page-title',
		'subsection'   	=> true,
        'fields'     	=> array(			
			array (
				'id'       		=> 'page-title-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Page title background image or color', 'kapee'),
				'output' 		=> array('#page-title'),
				'default'  		=> array(
					'background-color'	 => '#f8f8f8',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> 'cover',
					'background-attachment' => '',
					'background-position' 	=> 'center center'
				),
			),
			array(
                'id'       			=> 'page-title-color',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Title Color','kapee'),
                'subtitle' 	   		=> esc_html__('Page title color.','kapee'),
                'options'  			=> array(
                    'default' 	=> esc_html__('Default', 'kapee' ),
                    'light' 	=> esc_html__('Light', 'kapee' ),
                    'dark' 		=> esc_html__('Dark', 'kapee' ),
                ),
                'default'  			=> 'dark',
            ),
			array(
                'id'       			=> 'page-title-size',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Title Size','kapee'),
                'subtitle' 	   		=> esc_html__('Page title size.','kapee'),
                'options'  			=> array(
                    'default' 		=> esc_html__('Default', 'kapee' ),
                    'small' 		=> esc_html__('Small', 'kapee' ),
                    'large' 		=> esc_html__('Large', 'kapee' ),
                ),
                'default'  			=> 'default',
            ),
			array(
				'id'             	=> 'page-title-padding',
				'type'           	=> 'spacing',
				'title'          	=> esc_html__('Padding', 'kapee'),
				'subtitle'       	=> esc_html__('Set top bottom padding for page title.', 'kapee'),
				'mode'           	=> 'padding',
				'units_extended' 	=> 'false',
				'left'        	 	=> false,
                'right'        	 	=> false,
				'default'            => array(
					'padding-top'     	=> '50', 
					'padding-bottom'  	=> '50',
					'units'          	=> 'px', 
				)
			)
		),
	) );
	
	/*
	* Footer colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Footer', 'kapee' ),
        'id'         	=> 'section-footer',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'    => 'footer-notice1',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Footer Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'footer-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Footer background image or color', 'kapee'),
				'output' 		=> array('.site-footer .footer-main'),
				'default'  		=> array(
					'background-color'	 => '#172337',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'footer-title-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Title Color','kapee'),
				'subtitle' 		=> esc_html__('Footer title color like widget, etc', 'kapee'),
                'default'  		=> '#ffffff',
            ),
			array(
                'id'       		=> 'footer-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Footer text color', 'kapee'),
                'default'  		=> '#f1f1f1',
            ),
			array(
                'id'       		=> 'footer-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Footer link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#f1f1f1',
                )
            ),
			array(
                'id'       		=> 'footer-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Footer border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#454d5e',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
			array(
                'id'       		=> 'footer-input-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Color', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set color input field like TextBox, Textarea, SelectBox, etc..', 'kapee'),
                'default'  		=> '#555555',
            ),
			array(
                'id'       		=> 'footer-input-background',
                'type'     		=> 'color',
                'title'    		=> esc_html__( 'Input Field Background', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Set background input field like TextBox, Textarea, SelectBox, etc..', 'kapee' ),
                'default'  		=> '#ffffff',
            ),
			array(
                'id'    => 'copyright-notice1',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Copyright Colors', 'kapee' ),
            ),
			array (
				'id'       		=> 'copyright-background',
				'type'     		=> 'background',
				'title'    		=> esc_html__('Background', 'kapee'),
				'subtitle' 		=> esc_html__('Copyright background image or color', 'kapee'),
				'output' 		=> array('.site-footer .footer-copyright'),
				'default'  		=> array(
					'background-color'	 => '#172337',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> ''
				),
			),
			array(
                'id'       		=> 'copyright-text-color',
                'type'     		=> 'color',
                'title'    		=> esc_html__('Text Color','kapee'),
				'subtitle' 		=> esc_html__('Copyright text color', 'kapee'),
                'default'  		=> '#f1f1f1',
            ),			
			array(
                'id'       		=> 'copyright-link-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Link Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Copyright link and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#f1f1f1',
                )
            ),
			array(
                'id'       		=> 'copyright-border',
                'type'     		=> 'border',
                'title'   	 	=> esc_html__( 'Border', 'kapee' ),
                'subtitle' 		=> esc_html__('Copyright border color, style and width.','kapee'),
                'default'  		=> array(
                    'border-color'  => '#454d5e',
                    'border-style'  => 'solid',
					'border-top'    => '1px',
					'border-right'  => '1px',
					'border-bottom' => '1px',
					'border-left'   => '1px'
                )
            ),
		),
	) );
	
	/*
	* Buttons colors
	*/
	Redux::setSection( $opt_name, array(
        'title'      	=> esc_html__( 'Buttons', 'kapee' ),
        'id'         	=> 'section-buttons',
		'subsection'   	=> true,
        'fields'     	=> array(
			array(
                'id'    => 'site-button-color-info',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Site Buttons Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'button-background',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Background', 'kapee' ),
                'subtitle' 		=> esc_html__('Set button background and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#2370F4',
                    'hover'   	=> '#2370F4',
                )
            ),
			array(
                'id'       		=> 'button-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Color', 'kapee' ),
                'subtitle' 		=> esc_html__( 'Set button text color and hover color.', 'kapee' ),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#fcfcfc',
                )
            ),
			array(
                'id'    => 'product-page-button-color-info',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Product Page Buttons Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'product-cart-button-background',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Add To Cart Background', 'kapee' ),
                'subtitle' 		=> esc_html__('Set add to cart button background and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ff9f00',
                    'hover'   	=> '#ff9f00',
                )
            ),
			array(
                'id'       		=> 'product-cart-button-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Add To Cart Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Set add to cart button text color and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#fcfcfc',
                )
            ),
			array(
                'id'       		=> 'buy-now-button-background',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Buy Now Background', 'kapee' ),
                'subtitle' 		=> esc_html__('Set buy now button background and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#FB641B',
                    'hover'   	=> '#FB641B',
                )
            ),
			array(
                'id'       		=> 'buy-now-button-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Buy Now Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Set buy now button text color and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#fcfcfc',
                )
            ),
			array(
                'id'    => 'checkout-button-color-info',
                'type'   => 'info',
                'notice' => false,
                'title' => esc_html__( 'Checkout Buttons Colors', 'kapee' ),
            ),
			array(
                'id'       		=> 'checkout-button-background',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Checkout & Place Order Background', 'kapee' ),
                'subtitle' 		=> esc_html__('Set checkout button background and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#FB641B',
                    'hover'   	=> '#FB641B',
                )
            ),
			array(
                'id'       		=> 'checkout-button-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Checkout & Place Order Color', 'kapee' ),
                'subtitle' 		=> esc_html__('Set checkout button text color and hover color.','kapee'),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#fcfcfc',
                )
            ),
			
		),
	) );
	
	/*
	* Header
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Header', 'kapee' ),
        'id'         => 'header',
		'icon'		 => 'el el-photo',
        'fields'     => array(						
			array(
                'id'   				=> 'header-phone-number',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Phone Number', 'kapee' ),
				'default'  			=> '+(123) 4567 890',
            ),			
			array(
                'id'   				=> 'header-email',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Email Address', 'kapee' ),
				'default'  			=> 'sales@kapee.com',
            ),
			array(
                'id'   				=> 'header-location',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Store Location', 'kapee' ),
				'default'  			=> '123 Street, New York, US',
            ),
			array(
                'id'   				=> 'header-welcome-message',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Welcome Message', 'kapee' ),
				'default'  			=> 'Welcome to Our Store!',
            ),
			array(
                'id'   				=> 'header-newsletter',
                'type'      		=> 'text',
                'title'     		=> esc_html__( 'Newsletter', 'kapee' ),
				'default'  			=> 'Newsletter',
            ),
			array(
                'id'       			=> 'header-language-switcher',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Language Switcher','kapee'),
                'subtitle' 			=> esc_html__('Show language switcher on header topbar or not.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-currency-switcher',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Currency Switcher','kapee'),
                'subtitle' 			=> esc_html__('Show currency switcher on header topbar or not.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'      			=> 'header-language-switcher-style',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__( 'Language Switcher Style', 'kapee' ),
				'subtitle'   		=> wp_kses( sprintf( __( 'This option will work if you have used <a href="%1$s" target="_blank">Polylang</a> Or <a href="%2$s" target="_blank">TranslatePress</a> plugin.', 'kapee' ), esc_url( 'https://wordpress.org/plugins/polylang/' ),esc_url( 'https://wordpress.org/plugins/translatepress-multilingual/' ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),
                'options'  			=> array(
					'dropdown'		=> esc_html__( 'Dropdown', 'kapee' ),
                    'horizontal' 	=> esc_html__( 'Horizontal List', 'kapee' ),
                ),
                'default'  			=> 'dropdown',
            ),
			array(
                'id'       			=> 'header-language-switcher-view',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__( 'Language Country', 'kapee' ),
				'subtitle'   		=> wp_kses( sprintf( __( 'This option will work if you have used <a href="%1$s" target="_blank">Polylang</a> Or <a href="%2$s" target="_blank">TranslatePress</a> plugin.', 'kapee' ), esc_url( 'https://wordpress.org/plugins/polylang/' ),esc_url( 'https://wordpress.org/plugins/translatepress-multilingual/' ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),
                'options'  			=> array(
					'both'		=> esc_html__( 'Flag & Name', 'kapee' ),
                    'name' 		=> esc_html__( 'Name', 'kapee' ),
                    'flag' 		=> esc_html__( 'Flag', 'kapee' ),
                ),
                'default'  			=> 'both',
            ),
			array(
                'id'       			=> 'header-login-register',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Login/Register','kapee'),
                'subtitle' 			=> esc_html__('Show login/register on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'login-register-popup',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Login/Register Popup','kapee'),
                'subtitle' 	   		=> esc_html__('Show header login/register popup.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-myaccount-style',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'My Account Style', 'kapee' ),
				'subtitle' 	   		=> esc_html__('Select myaccount style.','kapee'),
                'options'  			=> array(
					1 		=> array(
                        'alt' 	=> '1',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/myaccount/1.jpg'
                    ), 
					2 		=> array(
                        'alt' 	=> '2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/myaccount/2.jpg'
                    ),
 
                ),
                'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-cart',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Cart Icon','kapee'),
                'subtitle' 			=> esc_html__('Show cart icon on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-minicart-popup',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Mini Cart Popup','kapee'),
                'subtitle' 	   		=> esc_html__('Show header minicart popup.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-cart-style',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'Cart Style', 'kapee' ),
				'subtitle' 	   		=> esc_html__('Select cart style.','kapee'),
                'options'  			=> array( 
					1 		=> array(
                        'alt' 	=> '1',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/1.jpg'
                    ),
					2 		=> array(
                        'alt' 	=> '2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/2.jpg'
                    ), 
					3	=> array(
                        'alt' 	=> '3',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/3.jpg'
                    ),
                ),
                'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-cart-icon',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'Cart Icon', 'kapee' ),
				'subtitle' 	   		=> esc_html__('Select cart icon.','kapee'),
                'options'  			=> array(					
					'bag-icon' 		=> array(
                        'alt' 		=> 'Icon Bag',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/icon-1.jpg'
                    ),
					 'cart-icon'	=> array(
                        'alt' 		=> 'Icon Cart',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/icon-2.jpg'
                    ),
                    'bag-icon-2'	=> array(
                        'alt' 		=> 'Icon Bag 2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/cart/icon-3.jpg'
                    ),                   					
                ),
                'default'  			=> 'bag-icon',
            ),
			array(
                'id'       			=> 'header-wishlist',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Wishlist Icon','kapee'),
                'subtitle' 			=> esc_html__('Show wishlist icon on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-compare',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Compare Icon','kapee'),
                'subtitle' 			=> esc_html__('Show compare icon on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'categories-menu',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Categories Menu','kapee'),
                'subtitle' 			=> esc_html__('Show categories menu on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       => 'shop-by-categories-title',
                'type'     => 'text',
                'title'    => esc_html__('Shop By Categories Title','kapee'),
				'subtitle' => esc_html__('Enter shop by categories menu title.','kapee'),
				'default'  => 'Shop By Categories',
            ),
			array(
                'id'       => 'open-categories-menu',
                'type'     => 'switch',
                'title'    => esc_html__('Open Categories(Vertical) Menu In Front Page','kapee'),
                'subtitle' => esc_html__('Categories(Vertical) menu open in front page.On other page open with hover.','kapee'),
                'on'       => esc_html__('Open','kapee'),
				'off'      => esc_html__('Close','kapee'),
				'default'  => 0,
            ),
		),
	) );
	
	/*
	* Header Manager options
	*/
    Redux::setSection( $opt_name, array(
        'title'     	 	=> esc_html__( 'Header Manager', 'kapee' ),
        'id'         		=> 'header-manager',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       			=> 'header-topbar',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Topbar','kapee'),
                'subtitle' 	   		=> esc_html__('Enable/disable topbar.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-transparent',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Header Transparent','kapee'),
                'subtitle' 	   		=> esc_html__('Make the header transparent/overlay the content.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'header-transparent-on',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Header Transparent On','kapee'),
                'subtitle' 	   		=> esc_html__('Make the header transparent/overlay the content on front page or all pages.','kapee'),
                'options'  			=> array(
                    'front-page' 	=> esc_html__('Front Page', 'kapee' ),
                    'all-pages' 	=> esc_html__('All Pages', 'kapee' ),
                ),
                'default'  			=> 'front-page',
				'required' 			=> array( 'header-transparent', '=', 1 ),
            ),
			array(
                'id'       		=> 'header-select',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Select Header', 'kapee' ),
				//'desc'       	=> esc_html__( 'Show/hide specific meta.', 'kapee' ),
                'options'  		=> array(
                    'style' 	=> esc_html__('Header Style', 'kapee' ),
                    'builder' 	=> esc_html__('Header Builder', 'kapee' ),
                ),
                'default'  		=> 'style',
            ),
			array(
                'id'       			=> 'header-style',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'Header Style', 'kapee' ),
                'subtitle' 			=> esc_html__( 'Select a header style.', 'kapee' ),
				'full_width' 		=> true,
				'options'  			=> array(
					'1' => array( 'title' => '1', 'alt' => 'Header 1', 'img' => KAPEE_ADMIN_IMAGES.'header/header-1.png' ),
                    '2' => array( 'title' => '2', 'alt' => 'Header 2', 'img' => KAPEE_ADMIN_IMAGES.'header/header-2.png' ),
                    '3' => array( 'title' => '3', 'alt' => 'Header 3', 'img' => KAPEE_ADMIN_IMAGES.'header/header-3.png' ),
                    '4' => array( 'title' => '4', 'alt' => 'Header 4', 'img' => KAPEE_ADMIN_IMAGES.'header/header-4.png' ),
                    '5' => array( 'title' => '5', 'alt' => 'Header 5', 'img' => KAPEE_ADMIN_IMAGES.'header/header-5.png' ),
                    '6' => array( 'title' => '6', 'alt' => 'Header 6', 'img' => KAPEE_ADMIN_IMAGES.'header/header-6.png' ),
                    '7' => array( 'title' => '7', 'alt' => 'Header 7', 'img' => KAPEE_ADMIN_IMAGES.'header/header-7.png' ),
                ),
                'default'  			=> '1',				
				'required' 			=> array( 'header-select', '=', 'style' ),
            ),
			array(
                'id'    			=> 'header-topbar-info1',
                'type'  			=> 'info',
				'notice' 			=> false,
                'title' 			=> esc_html__( 'Header Topbar Manager', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),			
			array(
                'id'       			=> 'header-topbar-manager',
                'type'     			=> 'sorter',
                'title'    			=> esc_html__( 'Topbar Manager', 'kapee' ),
				'description'		=> esc_html__('Organize how you want the layout to appear on the header topbar', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                    'left'  	=> array(
						'language-switcher'	=> esc_html__( 'Language Switcher', 'kapee' ),
						'currency-switcher'	=> esc_html__( 'Currency Switcher', 'kapee' ),						
                    ),
					'right' 	=> array(
						'welcome-message'	=> esc_html__( 'Welcome Message', 'kapee' ),
						'topbar-menu'		=> esc_html__( 'Topbar Menu', 'kapee' ),
					),
					'disabled' 	=> array(						
                        'phone-number'		=> esc_html__( 'Phone Number', 'kapee' ),
						'email' 			=> esc_html__( 'Email', 'kapee' ),
						'social-profile'	=> esc_html__( 'Social Profile', 'kapee' ),
						'location'			=> esc_html__( 'Location', 'kapee' ),
						'newletter'			=> esc_html__( 'Newsletter', 'kapee' ),
						'min-search'		=> esc_html__( 'Mini Search', 'kapee' ),
						/* 'topbar-widget'		=> 'Widget', */
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-topbar-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Topbar Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '5',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'       			=> 'header-topbar-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Topbar Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '7',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'    			=> 'header-main-info1',
                'type'  			=> 'info',
				'notice' 			=> false,
                'title' 			=> esc_html__( 'Header Main Manager', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
                'id'       			=> 'header-main-manager',
                'type'     			=> 'sorter',
                'title'    			=> 'Header Main Manager',
				'subtitle'			=> esc_html__('Organize how you want the layout to appear on the header main', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                    'left'  	=> array(
                        'logo' 			=> esc_html__( 'Logo', 'kapee' ),
                    ),
                    'center' 	=> array(
						'ajax-search'	=> esc_html__( 'Ajax Search', 'kapee' ),
					),
					'right' 	=> array(
						'myaccount'			=> esc_html__( 'My Account', 'kapee' ),						
						'wishlist'			=> esc_html__( 'Wishlist', 'kapee' ),
						'cart'				=> esc_html__( 'Cart', 'kapee' ),						
					),
					'disabled' 	=> array(
						'primary-menu'		=> esc_html__( 'Primary Menu', 'kapee' ),
						'secondary-menu'	=> esc_html__( 'Secondary Menu', 'kapee' ),
						'min-search'		=> esc_html__( 'Mini Search', 'kapee' ),
						'compare'			=> esc_html__( 'Compare', 'kapee' ),
						'currency-switcher'	=> esc_html__( 'Currency Switcher', 'kapee' ),
						'language-switcher'	=> esc_html__( 'Language Switcher', 'kapee' ),
						'customer-support'	=> esc_html__( 'Customer Support', 'kapee' ),
						'custom-html'		=> esc_html__( 'Custom HTML', 'kapee' ),
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-main-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Main Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '3',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'       			=> 'header-main-center',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Main Center', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '6',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'       			=> 'header-main-align',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Alignment Center','kapee'),
                'subtitle' 	   		=> esc_html__('Alignment center for above section.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-main-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Main Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '3',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'      			=> 'header-main-custom-html',
				'type'    		 	=> 'editor',
                'title'    			=> esc_html__( 'Custom HTML', 'kapee' ),
				'default'  			=>'',
				'subtitle' 			=> esc_html__( 'Add your custom html here.', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'    			=> 'header-navigation-info1',
                'type'  			=> 'info',
				'notice' 			=> false,
                'title' 			=> esc_html__( 'Header Navigation Manager', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
                'id'       			=> 'header-navigation',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Header Navigation','kapee'),
                'subtitle' 	   		=> esc_html__('Enable/disable navigation.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 1,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
                'id'       			=> 'header-navigation-manager',
                'type'     			=> 'sorter',
                'title'    			=> esc_html__( 'Header Navigation Manager', 'kapee' ),
                'subtitle'			=> esc_html__('Organize how you want the layout to appear on the header navigation', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                   'left'  		=> array(
                       'category-menu'		=> esc_html__( 'Category Menu', 'kapee' ),
                    ),
                    'center' 	=> array(
						'primary-menu'			=> esc_html__( 'Primary Menu', 'kapee' ),
					),
					'right' 	=> array(
					),
					'disabled' => array(
						'secondary-menu'	=> esc_html__( 'Secondary Menu', 'kapee' ),	
						'ajax-search'		=> esc_html__( 'Ajax Search', 'kapee' ),
						'myaccount'			=> esc_html__( 'My Account', 'kapee' ),
						'cart'				=> esc_html__( 'Cart', 'kapee' ),					
						'wishlist'			=> esc_html__( 'Wishlist', 'kapee' ),
						'customer-support'	=> esc_html__( 'Customer Support', 'kapee' ),
						'custom-html'		=> esc_html__( 'Custom HTML', 'kapee' ),
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-navigation-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Navigation Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '3',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'       			=> 'header-navigation-center',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Navigation Center', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '9',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'       			=> 'header-navigation-align',
				'type'     			=> 'switch',
                'title'    			=> esc_html__('Alignment Center','kapee'),
                'subtitle' 	   		=> esc_html__('Alignment center for above section.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-navigation-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Navigation Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'      			=> 'header-navigation-custom-html',
				'type'    		 	=> 'editor',
                'title'    			=> esc_html__( 'Custom HTML', 'kapee' ),
				'default'  			=> '',
				'subtitle' 			=> esc_html__( 'Add your custom html here.', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
		)
	) );

	/*
	* Header Sticky Manager options
	*/
    Redux::setSection( $opt_name, array(
        'title'     	 	=> esc_html__( 'Header Sticky Manager', 'kapee' ),
        'id'         		=> 'header-sticky-manager',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       			=> 'sticky-header',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Sticky Header','kapee'),
                'subtitle' 	   		=> esc_html__('Enable sticky header on desktop or disable.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'sticky-header-scroll-up',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Sticky Header Scroll-up','kapee'),
                'subtitle' 	   		=> esc_html__('Enable sticky header on scroll up.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 1,
				'required' 			=> array( 'sticky-header', '=', 1 ),
            ),
			array(
                'id'       			=> 'header-sticky-manager',
                'type'     			=> 'sorter',
                'title'    			=> esc_html__( 'Header Sticky Manager', 'kapee' ),
				'subtitle'			=> esc_html__('Organize how you want the layout to appear on the header sticky', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                    'left'  	=> array(
                        'logo' 			=> esc_html__( 'Logo', 'kapee' ),
                    ),
                    'center' 	=> array(
						'primary-menu'		=> esc_html__( 'Primary Menu', 'kapee' ),
					),
					'right' 	=> array(
						'myaccount'		=> esc_html__( 'My Account', 'kapee' ),
						'cart'			=> esc_html__( 'Cart', 'kapee' ),						
					),
					'disabled' 	=> array(
                       'category-menu'		=> esc_html__( 'Category Menu', 'kapee' ),
						'ajax-search'		=> esc_html__( 'Ajax Search', 'kapee' ),
						'secondary-menu'	=> esc_html__( 'Secondary Menu', 'kapee' ),	
						'wishlist'			=> esc_html__( 'Wishlist', 'kapee' ),
						'min-search'		=> esc_html__( 'Mini Search', 'kapee' ),
						'currency-switcher'	=> esc_html__( 'Currency Switcher', 'kapee' ),
						'language-switcher'	=> esc_html__( 'Language Switcher', 'kapee' ),
						'customer-support'	=> esc_html__( 'Customer Support', 'kapee' ),
						'custom-html'		=> esc_html__( 'Custom HTML', 'kapee' ),
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-sticky-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Sticky Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '3',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'       			=> 'header-sticky-center',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Sticky Center', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '6',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'       			=> 'header-sticky-align',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Alignment Center','kapee'),
                'subtitle' 	   		=> esc_html__('Alignment center for above section.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-sticky-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Sticky Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '3',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'      			=> 'header-sticky-custom-html',
				'type'    		 	=> 'editor',
                'title'    			=> esc_html__( 'Custom HTML', 'kapee' ),
				'default'  			=> '',
				'subtitle' 			=> esc_html__( 'Add your custom html here.', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
		)
	) );
	
	/*
	* Header Mobile Manager options
	*/
    Redux::setSection( $opt_name, array(
        'title'     	 	=> esc_html__( 'Header Mobile Manager', 'kapee' ),
        'id'         		=> 'header-mobile',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'    			=> 'header-mobile-info',
                'type'  			=> 'info',
				'notice' 			=> false,
                'title' 			=> esc_html__( 'Header Mobile Manager', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),			
			array(
                'id'       			=> 'header-mobile-manager',
                'type'     			=> 'sorter',
                'title'    			=> esc_html__( 'Header Mobile Manager', 'kapee' ),
				'subtitle'			=> esc_html__('Organize how you want the layout to appear on the header mobile', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                    'left'  	=> array(
						'mobile-navbar'		=> esc_html__( 'Mobile Nav', 'kapee' ),
						'logo'				=> esc_html__( 'Logo', 'kapee' ),						
                    ),
					'center' 	=> array(
					),
					'right' 	=> array(
						'myaccount'			=> esc_html__( 'My Account', 'kapee' ),
						'cart'				=> esc_html__( 'Cart', 'kapee' ),
					),
					'disabled' 	=> array(						
                        'wishlist'			=> esc_html__( 'Wishlist', 'kapee' ),
						'min-search'		=> esc_html__( 'Mini Search', 'kapee' ),
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-mobile-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '6',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			
			array(
				'id'       			=> 'header-mobile-center',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Center', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'       			=> 'header-mobile-align',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Alignment Center','kapee'),
                'subtitle' 	   		=> esc_html__('Alignment center for above section.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-mobile-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '6',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'    			=> 'header-mobile-sticky-info',
                'type'  			=> 'info',
				'notice' 			=> false,
                'title' 			=> esc_html__( 'Header Mobile Sticky Manager', 'kapee' ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),			
			array(
                'id'       			=> 'sticky-header-tablet',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('On Tablet ( width < 992px )','kapee'),
                'subtitle' 	  		=> esc_html__('Enable sticky header on tablet width < 992px or disable.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'sticky-header-mobile',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('On Mobile ( width < 480px )','kapee'),
                'subtitle' 	 		=> esc_html__('Enable sticky header mobile width < 480px or disable.','kapee'),
                'on'       			=> esc_html__('Enable','kapee'),
				'off'      			=> esc_html__('Disable','kapee'),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'header-mobile-sticky-manager',
                'type'     			=> 'sorter',
                'title'    			=> esc_html__( 'Header Mobile Sticky Manager', 'kapee' ),
				'description'		=> esc_html__('Organize how you want the layout to appear on the header mobile sticky', 'kapee'),
				'full_width' 		=> true,
                'options'  			=> array(
                    'left'  	=> array(
						'mobile-navbar'		=> esc_html__( 'Mobile Nav', 'kapee' ),					
                    ),
                    'center' 	=> array(
						'ajax-search'		=> esc_html__( 'Ajax Search', 'kapee' ),
					),
					'right' 	=> array(
						'cart'				=> esc_html__( 'Cart', 'kapee' ),
					),
					'disabled' 	=> array(						
						'logo'				=> esc_html__( 'Logo', 'kapee' ),	
						'myaccount'			=> esc_html__( 'My Account', 'kapee' ),
                        'wishlist'			=> esc_html__( 'Wishlist', 'kapee' ),
						'min-search'		=> esc_html__( 'Mini Search', 'kapee' ),
					),
                ),
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-mobile-sticky-left',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Sticky Left', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '2',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
				'id'       			=> 'header-mobile-sticky-center',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Sticky Center', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '8',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
			array(
                'id'       			=> 'header-mobile-sticky-align',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Alignment Center','kapee'),
                'subtitle' 	   		=> esc_html__('Alignment center for above section.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
				'required' 			=> array( 'header-select', '=', 'builder' ),
            ),
			array(
				'id'       			=> 'header-mobile-sticky-right',
				'type'     			=> 'select',
				'title'    			=> esc_html__( 'Header Mobile Sticky Right', 'kapee' ),
				'options' 			=> array(
					'1'  => esc_html__( '1 column - 1/12', 'kapee' ),
					'2'  => esc_html__( '2 columns - 1/6', 'kapee' ),
					'3'  => esc_html__( '3 columns - 1/4', 'kapee' ),
					'4'  => esc_html__( '4 columns - 1/3', 'kapee' ),
					'5'  => esc_html__( '5 columns - 5/12', 'kapee' ),
					'6'  => esc_html__( '6 columns - 1/2', 'kapee' ),
					'7'  => esc_html__( '7 columns - 7/12', 'kapee' ),
					'8'  => esc_html__( '8 columns - 2/3', 'kapee' ),
					'9'  => esc_html__( '9 columns - 3/4', 'kapee' ),
					'10' => esc_html__( '10 columns - 5/6', 'kapee' ),
					'11' => esc_html__( '11 columns - 11/12)', 'kapee' ),
					'12' => esc_html__( '12 columns - 1/1', 'kapee' ),
				),
				'default'  			=> '2',
				'required' 			=> array( 'header-select', '=', 'builder' ),
			),
		)
	) );
	/*
	* Header Styles
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Ajax Search', 'kapee' ),
        'id'         		=> 'header-search-section',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       			=> 'header-search',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Header Search','kapee'),
                'subtitle' 			=> esc_html__('Show search bar on header.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-ajax-search-style',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'Ajax Search Style', 'kapee' ),
				'subtitle' 	   		=> esc_html__('Select ajax search box style.','kapee'),
                'options'  			=> array(
					'ajax-search-style-1' 	=> array(
                        'alt' 	=> '1',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/search/1.jpg'
                    ), 
					'ajax-search-style-2' 	=> array(
                        'alt' 	=> '2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/search/2.jpg'
                    ), 
					'ajax-search-style-3' 	=> array(
                        'alt' 	=> '2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/search/3.jpg'
                    ), 
					'ajax-search-style-4' 	=> array(
                        'alt' 	=> '2',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/search/4.jpg'
                    ), 
                ),
                'default'  			=> 'ajax-search-style-1',
            ),
			array(
                'id'       			=> 'ajax-search-shape',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__( 'Ajax Search Shape', 'kapee' ),
				'subtitle' 			=> esc_html__('Select ajax search box shape.','kapee'),
                'options'  			=> array(
                    'ajax-search-square'	=> esc_html__('Square', 'kapee' ),
                    'ajax-search-radius' 	=> esc_html__('Radius', 'kapee' ),
                ),
                'default'  			=> 'ajax-search-square',
            ),
			array(
                'id'       			=> 'search-content-type',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__( 'Search Content Type', 'kapee' ),
				'subtitle'     		=> esc_html__('Select content type you want to use in the search box.','kapee'),
                'options'  			=> array(
                    'all'			=> esc_html__('All', 'kapee' ),
                    'product' 		=> esc_html__('Product', 'kapee' ),
                    'post' 			=> esc_html__('Post', 'kapee' ),
                    'portfolio' 	=> esc_html__('Portfolio', 'kapee' ),
                ),
                'default'  			=> 'product',
            ),
			array(
                'id'       			=> 'product-ajax-search',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Product Live/Ajax Search', 'kapee' ),
                'subtitle' 			=> esc_html__( 'You want to product live/ajax search on header or not.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'categories-dropdow',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Categories Dropdown','kapee'),
                'subtitle' 			=> esc_html__('Show categories dropdow in search form.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'search-categories',
                'type'     			=> 'radio',
                'title'    			=> esc_html__('Search Categories Dropdown','kapee'),
                'subtitle'     		=> esc_html__('Display categories in search categories dropdow.','kapee'),
                'options'  			=> array(
					'all' 	 	=> esc_html__('Show All Categories','kapee'),
					'parent' 	=> esc_html__('Only Parent(top level) Categories','kapee'),
				),
				'default'  			=> 'all',
				'required' 			=> array( 'categories-dropdow', '=', 1 ),
            ),
			array(
                'id'       			=> 'categories-hierarchical',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Categories Hierarchical','kapee'),
                'subtitle' 	   		=> esc_html__('Show categories in hierarchical (Must be need to select above option Show All Categories).','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
				'required' 			=> array( 'search-categories', '=', 'all' )
            ),
			array(
                'id'       			=> 'search-placeholder-text',
                'type'     			=> 'text',
                'title'    			=> esc_html__('Search Palceholder Text','kapee' ),
                'subtitle'     		=> esc_html__('Enter search palceholder text','kapee' ),
				'default'  			=> 'Search for products, categories, brands, sku...',
            ),
			array(
                'id'       			=> 'header-search-image',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Search Image', 'kapee' ),
                'subtitle' 	   		=> esc_html__('Show product Image in search results.', 'kapee' ),
                'on'       			=> esc_html__('Yes', 'kapee' ),
				'off'      			=> esc_html__('No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-search-price',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Search Price', 'kapee' ),
                'subtitle' 	   		=> esc_html__('Show product price in search results.', 'kapee' ),
                'on'       			=> esc_html__('Yes', 'kapee' ),
				'off'      			=> esc_html__('No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'header-search-rating',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Search Rating', 'kapee' ),
                'subtitle' 	   		=> esc_html__('Show product raing in search results.', 'kapee' ),
                'on'       			=> esc_html__('Yes', 'kapee' ),
				'off'      			=> esc_html__('No', 'kapee' ),
				'default'  			=> 1,
            ),
			array(
                'id'       			=> 'search-trending',
                'type'     			=> 'switch',
                'title'    			=> esc_html__('Trending Search','kapee'),
                'subtitle' 	   		=> esc_html__('Enable trending search.It will show when focus on search box.','kapee'),
                'on'       			=> esc_html__('Yes','kapee'),
				'off'      			=> esc_html__('No','kapee'),
				'default'  			=> 0,
            ),
			array(
				'id'       			=> 'search-trending-categories',
				'type'     			=> 'select',
				'multi'    			=> true,
				'data' 	   			=> 'terms',
				/* 'args' 				=> array( 'taxonomies'=>'product_cat','args'=> array( 'hide_empty' => 1,'parent' => 0 ) ), */
				'args' 				=> array( 'taxonomies'=>'product_cat' ),
				'title'    			=> esc_html__('Trending Categories', 'kapee'),
				'subtitle'     		=> esc_html__( 'Select your trending search categories.', 'kapee' ),
				'placeholder' 		=> esc_attr__('Choose product categories','kapee'),
				'required' 			=> array( 'search-trending', '=', 1),
			),
		),
	) );

	/*
	* Page Title
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Page Title', 'kapee' ),
        'id'         => 'page-title',
		'icon'		 => 'el el-icon-website',
        'fields'     => array(
			array(
                'id'       		=> 'page-title-layout',
                'type'     		=> 'image_select',
                'title'    		=> esc_html__( 'Page Title Layout', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Select page title layout.Disable for hide title area', 'kapee' ),
                'options'  		=> array(
                    'left' => array(
                        'title' => 'Default',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/page-title-default.png',
                    ),
					'center' => array(
                        'title' => 'Centered',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/page-title-centered.png',
                    ),
					'disable' => array(
                        'title' => 'Disable',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/page-title-none.png',
                    )
                ),
                'default'  		=> 'center',
            ),
			array(
                'id'       		=> 'page-title',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Page Title', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show/Hide page title.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Show','kapee'),
                'off'      		=> esc_html__('Hide','kapee'),
            ),
			array(
                'id'       		=> 'page-breadcrumbs',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Breadcrumbs', 'kapee' ),
                'subtitle'    	=> esc_html__( 'Show/Hide the breadcrumbs.', 'kapee' ),
                'default'  		=> 1,
                'on'      		=> esc_html__('Show','kapee'),
                'off'      		=> esc_html__('Hide','kapee'),
            ),
			array(
                'id'       		=> 'breadcrumbs-delimiter',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Breadcrumbs Delimiter', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Select breadcrumb seperator', 'kapee' ),
                'options'  		=> array(
                    'forward-slash' 	=> esc_html__('/', 'kapee' ),
                    'greater-than'		=> esc_html__('>', 'kapee' ),
                ),
                'default'  		=> 'forward-slash',
            ),
		)
	) );
			
	/*
	* Footer
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Footer', 'kapee' ),
        'id'         		=> 'footer',
		'icon'		 		=> 'el el-photo',
        'fields'     		=> array(
			array(
                'id'       		=> 'site-footer',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Footer','kapee'),
				'subtitle'    	=> esc_html__( 'Show/Hide website footer.', 'kapee' ),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'footer-layout',
                'type'     		=> 'image_select',
                'title'    		=> esc_html__( 'Footer Layout', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Select footer layout.', 'kapee' ),
                'options'  		=> array(
                    '1' => array(
                        'title' 	=> esc_html__( 'Layout 1', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-1.png',
                    ),
					'2' => array(
                        'title' 	=> esc_html__( 'Layout 2', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-2.png',
                    ),
					'3' => array(
                        'title' 	=> esc_html__( 'Layout 3', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-3.png',
                    ),					
					'4' => array(
                        'title' 	=> esc_html__( 'Layout 4', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-4.png',
                    ),
					'5' => array(
                        'title' 	=> esc_html__( 'Layout 5', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-5.png',
                    ),
					'6' => array(
                        'title' 	=> esc_html__( 'Layout 6', 'kapee'),
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/footer-6.png',
                    ),
                ),
                'default'  			=> '2',
				'required'			=> array( 'site-footer', '=', 1 )
            ),
			array(
                'id'       		=> 'footer-widget-collapse',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Collapse Widgets on Mobile', 'kapee'),
				'subtitle'    	=> esc_html__( 'Yes/No collapse footer widgets on mobile device.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
				'off'      		=> esc_html__( 'No', 'kapee' ),
				'default'  		=> 0,
				'required'		=> array( 'site-footer', '=', 1 )
            ),
		)
	) );
	
	/*
	* Footer Copyright
	*/
	Redux::setSection( $opt_name, array(
        'title'      		=> esc_html__( 'Footer Copyright', 'kapee' ),
        'id'         		=> 'section-footer-copyright',
		'subsection'		=> true,
        'fields'     		=> array(
			array(
                'id'       		=> 'footer-copyright',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Copyright','kapee'),
				'subtitle'    	=> esc_html__( 'Show/Hide website copyright.', 'kapee' ),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1
            ),
			array(
                'id'       		=> 'copyright-layout',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Copyright Layout', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Select copyright layout.', 'kapee' ),
                'options'  		=> array(
                    'columns' 		=> esc_html__('Columns', 'kapee' ),
                    'centered'		=> esc_html__('Centered', 'kapee' ),
                ),
                'default'  		=> 'columns',
				'required'		=> array( 'footer-copyright', '=', 1 )
            ),
			array(
                'id'       		=> 'copyright-text',
                'type'     		=> 'textarea',
				'title'    		=> esc_html__( 'Copyright Text', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Enter copyright text. Use {current_year} for get dynamic current year.', 'kapee' ),
				'default'  		=> wp_kses_post('Kapee &copy; {current_year} by <a href="https://presslayouts.com/" target="_blank">PressLayouts</a> All Rights Reserved.'),
				'required'		=> array( 'footer-copyright', '=', 1 )
            ),
			array(
                'id'       		=> 'payment-logo',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Payment Logo','kapee'),
				'subtitle'    	=> esc_html__( 'Show/Hide payment logo.', 'kapee' ),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 0,
				'required'		=> array( 'footer-copyright', '=', 1 )
				
            ),
			array(
                'id'      		=> 'payment-logo-img',
                'type'     		=> 'media',
                'url'      		=> false,
                'title'    		=> esc_html__( 'Payment Logo Image', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Upload payment logo image.', 'kapee' ),
                'compiler' 		=> 'true',
				'default'  		=> array(),
				'required' 		=> array( 'payment-logo', '=', 1 )
			),
		)
	) );
	
	/*
	* Woocommerce
	*/
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'WooCommerce'.$theme_slug , 'kapee' ),
        'id'         => 'woocommerce',
		'icon'		 => 'el el-shopping-cart',
        'fields'     => array(
			array(
                'id'       		=> 'order-tracking-page',
                'type'     		=> 'select',
                'data'     		=> 'pages',
                'title'    		=> esc_html__( 'Order Tracking Page', 'kapee' ),
                'subtitle' 		=> esc_html__( 'Set your order tracking page.', 'kapee' ),
                'desc' 			=> esc_html__( 'Page contents: [woocommerce_order_tracking]', 'kapee' ),
            ),
			array(
                'id'       		=> 'product-search-by-sku',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Search By Product SKU','kapee'),
				'subtitle'     	=> esc_html__( 'Ajax search product by  sku.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'manage-password-strength',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Manage Password Strength','kapee'),
				'subtitle'     	=> esc_html__( 'Reduce the strength requirement on the woocommerce user login/signup password ', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'id'       		=> 'user-password-strength',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'User Password Strength', 'kapee' ),
                'options'  		=> array(
                    '3' 	=> esc_html__('Strong (default)', 'kapee' ),
                    '2' 	=> esc_html__('Medium', 'kapee' ),
					'1' 	=> esc_html__('Weak', 'kapee' ),
					'0' 	=> esc_html__('Very Weak', 'kapee' ),
                ),
                'default'  		=> '3',
				'required'		=> array( 'manage-password-strength', '=', 1 )
            ),
			array(
                'id'       		=> 'single-line-product-title',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Single Line Title','kapee'),
				'subtitle' 	   	=> esc_html__( 'Show product/category/widget  title in single line.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'product-hover-tooltip',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Tooltip','kapee'),
				'subtitle' 	   	=> esc_html__( 'Show/hide product hover tooltip.', 'kapee' ),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       => 'product_open_cart_mini',
                'type'     => 'switch',
                'title'    => esc_html__('Min Cart Popup','kapee'),
				'subtitle'     => esc_html__( 'Show mini cart popup after added product in cart. ', 'kapee' ),
                'on'       => esc_html__( 'Show', 'kapee' ),
				'off'      => esc_html__( 'Hide', 'kapee' ),
				'default'  => 1,
            ),
			array(
                'id'       => 'mini-cart-quantity',
                'type'     => 'switch',
                'title'    => esc_html__('Quantity Field in Mini Cart','kapee'),
				'subtitle'     => esc_html__( 'Show quantity field in mini cart. ', 'kapee' ),
                'on'       => esc_html__( 'Show', 'kapee' ),
				'off'      => esc_html__( 'Hide', 'kapee' ),
				'default'  => 1,
            ),
			array(
                'id'       		=> 'product-labels',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Labels','kapee'),
				'subtitle' 	   	=> esc_html__( 'Show labels sale, featured, new and out of stock on product.', 'kapee' ),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'sale-product-label',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Sale Product Label','kapee'),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'product-labels', '=', 1 )
            ),
			array(
                'id'      		=> 'sale-product-label-after-price',
                'type'     		=> 'button_set',
				'desc' 			=> esc_html__( 'Show sale product label after price or on product image in shop/listing page.', 'kapee' ),
                'options'  		=> array(
                    'after-price' 		=> esc_html__('After Price','kapee'),
                    'on-product-image'	=> esc_html__('On Product Image','kapee'),
                ),
                'default'  		=> 'after-price',
				'required' 		=> array( 'sale-product-label', '=', 1 )
            ),
			array(
                'id'      		=> 'sale-product-label-text-options',
                'type'     		=> 'button_set',
				'desc' 			=> esc_html__( 'sale product label in percentage or text.', 'kapee' ),
                'options'  		=> array(
                    'percentage' 	=> esc_html__('Percentage','kapee'),
                    'text' 			=> esc_html__('Text','kapee'),
                ),
                'default'  		=> 'percentage',
				'required' 		=> array( 'sale-product-label', '=', 1 )
            ),
			array(
                'id'       		=> 'sale-product-label-percentage-text',
                'type'     		=> 'text',
				'desc'   		=> esc_html__('Sale label percentage text.','kapee'),
				'default'  		=> esc_html__('Off','kapee'),
				'required' 		=> array( 'sale-product-label-text-options', '=', 'percentage' )
            ),
			array(
                'id'       		=> 'sale-product-label-text',
                'type'     		=> 'text',
                'desc'    		=> esc_html__('Sale product label text.','kapee'),
				'default'  		=> esc_html__('Sale','kapee'),
				'required' 		=> array( 'sale-product-label-text-options', '=', 'text' )
            ),
			array(
                'id'       		=> 'sale-product-label-color',
                'type'     		=> 'color',
                'desc'    		=> esc_html__( 'Sale product label color.', 'kapee' ),
                'default'  		=> '#388E3C',
				'required' 		=> array( 'sale-product-label', '=', 1 )
            ),
			array(
                'id'       		=> 'product-new-label',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('New Product Label','kapee'),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'product-labels', '=', 1 )
            ),
			array(
                'id'       		=> 'new-product-label-text',
                'type'     		=> 'text',
                'desc'    		=> esc_html__('New product label text.','kapee'),
				'default'  		=> esc_html__('New','kapee'),
				'required' 		=> array( 'product-new-label', '=', 1 )
            ),
			array(
                'id'        	=> 'product-newness-days',
                'type'      	=> 'slider',
                'desc'      	=> esc_html__( 'Enter number of days to newness.', 'kapee' ),
                'default'   	=> 30,
                'min'       	=> 1,
                'step'      	=> 1,
                'max'       	=> 90,
                'display_value' => 'text',
				'required' 		=> array( 'product-new-label', '=', 1 )
            ),
			array(
                'id'      		=> 'new-product-label-color',
                'type'     		=> 'color',
                'desc'    		=> esc_html__( 'New product label color.', 'kapee' ),
                'default'  		=> '#82B440',
				'required' 		=> array( 'product-new-label', '=', 1 )
            ),
			array(
                'id'       		=> 'featured-product-label',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Featured Product Label','kapee'),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'product-labels', '=', 1 )
            ),
			array(
                'id'       		=> 'featured-product-label-text',
                'type'     		=> 'text',
                'desc'    		=> esc_html__('Featured product label text.','kapee'),
				'default'  		=> esc_html__('Featured','kapee'),
				'required' 		=> array( 'featured-product-label', '=', 1 )
            ),
			array(
                'id'       		=> 'featured-product-label-color',
                'type'     		=> 'color',
                'desc'     		=> esc_html__( 'Featured product label color.', 'kapee' ),
                'default'  		=> '#ff9f00',
				'required' 		=> array( 'featured-product-label', '=', 1 )
            ),
			array(
                'id'       		=> 'outofstock-product-label',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Out Of Stock Product Label','kapee'),
                'on'       		=> esc_html__('Show','kapee'),
				'off'      		=> esc_html__('Hide','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'product-labels', '=', 1 )
            ),
			array(
                'id'       		=> 'outofstock-product-label-text',
                'type'     		=> 'text',
                'desc'     		=> esc_html__('out of stock product label text.','kapee'),
				'default'  		=> esc_html__('Out Of Stock','kapee'),
				'required' 		=> array( 'outofstock-product-label', '=', 1 )
            ),
			array(
                'id'       		=> 'outofstock-product-label-color',
                'type'     		=> 'color',
                'desc'    		=> esc_html__( 'Out of stock product label color.', 'kapee' ),
                'default'  		=> '#ff6161',
				'required' 		=> array( 'outofstock-product-label', '=', 1 )
            ),
		),
	) );
	
	/*
	* Woocommerce Shop Page
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Shop Page', 'kapee' ),
        'id'         => 'shop-page',
		'icon'		 => 'el el-shopping-cart',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       	=> 'shop-page-layout',
                'type'     	=> 'image_select',
                'title'    	=> esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' 	=> esc_html__( 'Select shop/listing page layout with sidebar postion.', 'kapee' ),
                'options'  	=> array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => 'Left Sidebar',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => 'Right Sidebar',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  	=> 'left-sidebar'
            ),
			array(
                'id'       	=> 'shop-page-sidebar-width',
                'type'     	=> 'button_set',
                'title'    	=> esc_html__( 'Sidebar Width', 'kapee' ),
                'subtitle'  => esc_html__( 'Select sidebar size.', 'kapee' ),
                'options'  	=> array(
					'3'	=> esc_html__('Medium','kapee'),
					'4'	=> esc_html__('Large','kapee'),
				),
                'default'  	=> '3',
				'required' 	=> array( 'shop-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       	=> 'shop-page-sidebar-widget',
                'type'     	=> 'select',
                'title'    	=> esc_html__('Sidebar Widget Area','kapee'),
				'subtitle'  => esc_html__( 'Select sidebar for shop page.', 'kapee' ),
                'data'     	=> 'sidebars',
                'default'  	=> 'shop-page-sidebar',
                'required' 	=> array( 'shop-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       		=> 'shop-page-title',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Page Title', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show shop page title.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Yes','kapee'),
                'off'      		=> esc_html__('No','kapee'),
            ),
			array(
                'id'       		=> 'product-header',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Products Header', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show products header.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Yes','kapee'),
                'off'      		=> esc_html__('No','kapee'),
            ),
			array(
                'id'       		=> 'products-view-icon',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product View Mode Icon','kapee'),
				'subtitle'      => esc_html__( 'Show Product view mode icon on product header', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-default-view',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Product View Mode', 'kapee' ),
                'subtitle'      => esc_html__('Select by default product view mode.', 'kapee' ),
                'options'  		=> array(
                    'grid-view'		=> esc_html__('Grid', 'kapee' ),
                    'list-view' 	=> esc_html__('List', 'kapee' ),
                ),
                'default'  		=> 'grid-view',
            ),
			array(
                'id'            => 'products-per-page',
                'type'          => 'slider',
                'title'         => esc_html__('Product Per Page','kapee'),
                'subtitle'      => esc_html__('Show number of product per page.','kapee'),
                'default'       => 12,
                'min'           => 6,
                'step'          => 1,
                'max'           => 120,
                'display_value' => 'text',
            ),
			array(
                'id'       		=> 'products-per-page-dropdown',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Per Page Dropdown','kapee'),
				'subtitle'     	=> esc_html__( 'Show product per page dropdown on product header', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-per-page-number',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Product Per Page Variations', 'kapee' ),
				'subtitle'     	=> esc_html__('Add product variations by comma. Ex. 9,12,24,36,48','kapee'),
                'default'  		=> '6,9,12,24,36,48',
				'required' 		=> array( 'products-per-page-dropdown', '=', 1 )
            ),			
			array(
                'id'       		=> 'product-sorting',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Sorting','kapee'),
				'subtitle' 	   	=> esc_html__( 'Show products sorting on shop page and archive pages.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),			
			array(
                'id'       		=> 'ajax-filter',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Ajax Filter','kapee'),
				'subtitle' 	   	=> esc_html__( 'Enable ajax filter on shop page and archive pages.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'id'       		=> 'shop-top-filter',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Shop Page Topbar Filter','kapee'),
				'subtitle' 	   	=> esc_html__( 'Show shop page filters on product header.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'id'       		=> 'products-columns',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Product Columns', 'kapee' ),
				'subtitle'      => esc_html__( 'How many product you want to show per row?', 'kapee' ),
                'options'  		=> array(
                    2		=> esc_html__('2', 'kapee' ),
                    3	 	=> esc_html__('3', 'kapee' ),
					4	 	=> esc_html__('4', 'kapee' ),
					5	 	=> esc_html__('5 In full width', 'kapee' ),
					6	 	=> esc_html__('6 In full width', 'kapee' ),
                ),
                'default'  		=> 3,
            ),
			array(
                'id'       => 'products-pagination-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Products Pagination', 'kapee' ),
				'subtitle' => esc_html__('Select product pagination type.','kapee'),
                'options'  => array(
					'default'			=> esc_html__('Default','kapee'),
					'infinity-scroll'	=> esc_html__('Infinity Scroll','kapee'),
					'load-more-button'	=> esc_html__('Load More','kapee'),
				),
                'default'  => 'default',
            ),
			array(
                'id'       => 'products-pagination-load-more-button-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Load More Button Text', 'kapee' ),
				'subtitle' => esc_html__('Enter load more button text.','kapee'),
                'default'  => 'Load More Products',
				'required' => array( 'products-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
			array(
                'id'       => 'products-pagination-finished-message',
                'type'     => 'text',
                'title'    => esc_html__( 'Finished Message', 'kapee' ),
				'subtitle' => esc_html__('Text to display when no additional products are available.','kapee'),
                'default'  => 'No More Products Available',
				'required' => array( 'products-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
			
		),
	) );
	
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product Styles', 'kapee' ),
        'id'         => 'product-styles',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'product-style',
                'type'     		=> 'image_select',
				//'full_width' 	=> true,
                'title'    	=> esc_html__( 'Products Hover Style', 'kapee' ),
                'options'  	=> array(
                    'product-style-1' => array(
                        'alt' 	=> 'Products Hover Style 1',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/product-hover-style-1.png',
                    ),
					'product-style-2' => array(
                        'alt' 	=> 'Products Hover Style 2',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/product-hover-style-2.png',
                    ),
                    'product-style-3' => array(
                        'alt' 	=> 'Products Hover Style 3',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/product-hover-style-3.png',
                    ), 
					'product-style-4' => array(
                        'alt' 	=> 'Products Hover Style 4',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/product-hover-style-4.png',
                    ),
					'product-style-5' => array(
                        'alt' 	=> 'Products Hover Style 5',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/product-hover-style-5.png',
                    ),
                ),
                'default'  	=> 'product-style-1',
            ),
			array(
                'id'       		=> 'product-quantity-field',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Quantity Field', 'kapee' ),
                'subtitle'  	=> esc_html__( 'Show quantity filed on home and shop page.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
				'off'      		=> esc_html__( 'No', 'kapee' ),
				'default'  		=> 0,
				'required' 		=> array( 'product-style', '=', array( 'product-style-3', 'product-style-4', 'product-style-5' ) )
            ),
			array(
                'id'       		=> 'products-hover-image',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Products Hover Image', 'kapee' ),
				'subtitle'      => esc_html__( 'Show product hover image on products.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes','kapee' ),
				'off'      		=> esc_html__( 'No','kapee' ),
				'default'  		=> 1,
            ),			
			array(
                'id'       => 'products-countdown',
                'type'     => 'switch',
                'title'    => esc_html__( 'Products Countdown', 'kapee' ),
                'on'       => esc_html__( 'Yes', 'kapee' ),
				'off'      => esc_html__( 'No', 'kapee' ),
				'default'  => 0,
            ),
			array(
                'id'       		=> 'products-category',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Category','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-title',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Title','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-rating',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Rating','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-rating-style',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Products Rating Style', 'kapee' ),
                'options'  		=> array(					
                    'fancy-rating'	 	=> esc_html__('Fancy', 'kapee' ),
                    'simple-rating'		=> esc_html__('Simple', 'kapee' ),
                ),
                'default'  		=> 'fancy-rating',
				'required' 		=> array( 'products-rating', '=', 1 )
            ),
			array(
                'id'       		=> 'products-rating-count',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Rating Count','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'products-rating', '=', 1 )
            ),
			array(
                'id'       		=> 'products-rating-histogram',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Rating Histogram','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
				'required' 		=> array( 'products-rating', '=', 1 )
            ),
			array(
                'id'       		=> 'products-price',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Price','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-variations',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Hover Variations','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'products-short-description',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Products Short Description','kapee'),
				'subtitle'      => esc_html__( 'Show product short description in list view.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
		),
	) );
	
	/*
	* Product Catalog Mode
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Catalog Mode', 'kapee' ),
        'id'         => 'product-catalog-mode',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'catalog-mode',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Catalog Mode','kapee'),
                'subtitle'  	=> esc_html__( 'Enable catalog mode.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'id'       		=> 'open-product-page-new-tab',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Open Product In New Tab','kapee'),
				'subtitle'      => esc_html__( 'Open product page in new tab.', 'kapee' ),
                'subtitle'  	=> esc_html__( 'Open product in browser new tab.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'id'       		=> 'product-cart-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Cart Button','kapee'),
                'subtitle'  	=> esc_html__( 'Show cart button on shop page.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),			
			array(
                'id'       		=> 'product-wishlist-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Wishlist Button','kapee'),
                'subtitle'  	=> esc_html__( 'Show wishlist button on shop page.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'product-compare-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Compare Button','kapee'),
                'subtitle'  	=> esc_html__( 'Show compare button on shop page.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'product-quickview-button',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Quick View Button','kapee'),
                'subtitle'  	=> esc_html__( 'Show quick view button on shop page.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'single-product-quick-buy',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Quick Buy Button','kapee'),
                'subtitle'  	=> esc_html__( 'Show quick buy button on product page.', 'kapee' ),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 0,
            ),
			array(
                'type'      		=> 'text',
                'id'        		=> 'product-quickbuy-button-text',
                'title'     		=> esc_html__( 'Quick Buy Button Text', 'kapee' ),
                'subtitle'  		=> esc_html__( 'Enter quick buy button text.', 'kapee' ),
                'default'     		=> 'Buy Now',
                'required'  		=> array( 'single-product-quick-buy', '=', '1' ),
            ),
		),
	) );
	
	/*
	* Product category Page
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Categories Page', 'kapee' ),
        'id'         => 'product-categories-page',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'category-style',
                'type'     		=> 'image_select',
                'title'    		=> esc_html__( 'Category Style', 'kapee' ),
                'subtitle'  	=> esc_html__( 'Select category style', 'kapee' ),
                'options'  		=> array(                    
                    'category-style-1' => array(
                        'alt' 	=> 'Category Style 1',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/category-style-1.png',
                    ),
					'category-style-2' => array(
                        'alt' 	=> 'Category Style 2',
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'layout/category-style-2.png',
                    ),
                ),
                'default'  	=> 'category-style-1',
            ),
		),
	) );

	/*
	* Product login to see prices
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Login To See Price', 'kapee' ),
        'id'         => 'section-login-to-see-price',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'login-to-see-price',
                'type'     => 'switch',
                'title'    => esc_html__( 'Login To See Price', 'kapee' ),
				'subtitle' => esc_html__('Only logged in users can see the pricing.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
                'default'  => 0,
            ),
		),
	) );
	
	/*
	* Single Product Page
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product Page', 'kapee' ),
        'id'         => 'single-product-page',
		'icon'		 => 'el el-shopping-cart',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       	=> 'product-page-layout',
                'type'     	=> 'image_select',
                'title'    	=> esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' 	=> esc_html__( 'Select product page layout with sidebar postion.', 'kapee' ),
                'options'  	=> array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  	=> 'full-width'
            ),
			array(
                'id'       	=> 'product-page-sidebar-width',
                'type'     	=> 'button_set',
                'title'    	=> esc_html__( 'Sidebar Width', 'kapee' ),
				'subtitle' 	=> esc_html__('Select sidebar size.','kapee'),
                'options'  	=> array(
					'3'	=> esc_html__('Medium','kapee'),
					'4'	=> esc_html__('Large','kapee'),
				),
                'default'  	=> '3',
				'required' 	=> array( 'product-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       	=> 'product-page-sidebar-widget',
                'type'     	=> 'select',
                'title'    	=> esc_html__('Sidebar Widget Area','kapee'),
				'subtitle' 	=> esc_html__('Select sidebar for product page.','kapee'),
                'data'     	=> 'sidebars',
                'default'  	=> 'product-page-sidebar',
                'required' 	=> array( 'product-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'sticky-product-image',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Product Image', 'kapee' ),
				'subtitle' => esc_html__('When you scroll the product page at this time you want to stick product image part or not.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
                'default'  => 1,
            ),
			array(
                'id'       => 'sticky-product-summary',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Product Summary', 'kapee' ),
				'subtitle' => esc_html__('When you scroll the product page at this time you want to stick product summary part or not.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
                'default'  => 1,
            ),
			array(
                'id'       => 'sticky-add-to-cart-button',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Add to Cart Button', 'kapee' ),
				'subtitle' => esc_html__('Sticky add to cart button on bottom when scroll the page.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
                'default'  => 0,
            ),
		),
	) );
	
	/*
	* Product Gallery
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Product Gallery', 'kapee' ),
        'id'         => 'product-gallery',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       	=> 'product-gallery-style',
                'type'     	=> 'image_select',
                'title'    	=> esc_html__( 'Gallery Layout', 'kapee' ),
                'options'  	=> array(
                    'product-gallery-left' 	=> array(
                        'title' 	=> esc_html__( 'Thumbnail Left', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-left.png',
                    ),                   
                    'product-gallery-bottom' 	=> array(
                        'title' 	=> esc_html__( 'Thumbnail Bottom', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-bottom.png',
                    ),
					'product-gallery-horizontal' 	=> array(
                        'title' 	=> esc_html__( 'Gallery Horizontal', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-horizontal.png',
                    ),
					'product-gallery-center' 	=> array(
                        'title' 	=> esc_html__( 'Gallery Center', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-center.png',
                    ),
					'product-gallery-grid' 	=> array(
                        'title' 	=> esc_html__( 'Gallery Grid', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-gallery-grid.png',
                    ),
					'product-sticky-info' 	=> array(
                        'title' 	=> esc_html__( 'Sticky Info', 'kapee' ),
                        'img' 	=> KAPEE_ADMIN_IMAGES . 'product-page/product-sticky-info.png',
                    ),
                ),
                'default'  	=> 'product-gallery-left'
            ),
			array(
                'id'       => 'product-gallery-zoom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product Gallery Zoom', 'kapee' ),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
                'default'  => 1,
            ),
			array(
                'id'       => 'product-gallery-lightbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product Gallery Lightbox', 'kapee' ),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
                'default'  => 1,
            ),
		),
	) );
	
	/*
	* Product Summary
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Summary', 'kapee' ),
        'id'         => 'product-summary',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'single-product-breadcrumbs',
                'type'     => 'switch',
                'title'    => esc_html__('Product Breadcrumbs','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-breadcrumbs-position',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Breadcrumbs Position', 'kapee' ),
                'options'  		=> array(
                    'above-summary' 	=> esc_html__( 'Above Summary', 'kapee' ),
                    'above-image'		=> esc_html__( 'Above Image', 'kapee' ),
                ),
                'default'  		=> 'above-summary',
				'required' => array( 'single-product-breadcrumbs', '=', 1 )
            ),
			array(
                'id'       => 'single-product-navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Product Navigation','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-rating',
                'type'     => 'switch',
                'title'    => esc_html__('Product Rating','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-countdown',
                'type'     => 'switch',
                'title'    => esc_html__('Product Countdown','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-countdown-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Countdown Style', 'kapee' ),
                'options'  => array(
					'countdown-box'		=> esc_html__('Box','kapee'),
					'countdown-text'  	=> esc_html__('Text','kapee'),					
				),
                'default'  => 'countdown-box',
				'required' => array( 'single-product-countdown', '=', 1 )
            ),
			array(
                'id'        => 'single-product-countdown-tag',
                'type'      => 'text',
                'title'     => esc_html__( 'Countdown Tag', 'kapee' ),
                'default' 	=> 'Special price ends in less than',
				'required' 	=> array( 'single-product-countdown-style', '=', 'countdown-text' )
            ),
			array(
                'id'      		=> 'sale-single-product-label-after-price',
                'type'     		=> 'button_set',
				'title'     	=> esc_html__( 'Sale Product Label', 'kapee' ),
				'desc' 			=> esc_html__( 'Show sale product label after price or on product image in product page.', 'kapee' ),
                'options'  		=> array(
                    'after-price' 		=> esc_html__('After Price','kapee'),
                    'on-product-image'	=> esc_html__('On Product Image','kapee'),
                ),
                'default'  		=> 'after-price',
            ),
			array(
                'id'       => 'single-product-price-summary',
                'type'     => 'switch',
                'title'    => esc_html__('Product Price Summary','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       		=> 'single-product-availability',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Availability','kapee'),
				'subtitle'     	=> esc_html__('Show Product availability message like In Stock, Out Of Stock, Hurry left, etc...','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'        	=> 'single-product-availability-instock-msg',
                'type'      	=> 'text',
                'title'     	=> esc_html__( 'In Stock Message', 'kapee' ),
                'default' 		=> 'In Stock',
				'required' 		=> array( 'single-product-availability', '=', 1 )
            ),
			array(
                'id'            => 'single-product-availability-lowstock-qty',
                'type'          => 'slider',
                'title'         => esc_html__('Low Stock Qty','kapee'),
                'subtitle'		=> esc_html__('How many numbers you want to display below low stock messages. like Hurry, Only {qty} left.','kapee'),
                'default'       => 5,
                'min'           => 1,
                'step'          => 1,
                'max'           => 25,
                'display_value' => 'text',
				'required' 		=> array( 'single-product-availability', '=', 1 )
            ),
			array(
                'id'        	=> 'single-product-availability-hurry-left-msg',
                'type'      	=> 'text',
                'title'     	=> esc_html__( 'Stock Hurry Left Message', 'kapee' ),
				'subtitle'		=> esc_html__('Default template is: Hurry, Only {qty} left.Here {qty} is number of item available in stock','kapee'),
                'default' 		=> 'Hurry, Only {qty} left.',
				'required' 		=> array( 'single-product-availability', '=', 1 )
            ),
			array(
                'id'        	=> 'single-product-availability-outstock-msg',
                'type'      	=> 'text',
                'title'     	=> esc_html__( 'Out of Stock Message', 'kapee' ),
                'default' 		=> 'Out of Stock',
				'required' 		=> array( 'single-product-availability', '=', 1 )
            ),
			array(
                'id'       => 'single-product-offers',
                'type'     => 'switch',
                'title'    => esc_html__('Product Offers','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-services',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product Services', 'kapee' ),
                'on'       => esc_html__( 'Yes', 'kapee' ),
				'off'      => esc_html__( 'No', 'kapee' ),
				'default'  => 1,
            ),
			array(
                'id'        	=> 'single-product-services-label',
                'type'      	=> 'text',
                'title'     	=> esc_html__( 'Short Services Label', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show product services label text. ', 'kapee' ),
                'default' 		=> 'Services:',
				'required' 		=> array( 'single-product-services', '=', 1 )
            ),
			array(
                'id'       => 'single-product-brands',
                'type'     => 'switch',
                'title'    => esc_html__('Product Brands','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-short-description',
                'type'     => 'switch',
                'title'    => esc_html__('Product Short Description','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'        	=> 'single-product-short-description-label',
                'type'      	=> 'text',
                'title'     	=> esc_html__( 'Short Description(Highlight) Label', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show product short description/highlight label text. ', 'kapee' ),
                'default' 		=> 'Highlights:',
				'required' 		=> array( 'single-product-short-description', '=', 1 )
            ),
			array(
                'id'       		=> 'product_add_to_cart_ajax',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Enable AJAX Add To Cart','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'single-product-size-chart',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Size chart','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       		=> 'single-product-meta',
                'type'     		=> 'switch',
                'title'    		=> esc_html__('Product Meta','kapee'),
				'subtitle'     	=> esc_html__('Show or hide product SKU, category, tag, etc...','kapee'),
                'on'       		=> esc_html__('Yes','kapee'),
				'off'      		=> esc_html__('No','kapee'),
				'default'  		=> 1,
            ),
			array(
                'id'       => 'single-product-share',
                'type'     => 'switch',
                'title'    => esc_html__('Product Share','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'product-share-location',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Product Share Location', 'kapee' ),
                'options'  => array(
					'summary-top'		=> esc_html__('Summary Top','kapee'),
					'summary-bottom'  	=> esc_html__('Summary Bottom','kapee'),					
				),
                'default'  => 'summary-top',
				'required' => array( 'single-product-share', '=', 1 )
            ),
		),
	) );

	/*
	* Product Bought Together
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Bought Together', 'kapee' ),
        'id'         => 'product-bought-together',
		'subsection' => true,
        'fields'     => array(
			
			array(
                'id'       => 'single-product-bought-together',
                'type'     => 'switch',
                'title'    => esc_html__('Product Bought Together','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'type'     	=> 'text',
                'id'		=> 'product-bought-together-title',
                'title'		=> esc_html__( 'Bought Together Title', 'kapee' ),
				'default'  	=> 'Frequently Bought Together',
                'required' 	=> array( 'single-product-bought-together', '=', 1 )
            ),
			array(
                'id'       => 'product-bought-together-location',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Bought Together Location', 'kapee' ),
                'options'  => array(
					'summary-bottom'  	=> esc_html__('Summary Bottom','kapee'),
					'after-summary'		=> esc_html__('After Summary','kapee'),					
					'in-tab'  			=> esc_html__('In Tab','kapee'),
				),
                'default'  => 'summary-bottom',
				'required' => array( 'single-product-bought-together', '=', 1 )
            ),			
		),
	) );
	
	/*
	* Product Tags
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Tabs', 'kapee' ),
        'id'         => 'product-tabs',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'single-product-tabs',
                'type'     => 'switch',
                'title'    => esc_html__('Product Tabs','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-product-tabs-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Product Tabs Style', 'kapee' ),
                'options'  => array(
					'tabs'  		=> esc_html__('Tabs','kapee'),
					'accordion'		=> esc_html__('Accordion','kapee'),					
					'toggle'  		=> esc_html__('Toggle','kapee'),
				),
                'default'  => 'tabs',
				'required' => array( 'single-product-tabs', '=', 1 )
            ),
			array(
                'id'       => 'single-product-tabs-location',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Product Tabs Location', 'kapee' ),
                'options'  => array(
					'after-summary'		=> esc_html__('After Summary','kapee'),	
					'summary-bottom'  	=> esc_html__('Summary Bottom','kapee'),
				),
                'default'  => 'after-summary',
				'required' => array( 'single-product-tabs', '=', 1 )
            ),
			array(
                'id'       => 'single-product-tabs-titles',
                'type'     => 'switch',
                'title'    => esc_html__('Product Tabs Titles','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
				'required' => array( 'single-product-tabs', '=', 1 )
            ),
		),
	) );
	
	/*
	* Product Related/Up-Sells/Recently-Viewed
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Related/Up-Sells/Rviewed', 'kapee' ),
        'id'         => 'product-related-upsells-rv',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'upsells-products',
                'type'     => 'switch',
                'title'    => esc_html__('Up Sells Products','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'related-products',
                'type'     => 'switch',
                'title'    => esc_html__('Related Products','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'recently-viewed-products',
                'type'     => 'switch',
                'title'    => esc_html__('Recently Viewed Products','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'            => 'related-upsells-products',
                'type'          => 'slider',
                'title'         => esc_html__('Show Number Of Products','kapee'),
				'subtitle'     	=> esc_html__('How many products you want to display?','kapee'),
                'default'       => 12,
                'min'           => 1,
                'step'          => 1,
                'max'           => 24,
                'display_value' => 'text',
            ),
			array(
                'id'       => 'related-upsells-auto-play',
                'type'     => 'switch',
                'title'    => esc_html__('Carousel Autoplay','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'related-upsells-loop',
                'type'     => 'switch',
                'title'    => esc_html__('Carousel Inifnity Loop','kapee'),
                'subtitle' => esc_html__('Enables related/up sells products carousel Inifnity loop. Duplicate last and first products to get loop illusion.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'related-upsells-navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Carousel Navigation','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'related-upsells-product-dots',
                'type'     => 'switch',
                'title'    => esc_html__('Carousel Dots Navigation','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       		=> 'related-upsells-products-columns',
                'type'     		=> 'button_set',
                'title'    		=> esc_html__( 'Products Per Row - Desktop', 'kapee' ),
				'subtitle'     	=> esc_html__('How many products you want to show per row?','kapee'),
                'options'  		=> array( 2 => '2', 3 => '3', 4 => '4', 5=> '5 (In Full Width)', 6=> '6 (In Full Width)'),
                'default'  		=> 4,
            ),
			array(
                'id'            => 'related-upsells-products-small-desktop',
                'type'          => 'slider',
                'title'         => esc_html__('Products Per Row - Small Desktop', 'kapee' ),
                'default'       => 4,
                'min'           => 1,
                'step'          => 1,
                'max'           => 6,
            ),
			array(
                'id'            => 'related-upsells-products-tablet',
                'type'          => 'slider',
                'title'         => esc_html__('Products Per Row - Tablet', 'kapee' ),
                'default'       => 3,
                'min'           => 1,
                'step'          => 1,
                'max'           => 4,
            ),
			array(
                'id'            => 'related-upsells-products-mobile',
                'type'          => 'slider',
                'title'         => esc_html__('Products Per Row - Mobile', 'kapee' ),
                'default'       => 2,
                'min'           => 1,
                'step'          => 1,
                'max'           => 3,
            ),
			array(
                'id'            => 'related-upsells-products-small-mobile',
                'type'          => 'slider',
                'title'         => esc_html__('Products Per Row - Small Mobile', 'kapee' ),
                'default'       => 2,
                'min'           => 1,
                'step'          => 1,
                'max'           => 2,
            ),
		),
	) );
	
	/*
	* Free Shipping Bar		
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Free Shipping Bar', 'kapee' ),
        'id'         => 'section-freeshipping',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'free-shipping-bar',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Free Shipping Bar', 'kapee' ),
				'subtitle' 		=> esc_html__( 'You want to enable free shipping bar or not?', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
				'off'      		=> esc_html__( 'No', 'kapee' ),
				'default'  		=> 0,
            ),
			array(
				'id'      		=> 'free-shipping-amount',
				'type'    		=> 'text',
				'title'   		=> esc_html__( 'Enter Required Amount', 'kapee' ), 
				'subtitle'   	=> wp_kses( sprintf( __( 'You can set frees hipping method amount from Woocommerce => settings => shipping => shipping zones => manage shipping method.For more read <a href="%s" target="_blank"> WooCommerce documentation </a> guide.', 'kapee' ), esc_url( 'https://docs.woocommerce.com/document/free-shipping/' ) ),
				array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),     
				'default' 		=> '',								  
			),
			array(
				'id'      => 'free-shipping-msg',
				'type'    => 'textarea',
				'subtitle'    	=> esc_html__( 'Enter free shipping message text. Use {missing_amount} - The remaing amount for free shipping.', 'kapee' ),
				'title'   => esc_html__( 'Free Shipping Message', 'kapee' ),               
				'default' => 'Spend {missing_amount} to get <strong>free shipping</strong>',								  
			),
			array(
				'id'      => 'free-shipping-complete-msg',
				'type'    => 'textarea',
				'title'   => esc_html__( 'Free Shipping Success Message', 'kapee' ), 
				'subtitle'    	=> esc_html__( 'Message show after reaching progress bar 100%.', 'kapee' ),
				'default' => esc_html__( 'Congratulation! You have got free shipping', 'kapee' ),	  
			),
			array(
				'id'      		=> 'shipping-bar-bg-color',
				'type'    		=> 'color',
				'title'   		=> esc_html__( 'Shipping Bar Background Color', 'kapee' ),               
				'default' 		=> '#efefef',								  
			),
			array(
				'id'      		=> 'shipping-bar-color',
				'type'    		=> 'color',
				'title'   		=> esc_html__( 'Shipping Bar Color', 'kapee' ),               
				'default' 		=> '#2370F4',								  
			),
		),
	) );
	
	/**
	* Advance Options
	*/ 
    Redux::setSection( $opt_name, array(
        'title'   		=> esc_html__( 'Advance Options ', 'kapee' ),
		'id'         	=> 'section-advance-options',
		'subsection' 	=> true,
        'fields'  		=> array(
			array(
                'id'    			=> 'delivery-return-notice',
                'type'   			=> 'info',
                'notice' 			=> false,
                'title' 			=> esc_html__( 'Delivery & Return', 'kapee' ),
            ),
			array(
                'id'       			=> 'product-delivery-return',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Delivery & Return', 'kapee' ),
				'subtitle'			=> esc_html__( 'Show delivery & return terms on product page.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),			
			array(
                'id'       			=> 'delivery-return-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Delivery & Return Label', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter your own delivery & return label.', 'kapee' ),
				'default'  			=> 'Delivery & Return',
				'required'			=> array( 'product-delivery-return', '=', 1 )
            ),
			array(
				'id'       			=> 'delivery-return-terms',
				'type'     			=> 'select',
				'data' 	   			=> 'posts',
				'args' 				=> array( 'post_type'=>'block','posts_per_page' => -1 ),
				'title'    			=> esc_html__('Select Terms Block', 'kapee' ),
				'subtitle'   		=> wp_kses( sprintf( __( 'Choose delivery & retund terms block. You can add custom block from <a href="%s" target="_blank">here</a>', 'kapee' ), esc_url( admin_url( 'post-new.php?post_type=block' ) ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),
				'placeholder' 		=> esc_attr__( 'Choose terms block', 'kapee' ),
				'required'			=> array( 'product-delivery-return', '=', 1 )
			),
			array(
                'id'    			=> 'ask-quetion-notice',
                'type'   			=> 'info',
                'notice' 			=> false,
                'title' 			=> esc_html__( 'Ask a Question', 'kapee' ),
            ),
			array(
                'id'       			=> 'product-ask-quetion',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Ask a Question', 'kapee' ),
				'subtitle'			=> esc_html__( 'Show ask a question form on product page.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),			
			array(
                'id'       			=> 'ask-quetion-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Ask a Question Label', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter ask a question label text.', 'kapee' ),
				'default'  			=> 'Ask a Question',
				'required'			=> array( 'product-ask-quetion', '=', 1 )
            ),
			array(
                'id'       			=> 'ask-quetion-form-title',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Ask a Question Form Title', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter ask a question form(popup) title.', 'kapee' ),
				'default'  			=> 'Ask a Question',
				'required'			=> array( 'product-ask-quetion', '=', 1 )
            ),
			array(
				'id'       			=> 'ask-question-form',
				'type'     			=> 'select',
				'data' 	   			=> 'posts',
				'args' 				=> array( 'post_type'=>'wpcf7_contact_form','posts_per_page' => -1 ),
				'title'    			=> esc_html__('Select Ask Question Form', 'kapee' ),
				'subtitle'   		=> wp_kses( sprintf( __( 'Choose ask a question form. You can add custom form  from <a href="%s" target="_blank">here</a>', 'kapee' ), esc_url( admin_url( 'admin.php?page=wpcf7-new' ) ) ), array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) 
				),
				'placeholder' 		=> esc_attr__( 'Choose form block', 'kapee' ),
				'required'			=> array( 'product-ask-quetion', '=', 1 )
			),
			array(
                'id'    			=> 'estimated-delivery-notice',
                'type'   			=> 'info',
                'notice' 			=> false,
                'title' 			=> esc_html__( 'Estimated Delivery Time', 'kapee' ),
            ),
			array(
                'id'       			=> 'product-estimated-delivery',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Estimated Delivery', 'kapee' ),
				'subtitle'			=> esc_html__( 'Show estimated delivery on product page.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),			
			array(
                'id'       			=> 'estimated-delivery-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Estimated Delivery Label', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter your own estimated delivery label.', 'kapee' ),
				'default'  			=> 'Estimated Delivery:',
				'required'			=> array( 'product-estimated-delivery', '=', 1 )
            ),
			array(
				'id' 				=> 'estimated-delivery-days',
				'type' 				=> 'slider',
				'title' 			=> esc_html__( 'Set Estimated Days', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Set estimated delivery days. Ex. 3-7 days', 'kapee' ),
				"min" 				=> 1,
				"step" 				=> 1,
				"max" 				=> 30,
				'display_value' 	=> 'text',
				'handles' 			=> 2,
				"default" 			=> array(
					1 		=> 3,
					2 		=> 7,
				),
				'required' 			=> array( 'product-estimated-delivery', '=', 1 ),
			),
			array(
                'id'    			=> 'product-visitor-count-notice',
                'type'   			=> 'info',
                'notice' 			=> false,
                'title' 			=> esc_html__( 'Visitor Count', 'kapee' ),
            ),
			array(
                'id'       			=> 'single-product-visitor-count',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Visitor Count', 'kapee' ),
				'subtitle'			=> esc_html__( 'Show the number of fake visitors currently viewing a product on product page.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),
			array(
				'id' 				=> 'random-visitor-number',
				'type' 				=> 'slider',
				'title' 			=> esc_html__( 'Set Random Number', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Set min and max range to get random number between these value.', 'kapee' ),
				"min" 				=> 1,
				"step" 				=> 1,
				"max" 				=> 200,
				'display_value' 	=> 'text',
				'handles' 			=> 2,
				"default" 			=> array(
					1 		=> 20,
					2 		=> 50,
				),
				'required' 			=> array( 'single-product-visitor-count', '=', 1 ),
			),
			array(
                'id'       			=> 'visitor-count-text',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Enter Visitor Text', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter visitor text. Use {visitor_count} for display visitor count number.', 'kapee' ),
				'default'  			=> '{visitor_count} People viewing this product right now!',
				'required' 			=> array( 'single-product-visitor-count', '=', 1 ),
            ),
			array(
				'id'       			=> 'visitor-count-delay-time',
				'type'     			=> 'slider', 
				'title'    			=> esc_html__( 'Update Visitors Count Number', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Select seconds to delay update the number of visitors count.', 'kapee' ),
				'default'  			=> 5,
				'min'      			=> 1,
				'step'     			=> 1,
				'max'      			=> 60,
				'display_value' 	=> 'text',
				'required' 			=> array( 'single-product-visitor-count', '=', 1 ),
			),
			array(
                'id'    		=> 'product-trust-badge-notice',
                'type'   		=> 'info',
                'notice' 		=> false,
                'title' 		=> esc_html__( 'Trust Badge Image', 'kapee' ),
            ),
			array(
                'id'       			=> 'single-product-trust-badge',
                'type'     			=> 'switch',
                'title'    			=> esc_html__( 'Trust Badge', 'kapee' ),
				'subtitle'			=> esc_html__( 'Show trust badge image on single product page.', 'kapee' ),
                'on'       			=> esc_html__( 'Yes', 'kapee' ),
				'off'      			=> esc_html__( 'No', 'kapee' ),
				'default'  			=> 0,
            ),
			array(
                'id'       			=> 'trust-badge-label',
                'type'     			=> 'text',
                'title'    			=> esc_html__( 'Trust Badge Label', 'kapee' ),
				'subtitle' 			=> esc_html__( 'Enter your own trust badge label.', 'kapee' ),
				'default'  			=> 'Guaranteed Safe Checkout',
				'required'			=> array( 'single-product-trust-badge', '=', 1 )
            ),
			array(
                'id'       		=> 'trust-badge-image',
                'type'     		=> 'media',
                'url'      		=> true,
                'title'    		=> esc_html__( 'Trust Badge Image', 'kapee' ),
                'compiler' 		=> 'true',
                'subtitle' 		=>  esc_html__( 'Upload trust badge image.', 'kapee' ),
                'default'  		=> array(),
				'required' 		=> array( 'single-product-trust-badge', '=', 1 ),
            ),
		)
    ));
		
	/*
	* Checkout Page
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Checkout Page', 'kapee' ),
        'id'         => 'section-checkout',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'checkout-steps',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Checkout Steps', 'kapee' ),
				'subtitle' 		=> esc_html__( 'Show checkout steps on Cart, Checkout and Order Complete pages.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
				'off'      		=> esc_html__( 'No', 'kapee' ),
                'default'  		=> 1,
            ),
			array(
                'id'       => 'multi-step-checkout',
                'type'     => 'switch',
                'title'    => esc_html__('Multi Step Checkout','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       		=> 'checkout-product-image',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Product Image', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show product image on checkout page.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
                'off'      		=> esc_html__( 'No', 'kapee' ),
                'default'  		=> 1,
            ),
			array(
                'id'       		=> 'checkout-product-quantity',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Product Quantity Filed', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Show product quantity filed on checkout page.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
                'off'      		=> esc_html__( 'No', 'kapee' ),
                'default'  		=> 0,
            ),
		),
	) );
	
		
	/*
	* Cart Page
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Cart', 'kapee' ),
        'id'         => 'section-cart-page',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       		=> 'cart-auto-update',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Auto Update Cart ', 'kapee' ),
				'subtitle'    	=> esc_html__( 'Auto update cart when change product quantity.', 'kapee' ),
                'on'       		=> esc_html__( 'Yes', 'kapee' ),
                'off'      		=> esc_html__( 'No', 'kapee' ),
                'default'  		=> 1,
            ),
		)
	) );
	
	/**
	* Login/Register 
	*/ 
    Redux::setSection( $opt_name, array(
        'title'   => esc_html__( 'Login/Register', 'kapee' ),
		'id'         => 'section-login-register',
		'icon'		 => 'el el-user',
        'fields'  => array(
			array(
				'id'       	=> 'login-information',
				'type'     	=> 'editor',
				'title'    	=> esc_html__( 'Login Information', 'kapee' ),
				'subtitle'	=> esc_html__( 'Display login information in login form.', 'kapee' ),
				'args'   	=> array(
					'teeny'            => true,
				),
				'default'  => esc_html__('Get access to your Orders, Wishlist and Recommendations.', 'kapee'),

			)
		)
    ));
	if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WC_Vendors' ) || class_exists( 'WCMp' ) || class_exists( 'WCFMmp' ) ) {
		$vendor_options = kapee_vendor_theme_options();
		/*
		* Vendor Options
		*/
		Redux::setSection( $opt_name, array(
			'title'      => esc_html__( 'Vendor Options', 'kapee' ),
			'id'         => 'vendor-options',
			'icon'		 => 'el-icon-broom',
			'fields'     => $vendor_options,
		) );
	}
	/*
	* Pages options
	*/
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Pages', 'kapee' ),
        'id'         => 'pages-section',
		'icon'		 => 'el el-list-alt',
        'fields'     => array(
			array(
                'id'       => 'page-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' => esc_html__( 'Select page layout with sidebar postion.', 'kapee' ),
                'options'  => array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  => 'full-width'
            ),
			array(
                'id'       => 'page-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'page-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Sidebar Widget Area','kapee'),
                'data'     => 'sidebars',
                'default'  => 'sidebar-1',
                'required' => array( 'page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'page-comments',
                'type'     => 'switch',
                'title'    => esc_html__('Page Comments','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
		)
	) );
	
	/*
	* Widget
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Widget', 'kapee' ),
        'id'         => 'section-widget',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       			=> 'widget-title-style',
                'type'     			=> 'image_select',
                'title'    			=> esc_html__( 'Title Style', 'kapee' ),
				'subtitle' 	   		=> esc_html__('Select widget title style.','kapee'),
                'options'  			=> array(
					'widget-title-default' 	=> array(						
                        'title' 	=> 'Default',
                        'alt' 		=> 'Default',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/widget-title/1.jpg'
                    ), 
					'widget-title-bordered-full' 	=> array(
                        'title' 	=> 'Bordered Full',
                        'alt' 		=> 'Bordered Full',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/widget-title/2.jpg'
                    ), 
					'widget-title-bordered-short' 	=> array(
                        'title' 	=> 'Bordered Short',
                        'alt' 		=> 'Bordered Short',
                        'img' 		=> KAPEE_ADMIN_IMAGES . 'layout/widget-title/3.jpg'
                    ),
                ),
                'default'  			=> 'widget-title-bordered-full',
            ),
			array(
                'id'       => 'sticky-sidebar',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sidebar Sticky', 'kapee' ),
                'subtitle' => esc_html__( 'When you scroll the page at this time you want to sticky sidebar part in all pages or not.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'widget-toggle',
                'type'     => 'switch',
                'title'    => esc_html__( 'Widget Toggle', 'kapee' ),
                'subtitle' => esc_html__( 'Enable page widget toggle or not.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'widget-menu-toggle',
                'type'     => 'switch',
                'title'    => esc_html__( 'Widget Menu Toggle', 'kapee' ),
                'subtitle' => esc_html__( 'Enable page widget menu toggle or not.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'widget-items-hide-max-limit',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Widget Items Hide', 'kapee' ),
                'subtitle' => esc_html__( 'Enable widget items hide max limit.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'            => 'number-of-show-widget-items',
                'type'          => 'slider',
                'title'         => esc_html__('Show Number Of Widget Items','kapee'),
                'default'       => 8,
                'min'           => 5,
                'step'          => 1,
                'max'           => 50,
                'display_value' => 'text',
				'required' => array( 'widget-items-hide-max-limit', '=', 1 )
            ),
			array(
                'id'       => 'sidebar-canvas-mobile',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sidebar Canvas In Mobile', 'kapee' ),
                'subtitle' => esc_html__( 'Display sidebar canvas in mobile.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
		),
	) );
	
	/*
	* 404 options 
	*/ 
    Redux::setSection( $opt_name, array(
        'title'   => esc_html__( 'Page 404', 'kapee' ),
        'subsection' => true,
        'fields'  => array(
			array(
				'id'      => 'kapee-404_heading',
				'type'    => 'text',
				'title'   => esc_html__( 'Heading text', 'kapee' ),                    
				'default' => esc_html__('PAGE NOT FOUND', 'kapee'),								  
			),
			array(
				'id'       	=> 'kapee-404_content',
				'type'     	=> 'editor',
				'title'    	=> esc_html__( 'Content body Text', 'kapee' ),
				'subtitle'	=> esc_html__( 'Custom html allow', 'kapee' ),
				'args'   	=> array(
					'teeny'            => true,
				),
				'default'  => esc_html__('Sorry, the page you are looking for is not available. Maybe you want to perform a search?', 'kapee'),

			),
			array(
				'id'      => 'kapee-404_btn_txt',
				'type'    => 'text',
				'title'   => esc_html__( 'Button text', 'kapee' ),                    
				'default' => 'Back To Home?',
								  
			),                   
		)
    ));     
		
	/*
	* Post options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Blog / Post', 'kapee' ),
        'id'         => 'section-blog',
		'icon'		 => 'el el-edit',
        'fields'     => array(
			array(
                'id'       => 'post-fancy-date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Fancy Date', 'kapee' ),
                'subtitle'    => esc_html__( 'Show post fancy date.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
                'default'  => 0,
            ),
			array(
                'id'       => 'fancy-date-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Fancy Date Style', 'kapee' ),
                'subtitle'    => esc_html__( 'Select fancy date style.', 'kapee' ),
                'options'  => array(
					 'fancy-square-date' => array(
                        'alt' => 'Fancy Square Date',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/fancy-squar-date.png',
                    ),
					'fancy-box2-date' => array(
                        'alt' => 'Fancy Box2 Date',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/fancy-box-2-date.png',
                    ), 
                    'fancy-box-date' => array(
                        'alt' => 'Fancy Box Date',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/fancy-box-date.png',
                    ),			
                   					
                ),
                'default'  => 'fancy-square-date',
				'required' => array( 'post-fancy-date', '=', 1 )
            ),
			array(
                'id'       => 'sticky-post-icon',
                'type'     => 'switch',
                'title'    => esc_html__('Sticky Post Icon','kapee'),
                'subtitle' => esc_html__('Show sticky post icon.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'post-format-icon',
                'type'     => 'switch',
                'title'    => esc_html__('Post Format Icon','kapee'),
                'subtitle' => esc_html__('Show post format icon.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'post-category',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Category', 'kapee' ),
                'subtitle' => esc_html__( 'Show post category.', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'post-meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Meta', 'kapee' ),
                'subtitle' => esc_html__( 'Show post meta.', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'specific-post-meta',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Specific Post Meta', 'kapee' ),
                'subtitle' => esc_html__( 'Select specific post meta to dispaly on post.', 'kapee' ),
                'multi'    => true,
                'options'  => array(
                    'post-author' 		=> esc_html__('Author', 'kapee' ),
                    'post-date' 		=> esc_html__('Date', 'kapee' ),
                    'post-category' 	=> esc_html__('Category', 'kapee' ),					
                    'post-tags' 		=> esc_html__('Tags', 'kapee' ),
					'post-comments' 	=> esc_html__('Comments', 'kapee' ),
					'post-views' 		=> esc_html__('Views', 'kapee' ),
					'post-rtime' 		=> esc_html__('Read Time', 'kapee' ),
					'post-share' 		=> esc_html__('Share', 'kapee' ),
					'post-edit' 		=> esc_html__('Edit', 'kapee' ),
                ),
                'default'  => array( 'post-author', 'post-date' ),
				'required' => array( 'post-meta', '=', 1 )
            ),
			array(
                'id'       => 'post-meta-icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Meta Icon', 'kapee' ),
                'subtitle' => esc_html__( 'Show post meta icon.', 'kapee' ),
                'default'  => 0,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
				'required' => array( 'post-meta', '=', 1 )
            ),
			array(
                'id'       => 'post-meta-separator',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Post Meta Separator', 'kapee' ),
                'options'  => array(
					'meta-separator-slash'	=> esc_html('/'),
					'meta-separator-colon'	=> esc_html(':'),
					'meta-separator-dot'	=> esc_html('.'),
					'meta-separator-bar'	=> esc_html('|'),
					'meta-separator-hyphen'	=> esc_html('-'),
					'meta-separator-tilde'	=> esc_html('~'),
				),
                'default'  => 'meta-separator-dot',
				'required' => array( 'post-meta', '=', 1 )
            ),		
		)
	) );
	
	/*
	* Blog/Archives options
	*/
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Blog / Archives', 'kapee' ),
        'id'         => 'blog-archive',
		'subsection'	 => true,
        'fields'     => array(
			array(
                'id'       => 'blog-page-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' => esc_html__( 'Select blog/archive page layout with sidebar postion.', 'kapee' ),
                'options'  => array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  => 'right-sidebar'
            ),
			array(
                'id'       => 'blog-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'blog-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'blog-page-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Sidebar Widget Area','kapee'),
                'subtitle' => esc_html__('Select blog page sidebar widget area.','kapee'),
                'data'     => 'sidebars',
                'default'  => 'sidebar-1',
                'required' => array( 'blog-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'blog-page-title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Title', 'kapee' ),
                'subtitle' => esc_html__( 'Show blog page title.','kapee'),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'    	=> 'blog-page-title-text',
                'type'      => 'text',
                'title'     => esc_html__( 'Blog Page Title Text', 'kapee' ),
                'subtitle' 	=> esc_html__( 'Enter blog page title.','kapee'),
                'default'   => esc_html__( 'Blog', 'kapee' ),
                'placeholder' => esc_attr__('Enter blog post title here','kapee'),
				'required' 	=> array( 'blog-page-title', '=', 1 )
            ),
			array(
                'id'       => 'blog-page-breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__( 'Blog Page Breadcrumb', 'kapee' ),
                'subtitle' => esc_html__( 'Show blog page breadcrumb.','kapee'),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'blog-post-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Post Style', 'kapee' ),
                'subtitle' => esc_html__( 'Choose Blog Post Style.','kapee'),
                'options'  => array(
					'blog-center' => array(
                        'title' => 'Default Center',
                        'alt' => 'Default Center',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/default-center.png',
                    ),
					'blog-small-image' => array(
                        'title' => 'Small Image',
                        'alt' => 'Small Image',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/small-image.png',
                    ),
					'blog-chess' => array(
                        'title' => 'Blog Chess',
                        'alt' => 'Blog Chess',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/blog-chess.png',
                    ),
					'blog-grid' => array(
                        'title' => 'Blog Grid',
                        'alt' => 'Blog Grid',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/blog-grid.png',
                    ),
					/* 'blog-timeline' => array(
                        'alt' => 'Blog Timeline',
                        'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                    ), */
                ),
                'default'  => 'blog-center',
            ),
			array(
                'id'       => 'blog-grid-layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Gird Layout', 'kapee' ),
                'subtitle' => esc_html__( 'Choose gird layout style.', 'kapee'),
                'options'  => array(
                    'simple-grid' 		=> esc_html__('Simple', 'kapee' ),
                    'masonry-grid' 		=> esc_html__('Masonry', 'kapee' ),
                ),
                'default'  => 'simple-grid',
				'required' => array( 'blog-post-style', '=', array( 'blog-grid' ) )
            ),
			array(
                'id'       => 'blog-grid-post-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Grid Post Style', 'kapee' ),
                'subtitle' => esc_html__(' Choose grid post style.','kapee'),
                'options'  => array(
					'blog-grid-center' => array(
                        'title' => 'Default Center',
                        'alt' => 'Default Center',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/default-center.png',
                    ),
					'blog-grid-gradient-overlay' => array(
                        'title' => 'Gradient Overlay',
                        'alt' => 'Gradient Overlay',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/gradient-overlay.png',
                    ),					
                ),
                'default'  => 'blog-grid-center',
				'required' => array( 'blog-post-style', '=', array( 'blog-grid' ) ),
            ),						
			array(
                'id'       => 'blog-grid-columns',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Gird Columns', 'kapee' ),
                'subtitle' => esc_html__( 'If you have choosed post style grid or masonry grid layout, so you can manage here number of grid columns display.', 'kapee' ),
                'options'  => array(
                    '2' 		=> esc_html__('2 Columns', 'kapee' ),
                    '3' 	=> esc_html__('3 Columns(in Full Width)', 'kapee' ),
					'4' 		=> esc_html__('4 Columns(in Full Width)', 'kapee' ),
                ),
                'default'  => '2',
				'required' => array( 'blog-post-style', '=', array('blog-grid') ),
            ),
			array(
                'id'       => 'blog-post-thumbnail',
                'type'     => 'switch',
                'title'    => esc_html__('Post Thumbnail','kapee'),
                'subtitle' => esc_html__('Show blog post thumbnail.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'blog-post-title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Title', 'kapee' ),
                'subtitle' => esc_html__('Show blog post title.','kapee'),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'show-blog-post-content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Content', 'kapee' ),
                'subtitle' => esc_html__('Show blog post content.','kapee'),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'blog-post-content',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Post Content ', 'kapee' ),
                'options'  => array(
					'excerpt-content'=>esc_html__('Excerpt Content','kapee'),
					'full-content'=>esc_html__('Full Content','kapee'),
				),
                'default'  => 'full-content',
            ),			
			array(
                'id'            => 'blog-excerpt-length',
                'type'          => 'slider',
                'title'         => esc_html__('Excerpt Length (words)','kapee'),
                'subtitle'      => esc_html__('Show blog listing excerpt content length (words).','kapee'),
                'default'       => 30,
                'min'           => 10,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
				'required' => array( 'blog-post-content', '=', 'excerpt-content' )
            ),
			array(
                'id'       => 'read-more-button',
                'type'     => 'switch',
                'title'    => esc_html__( 'Read More Button', 'kapee' ),
                'subtitle' => esc_html__( 'Show read more button.','kapee'),
                'default'  => 1,
                'on'       => esc_html__('Yes','kapee'),
                'off'      => esc_html__('No','kapee'),
            ),
			array(
                'id'       => 'read-more-button-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Read More Button Style', 'kapee' ),
                'subtitle' => esc_html__( 'Choose read more button style.','kapee'),
                'options'  => array(
					'read-more-link'=>esc_html__('Link','kapee'),
					'read-more-button'=>esc_html__('Button','kapee'),
					'read-more-button-fill'=>esc_html__('Button Fill','kapee'),
				),
                'default'  => 'read-more-link',
				'required' => array( 'read-more-button', '=', 1 )
            ),
			array(
                'id'       => 'read-more-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Read More Text', 'kapee' ),
                'subtitle' => esc_html__( 'Enter read more button text.','kapee'),
                'default'  => 'Continue Reading',
				'required' => array( 'read-more-button', '=', 1 )
            ),
			array(
                'id'       => 'blog-pagination-style',
                'type'     => 'button_set',
                'title'    => esc_html__( ' Pagination Style', 'kapee' ),
                'subtitle' => esc_html__( 'Choose blog page pagination style.','kapee'),
                'options'  => array(
					'default'=>esc_html__('Default','kapee'),
					'infinity-scroll'=>esc_html__('Infinity Scroll','kapee'),
					'load-more-button'=>esc_html__('Load More','kapee'),
				),
                'default'  => 'default',
            ),
			array(
                'id'       => 'blog-pagination-load-more-button-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Load More Button Text', 'kapee' ),
				'subtitle' => esc_html__('Add Load More Button Text.','kapee'),
                'default'  => 'Load More Posts',
				'required' => array( 'blog-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
			array(
                'id'       => 'blog-pagination-finished-message',
                'type'     => 'text',
                'title'    => esc_html__( 'Finished Message', 'kapee' ),
				'subtitle' => esc_html__('Text to display when no additional items are available.','kapee'),
                'default'  => 'No More Posts Available',
				'required' => array( 'blog-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
		),
	) );
	
	/*
	* Single Post options
	*/
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Single Post', 'kapee' ),
        'id'         => 'single-post',
		'subsection'	 => true,
        'fields'     => array(
			array(
                'id'       => 'single-post-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Sidebar', 'kapee' ),
                'subtitle' => esc_html__( 'Select single post sidebar layout.', 'kapee' ),
                'options'  => array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  => 'right-sidebar'
            ),
			array(
                'id'       => 'single-post-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'single-post-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'single-post-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Sidebar Widget Area','kapee'),
                'data'     => 'sidebars',
                'default'  => 'sidebar-1',
                'required' => array( 'single-post-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'single-post-thumbnail',
                'type'     => 'switch',
                'title'    => esc_html__('Post Thumbnail','kapee'),
                'subtitle' => esc_html__('Show/hide single post thumbnail.','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-post-gallery-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Post Gallery Style', 'kapee' ),
                'options'  => array(
					'slider'		=>esc_html__('Slider','kapee'),
					'grid'			=>esc_html__('Grid','kapee'),
					'one-column'	=>esc_html__('One Column','kapee'),					
				),
                'default'  => 'slider',
				'required' => array( 'single-post-thumbnail', '=', 1 )
            ),
			array(
                'id'       => 'single-post-title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Title', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'         	=> 'single-post-title-text',
                'type'        	=> 'text',
                'title'       	=> esc_html__( 'Page Title Text', 'kapee' ),
                'default'       => esc_html__( 'Our Blog', 'kapee' ),
                'placeholder' 	=> esc_attr__('Enter post title here','kapee'),
				'required' 		=> array( 'single-post-title', '=', 1 )
            ),
			array(
                'id'       => 'single-post-author-info',
                'type'     => 'switch',
                'title'    => esc_html__( 'Author Info', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'single-post-tag',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Tags', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'single-post-social-share-link',
                'type'     => 'switch',
                'title'    => esc_html__( 'Social Share Links', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),			
			array(
                'id'       => 'single-post-navigation',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Navigation', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'single-post-comment',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Comments', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'single-post-related',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Posts', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       	=> 'show-related-posts',
                'type'     	=> 'slider',
                'title'    	=> esc_html__( 'Show Related Posts', 'kapee' ),
				'subtitle'  => esc_html__('Show/display number of related posts.','kapee'),
                'default'   => 6,
                'min'       => 2,
                'step'      => 1,
                'max'       => 12,
                'display_value' => 'text',
				'required' => array( 'single-post-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-posts-taxonomy',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Taxonomy', 'kapee' ),
				'subtitle' => esc_html__('Get related posts by post taxonomy category or tag.','kapee'),
                'options'  => array(
					'post_tag'=>esc_html__('Tag','kapee'),
					'category'=>esc_html__('Category','kapee'),					
				),
                'default'  => 'post_tag',
				'required' => array( 'single-post-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-posts-orderby',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Post Orderby', 'kapee' ),
                'options'  => array(
					'none'=>esc_html__('None','kapee'),
					'rand'=>esc_html__('Random','kapee'),
					'ID'=>esc_html__('ID','kapee'),
					'name'=>esc_html__('Name','kapee'),
					'date'=>esc_html__('Date','kapee'),
					'modified'=>esc_html__('Modified Date','kapee'),					
					'comment_count'=>esc_html__('Comment Count','kapee'),
				),
                'default'  => 'rand',
				'required' => array( 'single-post-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-posts-order',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Post Order', 'kapee' ),
                'options'  => array(
					'DESC'=>esc_html__('DESC','kapee'),
					'ASC'=>esc_html__('ASC','kapee'),					
				),
                'default'  => 'DESC',
				'required' => array( 'single-post-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-posts-display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display Posts In', 'kapee' ),
				'subtitle' => esc_html__('Display related posts in slider or grid.','kapee'),
                'options'  => array(
					'slider'=>esc_html__('Slider','kapee'),
					'grid'=>esc_html__('Grid','kapee'),					
				),
                'default'  => 'slider',
				'required' => array( 'single-post-related', '=', 1 ),
            ),
		),
	) ); /* End Single Post Section */

	/*
	* Portfolio options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Portfolio', 'kapee' ),
        'id'         => 'portfolio',
		'icon'		 => 'el el-th',
        'fields'     => array(
			array(
                'id'       => 'enable-portfolio',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Enable','kapee'),
                'off'      => esc_html__('Disable','kapee'),
            ),
			array(
                'id'       => 'portfolio-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Slug Name', 'kapee' ),
                'default'  => '',
                'placeholder'  => esc_attr('portfolio'),
            ),
			array(
                'id'       => 'portfolio-name',
                'type'     => 'text',
                'title'    => esc_html__( 'Name', 'kapee' ),
                'default'  => '',
                'placeholder'  => esc_attr__('Portfolios','kapee'),
            ),
			array(
                'id'       => 'portfolio-singular-name',
                'type'     => 'text',
                'title'    => esc_html__( 'Singular Name', 'kapee' ),
                'default'  => '',
                'placeholder'  => esc_attr__('Portfolio','kapee'),
            ),
			array(
                'id'       => 'portfolio-cat-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Category Slug', 'kapee' ),
                'default'  => '',
                'placeholder'  => esc_attr('portfolio_cat'),
            ),
			array(
                'id'       => 'portfolio-skill-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Skill Slug', 'kapee' ),
                'default'  => '',
                'placeholder'  => esc_attr('portfolio_skill'),
            ),
			array(
                'id'       => 'portfolio-meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Meta', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'specific-portfolio-meta',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Portfolio Meta', 'kapee' ),
                'subtitle' => esc_html__( 'Show/hide specific meta.', 'kapee' ),
                'multi'    => true,
                'options'  => array(
                    'categories' 	=> esc_html__('Category', 'kapee' ),
                    'skills' 		=> esc_html__('Skill', 'kapee' ),
                ),
                'default'  => array( 'categories', 'skills'),
				'required' => array( 'portfolio-meta', '=', 1 )
            ),
		)
	) );
	/* END Portfolio SECTIONS */
	
	/*
	* Portfolio Archives options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Portfolio Archives', 'kapee' ),
        'id'         => 'portfolio-archive',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'portfolio-page-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Layout', 'kapee' ),
                'options'  => array(
                    'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  => 'full-width',
            ),
			array(
                'id'       => 'portfolio-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'portfolio-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'portfolio-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Select Sidebar Widget Area','kapee'),
                'data'     => 'sidebars',
                'default'  => 'sidebar-1',
                'required' => array( 'portfolio-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'portfolio-page-title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Title', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'        => 'portfolio-page-title-text',
                'type'      => 'text',
                'title'     => esc_html__( 'Page Title Text', 'kapee' ),
                'placeholder' => esc_attr__('Enter portfolio post title here','kapee'),
				'default'  	=> 'Portfolio',
				'required' 	=> array( 'portfolio-page-title', '=', 1 )
            ),
			array(
                'id'       => 'portfolio-page-breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Breadcrumb', 'kapee' ),
                'default'  => 1,
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
            ),
			array(
                'id'       => 'portfolio-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Portfolio Hover Style', 'kapee' ),
                'options'  => array(
                    'portfolio-style-1' => array(
                        'alt' => 'Style 1',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-1.png',
                    ),
					'portfolio-style-2' => array(
                        'alt' => 'Style 2',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-2.png',
                    ),
					'portfolio-style-3' => array(
                        'alt' => 'Style 3',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-3.png',
                    ),
					'portfolio-style-4' => array(
                        'alt' => 'Style 4',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-4.png',
                    ),
					'portfolio-style-5' => array(
                        'alt' => 'Style 5',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-5.png',
                    ),
					'portfolio-style-6' => array(
                        'alt' => 'Style 6',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-6.png',
                    ),
					'portfolio-style-7' => array(
                        'alt' => 'Style 7',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/style-7.png',
                    ),
                ),
                'default'  => 'portfolio-style-1',
            ),
			array(
                'id'       => 'portfolio-grid-layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Portfolio Grid Layout', 'kapee' ),
                'options'  => array(
                    'simple-grid' 	=> esc_html__('Simple', 'kapee' ),
                    'masonry-grid' 	=> esc_html__('Masonry', 'kapee' ),
                ),
                'default'  => 'masonry-grid',
            ),
			array(
                'id'       	=> 'portfolio-grid-columns',
                'type'     	=> 'button_set',
                'title'    	=> esc_html__( 'Portfolio Grid Columns', 'kapee' ),
                'options'  	=> array(
                    '2' 	=> esc_html__('2 Columns', 'kapee' ),
                    '3' 	=> esc_html__('3 Columns', 'kapee' ),
					'4' 	=> esc_html__('4 Columns', 'kapee' ),
                ),
                'default'  => '3',
            ),
			array(
                'id'            => 'portfolio-grid-gap',
                'type'          => 'slider',
                'title'         => esc_html__('Portfolio Grid Gapping','kapee'),
                'subtitle'      => esc_html__('Grid gapping/spacing between portfolio.','kapee'),
                'default'       => 15,
                'min'           => 0,
                'step'          => 5,
                'max'           => 15,
				'required' => array( 'portfolio-style', '=', array( 'portfolio-style-3', 'portfolio-style-4', 'portfolio-style-5', 'portfolio-style-6', 'portfolio-style-7' )),
            ),
			array(
                'id'       => 'portfolio-filter',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Filter', 'kapee' ),
				'subtitle' => esc_html__( 'Show portfolios filter or not.', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'            => 'portfolio-per-page',
                'type'          => 'slider',
                'title'         => esc_html__('Portfolio Per Page','kapee'),
                'subtitle'      => esc_html__('Show number of portfolio per page.','kapee'),
                'default'       => 9,
                'min'           => 3,
                'step'          => 1,
                'max'           => 50,
                'display_value' => 'text',
            ),
			array(
                'id'       => 'portfolio-button-icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hover Button Icon', 'kapee' ),
				'subtitle' => esc_html__( 'Portfolio hover button icon show or hide.', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'portfolio-link-icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Link Button Icon', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
                'default'  => 1,
				'required' => array( 'portfolio-button-icon', '=', 1 ),
            ),
			array(
                'id'       => 'portfolio-zoom-icon',
                'type'     => 'switch',
                'title'    => esc_html__( 'Zoom Image Icon', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
				'required' => array( 'portfolio-button-icon', '=', 1 ),
            ),
			array(
                'id'       => 'portfolio-content-part',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Content Part', 'kapee' ),
				'subtitle' => esc_html__( 'Portfolio bottom content part( title and category) show or hide.', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
				 'default'  => 1,
            ),
			array(
                'id'       => 'portfolio-category',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Category', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
				'required' => array( 'portfolio-content-part', '=', 1 ),
            ),
			array(
                'id'       => 'portfolio-title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Title', 'kapee' ),
                'on'       => esc_html__('Show','kapee'),
                'off'      => esc_html__('Hide','kapee'),
                'default'  => 1,
				'required' => array( 'portfolio-content-part', '=', 1 ),
            ),			
			array(
                'id'       => 'portfolio-pagination-style',
                'type'     => 'button_set',
                'title'    => esc_html__( ' Pagination Style', 'kapee' ),
                'options'  => array(
					'default'=>esc_html__('Default','kapee'),
					'infinity-scroll'=>esc_html__('Infinity Scroll','kapee'),
					'load-more-button'=>esc_html__('Load More','kapee'),
				),
                'default'  => 'default',
            ),
			array(
                'id'       => 'portfolio-pagination-load-more-button-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Load More Button Text', 'kapee' ),
				'subtitle' => esc_html__('Add Load More Button Text.','kapee'),
                'default'  => 'Load More Portfolios',
				'required' => array( 'portfolio-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
			array(
                'id'       => 'portfolio-pagination-finished-message',
                'type'     => 'text',
                'title'    => esc_html__( 'Finished Message', 'kapee' ),
				'subtitle' => esc_html__('Text to display when no additional items are available.','kapee'),
                'default'  => 'No More Portfolios Available',
				'required' => array( 'portfolio-pagination-style', '=', array('infinity-scroll', 'load-more-button') ),
            ),
		)
	) );
	/* END Portfolio Archives SECTIONS */
	
	/*
	* Single Portfolio options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Single Portfolio', 'kapee' ),
        'id'         => 'single-portfolio',
		'subsection'	 => true,
        'fields'     => array(
			array(
                'id'       => 'single-portfolio-page-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' => esc_html__( 'Select single post sidebar layout.', 'kapee' ),
                'options'  => array(
                   'full-width' => array(
                        'alt' => 'Full Width',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-none.png',
                    ),                   
                    'left-sidebar' => array(
                        'alt' => '2 Column Left',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-left.png',
                    ), 
					'right-sidebar' => array(
                        'alt' => '2 Column Right',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/sidebar-right.png',
                    ), 
                ),
                'default'  => 'full-width'
            ),
			array(
                'id'       => 'single-portfolio-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'single-portfolio-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'single-portfolio-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Sidebar Widget Area','kapee'),
                'data'     => 'sidebars',
                'default'  => 'sidebar-1',
                'required' => array( 'single-portfolio-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            ),
			array(
                'id'       => 'single-portfolio-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Portfolio Layout', 'kapee' ),
               'options'  => array(
                    '4' 	=> array(
                        'alt' => ' 4 8 Column',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/4_8-layout.png',
                    ),
					'6' 	=> array(
                        'alt' => ' 6 6 Column',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/6_6-layout.png',
                    ),                   
                    '8' => array(
                        'alt' => '8 4 Column',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/8_4-layout.png',
                    ), 
					'12' => array(
                        'alt' => '12 12 Column',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/portfolio/12_12-layout.png',
                    ),
                ),
                'default'  => '8',
            ),
			array(
                'id'       => 'single-portfolio-gallery',
                'type'     => 'switch',
                'title'    => esc_html__('Thumbnail/Gallery','kapee'),
                'subtitle' => esc_html__('Show/hide portfolio thumbnail/gallery.','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-gallery-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Gallery Style', 'kapee' ),
                'options'  => array(
					'slider'		=>esc_html__('Slider','kapee'),
					'grid'			=>esc_html__('Grid','kapee'),
					'one-column'	=>esc_html__('One Column','kapee'),					
				),
                'default'  => 'slider',
				'required' => array( 'single-portfolio-gallery', '=', 1 )
            ),			
			array(
                'id'       => 'single-portfolio-information-title',
                'type'     => 'switch',
                'title'    => esc_html__('Information Title','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-description',
                'type'     => 'switch',
                'title'    => esc_html__('Project Description','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-preview-button',
                'type'     => 'switch',
                'title'    => esc_html__('Preview Button','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-client',
                'type'     => 'switch',
                'title'    => esc_html__('Project Client','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-date',
                'type'     => 'switch',
                'title'    => esc_html__('Project Date','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-category',
                'type'     => 'switch',
                'title'    => esc_html__('Project Category','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-skill',
                'type'     => 'switch',
                'title'    => esc_html__('Project Skill','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-share',
                'type'     => 'switch',
                'title'    => esc_html__('Social Share Links','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Project Navigation','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-comments',
                'type'     => 'switch',
                'title'    => esc_html__('Comment','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'single-portfolio-related',
                'type'     => 'switch',
                'title'    => esc_html__('Related Projects','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       	=> 'show-related-portfolios',
                'type'     	=> 'slider',
                'title'    	=> esc_html__( 'Show Related Portfolios', 'kapee' ),
				'subtitle'  => esc_html__('Show/display number of related Portfolios.','kapee'),
                'default'   => 6,
                'min'       => 2,
                'step'      => 1,
                'max'       => 12,
                'display_value' => 'text',
				'required' => array( 'single-portfolio-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-portfolios-taxonomy',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Taxonomy', 'kapee' ),
				'subtitle' => esc_html__('Get related Portfolios by post taxonomy category or tag.','kapee'),
                'options'  => array(
					'portfolio_cat'		=>esc_html__('Category','kapee'),
					'portfolio_skills'	=>esc_html__('Skill','kapee'),				
				),
                'default'  => 'portfolio_cat',
				'required' => array( 'single-portfolio-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-Portfolios-orderby',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Portfolios Orderby', 'kapee' ),
                'options'  => array(
					'none'=>esc_html__('None','kapee'),
					'rand'=>esc_html__('Random','kapee'),
					'ID'=>esc_html__('ID','kapee'),
					'name'=>esc_html__('Name','kapee'),
					'date'=>esc_html__('Date','kapee'),
					'modified'=>esc_html__('Modified Date','kapee'),					
					'comment_count'=>esc_html__('Comment Count','kapee'),
				),
                'default'  => 'rand',
				'required' => array( 'single-portfolio-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-portfolios-order',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Portfolios Order', 'kapee' ),
                'options'  => array(
					'DESC'=>esc_html__('DESC','kapee'),
					'ASC'=>esc_html__('ASC','kapee'),					
				),
                'default'  => 'DESC',
				'required' => array( 'single-portfolio-related', '=', 1 ),
            ),
			array(
                'id'       => 'related-portfolios-display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display Portfolios In', 'kapee' ),
				'subtitle' => esc_html__('Display related portfolios in slider or grid.','kapee'),
                'options'  => array(
					'slider'=>esc_html__('Slider','kapee'),
					'grid'=>esc_html__('Grid','kapee'),					
				),
                'default'  => 'slider',
				'required' => array( 'single-portfolio-related', '=', 1 ),
            ),			
		)
	) ); /* END Portfolio Single SECTIONS */
	
	/*
	* Social
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Social', 'kapee' ),
        'id'         => 'social',
		'icon'		 => 'el el-group',
        'fields'     => array(
		)
	) );
	
	/*
	* Social Profile
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Social Profile', 'kapee' ),
        'id'         => 'social-profile',
		'icon'		 => '',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'show-social-profile',
                'type'     => 'switch',
                'title'    => esc_html__('Social Profile Icon','kapee'),
				'subtitle' => esc_html__('Show social profile icon in header and footer.','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'social-profile-icons-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Icons Style', 'kapee' ),
                'options'  => array(
					'icons-default' 	=> array(
                        'title' => 'Default',
                        'alt' => 'Default',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/default.png',
                    ),
					'icons-colour'	=> array(
                        'title' => 'Colour',
                        'alt' => 'Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/colour.png',
                    ),                   
                    'icons-bordered'  => array(
                        'title' => 'Bordered',
                        'alt' => 'Bordered',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/bordered.png',
                    ), 
					'icons-fill-colour' => array(
                        'title' => 'Fill Colour',
                        'alt' => 'Fill Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/fill-color.png',
                    ),
					'icons-theme-colour' => array(
                        'title' => 'Theme Colour',
                        'alt' => 'Theme Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/theme-color.png',
                    ),
										
                ),
                'default'  => 'icons-default',
				'required' => array( 'show-social-profile', '=', 1 )
            ),
			array(
                'id'       => 'profile-icons-size',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Icons Size', 'kapee' ),
                'options'  => array(
                    'icons-size-default'=> esc_html__('Default','kapee'),
					'icons-size-small' 	=> esc_html__('Small','kapee'),
					'icons-size-large' 	=> esc_html__('Large','kapee'),
                ),
                'default'  => 'icons-size-small',
				'required' => array( 'show-social-profile', '=', 1 )
            ),
			array(
                'id'       => 'facebook-link',
                'type'     => 'text',
                'title'    => esc_html__('Facebook','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the facebook icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'twitter-link',
                'type'     => 'text',
                'title'    => esc_html__('Twitter','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the twitter icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'instagram-link',
                'type'     => 'text',
                'title'    => esc_html__('Instagram','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the instagram icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'linkedin-link',
                'type'     => 'text',
                'title'    => esc_html__('Linkedin','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the linkedin icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'flickr-link',
                'type'     => 'text',
                'title'    => esc_html__('Flickr','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the flickr icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),			
			array(
                'id'       => 'rss-link',
                'type'     => 'text',
                'title'    => esc_html__('RSS','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the rss icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'pinterest-link',
                'type'     => 'text',
                'title'    => esc_html__('Pinterest','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the pinterest icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'youtube-link',
                'type'     => 'text',
                'title'    => esc_html__('Youtube','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the youtube icon. Leave blank to hide icon.','kapee'),
				'default'  => '#',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'tiktok-link',
                'type'     => 'text',
                'title'    => esc_html__('TikTok','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the tiktok icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'github-link',
                'type'     => 'text',
                'title'    => esc_html__('Github','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the github icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'whatsapp-link',
                'type'     => 'text',
                'title'    => esc_html__('WhatsApp','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the whatsapp icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'telegram-link',
                'type'     => 'text',
                'title'    => esc_html__('Telegram','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the telegram icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
			array(
                'id'       => 'vk-link',
                'type'     => 'text',
                'title'    => esc_html__('VK','kapee'),
                'subtitle' => esc_html__('Enter your custom link to show the VK icon. Leave blank to hide icon.','kapee'),
				'default'  => '',
				'required' => array( 'show-social-profile', '=', 1 ),
            ),
		)
	) );
	
	/*
	* Social Share
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Social Share', 'kapee' ),
        'id'         => 'social-share',
		'icon'		 => '',
		'subsection' => true,
        'fields'     => array(
			array(
                'id'       => 'show-social-sharing',
                'type'     => 'switch',
                'title'    => esc_html__('Share Icons','kapee'),
				'subtitle' => esc_html__('Show social share icons in blog, posts, products, portfolios, etc...','kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'social-sharing-icons-style',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Icons Style', 'kapee' ),
                'options'  => array(
					'icons-default' 	=> array(
                        'title' => 'Default',
                        'alt' => 'Default',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/default.png',
                    ),
					'icons-colour'	=> array(
                        'title' => 'Colour',
                        'alt' => 'Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/colour.png',
                    ),                   
                    'icons-bordered'  => array(
                        'title' => 'Bordered',
                        'alt' => 'Bordered',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/bordered.png',
                    ), 
					'icons-fill-colour' => array(
                        'title' => 'Fill Colour',
                        'alt' => 'Fill Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/fill-color.png',
                    ),
					'icons-theme-colour' => array(
                        'title' => 'Theme Colour',
                        'alt' => 'Theme Colour',
                        'img' => KAPEE_ADMIN_IMAGES . 'layout/social-icon/theme-color.png',
                    ),
										
                ),
                'default'  => 'icons-bordered',
				'required' => array( 'show-social-sharing', '=', 1 )
            ),
			array(
                'id'       => 'sharing-icons-shape',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Icons Shape', 'kapee' ),
                'options'  => array(
					'icons-shape-circle' => esc_html__('Circle','kapee'),
                    'icons-shape-square' => esc_html__('Square','kapee'),
                ),
                'default'  => 'icons-shape-circle',
				'required' => array( 'show-social-sharing', '=', 1 )
            ),
			array(
                'id'       => 'sharing-icons-size',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Icons Size', 'kapee' ),
                'options'  => array(
                    'icons-size-default'=> esc_html__('Default','kapee'),
					'icons-size-small' 	=> esc_html__('Small','kapee'),
					'icons-size-large' 	=> esc_html__('Large','kapee'),
                ),
                'default'  => 'icons-size-default',
				'required' => array( 'show-social-sharing', '=', 1 )
            ),
			array(
                'id'       => 'social-share-manager',
                'type'     => 'sorter',
                'title'    => 'Share Icons Manager',
                'compiler' => 'true',
                'options'  => array(
                    'enabled'  => array(
                        'facebook' 		=> 'Facebook',
                        'twitter'     	=> 'Twitter',
                        'linkedin'   	=> 'Linkedin',
						'telegram'		=> 'Telegram',
						'pinterest'		=> 'Pinterest',
                    ),
                    'disabled' => array(
						'stumbleupon'	=> 'StumbleUpon',
						'tumblr'   		=> 'Tumblr',
						'reddit'   		=> 'Reddit',
						'vk'   			=> 'VK',
						'odnoklassniki' => 'Odnoklassniki',
						'pocket'   		=> 'Pocket',
						'whatsapp'  	=> 'WhatsApp',
						'email'   		=> 'Email',
						'print'   		=> 'Print',
					),
                ),
				'required' => array( 'show-social-sharing', '=', 1 )
            ),			
		)
	) );/* End Social sections */
			
	/*
	* Slider Config
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Slider Config', 'kapee' ),
        'id'         => 'slider-config',
		'icon'		 => 'el el-picture',
        'fields'     => array(
			array(
                'id'       => 'slider-loop',
                'type'     => 'switch',
                'title'    => esc_html__('Loop','kapee'),
				'subtitle' => esc_html__('Infinity loop. Duplicate last and first items to get loop illusion.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'slider-autoplay',
                'type'     => 'switch',
                'title'    => esc_html__('Autoplay','kapee'),
                'subtitle' => esc_html__('Autoplay.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),			
			array(
                'id'       => 'slider-autoplay-hover-pause',
                'type'     => 'switch',
                'title'    => esc_html__('autoplayHoverPause','kapee'),
				'subtitle' => esc_html__('Pause on mouse hover.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
				'required' => array( 'slider-autoplay', '=', 1 )
            ),
			array(
                'id'       => 'slider-autoplaytimeout',
                'type'     => 'text',
                'title'    => esc_html__( 'autoplayTimeout', 'kapee' ),
				'subtitle' => esc_html__('Autoplay interval timeout.','kapee'),
                'default'  => 3500,
				'validate' => 'numeric',
				'required' => array( 'slider-autoplay', '=', 1 )
            ),
			array(
                'id'       => 'slider-center',
                'type'     => 'switch',
                'title'    => esc_html__('Center','kapee'),
				'subtitle' => esc_html__('Center item. Works well with even an odd number of items.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'slider-smartspeed',
                'type'     => 'text',
                'title'    => esc_html__( 'smartSpeed', 'kapee' ),
				'subtitle' => esc_html__('Speed Calculate. More info to come..','kapee'),
                'default'  => 750,
				'validate' => 'numeric',
            ),			
			array(
                'id'       => 'slider-rewind',
                'type'     => 'switch',
                'title'    => esc_html__('Rewind','kapee'),
				'subtitle' => esc_html__('Go backwards when the boundary has reached.','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'slider-auto-height',
                'type'     => 'switch',
                'title'    => esc_html__('AutoHeight','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'slider-navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Navigation','kapee'),
				'subtitle' => esc_html__( 'Show next/prev navigation.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'slider-navigation-mobile',
                'type'     => 'switch',
                'title'    => esc_html__( 'Navigation in Mobile', 'kapee' ),
				'subtitle' => esc_html__( 'Show next/prev navigation in mobile.', 'kapee' ),
                'on'       => esc_html__( 'Yes', 'kapee' ),
				'off'      => esc_html__( 'No', 'kapee' ),
				'default'  => 0,
            ),
			array(
                'id'       => 'slider-nav-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Navigation Style', 'kapee' ),
                'options'  => array(
					'owl-nav-rectangle'	=> esc_html__('Rectangle','kapee'),
					'owl-nav-circle'	=> esc_html__('Circle','kapee'),
					'owl-nav-square'	=> esc_html__('Square','kapee'),
					'owl-nav-arrow'		=> esc_html__('Arrow','kapee'),
				),
                'default'  => 'owl-nav-rectangle',
				'required' => array( 'slider-navigation', '=', 1 )
            ),
			/* array(
                'id'       => 'slider-nav-position',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Navigation Position', 'kapee' ),
                'options'  => array(
					'owl-nav-middle'=>esc_html__('Middle','kapee'),				
					'owl-nav-top'	=>esc_html__('Top','kapee'),
				),
                'default'  => 'owl-nav-middle',
				'required' => array( 'slider-navigation', '=', 1 )
            ), */
			array(
                'id'       => 'slider-dots-navigation',
                'type'     => 'switch',
                'title'    => esc_html__('Dots Navigation','kapee'),
				'subtitle' => esc_html__( 'Show dots navigation.', 'kapee' ),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 1,
            ),
			array(
                'id'       => 'slider-touchDrag',
                'type'     => 'switch',
                'title'    => esc_html__('TouchDrag','kapee'),
				'subtitle' => esc_html__('Touch drag enabled','kapee'),
                'on'       => esc_html__('Yes','kapee'),
				'off'      => esc_html__('No','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'slider-touchDrag-mobile',
                'type'     => 'switch',
                'title'    => esc_html__( 'TouchDrag In Mobile', 'kapee' ),
				'subtitle' => esc_html__( 'Touch drag enabled in mobile.', 'kapee' ),
                'on'       => esc_html__( 'Yes', 'kapee' ),
				'off'      => esc_html__( 'No', 'kapee' ),
				'default'  => 1,
            ),
			array(
                'id'       => 'slider-animate-in',
                'type'     => 'text',
                'title'    => esc_html__( 'Animate In', 'kapee' ),
				'subtitle' => wp_kses_post('Please input animation. Please reference <a href="http://daneden.github.io/animate.css/">animate.css</a>. ex: fadeIn', 'kapee'),
                'default'  => '',
            ),
			array(
                'id'       => 'slider-animate-out',
                'type'     => 'text',
                'title'    => esc_html__( 'Animate Out', 'kapee' ),
				'subtitle' => wp_kses_post('Please input animation. Please reference <a href="http://daneden.github.io/animate.css/">animate.css</a>. ex: fadeOut', 'kapee'),
                'default'  => '',
            ),
		)
	) );/* END SLIDER CONFIG SECTIONS */	
	
	/*
	* Newsletter Options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Newsletter', 'kapee' ),
        'id'         => 'section-newsletter',
		'icon'       => 'el el-envelope',
        'fields'     => array(
			array(
                'id'       => 'newsletter-popup',
                'type'     => 'switch',
                'title'    => esc_html__('Newsletter', 'kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Newsletter popup enable or disable in your site.', 'kapee'),
				'default'  => 0,
            ),
			array(
                'id'       			=> 'newsletter-popup-on',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Newletter Popup On','kapee'),
                'subtitle' 	   		=> esc_html__('Show newsletter popup on front page or all pages.', 'kapee' ),
                'options'  			=> array(
                    'front-page' 	=> esc_html__('Front Page', 'kapee' ),
                    'all-pages' 	=> esc_html__('All Pages', 'kapee' ),
                ),
                'default'  			=> 'all-pages',
				'required' 	=> array( 'newsletter-popup', '=', 1 ),
            ),
			array(
                'id'       => 'newsletter-show-mobile',
                'type'     => 'switch',
                'title'    => esc_html__('Mobile Device', 'kapee'),
                'on'       => esc_html__('Show','kapee'),
				'off'      => esc_html__('Hide','kapee'),
				'subtitle' => esc_html__('You want to show newsletter for mobile devices.', 'kapee'),
				'default'  => 1,
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
			array(
				'id'      	=> 'newsletter-when-appear',
				'type'    	=> 'button_set',
				'title'   	=> esc_html__( 'When Popup Appear?', 'kapee' ),                    
				'options' 	=> array(
					'page_load' 	=> esc_html__('On Page Load', 'kapee'),
					'scroll' 		=> esc_html__('When Page Scroll', 'kapee'),
					'exit' 			=> esc_html__('On Exit Intent', 'kapee'),
				), 
				'default' 	=> 'page_load',
				'required' 	=> array( 'newsletter-popup', '=', 1 ),
			),
			array(
				'id'       => 'newsletter-delay',
				'type'     => 'text',
				'title'    => esc_html__( 'Popup Delay', 'kapee' ),
				'default'  => '5',
				'subtitle' =>  esc_html__( 'Enter no of second to open popup after page load.', 'kapee' ),
				'required' => array( 'newsletter-when-appear', '=', 'page_load' ),
			),
			
			array(
				'id'       => 'newsletter-version',
				'type'     => 'text',
				'title'    => esc_html__( 'Popup Version', 'kapee' ),
				'default'  => '1',
				'subtitle' =>  esc_html__( 'Increase version number, for show forcefully popup who already closed it.', 'kapee' ),
				'required' 	=> array( 'newsletter-popup', '=', 1 ),
			),
			array(
				'id'       => 'newsletter-x-scroll',
				'type'     => 'text',
				'title'    => esc_html__( 'Open when user scroll % of page', 'kapee' ),
				'default'  => '30',
				'subtitle' =>  esc_html__( '100% - For end of page', 'kapee' ),
				'required' => array( 'newsletter-when-appear', '=', 'scroll' ),
			),
			array(
                'id'       => 'newsletter-title',
                'type'     => 'text',
                'title'    => esc_html__('Newsletter Title', 'kapee'),
				'default'  => esc_html__('Sign Up & Get 40% Off', 'kapee'),
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
			array(
				'id'       => 'newsletter-tag-line',
				'type'     => 'editor',
				'title'    => esc_html__('Main Content', 'kapee'),
				'subtitle' => esc_html__('It will be shown at just below title', 'kapee'),
               'required' => array( 'newsletter-popup', '=', 1 ),
				'default'  => esc_html__('Signup today for free and be the first to hear of special promotions, new arrivals, designer and offers news.', 'kapee'),
			),
			array(
                'id'       => 'newsletter-dont-show',
                'type'     => 'text',
                'title'    => esc_html__('Newsletter Don\'t Show Msg', 'kapee'),
				'default'  => esc_html__('Don\'t show this popup again', 'kapee'),
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
			array(
                'id'       	=> 'newsletter-background',
                'type'     	=> 'background',
                'title'    	=> esc_html__('Background Color', 'kapee'),
                'subtitle'  => esc_html__( 'Newsletter background with image, color, etc.', 'kapee' ),
				'output'	=> array('.kapee-newsletter-popup'),
                'default' 	=> array(
					'background-color' 		=> '#656565',
					'background-image' 		=> '',
					'background-repeat' 	=> '',
					'background-size' 		=> '',
					'background-attachment' => '',
					'background-position' 	=> '',
				),
				'required' 	=> array( 'newsletter-popup', '=', 1 ),
            ),
			array(
                'id'       			=> 'newsletter-color',
                'type'     			=> 'button_set',
                'title'    			=> esc_html__('Title Color','kapee'),
                'subtitle' 	   		=> esc_html__('Page title color.','kapee'),
                'options'  			=> array(
                    'default' 	=> esc_html__('Default', 'kapee' ),
                    'light' 	=> esc_html__('Light', 'kapee' ),
                    'dark' 		=> esc_html__('Dark', 'kapee' ),
                ),
                'default'  			=> 'light',
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
			array(
                'id'       		=> 'newsletter-button-bg-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Background Color', 'kapee' ),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#2370F4',
                    'hover'   	=> '#2370F4',
                ),			
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
			array(
                'id'       		=> 'newsletter-button-text-color',
                'type'     		=> 'link_color',
                'title'    		=> esc_html__( 'Button Text Color', 'kapee' ),
                'active'    	=> false,
                'default'  		=> array(
                    'regular' 	=> '#ffffff',
                    'hover'   	=> '#ffffff',
                ),			
				'required' => array( 'newsletter-popup', '=', 1 ),
            ),
		)
	) );
	
	/*
	* Cookie Options
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Cookie Notice', 'kapee' ),
        'id'         => 'section-cookie-notice',
		'icon'       => 'el el-dashboard',
        'fields'     => array(
			array(
                'id'       => 'cookie-notice',
                'type'     => 'switch',
                'title'    => esc_html__('Cookie','kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Cookie notice enable or disable in your site.','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'cookie-title',
                'type'     => 'text',
                'title'    => 'Cookie Title',
                'subtitle' => esc_html__('Enter the Cookie Title/Name.','kapee'),
				'default'  => esc_html__('Cookies Notice','kapee'),
            ),
			array(
                'id'       => 'cookie-message-text',
                'type'     => 'textarea',
                'title'    => esc_html__('Message','kapee'),
				'subtitle' => esc_html__('Enter the cookie notice message.','kapee'),
				'default'  => esc_html__('We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.','kapee'),
            ),
			array(
                'id'       => 'cookie-accept-text',
                'type'     => 'text',
                'title'    => esc_html__('Button Text','kapee'),
                'subtitle' => esc_html__('The text of the option to accept the usage of the cookies and make the notification disappear.','kapee'),
				'default'  => esc_html__('Yes, I\'m Accept','kapee'),
            ),
			array(
                'id'       => 'cookie-see-more-opt',
                'type'     => 'switch',
                'title'    => esc_html__('More Info Link','kapee'),
                'on'       => esc_html__('Enable','kapee'),
				'off'      => esc_html__('Disable','kapee'),
				'subtitle' => esc_html__('Enable Read more link.','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'cookie-see-more-text',
                'type'     => 'text',
                'title'    => '',
                'subtitle' => esc_html__('The text of the more info button.','kapee'),
				'default'  => esc_html__('Read more','kapee'),
				'required' => array( 'cookie-see-more-opt', '=', 1 ),
            ),
			array(
                'id'       => 'cookie-see-more-link-type',
                'type'     => 'radio',
                'title'    => '',
                'subtitle' => esc_html__('Select where to redirect user for more information about cookies.','kapee'),
                'options'  => array(
								'custom' 	 => esc_html__('Custom link','kapee'),
								'page' => esc_html__('Page link','kapee'),
							),
				'default'  => 'custom',
				'required' => array( 'cookie-see-more-opt', '=', 1 ),
            ),
			array(
                'id'       => 'cookie-see-more-link-custom',
                'type'     => 'text',
                'title'    => '',
                'subtitle' => esc_html__('Enter the full URL starting with http://','kapee'),
				'default'  => 'http://empty',
				'placeholder' => esc_attr('http://#'),
				'required' => array( 'cookie-see-more-link-type', '=', 'custom' ),
            ),
			array(
                'id'       => 'cookie-see-more-link-pages',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => '',
                'subtitle' => esc_html__( 'Select from one of your site\'s pages', 'kapee' ),
				'required' => array( 'cookie-see-more-link-type', '=', 'page' ),
            ),
			array(
                'id'       => 'cookie-see-more-link-target',
                'type'     => 'select',
                'title'    => esc_html__( 'Link Target', 'kapee' ),
                'subtitle' => esc_html__( 'Select the link target for more info page.', 'kapee' ),
                'options'  => array(
                    '_blank' => '_blank',
                    '_self' => '_self',
                ),
                'default'  => '_blank',
            ),
			array(
                'id'       => 'cookie-refuse-opt',
                'type'     => 'switch',
                'title'    => esc_html__('Refuse Button','kapee'),
                'on'       => esc_html__('Enable', 'kapee'),
				'off'      => esc_html__('Disable', 'kapee'),
				'subtitle' => esc_html__('Give to the user the possibility to refuse third party non functional cookies.','kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'cookie-refuse-text',
                'type'     => 'text',
                'title'    => '',
                'subtitle' => esc_html__('The text of the option to refuse the usage of the cookies. To get the cookie notice status use kapee_cn_cookies_accepted() function.', 'kapee'),
				'default'  => esc_html__('No', 'kapee'),
				'required' => array( 'cookie-refuse-opt', '=', 1 ),
            ),
			array(
                'id'       => 'cookie-refuse-code',
                'type'     => 'textarea',
                'title'    => '',
				'subtitle' => esc_html__('Enter non functional cookies Javascript code here (for e.g. Google Analitycs). It will be used after cookies are accepted.','kapee'),
				'required' => array( 'cookie-refuse-opt', '=', 1 ),
				
            ),
			array(
                'id'       => 'cookie-on-scroll',
                'type'     => 'switch',
                'title'    => esc_html__('On Scroll', 'kapee'),
                'on'       => esc_html__('Enable', 'kapee'),
				'off'      => esc_html__('Disable', 'kapee'),
				'subtitle' => esc_html__('Enable cookie notice acceptance when users scroll.', 'kapee'),
				'default'  => 0,
            ),
			array(
                'id'       => 'cookie-on-scroll-offset',
                'type'     => 'text',
                'title'    => '',
                'subtitle' => esc_html__('Number of pixels user has to scroll to accept the usage of the cookies and make the notification disappear.','kapee'),
				'default'  => 100,
				'required' => array( 'cookie-on-scroll', '=', 1 ),
            ),
			array(
                'id'       => 'cookie-expiry-times',
                'type'     => 'select',
                'title'    => esc_html__( 'Cookie Expiry', 'kapee' ),
                'subtitle' => esc_html__( 'Select the link target for more info page.', 'kapee' ),
                'options'  => array(
					'86400'	 	=> esc_html__( '1 day', 'kapee' ),
					'604800'	=> esc_html__( '1 week', 'kapee' ),
					'2592000'	=> esc_html__( '1 month', 'kapee' ),
					'7862400'	=> esc_html__( '3 months', 'kapee' ),
					'15811200'	=> esc_html__( '6 months', 'kapee' ),
					'31536000'	=> esc_html__( '1 year', 'kapee' ),
					'31337313373' => esc_html__( 'infinity', 'kapee' ),
                ),
                'default'  => '2592000',
            ),
			array(
                'id'       => 'cookie-script-placements',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Script Placement', 'kapee' ),
                'subtitle' => esc_html__( 'Select where all the plugin scripts should be placed.', 'kapee' ),
                'options'  => array(
                    'header' => esc_html__('Header', 'kapee'),
                    'footer' => esc_html__('Footer', 'kapee'),
                ),
                'default'  => 'footer',
            ),
			array(
                'id'       => 'cookie-positions',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Position', 'kapee' ),
                'subtitle' => esc_html__( 'Select location for your cookie notice.', 'kapee' ),
                'options'  => array(
                    'top' 		=> esc_html__('Top', 'kapee'),
                    'bottom' 	=> esc_html__('Bottom', 'kapee'),
                ),
                'default'  => 'bottom'
            ),
			array(
                'id'       => 'cookie-style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Cookie Style', 'kapee' ),
                'subtitle' => esc_html__( 'Select style of cookie notice on bottom.', 'kapee' ),
                'options'  => array(
                    'bar' 		=> esc_html__('Bar', 'kapee'),
                    'box' 	=> esc_html__('Box', 'kapee'),
                ),
                'default'  => 'box',
				'required' => array( 'cookie-positions', '=', 'bottom' ),
            ),
			array(
                'id'       => 'cookie-text-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Text Color', 'kapee' ),
                'default'  => '#212121',
            ),
			array(
                'id'       => 'cookie-background-color',
                'type'     => 'color',
                'title'    => esc_html__( 'Bar Background Color', 'kapee' ),
                'default'  => '#fcfcfc',
            ),
		)
	) );

	/*
	* Maintenance Mode
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Maintenance Mode', 'kapee' ),
        'id'         => 'site-maintenance-mode',
		'icon'		 => 'el el-icon-website',
        'fields'     => array(
			array(
                'id'       		=> 'maintenance-mode',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Maintenance Mode', 'kapee' ),
				'subtitle'		=> esc_html__('Status of Maintenance Mode.', 'kapee' ),
                'default'  		=> 0,
                'on'       		=> esc_html__('On','kapee'),
                'off'      		=> esc_html__('Off','kapee'),
            ),
			array(
				'id'      	=> 'maintenance-page',
				'type'    	=> 'select',
				'title'   	=> esc_html__('Page', 'kapee' ),
				'subtitle'	=> esc_html__('Select page to display as maintenance page.', 'kapee' ),
				'data'    	=> 'pages',
			),
		)
	) );
	
	/*
	* Custom Code Mode
	*/
	Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Custom Css/Js', 'kapee' ),
        'id'         => 'custom-css-js',
		'icon'		 => 'el-icon-broom',
        'fields'     => array(
			array(
                'id'       => 'custom-css',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'CSS Code', 'kapee' ),
				'subtitle' => esc_html__( 'Paste your CSS code here.', 'kapee' ),
				'mode'     => 'css',
				'theme'    => 'monokai',
				'default'  => '',
            ),
			array(
				'id'       => 'custom-js-head',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'JS Code before &lt;/head&gt;', 'kapee' ),
				'subtitle' => esc_html__( 'Paste your JS code here.', 'kapee' ),
				'mode'     => 'javascript',
				'theme'    => 'chrome',
				'default'  => '',
			),
			array(
				'id'       => 'custom-js-footer',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'JS Code before &lt;/body&gt;', 'kapee' ),
				'subtitle' => esc_html__( 'Paste your JS code here.', 'kapee' ),
				'mode'     => 'javascript',
				'theme'    => 'chrome',
				'default'  => '',
			),
		)
	) );
	
    /* Action hook examples */

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'kapee' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'kapee' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }
