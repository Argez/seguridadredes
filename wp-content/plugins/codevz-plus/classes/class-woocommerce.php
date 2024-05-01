<?php if ( ! defined( 'ABSPATH' ) ) {exit;} // Exit if accessed directly.

/**
 * Woocommerce compatibility.
 */




function enqueue_log_sessions_script() {

	$sessions = get_transient( 'active_sessions' );
	$sessions = $sessions ? $sessions : [ 1 ];

    echo '<div class="watching" style="opacity: .7; font-size: 14px;"><i class="fa fa-eye mr8"></i><span>' . count( $sessions ) . '</span> people are watching this product</div><script>
        function logActiveSessions() {
            jQuery.ajax({
                url: "' . admin_url('admin-ajax.php') . '",
                type: "POST",
                data: {
                    action: "fetch_active_sessions"
                },
                success: function(response) {
                    console.log(response);
                    jQuery( ".watching span" ).html( response );
                }
            });
        }

        setInterval( logActiveSessions, 60000 );
    </script>';
}
//add_action( 'woocommerce_single_product_summary', 'enqueue_log_sessions_script', 35 );
//add_action('wp_ajax_fetch_active_sessions', 'fetch_active_sessions');
//add_action('wp_ajax_nopriv_fetch_active_sessions', 'fetch_active_sessions');
function fetch_active_sessions() {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (session_status() == PHP_SESSION_ACTIVE) {

        $session_id = session_id();
        $active_sessions = get_transient('active_sessions');

        if ($active_sessions === false) {
            $active_sessions = array($session_id => time());
            set_transient('active_sessions', $active_sessions, 60);
        } else {
            foreach ($active_sessions as $key => $value) {
                if (time() - $value > 60) {
                    unset($active_sessions[$key]);
                }
            }

            $active_sessions[$session_id] = time();
            set_transient('active_sessions', $active_sessions, 60);
        }

        // Log count of active sessions array
        $active_sessions_count = count($active_sessions);
        //error_log('Count of active sessions: ' . $active_sessions_count);

        echo $active_sessions_count;
    }

    wp_die();
}





class Codevz_Plus_Woocommerce {

	// Get product ID before load product.
	protected $singular_product_id = null;

	// Instance of this class.
	protected static $instance = null;

	// Init.
	public function __construct() {

		add_action( 'woocommerce_init', [ $this, 'woocommerce_init' ], 11 );

	}

