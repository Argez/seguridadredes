<?php
/**
 * Kapee Core Fucntions
 *
 * @author 	PressLayouts
 * @package kapee/inc
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get theme Options
 */
if ( ! function_exists( 'kapee_get_option' ) ) :
	function kapee_get_option($name, $default = '') {
		global $kapee_options;
		$kapee_options = apply_filters('kapee_theme_options',$kapee_options);
		$value = $default;
		if ( isset( $kapee_options[$name]  ) ) {
			if(  is_array( $kapee_options[$name] ) && isset($kapee_options[$name]['url']) && empty ( $kapee_options[$name]['url'] ) ){
				$value = $default;
			}elseif(is_array( $kapee_options[$name] ) && empty($kapee_options[$name])){
				$value = $default;
			}else{
				$value =  $kapee_options[$name];
			}			
		}
		$value = apply_filters( 'kapee_get_option', $value, $name, $kapee_options );
		return apply_filters( 'kapee_get_option_' . $name, $value, $name, $kapee_options) ;
	}
endif;

/**
 * Get theme Options
 */
if ( ! function_exists( 'kapee_uniqid' ) ) :
	function kapee_uniqid( $prefix = '' ) {		
		return $prefix.rand(1000,100000);
	}
endif;

/**
 * Get protocol (https or http)
 */
if( ! function_exists( 'kapee_get_protocol' )) :
	function kapee_get_protocol() {
		if( is_ssl() ) {
			return 'https:';
		} else {
			return 'http:';
		}
	}
endif;

/**
 * Manage Hook
 */
if( ! function_exists( 'kapee_manage_hook' ) ) :
	function kapee_manage_hook() {
		
		// Manage promo bar position
		if( kapee_get_option('promo-bar', 0 ) ) {
			if( 'top'  == kapee_get_option( 'promo-bar-position', 'top' ) ) {
				add_action( 'wp_body_open', 'kapee_promo_bar', 10 );
			}else{
				add_action( 'kapee_body_bottom', 'kapee_promo_bar', 45 );
			}			
		}
	}
	add_action( 'init', 'kapee_manage_hook' );
endif;

/**
 * Set Plugins with Theme
 */
if( ! function_exists( 'kapee_revslider_as_theme' ) ) :
	function kapee_revslider_as_theme() {
		if( function_exists( 'set_revslider_as_theme' ) ) {
			set_revslider_as_theme();
		}
	}
	add_action( 'init', 'kapee_revslider_as_theme' );
endif;

if( ! function_exists ( 'kapee_vcSetAsTheme' ) ) :
	function kapee_vcSetAsTheme() {			 
		// Bundled with the theme
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme();
		}
	}
	add_action( 'vc_before_init', 'kapee_vcSetAsTheme' );
endif;

/**
 * Clean up CSS	
 * @since 1.3.13
 * @return string
 */
function kapee_cleanup_css( $css = '' ) {

	if ( ! empty( $css ) ) {
		// Remove comments
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		// Remove whitespace
		$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
		$css = str_replace( ', ', ',', $css );
	}

	return $css;
}

/**
 * Get locale in uniform format.
 */
function kapee_get_locale() {
	$kapee_locale = get_locale();
	if ( preg_match( '#^[a-z]{2}\-[A-Z]{2}$#', $kapee_locale ) ) {
		$kapee_locale = str_replace( '-', '_', $kapee_locale );
	} elseif ( preg_match( '#^[a-z]{2}$#', $kapee_locale ) ) {
		$kapee_locale .= '_' . mb_strtoupper( $kapee_locale, 'UTF-8' );
	}

	if ( empty( $kapee_locale ) ) {
		$kapee_locale = 'en_US';
	}
	return apply_filters( 'kapee_locale', $kapee_locale );
}

/**
 * Allowed html
 */
function kapee_allowed_html( $allowed_els = '' ){

	// bail early if parameter is empty
	if( empty($allowed_els) ) return array();

	if( is_string($allowed_els) ){
		$allowed_els = explode(',', $allowed_els);
	}

	$allowed_html = array();

	$allowed_tags = wp_kses_allowed_html('post');

	foreach( $allowed_els as $el ){
		$el = trim($el);
		if( array_key_exists($el, $allowed_tags) ){
			$allowed_html[$el] = $allowed_tags[$el];
		}
	}

	return $allowed_html;
}

/**
 * Get timezone string
 */
