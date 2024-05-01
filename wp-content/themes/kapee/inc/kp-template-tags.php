<?php
/**
 * Custom template tags for this theme
 *
 * @author 		PressLayouts
 * @package 	kapee/inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Display page title on header.
 */
if ( ! function_exists( 'kapee_get_page_title' ) ) :
	function kapee_get_page_title() {		
		global $wp_query;
		$output = '';

		if ( is_singular() ) {
			
			$post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
			$page_title = '';
			if ( is_page() && kapee_get_option( 'parent-page-title', 0 ) ) {
				$page_title = empty($post->post_parent) ? '' : get_the_title($post->post_parent);
			} else if (!is_page() && kapee_get_option( 'archives-page-title', 0 ) ) {
				if ( isset( $post->post_type ) && $post->post_type == 'post' && kapee_get_option( 'archives-page-title', 0 ) ) {
					if (get_option( 'show_on_front' ) == 'page') {
						$page_title = get_the_title( get_option('page_for_posts', true) );
					} else {
						$page_title = kapee_page_title_archive($post->post_type);
					}
				} else if ( isset( $post->post_type ) && $post->post_type == 'product' && kapee_get_option( 'archives-page-title', 0 ) ) {
					$post_type = 'product';
					$post_type_object = get_post_type_object( $post_type );
					if ( is_object( $post_type_object ) && function_exists( 'wc_get_page_id' ) ) {
						$shop_page_id = wc_get_page_id( 'shop' );
						$page_title  = $shop_page_id ? get_the_title( $shop_page_id ) : '';
						if ( !$page_title  ) {
							$page_title  = $post_type_object->labels->name;
						}else{
							$page_title .= ' - ' . get_the_title();
						}
					}
				} else {
					$page_title = kapee_page_title_archive($post->post_type);
					$page_title .= ' - ' . get_the_title();
				}
			}

			if ( $page_title ) {
				$output.= $page_title;
			} else {
				$single_post_title = kapee_get_option( 'single-post-title-text', 'Our Blog' );
				$custom_page_title 				= kapee_get_post_meta('custom_page_title');
				if(!empty($custom_page_title )){
					$output .= $custom_page_title ;
				}elseif(!empty($single_post_title) && is_singular('post')){
					$output .= kapee_get_option( 'single-post-title-text', 'Our Blog' );
				}else{
					$output .= get_the_title( $post->ID );
				}
				
			}
		} else {
			
			if ( is_post_type_archive() ) {
				
				if ( is_search() ) {
					$output .= sprintf( esc_html__( 'Search Results: %s', 'kapee' ), esc_html( get_search_query() ) );
				} else {
					$output .= kapee_page_title_archive();
				}
			} elseif ( (is_tax() || is_tag() || is_category()) &&  kapee_get_option( 'blog-page-title', 1 ) ) { 
				$term = $wp_query->get_queried_object();
				$html = $title = $term->name;

				if ( is_tag() ) {
					$output .= sprintf( __( 'Tag Archives: %s', 'kapee' ), $html );
				} elseif ( is_tax('product_tag') ) {
					$output .= sprintf( __( 'Product Tag: %s', 'kapee' ), $html );
				} else {
					$output .= $html;
				}
			} elseif ( is_date() &&  kapee_get_option( 'blog-page-title', 1 ) ) {
				if ( is_year() ) {
					$output .= sprintf( esc_html__( 'Yearly Archives: %s', 'kapee' ), get_the_date( _x( 'Y', 'yearly archives date format', 'kapee' ) ) );
				} elseif ( is_month() ) {
					$output .= sprintf( esc_html__( 'Monthly Archives: %s', 'kapee' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'kapee' ) ) );
				} elseif ( is_day() ) {
					$output .= sprintf( esc_html__( 'Daily Archives: %s', 'kapee' ), get_the_date() );
				}else{
					$output .= esc_html__( 'Archives', 'kapee' );
				}
			} elseif ( is_author() &&  kapee_get_option( 'blog-page-title', 1 ) ) {
				$user 	= $wp_query->get_queried_object();
				$output .= sprintf( esc_html__( 'Author Archives: %s', 'kapee' ), $user->display_name );
			} elseif ( is_search() ) {
				$output .= sprintf( esc_html__( 'Search Results: %s', 'kapee' ), esc_html( get_search_query() ) );
			} elseif ( is_404() ) {
				$output .= esc_html__( 'Error 404', 'kapee' );
			}else {				
				if ( is_home() && !is_front_page() ) {
					if( kapee_get_option( 'blog-page-title', 1 ) && !empty( trim( kapee_get_option( 'blog-page-title-text', 'Blog' ) ) ) ){
						$output .= kapee_get_option( 'blog-page-title-text', 'Blog' );
					}elseif( get_option( 'show_on_front' ) == 'page'  && kapee_get_option( 'blog-page-title', 1 ) ){
						$output .= get_the_title( get_option('page_for_posts', true) );
					}
				}else{
					if( kapee_get_option( 'blog-page-title', 1 ) ){
						$output .= kapee_get_option( 'blog-page-title-text', 'Blog' );
					}
				}
			}
		}

		return apply_filters( 'kapee_get_page_title', $output );
	}