	// Instance of this class.
	public static function instance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Init WooCommerce actions and filters.
	 * 
	 * @return -
	 */
	public function woocommerce_init() {

		// Register size guide post type.
		register_post_type( 'codevz_size_guide',
			[
				'public' 	=> true,
				'label' 	=> esc_html__( 'Size Guide', 'codevz' ),
				'supports' 	=> [ 'title', 'editor' ],
				'rewrite' 	=> [ 'slug' => 'product-size-guide' ]
			]
		);

		// Register FAQ post type.
		register_post_type( 'codevz_faq',
			[
				'public' 	=> true,
				'label' 	=> esc_html__( 'FAQ', 'codevz' ),
				'supports' 	=> [ 'title', 'editor' ],
				'rewrite' 	=> [ 'slug' => 'product-faq' ]
			]
		);

		// Register brands taxonomy.
		register_taxonomy( 'codevz_brands', 'product', [
			'labels' => [
				'name' 			=> esc_html__( 'Brands', 'codevz' ),
				'singular_name' => esc_html__( 'Brand', 'codevz' )
			],
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'					 => [ 'slug' => 'product-brand' ]
		] );

		// Product brand and other tabs in single product page.
		add_filter( 'woocommerce_product_tabs', [ $this, 'product_tabs' ] );

		// Enqueue fragments JS.
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ], 11 ); 

		// Number of products per page & columns.
		if ( ! class_exists( 'Woocommerce_Products_Per_Page' ) ) {

			add_filter( 'loop_shop_columns', [ $this, 'columns' ], 11 );
			add_filter( 'loop_shop_per_page', [ $this, 'loop_shop_per_page' ], 101, 1 );
			add_filter( 'woocommerce_product_query', [ $this, 'products_per_page' ], 11 );

			// Number of products browser request.
			if ( isset( $_REQUEST['ppp'] ) ) {
				wc_setcookie( 'woocommerce_products_per_page', intval( $_REQUEST['ppp'] ), time() + DAY_IN_SECONDS * 2, apply_filters( 'wc_session_use_secure_cookie', false ) );
			}

			// Show products per page dropdown.
			add_action( 'woocommerce_before_shop_loop', [ $this, 'products_per_page_dropdown' ], 99 );

		}

		// AJAX mini cart content.
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'cart' ], 11, 1 );

		// Number of  related products per page.
		add_filter( 'woocommerce_upsell_display_args', [ $this, 'related_products' ], 11 );
		add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products' ], 11 );

		// Customize products HTML and add quickview and wihlist.
		add_filter( 'woocommerce_post_class', [ $this, 'product_classes' ], 10, 2 );
		add_action( 'woocommerce_after_add_to_cart_button', [ $this, 'single_icons' ], 20 );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'woocommerce_before_shop_loop_item_title_low' ], 9 );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'woocommerce_before_shop_loop_item_title_high' ], 11 );

		// Single Wrap.
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'before_single' ], 11 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'after_single' ], 1 );

		// Recently viewed products.
		add_action( 'woocommerce_after_single_product', [ $this, 'recently_viewed_products' ], 20 );

		// Cart item removal AJAX.
		add_action( 'wp_ajax_xtra_remove_item_from_cart', [ $this, 'remove_item_from_cart' ] );
		add_action( 'wp_ajax_nopriv_xtra_remove_item_from_cart', [ $this, 'remove_item_from_cart' ] );

		// Quickview AJAX function.
		add_action( 'wp_ajax_xtra_quick_view', [ $this, 'quickview' ] );
		add_action( 'wp_ajax_nopriv_xtra_quick_view', [ $this, 'quickview' ] );

		// Get wishlist & compare page content via AJAX.
		add_action( 'wp_ajax_xtra_wishlist_content', [ $this, 'wishlist_content' ] );
		add_action( 'wp_ajax_nopriv_xtra_wishlist_content', [ $this, 'wishlist_content' ] );
		add_action( 'wp_ajax_xtra_compare_content', [ $this, 'compare_content' ] );
		add_action( 'wp_ajax_nopriv_xtra_compare_content', [ $this, 'compare_content' ] );

		// Wishlist shortcode.
		add_shortcode( 'cz_wishlist', [ $this, 'wishlist_shortcode' ] );

		// Compare shortcode.
		add_shortcode( 'cz_compare', [ $this, 'compare_shortcode' ] );

		// Quickview popup content.
		add_filter( 'woocommerce_product_loop_end', [ $this, 'popup' ] );

		// Modify checkout page.
		add_action( 'woocommerce_checkout_after_customer_details', [ $this, 'checkout_order_review_before' ] );
		add_action( 'woocommerce_checkout_after_order_review', [ $this, 'checkout_order_review_after' ] );

		// Add back to store button on WooCommerce cart page.
		add_action( 'woocommerce_cart_actions', [ $this, 'continue_shopping' ] );

		// Modify products query.
		add_action( 'woocommerce_product_query', [ $this, 'products_query' ], 10, 2 );

		// Out of stock badge.
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'out_of_stock' ] );

		// Remove product description h2 tab.
		add_filter( 'woocommerce_product_description_heading', '__return_null' );

		// Modify products title and add category name.
		if ( Codevz_Plus::option( 'woo_category_under_title' ) && ! is_admin() ) {
			add_filter( 'the_title', [ $this, 'category_under_title' ], 10, 2 );
		}

		// Sale badge percentage. 
		if ( Codevz_Plus::option( 'woo_sale_percentage' ) ) {
			add_filter( 'woocommerce_sale_flash', [ $this, 'percentage_sale_flash' ], 10, 3 );
		}

		// NEW Badge.
		if ( Codevz_Plus::option( 'woo_new_label' ) && ! Codevz_Plus::$is_free ) {
			add_filter( 'woocommerce_after_shop_loop_item_title', [ $this, 'new_badge' ], 11 );
			add_filter( 'woocommerce_before_single_product_summary', [ $this, 'new_badge' ], 11 );
		}

		// Single product page countdown.
		add_action( 'woocommerce_single_product_summary', [ $this, 'countdown' ], 25 );

		// Taxonomy add meta box.
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		// Save post action to update taxonomy fields.
		add_action( 'save_post', [ $this, 'save_post' ] );

		// Move new post types menu under products.
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		// Add cart empty SVG icon into cart page when its empty.
		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 ); // remove
		add_action( 'woocommerce_cart_is_empty', [ $this, 'cart_empty_svg' ], 10 ); // add

		// Rating text.
		add_filter( 'woocommerce_product_get_rating_html', [ $this, 'rating_reviews_text' ], 10, 3 );

		// Add text after product meta for all products.
		add_action( 'woocommerce_share', [ $this, 'content_after_product_meta' ], 1 );

		// Customize product meta HTML.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		add_action( 'woocommerce_single_product_summary', [ $this, 'product_meta' ], 40 );

		// Attribute variations settings and output.
		add_action( 'woocommerce_after_add_attribute_fields', [ $this, 'attribute_add_fields' ] );
		add_action( 'woocommerce_after_edit_attribute_fields', [ $this, 'attribute_add_fields' ] );
		add_action( 'woocommerce_attribute_added', [ $this, 'attribute_added_updated' ], 10, 2 );
		add_action( 'woocommerce_attribute_updated', [ $this, 'attribute_added_updated' ], 10, 2 );$attributes = (array) wc_get_attribute_taxonomies();

		$attributes = (array) wc_get_attribute_taxonomies();

		// Variations colorpicker.
		if ( ! empty( $attributes ) ) {

			foreach( $attributes as $attribute ) {

				add_action( 'pa_' . $attribute->attribute_name . '_edit_form_fields', [ $this, 'add_variation_colorpicker' ] );
				add_action( 'pa_' . $attribute->attribute_name . '_add_form_fields',  [ $this, 'add_variation_colorpicker' ] );

				add_filter( 'manage_edit-pa_' . $attribute->attribute_name . '_columns',  [ $this, 'add_variation_color_column' ], 1 );
				add_action( 'manage_pa_' . $attribute->attribute_name . '_custom_column', [ $this, 'show_variation_color_column' ], 1, 3 );

			}

		}

		// Variations save colorpicker.
		add_action( 'edit_term', [ $this, 'save_variation_colorpicker' ], 10, 3 );
		add_action( 'created_term', [ $this, 'save_variation_colorpicker' ], 10, 3 );

		// Variations output HTML.
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', [ $this, 'variations_output' ], 10, 2 );

		// Cart page related products according to cart items.
		if ( Codevz_Plus::option( 'woo_cart_page_related_products' ) && ! Codevz_Plus::$is_free ) {

			add_action( 'woocommerce_after_cart_totals', [ $this, 'cart_related_products' ] );
			add_action( 'woocommerce_cart_is_empty', [ $this, 'cart_empty_products_section' ] );

		}

		// Show 3 steps above on cart, checkout and order completion pages.
		if ( Codevz_Plus::option( 'woo_cart_checkout_steps' ) && ! Codevz_Plus::$is_free ) {

			add_action( 'woocommerce_before_cart', [ $this, 'cart_checkout_steps' ], 1 );
			add_action( 'woocommerce_before_checkout_form', [ $this, 'cart_checkout_steps' ], 1 );

		}

		// Avatar above the account nav.
		add_filter( 'woocommerce_before_account_navigation', [ $this, 'my_account_avatar' ] );

		// Fix new links in my account nav.
		$this->my_account_endpoints();

		// Add a new menus to my account page.
		add_filter( 'woocommerce_account_menu_items', [ $this, 'my_account_menus' ] );

		// My account menus content.
		add_action( 'woocommerce_account_wishlist_endpoint', [ $this, 'my_account_wishlist' ] );
		add_action( 'woocommerce_account_viewed_endpoint',   [ $this, 'my_account_viewed' ] );
		add_action( 'woocommerce_account_reviews_endpoint',  [ $this, 'my_account_reviews' ] );
		add_action( 'woocommerce_account_tracking_endpoint', [ $this, 'my_account_tracking' ] );
		add_action( 'woocommerce_before_customer_login_form', [ $this, 'before_my_account_form' ], 9 );
		add_action( 'woocommerce_after_customer_login_form', [ $this, 'after_my_account_form' ], 9 );
		add_action( 'woocommerce_before_lost_password_form', [ $this, 'before_my_account_form' ], 9 );
		add_action( 'woocommerce_after_lost_password_form', [ $this, 'after_my_account_form' ], 9 );

		// Product gallery navigation arrows.
		add_filter( 'woocommerce_single_product_carousel_options', [ $this, 'woo_flexslider_options' ] );

		// Add brands logo to taxonomy page.
		add_action( 'woocommerce_taxonomy_archive_description_raw', [ $this, 'brand_logo_term_description' ], 10, 2 );

		// Add short description under product rating on shop archive pages
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'products_short_desc' ], 4 );

	}

	/**
	 * Onsale badge percentage
	 * 
	 * @return string
	 */
	public function percentage_sale_flash( $html, $post, $product ) {

		if ( $product->is_on_sale() ) {

			if ( $product->is_type( 'variable' ) ) {

				$regular_price 	= (int) $product->get_variation_regular_price( 'max' );
				$sale_price 	= (int) $product->get_variation_sale_price( 'min' );

			} else {

				$regular_price 	= (int) $product->get_regular_price();
				$sale_price 	= (int) $product->get_sale_price();

			}

			if ( $regular_price && $sale_price ) {

				// Calculate the percentage discount
				$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

				// Customize the HTML output to display the percentage discount
				if ( Codevz_Plus::option( 'woo_sale_percentage' ) === 'woo-sale-text-percentage' ) {
					$html = '<span class="onsale">' . strip_tags( $html ) . '<span>-' . $percentage . '%</span></span>';
				} else {
					$html = '<span class="onsale">-' . $percentage . '%</span>';
				}

			}

		}

		return $html;

	}

	/**
	 * Showing NEW badge in the 
	 * 
	 * @return string
	 */
	public function new_badge( $onsale ) {

		$days = intval( abs( current_time( 'timestamp' ) - get_the_time( 'U', get_the_ID() ) ) / 86400 );

		if ( $days <= Codevz_Plus::option( 'woo_new_label_days', 1 ) ) {
			echo '<span class="onsale cz_new_badge">NEW</span>';
		}

	}

	/**
	 * Run cart JS fragments on all pages for mini cart.
	 * 
	 * @return string
	 */
	public function wp_enqueue_scripts() {

		wp_enqueue_script( 'wc-cart-fragments' );

	}

	/**
	 * Change cart empty message with SVG icon.
	 * 
	 * @return string
	 */
	public function cart_empty_svg( $only_svg = true ) {

		echo '<svg class="codevz-cart-empty-svg" fill="#676767" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 231.523 231.523" xml:space="preserve">
				<g>
					<path d="M107.415,145.798c0.399,3.858,3.656,6.73,7.451,6.73c0.258,0,0.518-0.013,0.78-0.04c4.12-0.426,7.115-4.111,6.689-8.231
						l-3.459-33.468c-0.426-4.12-4.113-7.111-8.231-6.689c-4.12,0.426-7.115,4.111-6.689,8.231L107.415,145.798z"/>
					<path d="M154.351,152.488c0.262,0.027,0.522,0.04,0.78,0.04c3.796,0,7.052-2.872,7.451-6.73l3.458-33.468
						c0.426-4.121-2.569-7.806-6.689-8.231c-4.123-0.421-7.806,2.57-8.232,6.689l-3.458,33.468
						C147.235,148.377,150.23,152.062,154.351,152.488z"/>
					<path d="M96.278,185.088c-12.801,0-23.215,10.414-23.215,23.215c0,12.804,10.414,23.221,23.215,23.221
						c12.801,0,23.216-10.417,23.216-23.221C119.494,195.502,109.079,185.088,96.278,185.088z M96.278,216.523
						c-4.53,0-8.215-3.688-8.215-8.221c0-4.53,3.685-8.215,8.215-8.215c4.53,0,8.216,3.685,8.216,8.215
						C104.494,212.835,100.808,216.523,96.278,216.523z"/>
					<path d="M173.719,185.088c-12.801,0-23.216,10.414-23.216,23.215c0,12.804,10.414,23.221,23.216,23.221
						c12.802,0,23.218-10.417,23.218-23.221C196.937,195.502,186.521,185.088,173.719,185.088z M173.719,216.523
						c-4.53,0-8.216-3.688-8.216-8.221c0-4.53,3.686-8.215,8.216-8.215c4.531,0,8.218,3.685,8.218,8.215
						C181.937,212.835,178.251,216.523,173.719,216.523z"/>
					<path d="M218.58,79.08c-1.42-1.837-3.611-2.913-5.933-2.913H63.152l-6.278-24.141c-0.86-3.305-3.844-5.612-7.259-5.612H18.876
						c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h24.94l6.227,23.946c0.031,0.134,0.066,0.267,0.104,0.398l23.157,89.046
						c0.86,3.305,3.844,5.612,7.259,5.612h108.874c3.415,0,6.399-2.307,7.259-5.612l23.21-89.25C220.49,83.309,220,80.918,218.58,79.08z
						 M183.638,165.418H86.362l-19.309-74.25h135.895L183.638,165.418z"/>
					<path d="M105.556,52.851c1.464,1.463,3.383,2.195,5.302,2.195c1.92,0,3.84-0.733,5.305-2.198c2.928-2.93,2.927-7.679-0.003-10.607
						L92.573,18.665c-2.93-2.928-7.678-2.927-10.607,0.002c-2.928,2.93-2.927,7.679,0.002,10.607L105.556,52.851z"/>
					<path d="M159.174,55.045c1.92,0,3.841-0.733,5.306-2.199l23.552-23.573c2.928-2.93,2.925-7.679-0.005-10.606
						c-2.93-2.928-7.679-2.925-10.606,0.005l-23.552,23.573c-2.928,2.93-2.925,7.679,0.005,10.607
						C155.338,54.314,157.256,55.045,159.174,55.045z"/>
					<path d="M135.006,48.311c0.001,0,0.001,0,0.002,0c4.141,0,7.499-3.357,7.5-7.498l0.008-33.311c0.001-4.142-3.356-7.501-7.498-7.502
						c-0.001,0-0.001,0-0.001,0c-4.142,0-7.5,3.357-7.501,7.498l-0.008,33.311C127.507,44.951,130.864,48.31,135.006,48.311z"/>
				</g>
			</svg>';

		if ( ! $only_svg ) {

			echo '<div class="codevz-cart-is-empty"><h2>' . esc_html__( 'Looks like your cart is empty!', 'codevz' ) . '</h2><span>' . esc_html__( 'Time to start your shopping', 'codevz' ) . '</span></div>';

		}

	}

	/**
	 * Get WooCommerce cart in header.
	 * 
	 * @return string
	 */
	public function cart( $fragments ) {

		$wc = WC();
		$count = $wc->cart->cart_contents_count;
		$total = $wc->cart->get_cart_total();

		ob_start(); ?>
			<div class="cz_cart">
				<?php if ( $count > 0 || Codevz_Plus::option( 'woo_show_zero_count' ) ) { ?>
				<span class="cz_cart_count"><?php echo esc_html( $count ); ?></span>
				<?php } ?>
				<div class="cz_cart_items"><div>
					<?php if ( $wc->cart->cart_contents_count == 0 ) { ?>
						<div class="cart_list">

							<div class="item_small xtra-empty-cart">

								<?php echo $this->cart_empty_svg( true ) . esc_html( Codevz_Plus::option( 'woo_no_products', esc_html__( "Cart's empty! Let's fill it up!", 'codevz' ) ) ); ?>

							</div>

						</div>
					<?php $fragments['.cz_cart'] = ob_get_clean(); return $fragments; } else { ?>
						<div class="cart_list">

							<?php foreach( $wc->cart->cart_contents as $cart_item_key => $cart_item ) {
								$id = $cart_item['product_id'];
								$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							?>
								<div class="item_small">
									<a href="<?php echo esc_url( get_permalink( $id ) ); ?>">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'codevz_600_600' ), $cart_item, $cart_item_key ) ); ?>
									</a>
									<div class="cart_list_product_title cz_tooltip_up">
										<h3><a href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo wp_kses_post( get_the_title( $id ) ); ?></a></h3>
										<div class="cart_list_product_quantity"><?php echo wp_kses_post( $cart_item['quantity'] ); ?> x <?php echo wp_kses_post( $wc->cart->get_product_subtotal( $cart_item['data'], 1 ) ); ?> </div>
										<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove" data-product_id="<?php echo esc_attr( $id ); ?>" data-title="<?php echo esc_attr__( 'Remove from cart', 'codevz' ); ?>"><i class="fa czico-198-cancel"></i></a>
									</div>
								</div>
							<?php } ?>
							</div>
							
							<div class="cz_cart_buttons clr">
								<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>"><i class="fa czico-071-money-3"></i><?php echo esc_html( do_shortcode( Codevz_Plus::option( 'woo_cart', esc_html__( 'Cart', 'codevz' ) ) ) ); ?> <span><?php echo wp_kses_post( $wc->cart->get_cart_total() ); ?></span></a>
								<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_checkout_page_id') ) ); ?>"><i class="fa czico-021-shopping-bag-7"></i><?php echo esc_html( do_shortcode( Codevz_Plus::option( 'woo_checkout', esc_html__( 'Checkout', 'codevz' ) ) ) ); ?></a>
							</div>
						<?php } ?>
					</div>

					<?php if ( Codevz_Plus::option( 'woo_cart_footer' ) ) { ?>
						<span class="cz_cart_footer"><?php echo esc_html( Codevz_Plus::option( 'woo_cart_footer' ) ); ?></span>
					<?php } ?>

				</div>
			</div>
		<?php 

		$fragments['.cz_cart'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * WooCommerce products columns
	 * 
	 * @return string
	 */
	public function columns() {

		return Codevz_Plus::option( 'woo_col', 4 );

	}

	/**
	 * WooCommerce products per page
	 * 
	 * @return object
	 */
	public function products_per_page( $query ) {

		$query->set( 'posts_per_page', $this->loop_shop_per_page() );

	}

	/**
	 * WooCommerce products per page
	 * 
	 * @return int
	 */
	public function loop_shop_per_page( $per_page = '' ) {

		$to = Codevz_Plus::option( 'woo_items_per_page', $per_page );

		if ( isset( $_REQUEST['ppp'] ) ) {

			$per_page = $_REQUEST['ppp'];

		} else if ( isset( $_COOKIE['woocommerce_products_per_page'] ) ) {

			$per_page = $_COOKIE['woocommerce_products_per_page'];

		} else {

			$per_page = $to;

		}

		if ( $per_page == 0 ) {
			$per_page = $to;
		}

		return intval( $per_page );

	}

	/**
	 * WooCommerce show products per page dropdown.
	 * 
	 * @return string
	 */
	public function products_per_page_dropdown() {

		if ( ! Codevz_Plus::option( 'woo_ppp_dropdown' ) ) {
			return;
		}

		global $wp_query;

		// Set the products per page options (e.g. 4, 8, 12)
		if ( Codevz_Plus::option( 'woo_col', 4 ) % 2 == 0 ) {
			$numbers = [ 4, 8, 16, 24, 32 ];
		} else {
			$numbers = [ 6, 9, 15, 21, 27 ];
		}

		// Get action URL.
		$cat = $wp_query->get_queried_object();

		if ( isset( $cat->term_id ) && isset( $cat->taxonomy ) ) {
			$action = get_term_link( $cat->term_id, $cat->taxonomy );
		} else {
			$action = get_the_permalink( get_option( 'woocommerce_shop_page_id' ) );
		}

		// Set action url if option behaviour is true
		// Paste QUERY string after for filter and orderby support
		$query_string = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . add_query_arg( array( 'ppp' => false ), $_SERVER['QUERY_STRING'] ) : null;
		$action = $action . $query_string;

		// Only show on product categories
		if ( ! woocommerce_products_will_display() ) :
			return;
		endif;

		$ppp = $this->loop_shop_per_page( 6 );

		?><form method="post" action="<?php echo esc_url( $action ); ?>" class="codevz-products-per-page">
			<select name="ppp" onchange="this.form.submit()">
				<option value="0" <?php echo in_array( $ppp, $numbers ) ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Products per page', 'codevz' ); ?></option>

				<?php

				foreach( $numbers as $key => $value ) :

					?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $ppp ); ?>><?php
						esc_html( printf( esc_html__( '%s products per page', 'codevz' ), $value ) );
					?></option><?php

				endforeach;

			?></select><?php

			// Keep query string vars intact
			foreach ( $_GET as $key => $val ) :

				if ( 'ppp' === $key || 'submit' === $key ) :
					continue;
				endif;
				if ( is_array( $val ) ) :
					foreach( $val as $inner_val ) :
						?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
					endforeach;
				else :
					?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
				endif;
			endforeach;

		?></form><?php

	}

	/**
	 * WooCommerce products per page
	 * 
	 * @return array
	 */
	public function related_products( $args ) {

		$columns = (int) Codevz_Plus::option( 'woo_related_col' );

		$args['columns'] 		= $columns;
		$args['posts_per_page'] = $columns;

		return $args;

	}

	/**
	 * Wishlist container shortcode.
	 * 
	 * @return string
	 */
	public function wishlist_shortcode( $a, $c = '' ) {
		return '<div class="woocommerce xtra-wishlist xtra-icon-loading" data-col="3" data-empty="' . esc_html__( 'Your wishlist list is empty.', 'codevz' ) . '" data-nonce="' . wp_create_nonce( 'xtra_wishlist_content' ) . '"></div>';
	}

	/**
	 * Compare container shortcode.
	 * 
	 * @return string
	 */
	public function compare_shortcode( $a, $c = '' ) {
		return '<div class="woocommerce xtra-compare xtra-icon-loading" data-empty="' . esc_html__( 'Your products compare list is empty.', 'codevz' ) . '" data-nonce="' . wp_create_nonce( 'xtra_compare_content' ) . '"></div>';
	}

	/**
	 * Get wishlist products via AJAX.
	 * 
	 * @return string
	 */
	public function wishlist_content() {

		if ( empty( $_POST['ids'] ) && empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'xtra_wishlist_content' ) ) {
			wp_die( '<b>' . esc_html__( 'Server error, Please reload page ...', 'codevz' ) . '</b>' );
		}

		if ( isset( $_POST['check'] ) ) {

			$new = '';

			$ids = explode( ',', $_POST['ids'] );

			foreach( $ids as $id ) {

				if ( $id && $id !== 'undefined' ) {

					$id = str_replace( ' ', '', $id );

					$post = get_post( $id );

					if ( ! empty( $post->post_title ) ) {

						$new .= $id . ',';

					}

				}

			}

			wp_die( esc_html( $new ) );

		}

		$col = isset( $_POST['col'] ) ? $_POST['col'] : '3';

		wp_die( do_shortcode( '[products ids="' . esc_html( $_POST['ids'] ) . '" columns="' . esc_html( $col ) . '"]' ) );

	}

	/**
	 * Get compare products via AJAX.
	 * 
	 * @return string
	 */
	public function compare_content() {

		if ( empty( $_POST['ids'] ) && empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'xtra_compare_content' ) ) {
			wp_die( '<b>' . esc_html__( 'Server error, Please reload page ...', 'codevz' ) . '</b>' );
		}

		$out = '';

		if ( isset( $_POST['check'] ) ) {

			$ids = explode( ',', $_POST['ids'] );

			foreach( $ids as $id ) {

				if ( $id && $id !== 'undefined' ) {

					$id = str_replace( ' ', '', $id );

					$post = get_post( $id );

					if ( ! empty( $post->post_title ) ) {

						$out .= $id . ',';

					}

				}

			}

			wp_die( esc_html( $out ) );

		} else {

			$ids = explode( ',', $_POST['ids'] );

			$out .= '<table class="cz-compare cz-compare-col-' . esc_attr( count( $ids ) - 1 ) . '"><tbody>';

			$tr = [

				'general' 			=> [ 'td' => '', 'title' => '' ],
				'price' 			=> [ 'td' => '', 'title' => esc_html__( 'Price', 'codevz' ) ],
				'brand' 			=> [ 'td' => '', 'title' => esc_html__( 'Brand', 'codevz' ) ],
				'desc' 				=> [ 'td' => '', 'title' => esc_html__( 'Description', 'codevz' ) ],
				'sku' 				=> [ 'td' => '', 'title' => esc_html__( 'Product SKU', 'codevz' ) ],
				'availablity' 		=> [ 'td' => '', 'title' => esc_html__( 'Availablity', 'codevz' ) ],
				'sold_individually' => [ 'td' => '', 'title' => esc_html__( 'Individual sale', 'codevz' ) ],
				'tax_status' 		=> [ 'td' => '', 'title' => esc_html__( 'Tax status', 'codevz' ) ],
				'weight' 			=> [ 'td' => '', 'title' => esc_html__( 'Weight', 'codevz' ) ],
				'length' 			=> [ 'td' => '', 'title' => esc_html__( 'Length', 'codevz' ) ],
				'height' 			=> [ 'td' => '', 'title' => esc_html__( 'Height', 'codevz' ) ],
				'width' 			=> [ 'td' => '', 'title' => esc_html__( 'Width', 'codevz' ) ],
				'average_rating' 	=> [ 'td' => '', 'title' => esc_html__( 'Average rating', 'codevz' ) ],
				'review_count' 		=> [ 'td' => '', 'title' => esc_html__( 'Review count', 'codevz' ) ],

			];

			foreach( $ids as $id ) {

				if ( $id && $id !== 'undefined' ) {

					$id = str_replace( ' ', '', $id );

					$product = wc_get_product( $id );

					$tr[ 'general' ][ 'td' ] .= '<td><a href="' . get_permalink( $product->get_id() ) . '">' . $product->get_image() . '<h4 data-id="' . $id . '">' . get_the_title( $id ) . '</h4></a>' . do_shortcode( '[add_to_cart id=' . $product->get_id() . ' show_price="false"]' ) . '</td>';

					$tr[ 'price' ][ 'td' ] .= '<td>' . $product->get_price_html() . '</td>';

					$brands  = (array) get_the_terms( $product->get_id(), 'codevz_brands', true );

					if ( ! empty( $brands[ 0 ]->term_id ) ) {

						$term_meta = get_term_meta( $brands[ 0 ]->term_id, 'codevz_brands', true );

						$tr[ 'brand' ][ 'td' ] .= '<td>';

						$tr[ 'brand' ][ 'td' ] .= empty( $term_meta[ 'brand_logo' ] ) ? '' : '<a href="' . get_term_link( $brands[ 0 ]->term_id ) . '">' . wp_get_attachment_image( $term_meta[ 'brand_logo' ], 'full' ) . '</a>';

						$tr[ 'brand' ][ 'td' ] .= '</td>';

					}

					$tr[ 'desc' ][ 'td' ] .= '<td>' . ( $product->get_short_description() ? $product->get_short_description() : '<i class="fa fa-times"></i>' ) . '</td>';

					$tr[ 'sku' ][ 'td' ] .= '<td>' . ( $product->get_sku() ? $product->get_sku() : '<i class="fa fa-times"></i>' ) . '</td>';

					// Product stock status.
					$get_stock_status = $product->get_stock_status();

					if ( $get_stock_status === 'instock' ) {

						$get_stock_status = esc_html__( 'Instock', 'codevz' );

					} else if ( $get_stock_status === 'outofstock' ) {

						$get_stock_status = esc_html__( 'Out of stock', 'codevz' );

					}

					$tr[ 'availablity' ][ 'td' ] .= '<td>' . ( ( $product->get_stock_quantity() || ! $product->get_manage_stock() ) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' ) . $product->get_stock_quantity() . ' ' . ucwords( $get_stock_status ) . '</td>';

					$tr[ 'sold_individually' ][ 'td' ] .= '<td>' . ( $product->get_sold_individually() ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' ) . '</td>';

					// Product tax status.
					$get_tax_status = $product->get_tax_status();

					if ( $get_tax_status === 'taxable' ) {

						$get_tax_status = esc_html__( 'Taxable', 'codevz' );

					} else if ( $get_tax_status === 'shipping' ) {

						$get_tax_status = esc_html__( 'Shipping only', 'codevz' );

					} else if ( $get_tax_status === 'none' ) {

						$get_tax_status = esc_html__( 'None', 'codevz' );

					}

					$tr[ 'tax_status' ][ 'td' ] .= '<td>' . ( $get_tax_status ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' ) . ucwords( $get_tax_status ) . '</td>';

					if ( $product->get_attributes() ) {

						foreach ( $product->get_attributes() as $attr ) {

							$name = $attr->get_name();
							$options = $attr->get_options();

							$tr[ $name ][ 'title' ] = ucwords( $name );

							$tr[ $name ][ 'td' ] = '';

							$tr[ $name ][ 'td' ] .= '<td>';

							foreach ( $options as $key => $val ) {
								$tr[ $name ][ 'td' ] .= $key ? ', ' . $val : $val;
							}

							$tr[ $name ][ 'td' ] .= '</td>';

						}

					}

					if ( $product->get_weight() ) {
						$tr[ 'weight' ][ 'td' ] .= '<td>' . $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' ) . '</td>';
					}

					if ( $product->get_length() ) {
						$tr[ 'length' ][ 'td' ] .= '<td>' . $product->get_length() . ' ' . get_option( 'woocommerce_dimension_unit' ) . '</td>';
					}

					if ( $product->get_height() ) {
						$tr[ 'height' ][ 'td' ] .= '<td>' . $product->get_height() . ' ' . get_option( 'woocommerce_dimension_unit' ) . '</td>';
					}

					if ( $product->get_width() ) {
						$tr[ 'width' ][ 'td' ] .= '<td>' . $product->get_width() . ' ' . get_option( 'woocommerce_dimension_unit' ) . '</td>';
					}

					$tr[ 'average_rating' ][ 'td' ] .= '<td>' . ( $product->get_average_rating() ? '<i class="fa fa-star"></i>' . $product->get_average_rating() : '<i class="fa fa-times"></i>' ) . '</td>';

					$tr[ 'review_count' ][ 'td' ] .= '<td>' . ( $product->get_review_count() ? $product->get_review_count() : '<i class="fa fa-times"></i>' ) . '</td>';

				}

			}

			foreach( $tr as $class => $inner ) {

				if ( empty( $inner['td'] ) ) {
					continue;
				}

				$out .= '<tr class="cz-compare-tr-' . esc_attr( $class ) . '">';

				if ( $class === 'general' ) {
					$inner['title'] = '';
				}

				$out .= '<th>' . esc_html( $inner['title'] ) . '</th>';

				$out .= empty( $inner['td'] ) ? '' : $inner['td'];

				$out .= '</tr>';

			}

			$out .= '</tbody></table><ul class="hide"><li></li></ul>';

			wp_die( $out );

		}

	}

	/**
	 * Add wishlist icon into single product page.
	 * 
	 * @return string
	 */
	public function single_icons() {

		$product_id  = get_the_id();

		// Display custom button next to Add to Cart button on single product page
		$button_title = get_post_meta( $product_id, 'codevz_custom_button_title', true );
		$button_link  = get_post_meta( $product_id, 'codevz_custom_button_link', true );

		if ( $button_title && $button_link ) {

			echo '<a href="' . esc_url( do_shortcode( $button_link ) ) . '" onclick="window.open(\'' . do_shortcode( esc_url( $button_link ) ) . '\', \'_blank\');return false;" target="_blank" class="codevz-product-second-button button alt">' . esc_html( do_shortcode( $button_title ) ) . '</a>';

		}

		if ( Codevz_Plus::option( 'woo_wishlist' ) ) {

			echo '<div class="xtra-product-icons xtra-product-icons-wishlist cz_tooltip_up" data-id="' . $product_id . '">';
			echo '<i class="fa fa-heart-o xtra-add-to-wishlist" data-title="' . esc_html__( 'Add to wishlist', 'codevz' ) . '"></i>';
			echo '</div>';

		}

		if ( Codevz_Plus::option( 'woo_compare' ) ) {

			echo '<div class="xtra-product-icons xtra-product-icons-compare cz_tooltip_up" data-id="' . $product_id . '">';
			echo '<i class="fa czico-shuffle xtra-add-to-compare" data-title="' . esc_html__( 'Add to compare', 'codevz' ) . '"></i>';
			echo '</div>';

		}

		echo '<div class="clr"></div>';

	}

	/**
	 * Add custom tabs to product single page tabs.
	 * 
	 * @return Array
	 */
	public function product_tabs( $tabs ) {

		if ( Codevz_Plus::$is_free ) {

			return $tabs;

		}

		// Product ID.
		$product_id = get_the_ID();

		// Size guide tab.
		if ( Codevz_Plus::option( 'woo_product_size_guide_tab' ) ) {

			$size_guide = get_post_meta( $product_id, 'codevz_size_guide', true );
			$size_guide = $size_guide ? $size_guide : Codevz_Plus::option( 'woo_product_size_guide_tab_content' );

			if ( $size_guide ) {

				$tabs[ 'codevz-size-guide' ] = array(
					'title'     => Codevz_Plus::option( 'woo_product_size_guide_tab_title', esc_html__( 'Size Guide', 'codevz' ) ),
					'priority'  => 50,
					'callback'  => function() use ( $size_guide ) {

						echo is_numeric( $size_guide ) ? Codevz_Plus::get_page_as_element( $size_guide ) : do_shortcode( $size_guide );

					}

				);

			}

		}

		// FAQ tab.
		if ( Codevz_Plus::option( 'woo_product_faq_tab' ) ) {

			$faq = get_post_meta( $product_id, 'codevz_faq', true );
			$faq = $faq ? $faq : Codevz_Plus::option( 'woo_product_faq_tab_content' );

			if ( $faq ) {

				$tabs[ 'codevz-faq' ] = array(
					'title'     => Codevz_Plus::option( 'woo_product_faq_tab_title', esc_html__( 'FAQ', 'codevz' ) ),
					'priority'  => 60,
					'callback'  => function() use ( $faq ) {

						echo is_numeric( $faq ) ? Codevz_Plus::get_page_as_element( $faq ) : do_shortcode( $faq );

					}

				);

			}

		}

		// Brand tab.
		if ( Codevz_Plus::option( 'woo_product_brand_tab' ) ) {

			$terms = (array) get_the_terms( $product_id, 'codevz_brands' );

			if ( ! empty( $terms[0] ) ) {

				foreach( $terms as $term ) {

					$tabs[ 'codevz-' . $term->slug ] = array(
						'title'     => $term->name,
						'priority'  => 70,
						'callback'  => function() use ( $term ) {

							$logo = get_term_meta( $term->term_id, 'codevz_brands', true );
							$logo = empty( $logo[ 'brand_logo' ] ) ? '' : wp_get_attachment_image( $logo[ 'brand_logo' ], 'full' );
							$logo = do_shortcode( $logo ? '<div class="codevz-product-brands">' . $logo . '</div>' : '' );

							echo '<h2 class="section_title mb30">' . $term->name . '</h2>';
							echo '<div class="clr">' . $logo . '<p>' . do_shortcode( $term->description ) . '</p></div>';
							echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="button" style="margin-top:30px">' . esc_html__( 'View brand products', 'codevz' ) . '</a>';

						}
					);

					continue;

				}

			}

		}

		// Shipping & Returns
		if ( Codevz_Plus::option( 'woo_product_shipping_returns_tab' ) ) {

			$tabs[ 'codevz-shipping-returns' ] = array(
				'title'     => Codevz_Plus::option( 'woo_product_shipping_returns_tab_title', esc_html__( 'Shipping & Returns' , 'codevz' ) ),
				'priority'  => 80,
				'callback'  => function() {

					echo do_shortcode( Codevz_Plus::option( 'woo_product_shipping_returns_tab_content', '...' ) );

				}
			);

		}

		return $tabs;

	} 

	/**
	 * AJAX remove product from header cart.
	 * 
	 * @return string
	 */
	public function remove_item_from_cart() {

		$wc = WC();
		$cart = $wc->instance()->cart;
		$cart_id = $cart->generate_cart_id( $_POST['id'] );
		$cart_item_id = $cart->find_product_in_cart( $cart_id );

		if ( $cart_item_id ) {
			$cart->set_quantity( $cart_item_id, 0 );
		}

		// Return cart content
		wp_die( WC_AJAX::get_refreshed_fragments() );
	}

	/**
	 * Add extra custom classes to products.
	 * 
	 * @return array
	 */
	public function product_classes( $classes, $product ) {

		// Hover effect name.
		$hover = Codevz_Plus::option( 'woo_hover_effect' );

		if ( $hover ) {

			$hover = 'cz_image cz_image_' . esc_attr( $hover );

			$attachment_ids = $product->get_gallery_image_ids();

			// Fix single page.
			if ( is_singular( 'product' ) && ! $this->singular_product_id ) {
				$hover = '';
			}

			// Check gallery first image.
			if ( is_array( $attachment_ids ) && isset( $attachment_ids[0] ) ) {

				$classes[] = $hover;

			}
		}

		return $classes;

	}

	public function quickview() {
		if ( ! isset( $_POST['id'] ) && ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'xtra_quick_view' ) ) {
			wp_die( '<b>' . esc_html__( 'Server error, Please reload page and try again ...', 'codevz' ) . '</b>' );
		}

		echo '<div class="xtra-qv-product-content">';
		$content = do_shortcode( '[product_page id="' . $_POST['id'] . '"] ' );
		echo str_replace( 'data-src=', 'src=', $content );
		
		echo '</div>';

		echo '<script src="' . plugins_url( 'assets/js/zoom/jquery.zoom.min.js', WC_PLUGIN_FILE ) . '"></script>';
		echo '<script src="' . plugins_url( 'assets/js/flexslider/jquery.flexslider.min.js', WC_PLUGIN_FILE ) . '"></script>';
		echo '<link media="all" href="' . plugins_url( 'codevz-plus/assets/css/share.css' ) . '" rel="stylesheet"/>';

		?><script type='text/javascript'>
		/* <![CDATA[ */
		var wc_single_product_params = <?php echo json_encode( array(
			'flexslider' => apply_filters(
				'woocommerce_single_product_carousel_options',
				array(
					'rtl'            => Codevz_Plus::$is_rtl,
					'animation'      => 'slide',
					'smoothHeight'   => true,
					'directionNav'   => false,
					'controlNav'     => 'thumbnails',
					'slideshow'      => false,
					'animationSpeed' => 500,
					'animationLoop'  => false, // Breaks photoswipe pagination if true.
					'allowOneSlide'  => false,
				)
			),
			'zoom_enabled' => apply_filters( 'woocommerce_single_product_zoom_enabled', get_theme_support( 'wc-product-gallery-zoom' ) ),
			'zoom_options' => apply_filters( 'woocommerce_single_product_zoom_options', array() ),
			'photoswipe_enabled' => false,
			'flexslider_enabled' => apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) ),
		) ); ?>;
		/* ]]> */
		</script><?php

		echo '<script src="' . plugins_url( 'assets/js/frontend/single-product.min.js', WC_PLUGIN_FILE ) . '"></script>';
		echo '<script src="' . plugins_url( 'assets/js/frontend/add-to-cart-variation.min.js', WC_PLUGIN_FILE ) . '"></script>';
		
		wp_die();
	}

	public function woocommerce_before_shop_loop_item_title_low() {
		echo '<div class="xtra-product-thumbnail">';

		$product_id = get_the_ID();

		$wishlist = Codevz_Plus::option( 'woo_wishlist' );
		$compare = Codevz_Plus::option( 'woo_compare' );
		$quick_view = Codevz_Plus::option( 'woo_quick_view' );

		if ( $wishlist || $quick_view ) {

			$center = Codevz_Plus::option( 'woo_wishlist_qv_center' ) ? ' xtra-product-icons-center' : '';
			$center .= $center ? ' cz_tooltip_up' : ( ( Codevz_Plus::$is_rtl || is_rtl() ) ? ' cz_tooltip_right' : ' cz_tooltip_left' );

			echo '<div class="xtra-product-icons' . $center . '" data-id="' . $product_id . '">';
			echo $wishlist ? '<i class="fa fa-heart-o xtra-add-to-wishlist" data-title="' . esc_html__( 'Add to wishlist', 'codevz' ) . '"></i>' : '';
			echo $compare ? '<i class="fa czico-shuffle xtra-add-to-compare" data-title="' . esc_html__( 'Add to compare', 'codevz' ) . '" data-nonce="' . wp_create_nonce( 'xtra_compare' ) . '"></i>' : '';
			echo $quick_view ? '<i class="fa czico-146-search-4 xtra-product-quick-view" data-title="' . esc_html__( 'Quick view', 'codevz' ) . '" data-nonce="' . wp_create_nonce( 'xtra_quick_view' ) . '"></i>' : '';
			echo '</div>';

		}

		$hover = Codevz_Plus::option( 'woo_hover_effect' );

		if ( $hover ) {

			$product = wc_get_product( $product_id );
			$attachment_ids = $product->get_gallery_image_ids();

			if ( is_array( $attachment_ids ) && isset( $attachment_ids[0] ) ) {

				echo '<div class="cz_image_in">';
				echo '<div class="cz_main_image">';

			}
		}
	}

	public function woocommerce_before_shop_loop_item_title_high() {

		$hover = Codevz_Plus::option( 'woo_hover_effect' );

		if ( $hover ) {

			$product = wc_get_product( get_the_ID() );
			$attachment_ids = $product->get_gallery_image_ids();

			if ( is_array( $attachment_ids ) && isset( $attachment_ids[0] ) ) {

				echo '</div><div class="cz_hover_image">';

				echo Codevz_Plus::lazyload( Codevz_Plus::get_image( $attachment_ids[0], 'woocommerce_thumbnail' ) );

				echo '</div></div>';

			}

		}

		echo '</div>';

	}

	/**
	 * Quick view, wishlist and compare added popup content.
	 * 
	 * @return string
	 */
	public function popup( $content = '' ) {

		// Quickview popup.
		if ( Codevz_Plus::option( 'woo_quick_view' ) ) {

			$content .= do_shortcode( '[cz_popup id_popup="xtra_quick_view" id="cz_xtra_quick_view" icon="fa czico-198-cancel" sk_icon="color:#ffffff;"][/cz_popup]' );

		}

		// Wishlist & Compare popup.
		if ( Codevz_Plus::option( 'woo_wishlist' ) || Codevz_Plus::option( 'woo_compare' ) ) {

			$content .= do_shortcode( '[cz_popup id_popup="xtra_wish_compare" id="cz_xtra_wish_compare" icon="fa czico-198-cancel" sk_icon="color:#ffffff;"]<i class="fa fa-check"></i><h3>...</h3><span>' . esc_html__( 'Product has been added to your list.', 'codevz' ) . '</span><a href="#" class="button"><span><strong></strong><i class="fas fa-chevron-' . ( is_rtl() ? 'left' : 'right' ) . '"></i></span></a>[/cz_popup]' );

		}

		// Added to cart notification for AJAX buttons.
		if ( Codevz_Plus::option( 'woo_added_to_cart_notification' ) ) {

			$content .= '<div class="codevz-added-to-cart-notif"><i class="fa fa-check"></i><span>"<strong></strong>" ' . esc_html__( 'has been added to your cart.', 'codevz' ) . '<a class="button" href="' . esc_url( get_permalink( get_option( 'woocommerce_cart_page_id' ) ) ) . '">' . esc_html__( 'View cart', 'codevz' ) . '</a></span></div>';

		}

		return $content;

	}

	/**
	 * Modify checkout page and add wrap to order details.
	 * 
	 * @return string
	 */
	public function checkout_order_review_before() {
		echo '<div class="xtra-woo-checkout-details cz_sticky_col"><div class="codevz-checkout-details">';
	}

	/**
	 * Modify checkout page and add wrap to order details.
	 * 
	 * @return string
	 */
	public function checkout_order_review_after() {
		echo '</div></div>';
	}

	/**
	 * Single product add wrap div.
	 * 
	 * @return string
	 */
	public function before_single() {

		// Remove stock HTML in single page.
		add_filter( 'woocommerce_get_stock_html', '__return_null' );

		// Get current product ID.
		if ( is_singular( 'product' ) ) {

			$this->singular_product_id = get_the_ID();

		}

		// Product container.
		echo '<div class="xtra-single-product clr">';

	}

	public function after_single() {

		echo '</div>';

		// Sticky add to cart row.
		if ( is_singular( 'product' ) && Codevz_Plus::option( 'woo_product_sticky_add_to_cart' ) ) {

			echo '<div class="cz-sticky-add-to-cart"><div class="row clr"></div></div>';

		}

	}

	/**
	 * Add product to recently viewed list on single product page.
	 * 
	 * @return string
	 */
	public function recently_viewed_products() {

		$product_id = get_the_ID();
		$option 	= Codevz_Plus::option( 'woo_recently_viewed_products' );

		// Get recently viewed products from cookie.
		$rvp = isset( $_COOKIE[ 'codevz_rvp' ] ) ? json_decode( wp_unslash( $_COOKIE[ 'codevz_rvp' ] ), true ) : [];

		if ( is_array( $rvp ) ) {

			// Remove product ID if already exists
			$key = array_search( $product_id, $rvp );
			if ( $key !== false ) {
				unset( $rvp[ $key ] );
			}

			// Add new product ID to the beginning
			array_unshift( $rvp, $product_id );

			// Keep only unique product IDs and limit to 5
			$rvp = array_unique( $rvp );
			$rvp = array_slice( $rvp, 0, 50 );

			echo '<script>document.cookie = "codevz_rvp=' . json_encode( $rvp ) . '; expires=' . gmdate( 'D, d M Y H:i:s \G\M\T', time() + 3600 * 24 * 30 ) . '; path=/";</script>';

			// Show products.
			if ( ! empty( $rvp ) && $option && $option !== '0' ) {

				echo '<div class="codevz-recently-viewed-products related products mt50">';
				echo '<h2>' . esc_html__( 'Recently viewed products', 'codevz' ) . '</h2>';
				echo do_shortcode( '[products ids="' . implode( ',', $rvp ) . '" columns="' . $option . '" limit="' . $option . '"]' );
				echo '</div>';

			}

		}

	}

	/**
	 * Continue shopping button in cart page.
	 * 
	 * @return string
	 */
	public function continue_shopping() {
		echo '<a class="button wc-backward" href="' . esc_url( get_the_permalink( get_option( 'woocommerce_shop_page_id' ) ) ) . '">' . Codevz_Plus::option( 'woo_continue_shopping', esc_html__( 'Continue shopping', 'codevz' ) ) . '</a>';
	}

	/**
	 * Modify products query.
	 * 
	 * @return object
	 */
	public function products_query( $query, $instance ) {

		// Products order.
		$order = Codevz_Plus::option( 'woo_order' );

		if ( $order ) {
			$query->set( 'order', esc_attr( $order ) );
		}

		// Products order by.
		$orderby = Codevz_Plus::option( 'woo_orderby' );

		if ( $orderby ) {
			$query->set( 'orderby', esc_attr( $orderby ) );
		}

	}

	/**
	 * Out of stock button title.
	 * 
	 * @return string
	 */
	public function out_of_stock() {

		if ( Codevz_Plus::option( 'woo_sold_out_badge' ) ) {

			global $product;

			if ( ! $product->is_in_stock() ) {
				echo '<span class="xtra-outofstock">' . Codevz_Plus::option( 'woo_sold_out_title', esc_html__( 'Sold out', 'codevz' ) ) . '</span>';
			}
			
		}

	}

	/**
	 * Single product page countdown
	 * 
	 * @return string
	 */
	public function countdown() {

		$date = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );

		if ( $date ) {

			$date = date( 'Y/m/d', $date + 86400 );

			if ( strtotime( $date ) > current_time( 'timestamp' ) ) {

				echo '<div class="cz-woo-countdown cz-woo-single-countdown">';
				echo do_shortcode( '[cz_title sk_overall="font-size:14px;color:#ffffff;background-color:#333333;padding:6px 20px;margin-right:25px;margin-bottom:-20px;margin-left:25px;"]' . esc_html__( 'Sale will end in', 'codevz' ) . '[/cz_title][cz_countdown date="' . $date . '" pos="tal" expire="" sk_cols="padding:0px 25px;margin-right:-1px;margin-left:0px;border-style:solid;border-width:0px 1px 0px 0px;border-color:rgba(205,205,205,0.3);" sk_title="font-size:13px;margin-top:-10px;opacity:0.7;" sk_overall="background-color:rgba(205,205,205,0.1);padding:35px 20px 20px;border-style:solid;border-width:1px;border-color:rgba(205,205,205,0.3);display:inline-block;"]' );
				echo '</div>';

			}

		}

	}

	/**
	 * Single product page taxonomy meta box getting from its post type.
	 * 
	 * @return string
	 */
	public function add_meta_boxes() {

		add_meta_box( 'codevz_woo_meta_box', esc_html__( 'Advanced', 'codevz' ), [ $this, 'metabox_content' ], 'product', 'side', 'default' );

	}

	/**
	 * Custom product options as side meta box.
	 * 
	 * @return string
	 */
	public function metabox_content( $post ) {

		$is_free = Codevz_Plus::is_free();

		echo codevz_add_field( [
			'id'    		=> 'codevz_size_guide',
			'type'  		=> $is_free ? 'content' : 'select',
			'title' 		=> esc_html__( 'Size guide tab', 'codevz'),
			'options' 		=> 'posts',
			'query_args' 	=> [ 'post_type' => 'codevz_size_guide', 'posts_per_page' => -1 ],
			'default_option'=> esc_html__( '~ Default ~', 'codevz'),
			'content' 		=> Codevz_Plus::pro_badge()
		], get_post_meta( $post->ID, 'codevz_size_guide', true ) );

		echo codevz_add_field( [
			'id'    		=> 'codevz_faq',
			'type'  		=> $is_free ? 'content' : 'select',
			'title' 		=> esc_html__( 'FAQ tab', 'codevz'),
			'options' 		=> 'posts',
			'query_args' 	=> [ 'post_type' => 'codevz_faq', 'posts_per_page' => -1 ],
			'default_option'=> esc_html__( '~ Default ~', 'codevz'),
			'content' 		=> Codevz_Plus::pro_badge()
		], get_post_meta( $post->ID, 'codevz_faq', true ) );

		echo codevz_add_field( [
			'id'    		=> 'codevz_custom_button_title',
			'type'  		=> $is_free ? 'content' : 'text',
			'title' 		=> esc_html__( 'Custom button title', 'codevz'),
			'content' 		=> Codevz_Plus::pro_badge()
		], get_post_meta( $post->ID, 'codevz_custom_button_title', true ) );

		echo codevz_add_field( [
			'id'    		=> 'codevz_custom_button_link',
			'type'  		=> $is_free ? 'content' : 'text',
			'title' 		=> esc_html__( 'Custom button link', 'codevz'),
			'content' 		=> Codevz_Plus::pro_badge()
		], get_post_meta( $post->ID, 'codevz_custom_button_link', true ) );

	}

	/**
	 * Update taxonomy value on product save.
	 * 
	 * @return -
	 */
	public function save_post( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST[ 'codevz_size_guide' ] ) ) {
			update_post_meta( $post_id, 'codevz_size_guide', $_POST[ 'codevz_size_guide' ] );
		}

		if ( isset( $_POST[ 'codevz_faq' ] ) ) {
			update_post_meta( $post_id, 'codevz_faq', $_POST[ 'codevz_faq' ] );
		}

		if ( isset( $_POST[ 'codevz_custom_button_title' ] ) ) {
			update_post_meta( $post_id, 'codevz_custom_button_title', $_POST[ 'codevz_custom_button_title' ] );
		}

		if ( isset( $_POST[ 'codevz_custom_button_link' ] ) ) {
			update_post_meta( $post_id, 'codevz_custom_button_link', $_POST[ 'codevz_custom_button_link' ] );
		}

	}

	/**
	 * Move new post types menu under products menu.
	 * 
	 * @return -
	 */
	public function admin_menu() {

		// Remove post type menu.
		remove_menu_page( 'edit.php?post_type=codevz_size_guide' );
		remove_menu_page( 'edit.php?post_type=codevz_faq' );

		global $submenu;

		// Add post type as taxonomy menu under products menu.
		$submenu['edit.php?post_type=product'][] = [ esc_html__( 'Size Guide', 'codevz' ), 'manage_options', 'edit.php?post_type=codevz_size_guide' ];
		$submenu['edit.php?post_type=product'][] = [ esc_html__( 'FAQ', 'codevz' ), 'manage_options', 'edit.php?post_type=codevz_faq' ];

	}

	/**
	 * Single product customer reviews text and count.
	 * 
	 * @return string
	 */
	public function rating_reviews_text( $html, $rating, $count ) {

		if ( $count ) {

			$string = ( $count === 1 ) ? esc_html__( 'customer review', 'codevz' ) : esc_html__( 'customer reviews', 'codevz' );

			$html .= ' ' . sprintf( '<a class="codevz-customer-reviews" href="#">( %d %s )</a>', $count, $string );

		}

		return $html;
	}

	/**
	 * Customize product meta HTML tags for styling.
	 * 
	 * @return string
	 */
	public function product_meta() {

		global $product;

		$id = $product->get_id();

		$sku 	= $product->get_sku();
		$cats 	= wc_get_product_category_list( $id, ', ', '', '' );
		$tags 	= wc_get_product_tag_list( $id, ', ', '', '' );
		$stock 	= $product->get_availability();
		$stock 	= isset( $stock[ 'availability' ] ) ? $stock[ 'availability' ] : '';
		$status = $product->get_stock_status();
		$icon 	= ( $status === 'outofstock' ? '<i class="fa fa-shop-lock" aria-hidden="true"></i>' : '<i class="fa fa-check" data-title="' . esc_attr( $stock ) . '" aria-hidden="true"></i>' );

		// Show brand name and logo in single product page.
		$brands = (array) get_the_terms( $id, 'codevz_brands', true );
		foreach( $brands as $term ) {

			if ( ! empty( $term->name ) ) {

				$name = $term->name;
				$link = get_term_link( $term );

				// Logo.
				$logo = get_term_meta( $term->term_id, 'codevz_brands', true );
				$logo = empty( $logo[ 'brand_logo' ] ) ? '' : wp_get_attachment_image( $logo[ 'brand_logo' ], 'full' );
				$logo = $logo ? '<div class="codevz-product-brands"><a href="' . esc_url( $link ) . '">' . do_shortcode( $logo ) . '</a></div>' : '';

				// Brand name.
				//$brand =  $logo ? esc_html( $name ) : '<a href="' . esc_url( $link ) . '">' . esc_html( $name ) . '</a>';
				$brand =  '<a href="' . esc_url( $link ) . '">' . esc_html( $name ) . '</a>';

				break;

			}

		}

		echo '<div class="product_meta clr">';

		echo !empty( $logo ) ? do_shortcode( $logo ) : ''; // brand logo.

		echo !empty( $brand ) ? '<div class="codevz-pm-brand"><strong>' . esc_html__( 'Brand', 'codevz' ) . '</strong><span>' . $brand . '</span></div>' : '';
		echo $sku  ? '<div class="codevz-pm-sku"><strong>' . esc_html__( 'SKU', 'codevz' ) . '</strong><span>' . $sku . '</span></div>' : '';
		echo $stock? '<div class="codevz-pm-status codevz-pm-status-' . esc_attr( $status ) . '"><strong>' . esc_html__( 'Status', 'codevz' ) . '</strong><span>' . preg_replace( '/(\d+)/', '<b>$1</b>', $stock ) . $icon . '</span></div>' : '';
		echo $tags ? '<div class="codevz-pm-tags clr"><strong>' . esc_html__( 'Tags', 'codevz' ) . '</strong><span>' . $tags . '</span></div>' : '';
		echo $cats ? '<div class="codevz-pm-cats clr"><strong>' . esc_html__( 'Categories', 'codevz' ) . '</strong><span>' . $cats . '</span></div>' : '';

		echo '</div>';

	}

	/**
	 * Add custom content after product meta for all products.
	 * 
	 * @return string
	 */
	public function content_after_product_meta() {

		if ( Codevz_Plus::option( 'woo_after_product_meta' ) && ! Codevz_Plus::$is_free ) {

			echo '<div class="codevz-custom-product-meta">';

			if ( Codevz_Plus::$preview ) {
				echo '<i class="codevz-section-focus fas fa-cog" data-section="product"></i>';
			}

			echo do_shortcode( Codevz_Plus::option( 'woo_after_product_meta' ) );

			echo '</div>';

		}


	}

	/**
	 * Hook to add custom option field to product attribute settings
	 * 
	 * @return string
	 */
	public function attribute_add_fields() {

		$id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
		$value = get_option( 'codevz_pa_' . $id );

		$types = [
			'select' 	=> esc_html__( 'Dropdown', 'codevz' ),
			'button' 	=> esc_html__( 'Button', 'codevz' ),
			'thumbnail' => esc_html__( 'Thumbnail', 'codevz' ),
			'color' 	=> esc_html__( 'Color', 'codevz' ),
		];

		echo '<' . ( $id ? 'tr' : 'div' ) . ' class="form-field" style="position: relative">';
		echo '<th scope="row" valign="top">';
		echo '<label for="my-field">' . esc_html__( 'Attribute swatch type', 'codevz' ) . '</label>';
		echo '</th><td>';

		if ( Codevz_Plus::is_free() ) {

			echo Codevz_Plus::pro_badge();

		} else {

			echo '<select name="codevz_pa" id="codevz_pa">';

			foreach ( $types as $key => $title ) {
				echo '<option value="' . $key . '"' . ( $value === $key ? ' selected' : '' ) . '>' . $title . '</option>';
			}

			echo '</select>';

		}

		echo '<p class="description">' . esc_html__( "Default output for product attributes' variations in HTML: dropdowns or swatches.", 'codevz' ) . '</p>';

		echo '</td></' . ( $id ? 'tr' : 'div' ) . '>';

	}

	/**
	 * Save option value when adding/editing product attribute term.
	 * 
	 * @return -
	 */
	public function attribute_added_updated( $id ) {

		if ( isset( $_POST[ 'codevz_pa' ] ) ) {

			update_option( 'codevz_pa_' . $id, sanitize_text_field( $_POST[ 'codevz_pa' ] ) );

		}

	}

	/**
	 * Add color picker to attribute taxonomy configuration.
	 * 
	 * @return string
	 */
	public function add_variation_colorpicker( $term ) {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="codevz_attribute_color"><?php esc_html_e( 'Attribute Color', 'codevz' ); ?></label>
				</th>
				<td>
					<input type="text" class="codevz-color-picker" name="codevz_attribute_color" id="codevz_attribute_color" value="<?php echo esc_attr( empty( $term->term_id ) ? '' : get_term_meta( $term->term_id, 'codevz_attribute_color', true ) ); ?>" />
					<p class="description"><?php esc_html_e( 'Select a color for this attribute.', 'codevz' ); ?></p>
				</td>
			</tr>
			<script type="text/javascript">
				jQuery( function( $ ) {
					$( '.codevz-color-picker' ).wpColorPicker();
				});
			</script>
		<?php

	}

	/**
	 * Save custom color field value when adding product attribute term
	 * 
	 * @return string
	 */
	public function save_variation_colorpicker( $term_id, $tt_id, $taxonomy ) {

		if ( isset( $_POST['codevz_attribute_color'] ) ) {
			update_term_meta( $term_id, 'codevz_attribute_color', sanitize_hex_color( $_POST['codevz_attribute_color'] ) );
		}

	}

	/**
	 * Add custom column to the term list table e.g. 'pa_color'
	 * 
	 * @return array
	 */
	public function add_variation_color_column( $columns ) {

		// Create an array of columns to add
		$new_columns = array(
			'codevz_attribute_color' => esc_html__( 'Color', 'codevz' ),
		);

		// Split the columns array into two parts
		$first_columns = array_slice( $columns, 0, 1 ); // Get the first column
		$last_columns = array_slice( $columns, 1 ); // Get the rest of the columns

		// Merge the new column after the first position
		$columns = array_merge( $first_columns, $new_columns, $last_columns );

		return $columns;

	}

	/**
	 * Display content for the custom column in pa_* taxonomy.
	 * 
	 * @return array
	 */
	public function show_variation_color_column( $content, $column_name, $term_id ) {

		if ( 'codevz_attribute_color' === $column_name ) {
			$custom_color = get_term_meta( $term_id, 'codevz_attribute_color', true );
			$content .= '<div style="border-radius:100px;width: 20px; height: 20px;border-radius: 100px; margin: 1px auto 0; background-color: ' . esc_attr( $custom_color ) . '"></div>';
		}

		return $content;

	}

	/**
	 * Modify variations output HTML and add swatches like color, thumbnail and button type.
	 * 
	 * @return array
	 */
	public function variations_output( $html, $args ) {

		global $product;

		// Attribute type.
		$type = get_option( 'codevz_pa_' . wc_attribute_taxonomy_id_by_name( $args[ 'attribute' ] ) );

		// Default variation selected for product.
		$default = $product->get_default_attributes();

		// Get all product variations.
		$variations = $product->get_available_variations();

		ob_start();

		echo '<div class="codevz-variations codevz-variations-' . esc_attr( $type ) . '">';

		// Get terms.
		$terms = wc_get_product_terms(
			$product->get_id(),
			$args[ 'attribute' ],
			array(
				'fields' => 'all',
			)
		);

		if ( $type === 'color' ) {

			foreach( $terms as $term ) {

				$selected = ( isset( $default[ $args[ 'attribute' ] ] ) && $default[ $args[ 'attribute' ] ] === $term->slug ) ? ' checked="checked"' : '';

				echo '<input type="radio" id="codevz_' . $term->term_id . '" name="attribute_' . $args[ 'attribute' ] . '" value="' . $term->slug . '"' . $selected . ' />';
				echo '<label title="' . $term->name . '" for="codevz_' . $term->term_id . '" style="background-color:' . get_term_meta( $term->term_id, 'codevz_attribute_color', true ) . '">' . $term->name . '</label>';

			}

		} else if ( $type === 'button' ) {

			foreach( $terms as $term ) {

				$selected = ( isset( $default[ $args[ 'attribute' ] ] ) && $default[ $args[ 'attribute' ] ] === $term->slug ) ? 'checked="checked"' : '';

				echo '<input type="radio" id="codevz_' . $term->term_id . '" name="attribute_' . $args[ 'attribute' ] . '" value="' . $term->slug . '"' . $selected . ' />';
				echo '<label for="codevz_' . $term->term_id . '">' . $term->name . '</label>';

			}

		} else if ( $type === 'thumbnail' ) {

			foreach( $terms as $term ) {

				foreach( $variations as $key => $variation ) {

					if ( isset( $variation[ 'attributes' ][ 'attribute_' . $args[ 'attribute' ] ] ) && $variation[ 'attributes' ][ 'attribute_' . $args[ 'attribute' ] ] === $term->slug ) {

						if ( ! empty( $variation[ 'image' ][ 'url' ] ) ) {

							$image = $variation[ 'image' ][ 'url' ];

							break;

						}

					}

				}

				$selected = ( isset( $default[ $args[ 'attribute' ] ] ) && $default[ $args[ 'attribute' ] ] === $term->slug ) ? 'checked="checked"' : '';

				echo '<input type="radio" id="codevz_' . $term->term_id . '" name="attribute_' . $args[ 'attribute' ] . '" value="' . $term->slug . '"' . $selected . ' />';
				echo '<label for="codevz_' . $term->term_id . '"><img src="' . ( isset( $image ) ? $image : '' ) . '" alt="thumbnail" /></label>';

				$image = '';

			}

		}

		echo $html;

		echo '</div>';

		$html = ob_get_clean();

		return $html;

	}

	/**
	 * Display cart page related products according to cart items.
	 * 
	 * @return string
	 */
	public function cart_related_products() {

		echo '</div>'; // Close cart total div.

		$cart = wc()->cart->get_cart();

		$linked_producs = false;

		// Find linked products.
		foreach( $cart as $cart_item_key => $cart_item ) {

			$linked_producs = empty( get_post_meta( $cart_item['product_id'], '_crosssell_ids', true ) ) ? false : true;

		}

		// Check and find related.
		if ( ! $linked_producs ) {

			$related = array_reduce( $cart, function( $result, $cart_item ) {
				return array_merge( $result, wc_get_related_products( $cart_item[ 'product_id' ] ) );
			}, [] );

			$related = array_slice( array_diff( array_unique( $related ), array_column( $cart, 'product_id' ) ), 0, 2 );

			if ( ! empty( $related ) ) {

				echo '<div class="codevz-cart-ralated related products"><h2>' . esc_html__( 'You may be interested in ...', 'codevz' ) . '</h2>';
				echo do_shortcode( '[products ids="' . implode( ',', $related ) . '" columns="2"]' );
				echo '</div>';

			}

		}

	}

	/**
	 * Display cart page interested products when cart is empty.
	 * 
	 * @return string
	 */
	public function cart_empty_products_section() {

		$products = wc_get_products( [ 'limit' => 4, 'orderby' => 'rand' ] );

		if ( ! empty( $products ) ) {

			$ids = [];

			foreach( $products as $product ) {
				$ids[] = $product->get_id();
			}

			echo '<div class="related products mt50"><h2>' . esc_html__( 'You may be interested in ...', 'codevz' ) . '</h2>';
			echo do_shortcode( '[products ids="' . implode( ',', $ids ) . '" columns="4"]' );
			echo '</div>';

		}

	}

	/**
	 * Show 3 steps above on cart, checkout and order completion pages
	 * 
	 * @return string
	 */
	public function cart_checkout_steps() {

		$steps = [
			[
				'name' => esc_html__( 'Shopping Cart', 'codevz' ),
				'link' => wc_get_cart_url()
			],
			[
				'name' => esc_html__( 'Checkout Details', 'codevz' ),
				'link' => wc_get_checkout_url()
			],
			[
				'name' => esc_html__( 'Order Complete', 'codevz' ),
				'link' => '#'
			]
		];

		echo '<div class="codevz-cart-checkout-steps' . ( Codevz_Plus::option( 'woo_cart_checkout_steps' ) === 'vertical' ? ' codevz-cart-checkout-steps-col' : '' ) . '">';

		foreach( $steps as $index => $step ) {

			$active_class = ( is_cart() && ! $index ) || ( is_checkout() && $index === 1 ) || ( is_order_received_page() && $index === 2 ) ? 'codevz-current-step' : '';

			echo '<a href="' . esc_url( $step['link'] ) . '" class="' . $active_class . '"><span>' . ( $index + 1 ) . '</span><strong>' . $step['name'] . '</strong></a>';
			echo $index !== 2 ? '<i class="fa czico-Icon-Navigation-Arrow-Right" aria-hidden="true"></i>' : '';

		}

		echo '</div>';

	}

	// Avatar above the account nav.
	public function my_account_avatar() {

		$user = wp_get_current_user();

		echo '<div class="codevz-account-avatar">';
		echo '<img src="' . esc_url( get_avatar_url( $user->ID, [ 'size' => 150 ] ) ) . '">';
		echo '<strong>' . esc_html( ucwords( $user->first_name . ' ' . $user->last_name ) ) . '</strong>';
		echo '<span>' . esc_html( $user->user_email ) . '</span>';
		echo '</div>';

		echo "<script>document.addEventListener( 'DOMContentLoaded', function() {document.querySelector('.woocommerce-MyAccount-navigation').prepend(document.querySelector('.codevz-account-avatar'));});</script>";

	}

	// Fix new links in my account nav.
	public function my_account_endpoints() {

		add_rewrite_endpoint( 'tracking', EP_PAGES );
		add_rewrite_endpoint( 'wishlist', EP_PAGES );
		add_rewrite_endpoint( 'viewed',   EP_PAGES );
		add_rewrite_endpoint( 'reviews',  EP_PAGES );

		flush_rewrite_rules();

	}

	// Add a new menus to my account page.
	public function my_account_menus( $items ) {

		$menus = [
			'tracking' 	=> esc_html__( 'Tracking orders', 'codevz' ),
			'wishlist' 	=> esc_html__( 'Wishlist', 'codevz' ),
			'viewed' 	=> esc_html__( 'Recently Viewed', 'codevz' ),
			'reviews' 	=> esc_html__( 'Reviews', 'codevz' ),
		];

		return array_slice( $items, 0, 2, true ) + $menus + array_slice( $items, 2, null, true );

	}

	// My account wishlist tab content.
	public function my_account_wishlist() {

		echo '<div class="codevz-my-account-wishlist">';
		echo '<h3 class="section_title">' . esc_html__( 'Wishlist', 'codevz' ) . '</h3><br />';
		echo '<div class="woocommerce xtra-wishlist xtra-icon-loading" data-col="2" data-empty="' . esc_html__( 'Your wishlist list is empty.', 'codevz' ) . '" data-nonce="' . wp_create_nonce( 'xtra_wishlist_content' ) . '"></div>';
		echo '</div>';

	}

	// My account recently viewed tab content.
	public function my_account_viewed() {

		$product_id = get_the_ID();

		// Get recently viewed products from cookie.
		$rvp = isset( $_COOKIE[ 'codevz_rvp' ] ) ? json_decode( wp_unslash( $_COOKIE[ 'codevz_rvp' ] ), true ) : null;

		if ( is_array( $rvp ) ) {

			// Remove product ID if already exists
			$key = array_search( $product_id, $rvp );
			if ( $key !== false ) {
				unset( $rvp[ $key ] );
			}

			// Add new product ID to the beginning
			array_unshift( $rvp, $product_id );

			// Keep only unique product IDs and limit to 5
			$rvp = array_slice( array_unique( $rvp ), 0, 20 );

			// Show products.
			if ( ! empty( $rvp ) ) {

				echo '<div class="codevz-recently-viewed-products">';
				echo '<h3 class="section_title">' . esc_html__( 'Recently viewed products', 'codevz' ) . '</h3>';
				echo do_shortcode( '[products ids="' . implode( ',', $rvp ) . '" columns="2"]' );
				echo '</div>';

			}

		} else {
			echo '<h3 class="section_title">' . esc_html__( 'Recently viewed products', 'codevz' ) . '</h3>';
			echo 'No products found here. Please explore some products.';
		}

	}

	// My account reviews tab content.
	public function my_account_reviews() {
		$user_id = get_current_user_id();
		$reviews = get_comments(array(
			'user_id' => $user_id,
			'status' => 'approve',
			'post_type' => 'product',
		));

		echo '<h3 class="section_title">Your rating and reviews</h3>';

		if ( $reviews ) {

			foreach( $reviews as $review ) {

				echo '<div class="codevz-my-account-reviews">';

				$product = wc_get_product( $review->comment_post_ID );

				echo '<div class="codevz-my-account-reviews-title">';
				echo $product->get_image();
				echo '<span><strong>' . esc_html( $product->get_name() ) . '</strong><span>' . esc_html( $review->comment_date ) . '</span></span></div>';

				echo '<div>';
				echo wc_get_rating_html( get_comment_meta( $review->comment_ID, 'rating', true ) );
				echo '<p>' . esc_html( $review->comment_content ) . '</p>';
				echo '</div>';

				echo '</div>';

			}

		} else {
			echo "<p>You haven't submitted any reviews yet. Please visit the product pages of your orders to share your feedback.</p>";
		}
	}

	// My account order tracking tab content.
	public function my_account_tracking() { ?>

		<div class="codevz-order-tracking-form">
			<h3 class="section_title"><?php esc_html_e( 'Tracking order', 'codevz' ); ?></h3>
			<form action="" method="post">
				<p>
					<label for="order_id"><?php esc_html_e( 'Order ID:', 'codevz' ); ?></label>
					<input type="text" name="order_id" id="order_id" required>
				</p>
				<p>
					<label for="customer_email"><?php esc_html_e( 'Your email:', 'codevz' ); ?></label>
					<input type="email" name="customer_email" id="customer_email" required>
				</p>
				<input type="submit" value="<?php esc_html_e( 'Track order', 'codevz' ); ?>">
			</form>
		</div>

		<?php

		// Display order tracking results
		if ( isset( $_POST['order_id'] ) && isset( $_POST['customer_email'] ) ) {

			// Check if wc_get_order function is available
			$order = wc_get_order( intval( $_POST['order_id'] ) );

			if ( $order && $order->get_billing_email() === sanitize_email( $_POST['customer_email'] ) ) {

				echo '<div class="codevz-order-tracking related products mt50">';

				// Display order status as steps
				$order_status = $order->get_status();

				echo '<h2>' . esc_html__( 'Tracking info of order #', 'codevz' ) . $order->get_order_number() . '</h2>';
				echo '<table>';

				echo '<thead><tr><th>' . esc_html__( 'Order number', 'codevz' ) . '</th><th>' . $order->get_order_number() . '</th></tr></thead>';

				echo '<tr><th>' . esc_html__( 'Order date', 'codevz' ) . '</th><td>' . wc_format_datetime($order->get_date_created()) . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Order status', 'codevz' ) . '</th><td>' . wc_get_order_status_name($order_status) . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Last update', 'codevz' ) . '</th><td>' . wc_format_datetime($order->get_date_modified()) . '</td></tr>';

				// Products List
				$items = $order->get_items();
				echo '<tr><th>' . esc_html__( 'Product(s)', 'codevz' ) . '</th><td>';
				foreach( $items as $item ) {
					echo '<strong>' . $item->get_name() . '</strong> x ' . $item->get_quantity() . ' = ' . wc_price( $item->get_subtotal() ) . '<br />';
				}
				echo '</td></tr>';

				echo '<tr><th>' . esc_html__( 'Total amount', 'codevz' ) . '</th><td>' . wc_price($order->get_total()) . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Name', 'codevz' ) . '</th><td>' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Phone', 'codevz' ) . '</th><td>' . $order->get_billing_phone() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Email', 'codevz' ) . '</th><td>' . $order->get_billing_email() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Address', 'codevz' ) . '</th><td>' . $order->get_formatted_billing_address() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Order note', 'codevz' ) . '</th><td>' . $order->get_customer_note() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Delivery method', 'codevz' ) . '</th><td>' . $order->get_shipping_method() . '</td></tr>';
				echo '<tr><th>' . esc_html__( 'Payment method', 'codevz' ) . '</th><td>' . $order->get_payment_method_title() . '</td></tr>';

				echo '</table>';
			} else {
				echo '<strong class="mt50" style="display:block;color:red">' . esc_html__( 'Invalid Order ID or Email. Please try again.', 'codevz' ) . '</strong>';
			}

			echo '</div>';

		}

	}

	// Fix my account login form container div.
	public static function before_my_account_form() {
		echo '<div class="codevz-woo-login-form">';
	}

	// Fix my account login form container div.
	public static function after_my_account_form() {
		echo '</div>';
	}

	// Modify products title and add category name under it.
	public function category_under_title( $title, $post_id ) {

		$post = get_post( $post_id );

		if ( $post && $post->post_type === 'product' && $post_id !== $this->singular_product_id ) {

			// Get product categories
			$categories = get_the_terms( $post_id, 'product_cat' );

			// Check if there are categories and get the first one
			if ( $categories && ! is_wp_error( $categories ) ) {

				$category = array_shift( $categories );

				$title .= '<span class="codevz-product-category-after-title">' . $category->name . '</span>';

			}

		}

		return $title;

	}

	// Product gallery navigation arrows.
	public function woo_flexslider_options( $options ) {

		$options['directionNav'] = true;

		return $options;

	}

	// Add brand logo to taxonomy page.
	public function brand_logo_term_description( $description, $term ) {

		// Logo for brand page.
		if ( is_tax( 'codevz_brands' ) ) {

			$logo = get_term_meta( $term->term_id, 'codevz_brands', true );
			$logo = empty( $logo[ 'brand_logo' ] ) ? '' : wp_get_attachment_image( $logo[ 'brand_logo' ], 'full' );
			$logo = do_shortcode( $logo ? '<div class="codevz-product-brands">' . $logo . '</div>' : '' );

			$description = $logo . $description;

		}

		// Add category cover to cat page.
		if ( is_tax( 'product_cat' ) ) {

			$cover = get_term_meta( $term->term_id, 'thumbnail_id', true );

			if ( $cover ) {
				$description = '<div class="codevz-product-brands">' . wp_get_attachment_image( $cover, 'full' ) . '</div>' . $description;
			}

		}

		return $description;

	}

	// Add short description under product rating on shop archive pages
	public function products_short_desc() {

		if ( Codevz_Plus::option( 'woo_products_short_desc' ) ) {

			global $product;

			$desc = $product->get_short_description();

			if ( $desc ) {

				echo '<div class="codevz-product-short-desc">';
				echo wp_kses_post( mb_strimwidth( $desc, 0, 90, '...' ) );
				echo '</div>';

			}

		}

	}

}

Codevz_Plus_Woocommerce::instance();