function kapee_timezone_string() {
    $timezone_string = get_option( 'timezone_string' );
 
    if ( $timezone_string ) {
        return $timezone_string;
    }
 
    $offset  = (float) get_option( 'gmt_offset' );
    $hours   = (int) $offset;
    $minutes = ( $offset - $hours );
 
    $sign      = ( $offset < 0 ) ? '-' : '+';
    $abs_hour  = abs( $hours );
    $abs_mins  = abs( $minutes * 60 );
    $tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );
 
    return $tz_offset;
}

/**
 * Standard menu fallback
 */

if ( ! function_exists( 'kapee_fallback_menu' ) ) :
	function kapee_fallback_menu() {
		if ( current_user_can( 'manage_options' ) ) {
			$menu_link = get_admin_url( null, 'nav-menus.php' );
			printf( 
				wp_kses( __('Add your &nbsp; <a href="%s"><strong>navigation menu here</strong></a>', 'kapee')
					,kapee_allowed_html( 'a', 'strong')
				) , $menu_link 
			);
		} else {
			$sentence = '<div class="main-navigation kapee-navigation"> <ul class="menu"><li><a href="#"><span>'.	esc_html__("No Menu Set", 'kapee').'</span></a></li></ul> </div>';

			echo wp_kses( $sentence, kapee_allowed_html('div', 'ul', 'li','a') );
		}
	}
endif;

/**
 * Check is plugin active
 */
function kapee_check_plugin_active( $plugin ) {
	
	if( empty($plugin) ) return false;
	
	return in_array( $plugin , apply_filters( 'active_plugins', (array) get_option( 'active_plugins',  array() ) ) ) ;
}

/**
 * Check tgmpa listed plugin active
 */
function kapee_tgmpa_is_plugin_check_active( $slug ) {
	$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

	return ( ( ! empty( $instance->plugins[ $slug ]['is_callable'] ) && is_callable( $instance->plugins[ $slug ]['is_callable'] ) ) || kapee_check_plugin_active( $instance->plugins[ $slug ]['file_path'] ) );
}

/**
 * Add some custom Css code.
 *
 * @param string $code Code.
 */
function kapee_add_custom_css( $code ) {
	global $kapee_custom_css;

	if ( empty( $kapee_custom_css ) ) {
		$kapee_custom_css = '';
	}

	$kapee_custom_css .= "\n" . $code . "\n";
}

/**
 * Get responsive class.
 */
function kapee_get_responsive_class( $col='' ) {
	
	if( empty( $col ) ){ return ''; }
	
	switch( $col ){
		case 1:
			$col_class = 'col-lg-1 col-xl-1 d-none d-lg-flex d-xl-flex';
			break;
		case 2:
			$col_class = 'col-lg-2 col-xl-2 d-none d-lg-flex d-xl-flex';
			break;
		case 3:
			$col_class = 'col-lg-3 col-xl-3 d-none d-lg-flex d-xl-flex';
			break;
		case 4:
			$col_class = 'col-lg-4 col-xl-4 d-none d-lg-flex d-xl-flex';
			break;
		case 5:
			$col_class = 'col-lg-5 col-xl-5 d-none d-lg-flex d-xl-flex';
			break;
		case 6:
			$col_class = 'col-lg-6 col-xl-6 d-none d-lg-flex d-xl-flex';
			break;
		case 7:
			$col_class = 'col-lg-7 col-xl-7 d-none d-lg-flex d-xl-flex';
			break;
		case 8:
			$col_class = 'col-lg-8 col-xl-8 d-none d-lg-flex d-xl-flex';
			break;
		case 9:
			$col_class = 'col-lg-9 col-xl-9 d-none d-lg-flex d-xl-flex';
			break;
		case 10:
			$col_class = 'col-lg-10 col-xl-10 d-none d-lg-flex d-xl-flex';
			break;
		case 11:
			$col_class = 'col-lg-11 col-xl-11 d-none d-lg-flex d-xl-flex';
			break;
		case 12:
			$col_class = 'col-lg-12 col-xl-12 d-none d-lg-flex d-xl-flex';
			break;
		default:
			$col_class = 'col d-none d-lg-flex d-xl-flex';
	}
	return apply_filters( 'kapee_responsive_class', $col_class, $col );
}

/**
 * Get footer layout.
 */
