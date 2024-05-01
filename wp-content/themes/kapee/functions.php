<?php
/**
 * Kapee functions and definitions
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */

/*-----------------------------------------------------------------------*/
/* Define Constants.
/*-----------------------------------------------------------------------*/
define( 'KAPEE_DIR', get_template_directory() );		// template directory
define( 'KAPEE_URI', get_template_directory_uri() );    // template directory uri

class Kapee_Theme_Class{
	
	public function __construct() {
		$this->constants();
		$this->include_functions();
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 10 );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ) );
		} else{		
			add_action( 'wp_enqueue_scripts', array( $this, 'theme_css' ), 10000 );
			add_action( 'wp_enqueue_scripts', array( $this, 'theme_js' ) );				
			add_action( 'wp_head', array( $this, 'favicon' ), 5 );
			add_action( 'wp_head', array( $this, 'pingback_header' ), 1 );
			add_action( 'wp_head', array( $this, 'kapee_google_theme_color' ), 2 );
			add_action( 'wp_head', array($this, 'javascript_detection'), 0 );
			add_action( 'wp_head', array($this, 'kapee_custom_head_js'));
			add_action( 'wp_footer', array($this, 'kapee_enqueue_inline_style'), 10 );
			add_action( 'wp_footer', array($this, 'kapee_print_css'), 15 );
			add_action( 'wp_footer', array($this, 'kapee_custom_footer_js'));
			add_action( 'pre_get_posts', array( $this, 'search_posts_per_page' ) );		
			add_action( 'wp', array($this, 'kapee_post_view_count'), 999 );		
			add_filter( 'excerpt_more', array($this, 'kapee_excerpt_more') );	
			add_filter( 'the_content_more_link', array($this, 'kapee_read_more_tag' ) );
			add_filter( 'excerpt_length', array($this, 'kapee_excerpt_length'), 999 );
			add_action( 'wp_footer', array( $this, 'kapee_owl_param' ) );
			if( KAPEE_WOOCOMMERCE_ACTIVE ){
				add_filter( 'posts_search', array( $this, 'product_search_sku' ), 9 );
			}
		}
		add_filter( 'upload_mimes', array( $this, 'kapee_upload_mimes' ) );
		
	}
	
	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public  function constants() {

		define( 'KAPEE_THEME_NAME', 'Kapee' );
		define( 'KAPEE_THEME_SLUG', 'kapee' );
		$theme = wp_get_theme( KAPEE_THEME_SLUG );
		define( 'KAPEE_VERSION', $theme->get('Version') );
		define( 'KAPEE_FRAMEWORK', KAPEE_DIR .'/inc/' );
		define( 'KAPEE_FRAMEWORK_URI', KAPEE_URI .'/inc/' );
		define( 'KAPEE_ADMIN_DIR_URI', KAPEE_FRAMEWORK_URI .'admin/' );
		define( 'KAPEE_SCRIPTS', KAPEE_URI .'/assets/js/' );
		define( 'KAPEE_STYLES', KAPEE_URI .'/assets/css/' );
		define( 'KAPEE_IMAGES', KAPEE_URI . '/assets/images/' );
		define( 'KAPEE_ADMIN_IMAGES', KAPEE_ADMIN_DIR_URI . 'assets/images/' );
		
		// Check if plugins are active		
		if( !defined( 'KAPEE_WOOCOMMERCE_ACTIVE' ) ) {
			define( 'KAPEE_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		}
		if( !defined( 'KAPEE_DOKAN_ACTIVE' ) ) {
			define( 'KAPEE_DOKAN_ACTIVE', class_exists( 'WeDevs_Dokan' ) );
		}
		if( !defined( 'KAPEE_WC_VENDORS_ACTIVE' ) ) {
			define( 'KAPEE_WC_VENDORS_ACTIVE', class_exists( 'WC_Vendors' ) );
		}
		
		// Othere		
		if( ! defined( 'KAPEE_API' ) ) {
			define('KAPEE_API', 'https://presslayouts.com/demo/api/');
		}
		if( ! defined( 'KAPEE_PREFIX' ) ) {
			define('KAPEE_PREFIX', '_kp_');
		}
		
	}
	
	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public function include_functions(){
		require_once KAPEE_FRAMEWORK.'kp-layout.php';
		require_once KAPEE_FRAMEWORK.'font-config.php';
		require_once KAPEE_FRAMEWORK.'kp-core-functions.php';
		require_once KAPEE_FRAMEWORK.'kp-template-tags.php';
		require_once KAPEE_FRAMEWORK.'kp-template-functions.php';		
		require_once KAPEE_FRAMEWORK.'kp-template-hooks.php';
		require_once KAPEE_FRAMEWORK.'dynamic-css.php';
		if( KAPEE_WOOCOMMERCE_ACTIVE ){
			require_once KAPEE_FRAMEWORK.'integrations/woocommerce/wc-core-functions.php';
			require_once KAPEE_FRAMEWORK.'integrations/woocommerce/wc-template-hooks.php';
			require_once KAPEE_FRAMEWORK.'integrations/woocommerce/wc-template-functions.php';
			require_once KAPEE_FRAMEWORK.'classes/class-swatches.php';
			require_once KAPEE_FRAMEWORK.'classes/class-bought-together.php';
			
			if( class_exists('WeDevs_Dokan') ){
				require_once KAPEE_FRAMEWORK.'integrations/dokan/dokan-core-functions.php';
			}
			
			if( class_exists('WCMp') ){
				require_once KAPEE_FRAMEWORK.'integrations/wcmp/wcmp-core-functions.php';
			}
			
			if( class_exists('WC_Vendors') ){
				require_once KAPEE_FRAMEWORK.'integrations/wc-vendor/wc-vendors-core-functions.php';
			}
			
			if( class_exists('WCFMmp') ){
				require_once KAPEE_FRAMEWORK.'integrations/wcfm/wcfm-core-functions.php';
			}
			
			if( function_exists( 'YITH_YWRAQ_Frontend' ) ){
				require_once KAPEE_FRAMEWORK.'integrations/yith-add-to-quote/yith-add-to-quote-core-functions.php';
			}
			
		}
		
		require_once KAPEE_FRAMEWORK.'classes/class-metabox.php';
		require_once KAPEE_FRAMEWORK.'classes/class-walker-nav-menu.php';
		require_once KAPEE_FRAMEWORK.'classes/class-breadcrumb.php';
		require_once KAPEE_FRAMEWORK.'classes/class-sidebar-generator.php';		
		require_once KAPEE_FRAMEWORK.'classes/class-cookie-notice.php';		
		require_once KAPEE_FRAMEWORK.'thirdparty/tgm-plugin-activation/tgm-plugin-activation.php';
		require_once KAPEE_FRAMEWORK.'admin/theme_options.php';
		require_once KAPEE_FRAMEWORK.'admin/class-admin.php';
		require_once KAPEE_FRAMEWORK.'admin/class-dashboard.php';
		require_once KAPEE_FRAMEWORK.'admin/class-update-theme.php';		
	}
	
	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public function theme_setup() {
	
		load_theme_textdomain( 'kapee', get_template_directory() . '/languages' );	
		load_theme_textdomain( 'kapee', get_stylesheet_directory() . '/languages' );
		
		/* Theme support */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );	
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'quote', 'link' ) );
		add_theme_support( 'html5', array( 'gallery', 'caption' ) );
		add_theme_support( 'wp-block-styles' );
		
		// Disable Widget block editor.
		if( apply_filters('kapee_disable_widgets_block_editor', true) ) {
            remove_theme_support( 'block-templates' );
            remove_theme_support( 'widgets-block-editor' );
        }
		
		// Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );
		
		// Set the default content width.
		$GLOBALS['content_width'] = 1200;
		
		register_nav_menus( array(
			'primary'					=> esc_html__( 'Primary(Main) Menu', 'kapee' ),
			'secondary'					=> esc_html__( 'Secondary Menu', 'kapee' ),
			'categories-menu' 			=> esc_html__( 'Categories(Vertical) Menu', 'kapee' ),
			'topbar-menu' 				=> esc_html__( 'Topbar Menu', 'kapee' ),
			'mobile-menu' 				=> esc_html__( 'Mobile Primary Menu', 'kapee' ),
			'mobile-categories-menu' 	=> esc_html__( 'Mobile Categories Menu', 'kapee' ),
			'myaccount-menu' 			=> esc_html__( 'MyAccount/Profile Menu', 'kapee' ),
		) );
		
		add_editor_style( array( 'assets/css/editor-style.css', $this->kapee_fonts_url() ) );
	}
	
	/*-----------------------------------------------------------------------*/
	/* Register custom fonts.
	/*-----------------------------------------------------------------------*/
	public function kapee_fonts_url() {
		$fonts_url = '';	 
		$fonts = array();
		$fonts[] = 'Lato:100,100i,300,300i,400,400i,700,700i,900,900i';

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( 'latin,latin-ext' ),
				),
				'https://fonts.googleapis.com/css'
			);
		}

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Registers sidebars
	 *
	 * @since   1.0.0
	 */
	public function register_sidebars(){

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Sidebar', 'kapee' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Page Sidebar', 'kapee' ),
			'id'            => 'shop-page-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your shop page.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );		
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Filter Sidebar', 'kapee' ),
			'id'            => 'shop-filters-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your shop page.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Product Page Sidebar', 'kapee' ),
			'id'            => 'product-page-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your single product page.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Area 1', 'kapee' ),
			'id'            => 'footer-area-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer first column.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Area 2', 'kapee' ),
			'id'            => 'footer-area-2',
			'description'   => esc_html__( 'Add widgets here to appear in your footer second column.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Area 3', 'kapee' ),
			'id'            => 'footer-area-3',
			'description'   => esc_html__( 'Add widgets here to appear in your footer third column.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Area 4', 'kapee' ),
			'id'            => 'footer-area-4',
			'description'   => esc_html__( 'Add widgets here to appear in your footer fourth column.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
		
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Area 5', 'kapee' ),
			'id'            => 'footer-area-5',
			'description'   => esc_html__( 'Add widgets here to appear in your footer fifth column.', 'kapee' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	
	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public function admin_style( $hook ) {
		global $pagenow;
		$theme_version = KAPEE_VERSION;
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'pls-fonts', KAPEE_STYLES.'pls-font.css', array(), '1.0' );
		$dashboard_pages = array( 'toplevel_page_kapee-theme', 'kapee_page_kapee-system-status', 'kapee_page_kapee-theme-option', 'kapee_page_kapee-demo-import' );
		if( in_array( $hook, $dashboard_pages ) ){
			wp_enqueue_style( 'magnific-popup', KAPEE_STYLES . 'magnific-popup.css', array(), $theme_version );
		}
		if ( 'customize.php' != $pagenow ) {
			wp_enqueue_style( 'kapee-style', KAPEE_FRAMEWORK_URI . 'admin/assets/css/admin.css', array(), $theme_version );
		}
	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public function admin_scripts( $hook ) {
		global $pagenow;
		wp_enqueue_media(); 
		wp_enqueue_script( 'wp-color-picker' );
				
		if ( 'toplevel_page_kapee-theme' == $hook ) {
			wp_enqueue_script( 'kapee-activation-theme', KAPEE_FRAMEWORK_URI . 'admin/assets/js/kapee-activation.js');
		}		
		if ( 'kapee_page_kapee-system-status' == $hook ) {
			wp_enqueue_script( 'kapee-system-status', KAPEE_FRAMEWORK_URI . 'admin/assets/js/kapee-system-status.js');
		}		
		if ( 'nav-menus.php' == $pagenow ) {
			wp_enqueue_script( 'kapee-mega-menu', KAPEE_FRAMEWORK_URI . 'admin/assets/js/mega-menu.js');
		}
		$dashboard_pages = array( 'toplevel_page_kapee-theme', 'kapee_page_kapee-system-status', 'kapee_page_kapee-theme-option', 'kapee_page_kapee-demo-import' );
		
		if( in_array( $hook, $dashboard_pages ) ){
			wp_enqueue_script( 'magnific-popup', KAPEE_SCRIPTS . 'jquery.magnific-popup.min.js');
		}
		
		wp_enqueue_script( 'kapee-admin-js', KAPEE_FRAMEWORK_URI . 'admin/assets/js/admin.js' );
		wp_localize_script( 'kapee-admin-js', 'kapee_admin_params', apply_filters( 'kapee_admin_js_params', array(
			'ajaxurl'          		=> admin_url( 'admin-ajax.php' ),
			'nonce'            		=> wp_create_nonce( 'kapee_nonce' ),
			'loading_text'      	=> esc_html__( 'Loading...', 'kapee' ),
			'bindmessage'      		=> esc_html__( 'Are you sure you want to leave?', 'kapee' ),
			'demo_success'      	=> esc_html__( 'Demo imported successfully.', 'kapee' ),
			'menu_icon_change_text'	=> esc_html__( 'Change Custom Icon', 'kapee' ),
			'menu_icon_upload_text'	=> esc_html__( 'Upload Custom Icon', 'kapee' ),
			'menu_delete_icon_msg'	=> esc_html__( 'Are you sure,You want to remove this icon?', 'kapee' ),
		))); 
	}

	/**
	 * Load front-end css
	 *
	 * @since   1.0.0
	 */
	public function theme_css() {
		
		// Remove font awesome style from plugins
		wp_deregister_style( 'fontawesome' );
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'yith-wcwl-font-awesome' );
		wp_deregister_style( 'wplc-font-awesome' );
		
		// Load our main stylesheet.
		wp_enqueue_style( 'kapee-style', KAPEE_URI.'/style.css' , array(), KAPEE_VERSION );
	
		// Load visual composer css
		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_style( 'js_composer_custom_css' );
		
		$style = ( is_rtl() ) ? KAPEE_STYLES .'style-rtl.css' : KAPEE_STYLES.'style.css';
		$woocommerce_style = ( is_rtl() ) ? KAPEE_STYLES.'woocommerce-rtl' : KAPEE_STYLES .'woocommerce' ;
		
		wp_enqueue_style( 'kapee-default-fonts', $this->kapee_fonts_url(), array(), null );
		wp_enqueue_style( 'bootstrap', KAPEE_STYLES.'bootstrap.min.css', array(), '4.0.0' );
		wp_enqueue_style( 'kapee-woocommerce', $woocommerce_style.'.css', array(), '3.4.5' );
		wp_enqueue_style( 'font-awesome', KAPEE_STYLES .'font-awesome.min.css', array(), '4.7.0' );
		wp_enqueue_style( 'pls-fonts', KAPEE_STYLES.'pls-font.min.css', array(), '1.0' );
		wp_enqueue_style( 'owl-carousel', KAPEE_STYLES.'owl.carousel.min.css', array(), '2.3.4' );	
		wp_enqueue_style( 'animate', KAPEE_STYLES.'animate.min.css', array(), '4.1.1' );
		wp_enqueue_style( 'magnific-popup', KAPEE_STYLES.'magnific-popup.css', array(), '1.1.0' );		
		
		if( kapee_get_option( 'skeleton-effect', 0 ) ){
			wp_enqueue_style( 'kapee-skeleton', KAPEE_STYLES.'skeleton.css', array(), KAPEE_VERSION );
		}
		
		// Theme basic stylesheet.
		wp_enqueue_style( 'kapee-basic', $style, array( 'bootstrap', 'kapee-woocommerce' ), KAPEE_VERSION );
		
		// Dynamic CSS
		wp_add_inline_style( 'kapee-basic', kapee_theme_style() );
		
		// load typekit fonts
		$enable_typekit_font 	= kapee_get_option( 'typekit-font', 0 );
		$typekit_id 			= kapee_get_option( 'typekit-kit-id', '' );

		if ( $enable_typekit_font && ! empty( $typekit_id ) ) {
			wp_enqueue_style( 'kapee-typekit',  kapee_get_protocol().'//use.typekit.net/' . esc_attr ( $typekit_id ) . '.css', array(), $theme_version );
		}
		
		// REMOVE WP EMOJI
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles');
		
		wp_register_style( 'kapee-custom-css', false );
	}
	
	/**
	 * Load front-end script
	 *
	 * @since   1.0.0
	 */
	public function theme_js() {
		
		// Load visual composer Js
		wp_register_script( 'waypoints', KAPEE_SCRIPTS.'waypoints.min.js', array( 'jquery' ), '2.0.2', true );
		wp_enqueue_script( 'wpb_composer_front_js' );
		wp_enqueue_script( 'popper', KAPEE_SCRIPTS.'popper.min.js', array( 'jquery' ), '4.0.0', true );
		wp_enqueue_script( 'bootstrap', KAPEE_SCRIPTS.'bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
		wp_enqueue_script( 'owl-carousel', KAPEE_SCRIPTS.'owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
		wp_register_script( 'isinviewport', KAPEE_SCRIPTS.'isInViewport.min.js', array( 'jquery' ), '1.8.0', true );
		wp_enqueue_script( 'slick', KAPEE_SCRIPTS.'slick.min.js', array( 'jquery' ), '1.9.0', true );
		wp_register_script( 'isotope', KAPEE_SCRIPTS.'isotope.pkgd.min.js', array( 'jquery' ), '3.0.6', true );
		wp_register_script( 'cookie', KAPEE_SCRIPTS.'cookie.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'parallax', KAPEE_SCRIPTS.'jquery.parallax.js', array( 'jquery' ), '', true );
		wp_register_script( 'threesixty', KAPEE_SCRIPTS .'threesixty.min.js', array( 'jquery' ), KAPEE_VERSION, true );
		wp_enqueue_script( 'magnific-popup', KAPEE_SCRIPTS.'jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'nanoscroller', KAPEE_SCRIPTS.'jquery.nanoscroller.min.js', array( 'jquery' ), '0.8.7', true );
		wp_register_script( 'countdown', KAPEE_SCRIPTS.'jquery.countdown.min.js', array( 'jquery' ), '2.2.0', true );
		wp_register_script( 'counterup', KAPEE_SCRIPTS.'jquery.counterup.min.js', array( 'jquery' ), '1.0', true );
		wp_register_script( 'sticky-kit', KAPEE_SCRIPTS.'sticky-kit.min.js', array( 'jquery' ), '1.10.0', true );
		if( kapee_get_option( 'product-ajax-search', 1 ) == 1 ){
			wp_enqueue_script( 'autocomplete', KAPEE_SCRIPTS.'jquery.autocomplete.min.js', array( 'jquery' ), '1.4.11', true );
		}		
		if( kapee_get_option( 'lazy-load', 1 ) ){
			wp_enqueue_script( 'lazyload', KAPEE_SCRIPTS.'jquery.lazy.min.js', array( 'jquery' ), '1.7.10', true );
		}		
		if( kapee_get_option( 'widget-items-hide-max-limit', 1 ) ){
			wp_enqueue_script( 'hideMaxListItem', KAPEE_SCRIPTS.'hideMaxListItem-min.js', array( 'jquery' ), '1.36', true );
		}		
		if( kapee_get_option( 'product-quickview-button', 1 ) ){
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}
		if ( ! wp_script_is( 'wc-cart-fragments', 'enqueued' ) && wp_script_is( 'wc-cart-fragments', 'registered' ) ) {
			wp_enqueue_script( 'wc-cart-fragments' );
		}
		if( kapee_get_option( 'sticky-sidebar', 1 ) && ( 'full-width' != kapee_get_layout() ) ){
			wp_enqueue_script( 'sticky-kit' );
		}
		if ( function_exists('is_product') && is_product() && ( kapee_get_option( 'sticky-product-image', 1 ) || kapee_get_option( 'sticky-product-summary', 1 ) ) ){
			wp_enqueue_script( 'sticky-kit' );			
		}
		//wp_enqueue_script( 'wc-password-strength-meter' );
		$google_api_key = kapee_get_option( 'google-map-api', '' );
		if( ! empty( $google_api_key ) ){
			wp_enqueue_script( 'kapee-google-map-api', kapee_get_protocol().'//maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=' . $google_api_key . '', array(), '', false );
		}
		wp_enqueue_script( 'kapee-script', KAPEE_SCRIPTS . 'functions.js', array( 'jquery' ), KAPEE_VERSION, true );
		
		$is_rtl = is_rtl() ? true : false ;		
		$kapee_options 	= apply_filters( 'kapee_localize_script_data', array( 
			'rtl' 							=> $is_rtl,
			'ajax_url' 						=> admin_url( 'admin-ajax.php' ), false,			
			'nonce'            				=> wp_create_nonce( 'kapee_nonce' ),
			'product_ajax_search'			=> kapee_get_option( 'product-ajax-search', 1 ) ? true : false,	
			'sticky_header'					=> kapee_get_option( 'sticky-header', 0 ) ? true : false,	
			'sticky_header_scroll_up'		=> kapee_get_option( 'sticky-header-scroll-up', 1 ) ? true : false,	
			'sticky_header_tablet'			=> kapee_get_option( 'sticky-header-tablet', 0 ) ? true : false,	
			'sticky_header_mobile'			=> kapee_get_option( 'sticky-header-mobile', 0 ) ? true : false,	
			'login_register_popup'			=> kapee_get_option( 'login-register-popup', 1 ) ? true : false,
			'button_loader'					=> true,
			'header_minicart_popup'			=> kapee_get_option( 'header-minicart-popup', 1 ) ? true : false,	
			'skeleton_effect'				=> kapee_get_option( 'skeleton-effect', 0 ) ? true : false,	
			'lazy_load'						=> kapee_get_option( 'lazy-load', 0 ) ? true : false,	
			'promo_bar'						=> kapee_get_option( 'promo-bar', 0 ) ? true : false,	
			'cookie_path'					=> COOKIEPATH,
			'cookie_expire'					=> 3600 * 24 * 30,
			'show_promobar_in_next_days'	=> 1,
			'permalink'						=> ( get_option( 'permalink_structure' ) == '' ) ? 'plain' : '',			
			'newsletter_args'				=> apply_filters( 'kapee_js_newsletter_args', array(
				'popup_enable'			=> kapee_get_option( 'newsletter-popup', 0 ) ? true : false,
				'popup_display_on'		=> kapee_get_option( 'newsletter-when-appear', 'page_load' ),
				'popup_delay'			=> kapee_get_option( 'newsletter-delay', 5 ),
				'popup_x_scroll'		=> kapee_get_option( 'newsletter-x-scroll', 30 ),
				'show_for_mobile'		=> kapee_get_option( 'newsletter-show-mobile', 1 ),
				'show_in_next_days'		=> 1,
				'version'				=> kapee_get_option( 'newsletter-version', 1 ),
			) ),
			'js_translate_text'				=> apply_filters( 'kapee_js_text', array(
				'days_text'				=> esc_html__( 'Days', 'kapee' ),
				'hours_text'			=> esc_html__( 'Hrs', 'kapee' ),
				'mins_text'				=> esc_html__( 'Mins', 'kapee' ),
				'secs_text'				=> esc_html__( 'Secs', 'kapee' ),
				'sdays_text'			=> esc_html__( 'd', 'kapee' ),
				'shours_text'			=> esc_html__( 'h', 'kapee' ),
				'smins_text'			=> esc_html__( 'm', 'kapee' ),
				'ssecs_text'			=> esc_html__( 's', 'kapee' ),
				'show_more'				=> esc_html__( '+ Show more', 'kapee' ),
				'show_less'				=> esc_html__( '- Show less', 'kapee' ),
				'loading_txt'			=> esc_html__( 'Loading...', 'kapee' ),
				'variation_unavailable'	=> esc_html__( 'Sorry, this product is unavailable. Please choose a different combination.', 'kapee' ),
			) ),
			'product_tooltip'				=> kapee_get_option( 'product-hover-tooltip', 1 ) ? true : false,
			'product_image_zoom'			=> kapee_get_option( 'product-gallery-zoom', 1 ) ? true : false,
			'product_PhotoSwipe'			=> kapee_get_option( 'product-gallery-lightbox', 1 ) ? true : false,
			'product_gallery_layout'		=> function_exists('kapee_get_product_gallery_layout') ? kapee_get_product_gallery_layout() : kapee_get_option( 'product-gallery-style', 'product-gallery-left' ),
			'product_add_to_cart_ajax'		=> kapee_get_option( 'product_add_to_cart_ajax', 1 ) ? true : false,
			'product_open_cart_mini'		=> kapee_get_option( 'product_open_cart_mini', 1 ) ? true : false,
			'product_quickview_button'		=> kapee_get_option( 'product-quickview-button', 1 ) ? true : false,
			'sticky_product_image'			=> kapee_get_option( 'sticky-product-image', 1 ) ? true : false,
			'sticky_product_summary'		=> kapee_get_option( 'sticky-product-summary', 1 ) ? true : false,
			'sticky_add_to_cart_btn'		=> kapee_get_option( 'sticky-add-to-cart-button', 1 ) ? true : false,
			'sticky_sidebar'				=> kapee_get_option( 'sticky-sidebar', 1 ) ? true : false,
			'widget_toggle'					=> kapee_get_option('widget-toggle', 0 ) ? true : false,
			'widget_menu_toggle'			=> kapee_get_option('widget-menu-toggle', 0 ) ? true : false,			
			'widget_hide_max_limit_item' 	=> kapee_get_option('widget-items-hide-max-limit', 0 ) ? true : false,
			'sidebar_canvas_mobile'			=> kapee_get_option('sidebar-canvas-mobile', 0 ) ? true : false,
			'number_of_show_widget_items' 	=> kapee_get_option('number-of-show-widget-items', 8),
			'cart_auto_update'				=> kapee_get_option( 'cart-auto-update', 1 ) ? true : false,
			'checkout_product_quantity'		=> kapee_get_option( 'checkout-product-quantity', 0 ) ? true : false,
			'bought_together_success'		=> esc_html__( 'Added all items to cart', 'kapee' ),
			'bought_together_error'			=> esc_html__('Someting wrong', 'kapee' ),
			'disable_variation_price_change'=> false,
			'maintenance_mode'				=> kapee_get_option( 'maintenance-mode' , 0 ) ? true : false,
			'dokan_active'					=> ( KAPEE_DOKAN_ACTIVE ) ? true : false
			
		) );

		if ( class_exists( 'WooCommerce' ) ) {
				$kapee_options['price_format']             = get_woocommerce_price_format();
				$kapee_options['price_decimals']           = wc_get_price_decimals();
				$kapee_options['price_thousand_separator'] = wc_get_price_thousand_separator();
				$kapee_options['price_decimal_separator']  = wc_get_price_decimal_separator();
				$kapee_options['currency_symbol']          = get_woocommerce_currency_symbol();
				$kapee_options['wc_tax_enabled']           = wc_tax_enabled();
				$kapee_options['cart_url']                 = wc_get_cart_url();
				if ( wc_tax_enabled() ) {
					$kapee_options['ex_tax_or_vat'] = WC()->countries->ex_tax_or_vat();
				} else {
					$kapee_options['ex_tax_or_vat'] = '';
				}
			}
			
		wp_localize_script( 'kapee-script', 'kapee_options', $kapee_options );
		
		wp_enqueue_script( 'html5', KAPEE_SCRIPTS .'html5.js' , array(), '3.7.3' );
		wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	
	/**
	 * Load custom js in footer
	 * @since 1.0.0
	 */
	function kapee_owl_param() {
		global $kapee_owlparam;
		wp_localize_script( 'kapee-script', 'kapeeOwlParam', ( array ) $kapee_owlparam );
	}
	
	/**
	 * Support to font mime
	 * @since 1.0.0
	 */
	function kapee_upload_mimes($existing_mimes) {
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['svgz'] = 'image/svg+xml';
		$existing_mimes['woff'] = 'application/x-font-woff';
		$existing_mimes['woff2'] = 'application/x-font-woff2';
		$existing_mimes['ttf'] = 'application/x-font-ttf';
		$existing_mimes['otf'] = 'application/x-font-otf';
		$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
		return $existing_mimes;
	}
	/**
	 * Search product with sku
	 * @since 1.3.9
	 */
	public function product_search_sku( $where ) {
        global $pagenow, $wpdb, $wp;
 
        if ( ( is_admin() && 'edit.php' != $pagenow )
             || ! is_search()
             || ! isset( $wp->query_vars['s'] )
             || ( isset( $wp->query_vars['post_type'] ) && 'product' != $wp->query_vars['post_type'] )
             || ( isset( $wp->query_vars['post_type'] ) && is_array( $wp->query_vars['post_type'] ) && ! in_array( 'product', $wp->query_vars['post_type'] ) )
        ) {
            return $where;
        }
        $search_ids = array();
        $terms      = explode( ',', $wp->query_vars['s'] );
 
        foreach ( $terms as $term ) {
            //Include the search by id if admin area.
            if ( is_admin() && is_numeric( $term ) ) {
                $search_ids[] = $term;
            }
            // search for variations with a matching sku.
 
            $sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $term ) ) );
 
            //Search for a simple product that matches the sku.
            $sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';", wc_clean( $term ) ) );
 
            $search_ids = array_merge( $search_ids, $sku_to_id, $sku_to_parent_id );
        }
 
        $search_ids = array_filter( array_map( 'absint', $search_ids ) );
 
        if ( sizeof( $search_ids ) > 0 ) {
            $where = str_replace( ')))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . "))))", $where );
        }
 
        return $where;
    }
	
	/**
	* Add Favicon.
	*/
	function favicon() {
		ob_start();
		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			return '';
		}
		$favicon_url 				= kapee_get_option( 'theme-favicon', array( 'url' => KAPEE_IMAGES.'favicon.png' ) );
		$favicon_appple_touch_url 	= kapee_get_option( 'theme-favicon-appple-touch', array( 'url' => KAPEE_IMAGES.'favicon-152.png' ) );
		if( empty( $favicon_url['url'] ) ){
			$favicon_url['url'] =  KAPEE_IMAGES.'favicon.png';
		}
		if( empty( $favicon_appple_touch_url['url'] ) ){
			$favicon_appple_touch_url['url'] =  KAPEE_IMAGES.'favicon-152.png';
		}
		if( is_ssl() ) {
			$favicon 				= str_replace('http://', 'https://', $favicon_url['url']);
			$favicon_appple_touch 	= str_replace('http://', 'https://', $favicon_appple_touch_url['url']);
		}else{
			$favicon				= $favicon_url['url'];
			$favicon_appple_touch	= $favicon_appple_touch_url['url'];
		}
		echo '<link rel="shortcut icon" sizes="32x32" href=" '. esc_url($favicon). '">'. "\n";
		echo '<link rel="apple-touch-icon" sizes="152x152" href=" '. esc_url($favicon_appple_touch). '">'. "\n";

	}
	
	/**
	* Add a pingback url auto-discovery header for singularly identifiable articles.
	*/
	function pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' )) );
		}
	}
	
	function kapee_google_theme_color(){
		
		$google_theme_color =kapee_get_option('google-theme-color', 'transparent' );
		
		if( 'transparent' != $google_theme_color){ ?>	
			<meta name="theme-color" content="<?php echo esc_attr( $google_theme_color ); ?>">
		<?php
		}
	}
	
	/**
	* Javascript detection
	*/
	public function javascript_detection(){
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>";
	}
	
	/**
	 * Output of custom js options.
	 */
	public function kapee_custom_head_js() {
		
		$custom_js = kapee_get_option('custom-js-head','');
		
		if ( !empty( trim( $custom_js ) ) ) {
			
			echo apply_filters( 'kapee_head_custom_js', $custom_js ); // WPCS: XSS OK.
			
		}
	}
	
	/**
	 * Output of custom js options.
	 */
	public function kapee_custom_footer_js() {
		
		$custom_js = kapee_get_option( 'custom-js-footer', '' );
		
		if ( ! empty( trim( $custom_js ) ) ) { 
			
			echo apply_filters( 'kapee_footer_custom_js', $custom_js ); // WPCS: XSS OK.
				
		}
	}
	
	/**
	 * Output of dyanamic css.
	 */
	public  function kapee_print_css() {
		global $kapee_custom_css;

		if ( ! empty( trim( (string)$kapee_custom_css ) ) ) {
			// Sanitize.
			$kapee_custom_css = wp_check_invalid_utf8( $kapee_custom_css );			
			wp_add_inline_style( 'kapee-custom-css', $kapee_custom_css );
		}
	}
	
	/**
	 * Enqueue custom inline style
	 */
	public function kapee_enqueue_inline_style(){
		wp_enqueue_style( 'kapee-custom-css' );
	}
	
	/**
	 * Alter the search posts per page
	 *
	 * @since 1.0.0
	 */
	public  function search_posts_per_page( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) return;
		$portfolio_per_page = kapee_get_option( 'portfolio-per-page', 9 );
		if ( in_array ( $query->get('post_type'), array('portfolio') ) ) {
			$query->set( 'posts_per_page', $portfolio_per_page);
			return;
		}elseif( $query->is_main_query() && is_search() && isset($_GET['post_type']) && $_GET['post_type'] == 'product' ){
			$posts_per_page = kapee_get_option( 'products-per-page', 12);
			if ( isset( $_GET[ 'per_page' ] ) ) {
				$posts_per_page = $_GET[ 'per_page' ];
			}
			$query->set( 'posts_per_page', $posts_per_page);
		}

	}
	
	/**
	 *Post View Count 
	 */
	public function kapee_post_view_count(){
		$prefix = KAPEE_PREFIX;
		if( ! is_single() || ! is_singular( 'post' ) ) return;
		$post_id = get_the_ID();
		$views = get_post_meta( $post_id, $prefix.'views_count', true );
		$views = !empty($views) ? $views : 0;
		
		update_post_meta( $post_id, $prefix.'views_count', ($views+1) );
		$views = get_post_meta( $post_id, $prefix.'views_count', true );
	}
	
	
	/**
	 * 'Continue reading' link.
	 */
	public function kapee_excerpt_more( $link ) {
		return '';
	}
	public function kapee_read_more_tag() {
		
		return sprintf( '<p class="read-more-btn link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
			esc_url( get_permalink( get_the_ID() ) ),
			kapee_get_option('read-more-text','Continue Reading')
		);
	}

	/**
	 * Filter the except length to 30 words.
	 */
	function kapee_excerpt_length( $length ) {
		return kapee_get_option('blog-excerpt-length', 30);
	}	
} 
// Initialize theme
$kapee_theme_class = new Kapee_Theme_Class;