endif;

function kapee_page_title_shop() {
    $post_type = 'product';
    $post_type_object = get_post_type_object( $post_type );

    $output = '';
    if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        $shop_page_name = $shop_page_id ? get_the_title( $shop_page_id ) : '';

        if ( ! $shop_page_name ) {
            $shop_page_name = $post_type_object->labels->name;
        }
        $output .= $shop_page_name;
    }

    return $output;
}

function kapee_page_title_archive( $post_type = null ) {
    global $wp_query;

    if (!$post_type)
        $post_type = $wp_query->query_vars['post_type'];
    $post_type_object = get_post_type_object( $post_type );
    $archive_title = '';

    if ( is_object( $post_type_object ) ) {

        // woocommerce
        if ( $post_type == 'product' && $shop_title = kapee_page_title_shop() ) {
            return $shop_title;
        }
		
        // default
        $archive_title = kapee_title_archive_name( $post_type );
    }

    return $archive_title;
}

function kapee_title_archive_name( $post_type = null ) {
    global $wp_query;

    if (!$post_type)
        $post_type = $wp_query->query_vars['post_type'];

    $page_id = 0;
    switch ($post_type) {
        case 'post':
            if (get_option( 'show_on_front' ) == 'page') {
                $page_id = (int) (get_option('page_for_posts', true));
            }
            break;
        case 'portfolio':
            $page_id = (int) esc_attr( kapee_get_option('portfolio-archive-page', null ) );
            break;
    }

    $archive_title = '';

    if ($page_id && ($post = get_post( $page_id ) )) {
        $archive_title = $post->post_title;
    } elseif($post_type == 'portfolio'){
		$archive_title = kapee_get_option('portfolio-page-title-text', 'Portfolio' );
	}else {
        $post_type_object = get_post_type_object( $post_type );

        if ( is_object( $post_type_object ) ) {

            if ( isset( $post_type_object->label ) && $post_type_object->label !== '' ) {
                $archive_title = $post_type_object->label;
            } elseif ( isset( $post_type_object->labels->menu_name ) && $post_type_object->labels->menu_name !== '' ) {
                $archive_title = $post_type_object->labels->menu_name;
            } else {
                $archive_title = $post_type_object->name;
            }
        }
    }
	
    return $archive_title;
}


/**
 * Return image files
 */
if ( ! function_exists( 'kapee_get_post_image' ) ) :
	
	function kapee_get_post_image($size ='large', $post_id = '') {
		$prefix = KAPEE_PREFIX;
		$image = '';
		$post_id = $post_id ? $post_id : get_the_ID();
		
		if ( $meta = get_post_meta( $post_id, $prefix.'post_format_image', true ) ) { 
			$image = $meta;
		}
		
		if(wp_get_attachment_url( $image )){
			$image = wp_get_attachment_image( $image, 'large' );
		}
		return $image;
	}
endif;

/**
 * Return video files
 */