function kapee_get_footer_layout($footer_style = '1') {
	$footer_layouts = array();
	$footer_layouts['style_1'] = array(
		'grid'	=> 4,
		'class'	=> array(
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-3',
		)
	);
	$footer_layouts['style_2'] = array(
		'grid'	=> 5,
		'class'	=> array(
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-3',
		)
	);
	$footer_layouts['style_3'] = array(
		'grid'	=> 5,
		'class'	=> array(
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
		)
	);
	$footer_layouts['style_4'] = array(
		'grid'	=> 5,
		'class'	=> array(
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-2',
			'col-xs-12 col-sm-6 col-lg-3',
			'col-xs-12 col-sm-6 col-lg-3',
		)
	);
	$footer_layouts['style_5'] = array(
		'grid'	=> 2,
		'class'	=> array(
			'col-xs-12 col-sm-6 col-lg-6',
			'col-xs-12 col-sm-6 col-lg-6',
		)
	);
	$footer_layouts['style_6'] = array(
		'grid'	=> 1,
		'class'	=> array(
			'col-12',
		)
	);
	$footer_layouts = apply_filters('kapee_footer_layouts', $footer_layouts, $footer_style);
	
	return $footer_layouts['style_'.$footer_style];
}

if ( ! function_exists( 'kapee_set_cookie' ) ) :
	function kapee_set_cookie($key,$value){
		$default_cookie_expire = time() + 3600 * 24 * 30;
		setcookie(
				$key,
				$value,
				$default_cookie_expire,
				COOKIEPATH
			);
	}
endif;

if ( ! function_exists( 'kapee_get_cookie' ) ) :
	function kapee_get_cookie($var){
		return isset($_COOKIE[$var]) ? $_COOKIE[$var] : null;
	}
endif;

if ( ! function_exists( 'kapee_get_current_page_url' ) ) :
	function kapee_get_current_page_url() {
		$current_url = add_query_arg(null,null);		
		return esc_url($current_url);
	}
endif;

/**
 * Vendor options
*/
function kapee_vendor_theme_options(){
	
	$options = array();
	
	if ( class_exists( 'WC_Vendors' ) || class_exists( 'WCMp' ) ) {
	$options[] = array(
                'id'       => 'vendor-page-layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Layout', 'kapee' ),
                'subtitle' => esc_html__( 'Select vendor page layout with sidebar postion.', 'kapee' ),
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
                'default'  => 'left-sidebar'
            );
	$options[] = array(
                'id'       => 'vendor-sidebar-width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Sidebar Width', 'kapee' ),
                'options'  => array(
					'3'=>esc_html__('Medium','kapee'),
					'4'=>esc_html__('Large','kapee'),
				),
                'default'  => '3',
				'required' => array( 'vendor-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            );	
	$options[] = array(
                'id'       => 'vendor-page-sidebar-widget',
                'type'     => 'select',
                'title'    => esc_html__('Sidebar Widget Area','kapee'),
                'data'     => 'sidebars',
                'default'  => 'shop-page-sidebar',
                'required' => array( 'vendor-page-layout', '=', array( 'left-sidebar', 'right-sidebar' ) )
            );
	}
	$options[] = array(
                'id'       		=> 'enable-sold-by-in-loop',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Loop Sold By', 'kapee' ),
				'subtitle'		=> esc_html__('Display sold by vendor name in loop.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Yes','kapee'),
                'off'      		=> esc_html__('No','kapee'),
            );
	$options[] = array(
                'id'       		=> 'enable-sold-by-in-single',
                'type'     		=> 'switch',
                'title'    		=> esc_html__( 'Single Sold By', 'kapee' ),
				'subtitle'		=> esc_html__('Display sold by vendor name in single page.', 'kapee' ),
                'default'  		=> 1,
                'on'       		=> esc_html__('Yes','kapee'),
                'off'      		=> esc_html__('No','kapee'),
            );
	if ( class_exists( 'WC_Vendors' ) || class_exists( 'WCFMmp' ) ) {
		$options[] = array(
                'id'       => 'vendor-sold-by-template',
                'type'     => 'select',
                'title'    => esc_html__( 'Sold By Template', 'kapee' ),
                'options'  => array(
					'theme'=>esc_html__('By Theme','kapee'),
					'plugin'=>esc_html__('By Plugin','kapee'),
				),
                'default'  => 'theme',
            );	
	}
	
	return apply_filters('kapee_vendor_options', $options);
}
// **********************************************************************//
// Get custom and typekit fonts
// **********************************************************************//
if ( ! function_exists( 'kapee_add_custom_fonts' ) ):
	function kapee_add_custom_fonts() {
		
		$fonts = array();
		
		$enable_custom_font1 = kapee_get_option( 'custom-font1',0);
		$enable_custom_font2 = kapee_get_option( 'custom-font2',0);
		$enable_custom_font3 = kapee_get_option( 'custom-font3',0);
		
		if($enable_custom_font1){
			$font1_name =  kapee_get_option( 'custom-font1-name',''); 
			if(!empty($font1_name)){
				$fonts['Custom-Fonts'][$font1_name] = $font1_name;
			}
			
		}
		if($enable_custom_font2){
			$font2_name =  kapee_get_option( 'custom-font2-name',''); 
			if(!empty($font2_name)){
				$fonts['Custom-Fonts'][$font2_name] = $font2_name;
			}			
		}
		if($enable_custom_font3){
			$font3_name =  kapee_get_option( 'custom-font3-name',''); 
			if(!empty($font3_name)){
				$fonts['Custom-Fonts'][$font3_name] = $font3_name;
			}
		}
		
		$enable_typekit_font 	= kapee_get_option( 'typekit-font',0);
		$typekit_id 			= kapee_get_option( 'typekit-kit-id', '' );
		$typekit_family 		= kapee_get_option( 'typekit-kit-family', '' );
		if ( $enable_typekit_font && !empty($typekit_id) && $typekit_family ) {
			$typekit = explode( ',', $typekit_family );
			foreach($typekit as $key => $font_family){
				$fonts['Custom-Fonts'][$font_family] = $font_family;
			}
		}
		
		return $fonts;
		
	}
	add_filter( 'redux/kapee_options/field/typography/custom_fonts', 'kapee_add_custom_fonts' );
