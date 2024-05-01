<?php 
if( ! class_exists( 'Kapee_Mega_Menu_Walker' )) {
	class Kapee_Mega_Menu_Walker extends Walker_Nav_Menu {
		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$sub_menu_class = 'sub-menu';
			
			$output .= "\n$indent<ul class=\"$sub_menu_class\">\n";
		}
		
		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}
		
		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'item-level-' . $depth;
			$item_id = $item->ID;
			$enable = $design = $width = $height = $icon = $label_text = $label_output = $icon_output = '';
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
			
			if( $depth == 0 && $enable =='enabled' ) {
				$classes[] = 'menu-item-has-children';
				$classes[] = 'kapee-megamenu-item-' . $design;
				$classes[] = 'kapee-' . ( (  in_array( $design, array( 'custom-size', 'full-width' ) ) ) ? 'megamenu-dropdown' : 'simple-dropdown' );
			}
			
			/* For menu label text*/
			if( !empty( $label_text ) ) {
				$classes[] 		= 'item-with-label';
				$classes[] 		= 'item-label';
				$bg_color 		= ( !empty( $label_color ) ) ? 'style = background-color:'.$label_color.';' : '';
				$label_output 	= '<span class="menu-label" '.esc_attr( $bg_color ).'>' . esc_attr( $label_text ) . '</span>';
			}

			if( ! empty( $block ) && $enable =='enabled' ) {
				$classes[] = 'menu-item-has-megamenu';
			}
			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$atts['class'] = 'nav-link';

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon_url = '';

			if( $attachment_id ) {
				$icon_url = kapee_get_image_src($attachment_id,'thumnail');
			}
			
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			if($icon != '') {
				if(strstr($icon, 'fa-') ){
					$icon = 'fa '.$icon; /* backward compatibility */
				}
				$icon_output = '<i class="' . $icon . '"></i>';
			}
			if( ! empty( $icon_url ) ) {
				$icon_output = '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" class="' . esc_attr( 'menu-icon-img' ) . '" />';
			}
			$item_output .= $icon_output;
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
			$item_output .= $label_output;
			$item_output .= '</a>';
			$item_output .= $args->after;

			
			
			/* Megamenu*/
			if( ($depth == 0 && $enable =='enabled') && !empty($custom_block) && !$args->walker->has_children) {
					if($design == 'custom-size') {	
						$width = !empty($width) ? $width : 640;
						$height = !empty($height) ? $height : 300;
						$style_mg_holder = 'style = "min-height: ' . $height .'px; ';
						$style_mg_holder .= 'width: ' . $width .'px;"';
					}else{
						$containerWidth = kapee_get_option( 'theme-container-width', 1200 );
						$style_mg_holder = 'style = "width:'.($containerWidth-30).'px"';
					}
					$item_output .= "\n$indent<div class=\"kapee-megamenu-wrapper\">\n";
					$item_output .= "\n$indent<div class=\"kapee-megamenu-holder\" $style_mg_holder>\n";
						$item_output .= do_shortcode('[kapee_block id="'.$custom_block.'"]');
					$item_output .= "\n$indent</div>\n";
					$item_output .= "\n$indent</div>\n";

			}
			

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

}

if( ! class_exists( 'Kapee_Menu_Walker' )) {
	class Kapee_Menu_Walker extends Walker_Nav_Menu {
		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$sub_menu_class = 'sub-menu';
			
			$output .= "\n$indent<ul class=\"$sub_menu_class\">\n";
		}
		
		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}
		
		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'item-level-' . $depth;
			$item_id = $item->ID;
			$enable = $design = $width = $height = $icon = $label_text = $label_output = $icon_output = '';
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
			
			
			/* For menu label text*/
			if( !empty( $label_text ) ) {
				$classes[] 		= 'item-with-label';
				$classes[] 		= 'item-label';
				$bg_color 		= ( !empty( $label_color ) ) ? 'style = background-color:'.$label_color.';' : '';
				$label_output 	= '<span class="menu-label" '.esc_attr( $bg_color ).'>' . esc_attr( $label_text ) . '</span>';
			}

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$atts['class'] = 'nav-link';

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon_url = '';

			if( $attachment_id ) {
				$icon_url = kapee_get_image_src($attachment_id,'thumnail');
			}
			
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			if($icon != '') {
				if(strstr($icon, 'fa-') ){
					$icon = 'fa '.$icon; /* backward compatibility */
				}
				$icon_output = '<i class="' . $icon . '"></i>';
			}
			if( ! empty( $icon_url ) ) {
				$icon_output = '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" class="' . esc_attr( 'menu-icon-img' ) . '" />';
			}
			$item_output .= $icon_output;
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
			$item_output .= $label_output;
			$item_output .= '</a>';
			$item_output .= $args->after;
			
			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

}
?>