if ( ! function_exists( 'kapee_get_post_video' ) ) {
	
	function kapee_get_post_video($post_id = '') {
		
		$prefix = KAPEE_PREFIX;
		$video = '';
		$post_id = $post_id ? $post_id : get_the_ID();
		
		if ( $meta = get_post_meta( $post_id, $prefix.'post_format_video', true ) ) { 
			$video = $meta;
		}
		
		if ( ! is_wp_error( $oembed = wp_oembed_get( $video ) ) && $oembed ) {
			return '<div class="responsive-video-wrap">'. $oembed .'</div>';
		}else {
			$video = apply_filters( 'the_content', $video );
			if ( strpos( $video, 'youtube' ) || strpos( $video, 'vimeo' ) ) {
				return '<div class="responsive-video-wrap">'. $video .'</div>';
			}else {
				return $video;
			}
		}		
	}
}
/**
 * Return audio files
 */
if ( ! function_exists( 'kapee_get_post_audio' ) ) {
	
	function kapee_get_post_audio($post_id = '') {
		$prefix = KAPEE_PREFIX;
		$audio = '';
		$post_id = $post_id ? $post_id : get_the_ID();
		
		if ( $meta = get_post_meta( $post_id, $prefix.'post_format_audio', true ) ) { 
			$audio = $meta;
		}
		$audio = apply_filters( 'the_content', $audio );
		return $audio;
		
	}
}

/**
 * Function to get post view count
 */
if ( ! function_exists( 'kapee_post_views' ) ) :
	function kapee_post_views($post_id = 0){
		
		$prefix = KAPEE_PREFIX;		
		global $post;
		$post_id = $post->ID;		
		$views = get_post_meta( $post_id, $prefix.'views_count', true );
		
		if(empty($views)){
			$views = 0;
		}
		$views_rounded = kapee_get_round_number($views);
		
		$post_view_tag = '%s<span class="post-meta-label"> %s</span>';
		$output = sprintf('<span class="post-view">%s</span>',
			sprintf( 
				_n(
					sprintf( $post_view_tag, '%s', esc_html__( 'View', 'kapee' ) ),
					sprintf( $post_view_tag, '%s', esc_html__( 'Views', 'kapee' ) ),
				$views ), 
				$views_rounded
			)
		);		
		echo apply_filters( 'kapee_post_views', $output);
	}
endif;

/**
 * Calculate Post Reading Time in Minutes
 */
if ( ! function_exists( 'kapee_calculate_post_reading_time' ) ) {
	function kapee_calculate_post_reading_time( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$post_content = get_post_field( 'post_content', $post_id );
		$strip_shortcodes = strip_shortcodes( $post_content );
		$strip_tags = strip_tags( $strip_shortcodes );
		$locale = kapee_get_locale();
		if ( 'ru_RU' === $locale ) {
			$word_count = count( preg_split( '/\s+/', $strip_tags ) );
		} else {
			$word_count = str_word_count( $strip_tags );
		}
		$reading_time = intval( ceil( $word_count / 250 ) );
		return $reading_time;
	}
}

/**
 * Update Post Reading Time on Post Save
 */
function kapee_update_post_reading_time( $post_id, $post, $update ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$reading_time = kapee_calculate_post_reading_time( $post_id );
	update_post_meta( $post_id, '_kp_reading_time', $reading_time );
}

add_action( 'save_post', 'kapee_update_post_reading_time', 10, 3 );

/**
 * Get Post Reading Time from Post Meta
 */
function kapee_get_post_reading_time( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$prefix = KAPEE_PREFIX;
	// Get existing post meta.
	$reading_time = get_post_meta( $post_id, $prefix.'reading_time', true );
	// Calculate and save reading time, if there's no existing post meta.
	if ( ! $reading_time ) {
		$reading_time = kapee_calculate_post_reading_time( $post_id );
		update_post_meta( $post_id, $prefix.'reading_time', $reading_time );
	}
	return $reading_time;
}

if(! function_exists( 'kapee_social_share_enable' )){
	function kapee_social_share_enable(){
		if(kapee_get_option('show-social-sharing', 1) || kapee_get_option('show-social-profile', 1)){
			return true;
		}
		return false;
	}
}

/**
 * Portfolio meta
 */