endif;

/**
 * Get blog meta
 *
 * @since  1.0
 *
 * @return string
 */
function  kapee_get_post_meta( $meta ) {
	$prefix = KAPEE_PREFIX;
	
	if ( is_home() && ! is_front_page() ) {
		$post_id = get_queried_object_id();

		return get_post_meta( $post_id, $prefix.$meta, true );
	}

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
		
		return get_post_meta( $post_id, $prefix.$meta, true );
	}
	
	if ( ! is_singular() ) {
		return false;
	}
	$post_meta = get_post_meta( get_the_ID(), $prefix.$meta, true );
	return apply_filters('kapee_get_post_meta', $post_meta, $meta);
	
}


if ( ! function_exists( 'kapee_has_post_thumbnail' ) ) :
	function kapee_has_post_thumbnail( $post_id = '' ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$prefix = KAPEE_PREFIX;
		$format =get_post_format();
		if( ( $format=='image') && get_post_meta( $post_id, $prefix.'post_format_image', true ) ){
			return true;
		}elseif( $format=='gallery' && get_post_meta( $post_id, $prefix.'post_format_gallery', true ) ){
			return true;
		}elseif( $format=='video' && get_post_meta( $post_id, $prefix.'post_format_video', true ) ){
			return true;
		}elseif( $format=='audio' && get_post_meta( $post_id, $prefix.'post_format_audio', true ) ){
			return false;
		}elseif( $format=='quote' && get_post_meta( $post_id, $prefix.'post_format_quote', true ) ){
			return false;
		}elseif( $format=='link' && get_post_meta( $post_id, $prefix.'post_format_link_url', true ) ){
			return false;
		}else{
			return has_post_thumbnail();
		}			
	}
endif;

/**
 * Function to get post types
 */
function kapee_get_post_types() {     
    
    $post_types = array();
    $args       = array('public' => true);
    $default_post_types = get_post_types($args,'name');

    $exclude_post = array('attachment', 'revision', 'nav_menu_item');
	$exclude_post = apply_filters('kapee_exclude_post',$exclude_post);

    foreach ($default_post_types as $post_type_key => $post_data) {
        if( !in_array( $post_type_key, $exclude_post) ) {
            $post_types[$post_type_key] = $post_data->label;
        }
    }

    return apply_filters('kapee_public_post_types', $post_types );  
}

/**
 * Returns the Taxonomies in a list.
 *
 * @param int    $post_id Post ID.
 * @param string $sep (default: ', ').
 * @param string $before (default: '').
 * @param string $after (default: '').
 * @return string
 */
function kapee_get_taxonomy_list( $post_id, $taxonomy = 'category', $sep = ', ', $before = '', $after = '' ) {
	$term_list	= get_the_term_list( $post_id, $taxonomy, $before, $sep, $after );
	if( !is_wp_error( $term_list )){
		return $term_list;
	}
}

