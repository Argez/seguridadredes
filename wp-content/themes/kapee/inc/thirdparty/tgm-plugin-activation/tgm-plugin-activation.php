<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Kapee for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
* Check Theme Activation
*/
/**
 * Include the TGM_Plugin_Activation class.
 */
require(KAPEE_FRAMEWORK. 'thirdparty/tgm-plugin-activation/class-tgm-plugin-activation.php' );
add_action( 'tgmpa_register', 'kapee_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function kapee_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name' 					=> esc_html__( 'Kapee Extensions', 'kapee' ),
			'slug' 					=> 'kapee-extensions',
			'source'             	=> kapee_get_tgm_plugin_path('kapee-extensions.zip'),
			'version'  				=> '1.2.13',
			'required' 				=> true,
		),
		array(
			'name' 					=> esc_html__( 'WPBakery Visual Composer', 'kapee' ),
			'slug' 					=> 'js_composer',
			'source'             	=> kapee_get_tgm_plugin_path('js_composer.zip'),
			'version'  				=> '7.5',
			'required' 				=> true,
		),
		array(
			'name' 					=> esc_html__( 'Revolution Slider', 'kapee' ),
			'slug' 					=> 'revslider',
			'source'             	=> kapee_get_tgm_plugin_path('revslider.zip'),
			'version'  				=> '6.6.20',
			'required' 				=> true,
		),
		array(
			'name' 					=> esc_html__('Woocommerce','kapee'),
			'slug' 					=> 'woocommerce',
			'required' 				=> true,
		),
		array(
			'name' 					=> esc_html__('YITH WooCommerce Wishlist','kapee'),
			'slug' 					=> 'yith-woocommerce-wishlist',
			'required' 				=> false,
		),
		array(
			'name' 					=> esc_html__('YITH WooCommerce Compare','kapee'),
			'slug' 					=> 'yith-woocommerce-compare',
			'required' 				=> false,
		),
		array(
            'name'      			=> esc_html__('Contact Form 7','kapee'),
            'slug'     			 	=> 'contact-form-7',
            'required' 			 	=> false,
        ),
		array(
			'name' 					=> esc_html__('MailChimp for WordPress','kapee'),
			'slug' 					=> 'mailchimp-for-wp',
			'required' 				=> false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'kapee-install-plugins',    // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		
	);

	tgmpa( $plugins, $config );
}

function kapee_get_tgm_plugin_path( $plugin_name = '' ){
	
	$is_license_activated= ( get_option('kapee_is_activated' ) && get_option( 'envato_purchase_code_24187521' ) ) ? true : false;
	
	if( empty($plugin_name) ) return '';
	if( !$is_license_activated ) return '';
	$plugin_url = get_option('kapee_plugin_file');
	return $plugin_url.$plugin_name;
}
