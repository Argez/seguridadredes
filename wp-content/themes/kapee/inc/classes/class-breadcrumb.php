<?php 
if( ! class_exists( 'Kapee_Breadcrumb' )) {
	class Kapee_Breadcrumb{
		/**
		 * Breadcrumb trail.
		 *
		 * @var array
		 */
		private $crumbs = array();

		/**
		 * Add a crumb so we don't get lost.
		 *
		 * @param string $name Name.
		 * @param string $link Link.
		 */
		public function add_crumb( $name, $link = '' ) {
			
			$name = !is_array($name) ? strip_tags( $name ) : $name;
			$this->crumbs[] = array(
				$name,
				$link,
			);
		}

		/**
		 * Reset crumbs.
		 */
		public function reset() {
			$this->crumbs = array();
		}
		
		/**
		 * Get the breadcrumb.
		 *
		 * @return array
		 */
		public function get_breadcrumb() {
			return apply_filters( 'kapee_get_breadcrumb', $this->crumbs, $this );
		}
		
		/**
		 * Generate breadcrumb trail.
		 *
		 * @return array of breadcrumbs
		 */
		public function generate() {
			global $post;
			$breadcrumbs_archives_link = true;
			$blog_link = true;
			
			if ( ! is_front_page() ) {
				$this->add_crumb(esc_html__('Home', 'kapee'),home_url( '/' ));
			} elseif ( is_home() ) {
				$this->add_crumbs_home();
			}
			
			// add woocommerce shop page link
			if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && ! is_shop() ) || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
				
				$this->add_crumbs_shop_link();
			}
			
			// add bbpress forums link
			if ( class_exists( 'bbPress' ) && is_bbpress() && ( bbp_is_topic_archive() || bbp_is_single_user() || bbp_is_search() || bbp_is_topic_tag()  || bbp_is_edit() ) ) {
				$this->add_crumb(bbp_get_forum_archive_title(),get_post_type_archive_link( 'forum' ));				
			}
			
			if ( is_singular() ) {
				if ( isset( $post->post_type ) && $post->post_type !== 'product' && get_post_type_archive_link( $post->post_type ) && $breadcrumbs_archives_link) {
					$this->add_crumbs_archive_link();
				} elseif ( isset( $post->post_type ) && $post->post_type == 'post' && get_option( 'show_on_front' ) == 'page' && $blog_link) {
					$this->add_crumb(get_the_title( get_option('page_for_posts', true) ),get_permalink( get_option('page_for_posts' ) ));
				}
			
				if ( isset( $post->post_parent ) && $post->post_parent == 0 ) {
					
					$this->add_crumbs_terms_link();
				} else {
					
					$this->add_crumbs_ancestors_link();
				}				
				$this->add_crumbs_leaf();				
			} else {
				if ( is_post_type_archive() ) {
					if ( is_search() ) {
						$this->add_crumbs_archive_link();
						$this->add_crumbs_leaf('search');					
					} else {
						$this->add_crumbs_archive_link(false);
					}
				} elseif ( is_tax() || is_tag() || is_category() ) {
					if ( is_tag() ) {
						if ( get_option( 'show_on_front' ) == 'page' && $blog_link ) {
							$this->add_crumb(get_the_title( get_option('page_for_posts', true) ),get_permalink( get_option('page_for_posts' ) ));
						}
						$this->add_crumbs_tag();
					} elseif ( is_tax('product_tag') ) {
						$this->add_crumbs_product_tag();
					} else {
						if ( is_category() && get_option( 'show_on_front' ) == 'page' && $blog_link ) {
							$this->add_crumb(get_the_title( get_option('page_for_posts', true) ),get_permalink( get_option('page_for_posts' ) ));
						}
						if ( is_tax('portfolio_cat') || is_tax('portfolio_skills') ) {
							$this->add_crumb($this->get_archive_name('portfolio'),get_post_type_archive_link( 'portfolio' ));
						}
						$this->add_crumbs_taxonomies_link();
						$this->add_crumbs_leaf('term');
					}
				} elseif ( is_date() ) {
						global $wp_locale;

						if ( get_option( 'show_on_front' ) == 'page' && $blog_link ) {
							$this->add_crumb(get_the_title( get_option('page_for_posts', true) ), get_permalink( get_option('page_for_posts' ) ) );
						}

						$year = get_the_time('Y');
						if ( is_month() || is_day() ) {
							$month = get_the_time('m');	
							$month_name = $wp_locale->get_month( $month );
						}

						if ( is_year() ) {
							$this->add_crumbs_leaf('year');
						} elseif ( is_month() ) {
							$this->add_crumb($year, get_year_link( $year ));
							$this->add_crumbs_leaf('month');
						} elseif ( is_day() ) {						
							$this->add_crumb($year, get_year_link( $year ));
							$this->add_crumb($month_name, get_month_link( $month ));
							$this->add_crumbs_leaf('day');
						}
				} elseif ( is_author() ) {
					$this->add_crumbs_leaf('author');
				} elseif ( is_search() ) {
					$this->add_crumbs_leaf('search');
				} elseif ( is_404() ) {
					$this->add_crumbs_leaf('404');
				} elseif ( class_exists( 'bbPress' ) && is_bbpress() ) {
					if ( bbp_is_search() ) {
						$this->add_crumbs_leaf('bbpress_search');
					} elseif ( bbp_is_single_user() ) {
						$this->add_crumbs_leaf('bbpress_user');
					} else {
						$this->add_crumbs_leaf();
					}
				} else {
					if ( is_home() && !is_front_page() ) {
						if ( get_option( 'show_on_front' ) == 'page' ) {
							$this->add_crumb(get_the_title( get_option('page_for_posts', true) ));
						} else {
						
						$this->add_crumb('Default title');
						}
					}
				}
			}			
			return $this->get_breadcrumb();			
		}
		
		/**
		 * Is home trail..
		 */
		private function add_crumbs_home() {
			$this->add_crumb(esc_html__('Home', 'kapee'));
		}
		
		/**
		 * Tag trail.
		 */
		private function add_crumbs_tag() {
			$queried_object = $GLOBALS['wp_query']->get_queried_object();

			/* translators: %s: tag name */
			$this->add_crumb( sprintf( __( 'Article tagged &ldquo;%s&rdquo;', 'kapee' ), single_tag_title( '', false ) ), get_tag_link( $queried_object->term_id ) );
		}
		
		/**
		 * Product Tag trail.
		 */
		private function add_crumbs_product_tag() {
			$queried_object = $GLOBALS['wp_query']->get_queried_object();

			/* translators: %s: tag name */
			$this->add_crumb( sprintf( __( ' Products tagged &ldquo;%s&rdquo;', 'kapee' ), single_tag_title( '', false ) ), get_tag_link( $queried_object->term_id ) );
		}
	
		private function add_crumbs_shop_link($linked = true) {
			$post_type = 'product';
			$post_type_object = get_post_type_object( $post_type );
			$link = '';
			if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				$shop_page_name = $shop_page_id ? get_the_title( $shop_page_id ) : '';

				if ( ! $shop_page_name ) {
					$shop_page_name = $post_type_object->labels->name;
				}
				if ($linked ) {
					$link = $shop_page_id !== -1 ? get_permalink($shop_page_id) : get_post_type_archive_link( $post_type );
				}
				
				$this->add_crumb($shop_page_name,$link);
			}
			
		}
		
		private function add_crumbs_archive_link($linked = true) {
			global $wp_query;

			$post_type = $wp_query->query_vars['post_type'];
			$post_type_object = get_post_type_object( $post_type );
			$link = '';
			$archive_title = '';

			if ( is_object( $post_type_object ) ) {

				// woocommerce
				if ( $post_type == 'product') {
					$this->add_crumbs_shop_link();
					return;
				}

				// bbpress
				if ( class_exists( 'bbPress' ) && $post_type == 'topic' ) {
					if ( $linked ) {
						$archive_title = bbp_get_forum_archive_title();
						$link = get_post_type_archive_link( bbp_get_forum_post_type() );
					} else {
						$archive_title = bbp_get_topic_archive_title();
					}
					$this->add_crumb($archive_title,$link);
					return;
				}

				// default
				$archive_title = $this->get_archive_name( $post_type );
			}

			if ( $linked ) {
				$link = get_post_type_archive_link( $post_type );
			}

			if ( $archive_title ) {				
				$this->add_crumb($archive_title,$link);
				return;
			}

		}
		
		private function add_crumbs_terms_link() {

			global $kapee_settings;

			$output = array();
			$post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
			
			$breadcrumbs_categories = true;
			
			if ( !$breadcrumbs_categories) {
				return $output;
			}
			$taxonomy = '';
			if ( $post->post_type == 'post' ) {
				$taxonomy = 'category';
			} elseif ( $post->post_type == 'portfolio' ) {
				$taxonomy = 'portfolio_cat';
			}elseif ( $post->post_type == 'product' ) {				
				$taxonomy = 'product_cat';					
			}
			if(!empty($taxonomy )){
				$terms = wp_get_object_terms(
					$post->ID, $taxonomy, apply_filters(
						'kapee_breadcrumb_product_terms_args', array(
							'orderby' => 'parent',
							'order'   => 'DESC',
						)
					)
				);
				if ( $terms ) {
					$main_term = apply_filters( 'kapee_breadcrumb_main_term', $terms[0], $terms );
					$this->term_ancestors( $main_term->term_id, $taxonomy );
					$this->add_crumb( $main_term->name, get_term_link( $main_term ) );
				}
			}
		}
		
		/**
		 * Add crumbs for a term.
		 *
		 * @param int    $term_id  Term ID.
		 * @param string $taxonomy Taxonomy.
		 */
		private function term_ancestors( $term_id, $taxonomy ) {
			$ancestors = get_ancestors( $term_id, $taxonomy );
			$ancestors = array_reverse( $ancestors );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $taxonomy );

				if ( ! is_wp_error( $ancestor ) && $ancestor ) {
					$this->add_crumb( $ancestor->name, get_term_link( $ancestor ) );
				}
			}
		}
	
		private function add_crumbs_ancestors_link() {
			$output = '';

			$post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
			$post_ancestor_ids = array_reverse( get_post_ancestors( $post ) );

			foreach ( $post_ancestor_ids as $post_ancestor_id ) {
				$post_ancestor = get_post( $post_ancestor_id );
				
				$this->add_crumb($post_ancestor->post_title,get_permalink( $post_ancestor->ID ));
			}
		}

		private function add_crumbs_taxonomies_link() {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$output = '';

			if ( $term && $term->parent != 0 && isset($term->taxonomy) && isset($term->term_id) && is_taxonomy_hierarchical( $term->taxonomy ) ) {
				$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
				$term_ancestors = array_reverse( $term_ancestors );

				foreach ( $term_ancestors as $term_ancestor ) {
					$term_object = get_term( $term_ancestor, $term->taxonomy );
					$this->add_crumb($term_object->name,get_term_link( $term_object->term_id, $term->taxonomy ));
				}
			}

			return $output;
		}

		public function get_archive_name($post_type){
			$archive_title = '';
			if ($post_type == 'portfolio') {
				$archive_title = esc_html__('Portfolio','kapee');
			} else {
				$post_type_object = get_post_type_object( $post_type );
				if ( is_object( $post_type_object ) ) {
					$archive_title = $post_type_object->labels->singular_name;
				}
			}
			return $archive_title;
		}
		
		function add_crumbs_leaf( $object_type = '' ) {
			global $wp_query, $wp_locale;

			$post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;

			switch( $object_type ) {
				case 'term':
					$term = $wp_query->get_queried_object();
					$title = $term->name;
					break;
				case 'year':
					$title = get_the_time('Y');
					break;
				case 'month':
					$month = get_the_time('m');
					$title = $wp_locale->get_month( $month  );
					break;
				case 'day':
					$title = get_the_time('d');
					break;
				case 'author':
					$user = $wp_query->get_queried_object();
					$title = $user->display_name;
					break;
				case 'search':
					$search = esc_html( get_search_query() );
					if ( $product_cat = get_query_var('product_cat') ) {
						$product_cat = get_term_by('slug', $product_cat, 'product_cat');
						$search = '<a href="' . esc_url( get_term_link($product_cat, 'product_cat') ) . '">' . esc_html( $product_cat->name ) . '</a>' . ( $search ? ' / ' : '' ) . $search;
					}
					$title = sprintf( __( 'Search - %s', 'kapee' ), $search );
					break;
				case '404':
					$title = esc_html__( '404', 'kapee' );
					break;
				case 'bbpress_search':
					$title = sprintf( __( 'Search - %s', 'kapee' ), esc_html( get_query_var( 'bbp_search' ) ) );
					break;
				case 'bbpress_user':
					$current_user = wp_get_current_user();
					$title = $current_user->user_nicename;
					break;
				default:
					$title = get_the_title( $post->ID );
					break;
			}

			$this->add_crumb($title,'');
		}	
		
	}
}

?>