/**
 * Function to get image src by id
*/
function kapee_get_image_src( $post_id = '', $size = 'full', $default_img = false ) {
    $size   = !empty($size) ? $size : 'full';
    $image  = wp_get_attachment_image_src( $post_id, $size );
    if( !empty($image) ) {
        $image = isset($image[0]) ? $image[0] : '';
	}
    // Getting default image
    if( $default_img && empty($image) ) {
        $image = '';
    }
	return $image;
}

if ( ! function_exists( 'kapee_implode_classes' ) ) :
	function kapee_implode_classes($classes=array()) {
		
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', $classes );
		}
		
		echo esc_attr( $classes );
	}
endif;

/**
 * Get post type list
 */
function kapee_get_posts_by_post_type($post_type ='post',$select_options = ''){
	$results = array();
	$args = array('post_type'	=> $post_type,
				'post_status' 	=>  array('publish'),
				'posts_per_page'=>-1);
	$post_type_query = get_posts( $args );
	if(!empty($select_options)){
		$results[' '] = $select_options;
	}
    foreach ( $post_type_query as $p ):
		$results[$p->ID] = $p->post_title;
    endforeach; 
	return $results;
}

function kapee_get_round_number( $number, $min_value = 1000, $decimal = 1 ) {
	if ( $number < $min_value ) {
		return number_format_i18n( $number );
	}
	$alphabets = array(
		1000000000 => 'B',
		1000000 => 'M',
		1000 => 'K',
	);
	foreach ( $alphabets as $key => $value ) {
		if ( $number >= $key ) {
			return round( $number / $key, $decimal ) . $value;
		}
	}
}

/**
 * Polylang Languages Switcher
 */
function kapee_polylang_language_switcher() {
	
	$lang_arr = $langs = array();
	$country_view 	= kapee_get_option( 'header-language-switcher-view', 'both' );
	$country_name 	= kapee_get_option( 'header-language-switcher-country-name', 'name' );
	$has_flag 		= ( $country_view =='both'|| $country_view == 'flag') ? true : false;
	$has_name 		= ( $country_view =='both'|| $country_view == 'name') ? true : false;		
	$languages 		= pll_the_languages(array('raw' => 1));
	
	if( ! empty( $languages ) ) {
		$flag	= $has_flag ? pll_current_language('flag') : '';
		$name	= $has_name ? pll_current_language('name') : '';			
		$lang_arr['current_language'] = array( 'flag'=>$flag, 'name'=>$name );
		
		foreach ($languages as $lang):
		
			$flag	= $has_flag ? '<img src="'.esc_url( $lang['flag'] ) .'" alt="'. esc_attr( $lang['name'] ).'"/>' : '';
			$name	= $has_name ? $lang['name'] : '';			
			$langs[] = array( 'flag'=>$flag, 'url'=> $lang['url'], 'name'=> $name, 'current_lang'=> $lang['current_lang'] );
			
		endforeach;
		
		$lang_arr['languages'] = $langs;
	}
	
	return $lang_arr;
}

/* Function to check is theme activated */
function kapee_is_license_activated(){
	$option_name = 'envato_purchase_code_24187521';
	if(get_option('kapee_is_activated') && get_option($option_name)){
		return true;
	}
	return false;
}

/* Function to get purchase code */
function kapee_get_purchase_code(){
	$option_name = 'envato_purchase_code_24187521';
	return get_option($option_name);
}

/* Function to get api key */
function kapee_get_token_key(){
	return get_option('kapee_token_key');
}


/*Template function*/
/**
 *	Get template from kapee theme
 */
function kapee_get_template_part( $slug, $name = '', $args = array() ) {
	$name = (string) $name;
	if ( '' !== $name ) {
		$templates = "{$slug}-{$name}";
	} else {
		$templates = "{$slug}";
	}
	kapee_get_template($templates,$args);
	
}

function kapee_get_post_thumbnail($size = 'thumbnail', $css_class = '', $attributes = false){
	
	global $post;
	
	$thumbnail_id = get_post_thumbnail_id();
	$html = kapee_get_image_html($thumbnail_id, $size, $css_class, $attributes);
	
	return $html;
}