if ( ! function_exists( 'kapee_portfolio_meta' ) ) :
	function kapee_portfolio_meta( $output_filter = '' ) {
		
		$meta_values = kapee_get_option( 'specific-portfolio-meta', array( 'categories', 'skills') );
		
		if( ! kapee_get_option('portfolio-meta',1) || empty($meta_values) ) return;

		ob_start();
		?>
		
		<div class="entry-meta">
		
			<?php do_action('kapee_portfolio_meta_top');?>
			
			<?php
			global $post;
			$post_id =  $post->ID;
			foreach ( $meta_values as $meta_value ) {

				switch ( $meta_value ) {
					case 'categories':
						echo kapee_get_category_list($post_id,'portfolio-cat'); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						break;
					case 'skills':
						echo kapee_get_category_list($post_id,'portfolio-skill'); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						break;
					default:
					
				}
			}
			?>
			
			<?php do_action('kapee_portfolio_meta_bottom');?>
			
		</div>
		
		<?php 		
		echo apply_filters('kapee_portfolio_meta', ob_get_clean(), $output_filter );
	}
endif;

/**
 * Function to get Author of Post
 */
if ( ! function_exists( 'kapee_portfolio_author' ) ) :

	function kapee_portfolio_author( $output_filter = '' ) {
		
		$output = sprintf(
			'<span class="author-link vcard">%1$s <a class="url fn n" href="%2$s">%3$s</a></span>',
			esc_html__('By', 'kapee'),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);		
		
		echo apply_filters( 'kapee_portfolio_author', $output, $output_filter );
	}
endif;

/**
 * Wrapper function for get_the_title() for blog post.
 */
if ( ! function_exists( 'kapee_the_post_title' ) ) {
	function kapee_the_post_title( $before = '', $after = '', $post_id = 0, $echo = true ) {
		$enabled = apply_filters( 'kapee_the_post_title_enabled', true );
		if ( $enabled ) {
			$title  = kapee_get_the_title( $post_id );
			$before = apply_filters( 'kapee_the_post_title_before', $before ); // WPCS: XSS OK.
			$after  = apply_filters( 'kapee_the_post_title_after', $after ); // WPCS: XSS OK.
			if ( $echo ) {
				echo apply_filters( 'kapee_the_post_title', $before . $title . $after ); // WPCS: XSS OK.
			} else {
				return apply_filters( 'kapee_the_post_title', $before . $title . $after ); // WPCS: XSS OK.
			}
		}
	}
}

/**
 * Wrapper function for get_the_title()
 */
if ( ! function_exists( 'kapee_get_the_title' ) ) {
	
	function kapee_get_the_title( $post_id = 0, $echo = false ) {

		$title = '';
		if ( $post_id || is_singular() ) {
			$title = get_the_title( $post_id );
		} else {
			if ( is_front_page() && is_home() ) {
				// Default homepage.
				$title = apply_filters( 'kapee_the_default_home_page_title', esc_html__( 'Home', 'kapee' ) );
			} elseif ( is_home() ) {
				// blog page.
				$title = apply_filters( 'kapee_the_blog_home_page_title', get_the_title( get_option( 'page_for_posts', true ) ) );
			} elseif ( is_404() ) {
				// for 404 page - title always display.
				$title = apply_filters( 'kapee_the_404_page_title', esc_html__( 'This page doesn\'t seem to exist.', 'kapee' ) );

				// for search page - title always display.
			} elseif ( is_search() ) {

				/* translators: 1: search string */
				$title = apply_filters( 'kapee_the_search_page_title', sprintf( __( 'Search Results for: %s', 'kapee' ), '<span>' . get_search_query() . '</span>' ) );

			} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {

				$title = woocommerce_page_title();

			} elseif ( is_archive() ) {

				$title = get_the_archive_title();
			}
		}

		// This will work same as `get_the_title` function but with Custom Title if exits.
		if ( $echo ) {
			echo apply_filters( 'kapee_the_title', $title ); // WPCS: XSS OK.
		} else {
			return apply_filters( 'kapee_the_title', $title ); // WPCS: XSS OK.
		}
	}
}