function kapee_get_image_html($attachment_id, $size = 'thumbnail', $css_class = '', $attr = false){
	
	$html = '';
	$image = wp_get_attachment_image_src( $attachment_id, $size );
	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		$size_class = $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$attachment = get_post($attachment_id);

		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size_class size-$size_class ".$css_class,
			'alt'	=> trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
		);

		$attr = wp_parse_args( $attr, $default_attr );
		if ( empty( $attr['srcset'] ) ) {
			$image_meta = wp_get_attachment_metadata( $attachment_id );
			if ( is_array( $image_meta ) ) {
				$size_array = array( absint( $width ), absint( $height ) );
				$srcset = wp_get_attachment_image_srcset( $attachment_id, $size, $image_meta  );
				$sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

				if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
					$attr['srcset'] = $srcset;

					if ( empty( $attr['sizes'] ) ) {
						$attr['sizes'] = $sizes;
					}
				}
			}
		}
		
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
		$attr = array_map( 'esc_attr', $attr );
		$html .= rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
	} else{
		$src 			= apply_filters( 'kapee_lazyload_image_url', KAPEE_URI.'/assets/images/transparent.png');		
		$dimensions		= kapee_get_image_size( $size );
		$hwstring 		= image_hwstring($dimensions['width'], $dimensions['height'] );				
		$size_class 	= $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size_class size-$size_class ".$css_class,
			'alt'	=> 'Place holder',
		);
		$attr = wp_parse_args( $attr, $default_attr );		
		$attr = array_map( 'esc_attr', $attr );
		$html .= rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
		
	} 
	
	return $html;
}
if ( !function_exists('kapee_get_src_image_loaded') ) {
	function kapee_get_src_image_loaded($src, $attr = '', $hwstring ='' , $echo = true)  {

		$src_blank = apply_filters( 'kapee_lazyload_image_url', KAPEE_URI.'/assets/images/transparent.png');
		
		$default_attr = array(
			'src'	=> $src_blank,
			'data-src'	=> $src,
			'class'	=> '',
		);
		$lazy_load = kapee_get_option( 'lazy-load', 0 );
		if( !$lazy_load ) {
			$default_attr['src'] = $src;
			unset($default_attr['data-src']);
		}

		$attr = wp_parse_args( $attr, $default_attr );

		if( $lazy_load ) {
			$attr['class'] = $attr['class']. ' lazy loading';
		}

		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';

		if( $echo ) {
			echo trim($html);
		} else {
			return $html;
		}		
	}
}

/**
 * Get image size
 */
if ( ! function_exists('kapee_get_image_size') ) :
	function kapee_get_image_size( $size = 'thumbnail' ) {		
		global $_wp_additional_image_sizes;
		$sizes = array();  
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'large') ) ) {
				$width = get_option( "{$_size}_size_w" );
				$height = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['width']  = $width;
			$sizes[ $_size ]['height'] = $height;
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$width = $_wp_additional_image_sizes[ $_size ]['width'];
			$height = $_wp_additional_image_sizes[ $_size ]['height'];
			$sizes[ $_size ] = array(
				'width'  => $width,
				'height' => $height,
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}
	return isset( $sizes[$size] ) ? $sizes[$size] : array();
}
endif;
/**
 * Add lazyload to attachment image
 */
if ( ! function_exists('kapee_lazyload_to_attachment_image') ) :
	function kapee_lazyload_to_attachment_image( $attr, $attachment, $size ) {
	
		if( ! is_admin() && kapee_get_option( 'lazy-load', 0 ) ) {
			if( apply_filters( 'kapee_enable_lazyload', true) ) {
				$attr['data-src'] 	= $attr['src'];
				$image 				= wp_get_attachment_image_src( $attachment->ID, $size );
				$attr['src'] 		= apply_filters( 'kapee_lazyload_image_url', KAPEE_URI.'/assets/images/transparent.png');
				
				$lazy_class 		= 'lazy';	
				$attr['class'] 		= ( isset( $attr['class'] ) ? $attr['class'] . " {$lazy_class}" : $lazy_class );
				
				if ( isset( $attr['srcset'] ) ) {
					$attr['data-srcset'] = $attr['srcset'];
					unset( $attr['srcset'], $attr['sizes'] );
				}
			}
		}
		return $attr;
	}
	add_filter( 'wp_get_attachment_image_attributes', 'kapee_lazyload_to_attachment_image', 10, 3 );
endif;

if ( !function_exists('kapee_ajax_get_size_chart') ) {
	function kapee_ajax_get_size_chart(){
		
		$post_id = isset($_POST['id']) ? sanitize_text_field( (int) $_POST['id'] ) : 0;
		if( $post_id ){
			$content_post = get_post($post_id);
			if( $content_post ){
				$prefix = KAPEE_EXTENSIONS_META_PREFIX; // Metabox prefix
				$title = $content_post->post_title;
				$content = $content_post->post_content;
				$chart_data = get_post_meta($post_id,$prefix.'size_chart_data',true);
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$table_html = '';
				if( ! empty( $chart_data ) ){
					$chart_table = json_decode($chart_data);
					if ( ! empty( $chart_table ) ) {
						$table_html .= "<table id='size-chart' class='table'>";
						$i = 0;
						foreach ( $chart_table as $chart ) {

							$table_html .= "<tr>";
							for ($j = 0; $j < count($chart); $j++) {
								//If data avaible
								if (!empty($chart[$j])) {
									$table_html .= ($i == 0) ? "<th>" . $chart[$j]. "</th>" : "<td>" .$chart[$j] . "</td>";
								}  else {
									$table_html .= ($i == 0) ? "<th>" . $chart[$j] . "</th>" : "<td></td>";
								}
							}
							$table_html .= "</tr>";
							$i++;
						}
						$table_html .= "</table>";
					}
				}
				$args = array('chart_id'=>$post_id,'title'=>$title,'content' => $content,'table_html'=> $table_html);
				wc_get_template( 'content-size-chart.php',$args );
				
			}else{
				echo esc_html__('Something wrong..','kapee');
			}	
			
		}else{
			echo esc_html__('Something wrong..','kapee');
		}
		die();
	}
}
//Ajax
add_action('wp_ajax_kapee_ajax_get_size_chart', 'kapee_ajax_get_size_chart');
add_action('wp_ajax_nopriv_kapee_ajax_get_size_chart', 'kapee_ajax_get_size_chart');

if ( !function_exists('kapee_ajax_get_product_terms_conditions') ) {
	function kapee_ajax_get_product_terms_conditions(){
		
		$block_id = isset( $_POST['id'] ) && !empty($_POST['id']) ? sanitize_text_field( (int) $_POST['id'] ) : 0; ?>
		
		<div class="terms-header">
			<span class="kapee-close"><?php esc_html_e( 'Close', 'kapee' );?></span>
			<h5><?php echo apply_filters('kapee_product_terms_conditions_title',esc_html__('Terms and Condition', 'kapee' ));?></h5>
		</div>
		<div class="terms-content">
			<?php 		
			if( $block_id ){		
				echo do_shortcode("[kapee_block id='$block_id']");		
			}else{
				echo esc_html__( 'Something wrong..', 'kapee' );
			}?>
		</div>
		<?php 
		die();
	}
}
add_action('wp_ajax_kapee_ajax_get_product_terms_conditions', 'kapee_ajax_get_product_terms_conditions');
add_action('wp_ajax_nopriv_kapee_ajax_get_product_terms_conditions', 'kapee_ajax_get_product_terms_conditions');

function kapee_get_template( $templates, $args = array() ) {

	// Templates prefix
	$templates = sprintf( '%s', $templates );
	if( strpos( $templates, '.php' ) === false) {
		$templates = $templates.'.php';
	}
	// Locate template file
	$located = locate_template( $templates, false );
	
	// Apply filters to current template file
	$template_file = apply_filters( 'kapee_get_template', $located, $templates, $args );
	
	// File does not exists
	if ( ! file_exists( $template_file ) ) {
		kapee_doing_it_wrong( __FUNCTION__, sprintf( '%s does not exist.', '<code>' . $templates . '</code>' ), '2.1' );
		return;
	}
	
	// Filter arguments by "kapee_get_template-filename.php"
	$args = apply_filters( "kapee_get_template-{$templates}", $args );
	
	// Extract arguments (to use in template file)
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}
	
	// Actions before parsing template
	do_action( 'kapee_get_template_before', $located, $templates, $args );
	
	include( $template_file );
	
	// Actions after parsing template
	do_action( 'kapee_get_template_after', $located, $templates, $args );
}

/**
 *	Doing it wrong
 */
function kapee_doing_it_wrong( $function, $message, $version ) {
	$message .= ' Backtrace: ' . wp_debug_backtrace_summary();

	if ( defined( 'DOING_AJAX' ) ) {
		do_action( 'doing_it_wrong_run', $function, $message, $version );
		error_log( "{$function} was called incorrectly. {$message}. This message was added in version {$version}." );
	} else {
		_doing_it_wrong( $function, $message, $version );
	}
}

/* get default slider options */
if( ! function_exists( 'kapee_slider_options' ) ) :
	function kapee_slider_options(){
		$options = array(
			'slider_loop'				=> ( kapee_get_option('slider-loop', 0 ) ) ? true : false,
			'slider_autoplay'			=> ( kapee_get_option('slider-autoplay', 0 ) ) ? true : false,
			'slider_autoplaytimeout'	=> kapee_get_option('slider-autoplaytimeout', 3500 ),
			'slider_smartspeed'			=> kapee_get_option('slider-smartspeed', 750 ),
			'slider_autoplayHoverPause'	=> ( kapee_get_option( 'slider-autoplay-hover-pause', 1 ) ) ? true : false,
			'slider_center'				=> ( kapee_get_option( 'slider-center', 0 ) ) ? true : false,
			'slider_rewind'				=> ( kapee_get_option( 'slider-rewind', 0 ) ) ? true : false,
			'slider_autoHeight'			=> ( kapee_get_option( 'slider-auto-height', 1) ) ? true : false,
			'slider_nav'				=> ( kapee_get_option( 'slider-navigation', 1 ) ) ? true : false,
			'slider_nav_mobile'			=> ( kapee_get_option( 'slider-navigation-mobile', 0 ) ) ? true : false,
			'slider_dots'				=> ( kapee_get_option( 'slider-dots-navigation', 1 ) ) ? true : false,
			'slider_touchDrag'			=> ( kapee_get_option( 'slider-touchDrag', 0 ) ) ? true : false,
			'slider_touchDrag_mobile'	=> ( kapee_get_option( 'slider-touchDrag-mobile', 1 ) ) ? true : false,
			'slider_animatein'			=> kapee_get_option( 'slider-animate-in', '' ),
			'slider_animateout'			=> kapee_get_option( 'slider-animate-out', '' ),
			'slider_margin'				=> kapee_get_option( 'slider-margin', 0 ),
			'rs_extra_large'			=> 5,
			'rs_large'					=> 4,
			'rs_medium'					=> 3,
			'rs_small'					=> 2,
			'rs_extra_small'			=> 2,
		);
		$options = apply_filters( "kapee_slider_options", $options );
		return $options;
	}
endif;

/* Kapee css animation */
if ( ! function_exists( 'kapee_get_css_animation' ) ) :
	function kapee_get_css_animation( $css_animation ) {
		$output = '';
		if ( $css_animation && $css_animation != 'none' ) {
			$output = 'wow ' . $css_animation;
		}
		return $output;
	}
endif;

/**
 * Convert HEX to RGB.
 *
 * @since Kapee 1.0
 */
function kapee_hex2rgb( $hex ) {
   $hex = str_replace( "#", "", $hex );

   if( strlen( $hex ) == 3 ) {
	  $r = hexdec( substr( $hex, 0, 1 ).substr( $hex ,0 , 1 ) );
	  $g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
	  $b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
   } else {
	  $r = hexdec( substr( $hex, 0, 2 ) );
	  $g = hexdec( substr( $hex, 2, 2 ) );
	  $b = hexdec( substr( $hex, 4, 2 ) );
   }
   $rgb = array( $r, $g, $b );
   return implode( ",", $rgb ); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

/**
 * remove all redux notice 
 *
 * @since  1.0.0
 */
if ( ! class_exists( 'reduxNewsflash' ) ){
    class reduxNewsflash {
        public function __construct( $parent, $params ) {}
    }
}
add_filter( 'redux/kapee_options/aURL_filter', '__return_empty_string' );

	
/* Kapee debug function */
function kapee_pre($test_data = ''){
	echo '<pre>';
	print_r($test_data);
	echo '</pre>';
}

/**
 * Display field type icon
 *
 * @since  1.0.0
 *
 * @param  string $selected The selected icon
 */
function kapee_get_font_awesome_icons( $selected = '' ) {
	$icons = kapee_pls_fonts();
	$list = array();

	foreach( $icons as $icon => $utf_code) {
		
		$list[] = sprintf(
			'<i class="pls %1$s %2$s" data-icon="%3$s"></i>',
			esc_attr( key($utf_code) ),
			key($utf_code) == trim($selected) ? 'selected' : '',
			esc_attr( key($utf_code) )
		);
	}

	return $list;
}