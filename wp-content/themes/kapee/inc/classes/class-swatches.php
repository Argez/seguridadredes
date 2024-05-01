<?php
if (!class_exists('Kapee_Woocommerce')) {

	class Kapee_Woocommerce{
		public $prefix = KAPEE_PREFIX;
		private $cat_sidebars = array();
		function __construct() {
			
			/*Swatches fronted display*/		
			$this->init();
			
			add_action( 'woocommerce_variable_add_to_cart', array( $this, 'enqueue_variable_script' ) );
			
			$this->cat_sidebars[''] = esc_html__( 'Default', 'kapee' );
			global $wp_registered_sidebars;			
			if ( $wp_registered_sidebars ) {
				foreach ( $wp_registered_sidebars as $sidebar ) {
					$this->cat_sidebars[ $sidebar['id'] ] = $sidebar['name'];
				}
			}
		
			/*Swatches admin options*/			
			/* add attribute */
			add_filter('woocommerce_after_add_attribute_fields', array( $this,'kapee_add_attribute_swatch_size_selector'),10, 3 );
			add_action( 'woocommerce_attribute_added', array( $this, 'kapee_save_attribute_swatch_size' ), 10, 2 );

			/* edit attribute */
			add_filter('woocommerce_after_edit_attribute_fields', array( $this,'kapee_edit_attribute_swatch_size_selector'),10, 3 );
			add_action( 'woocommerce_attribute_updated', array( $this, 'kapee_save_attribute_swatch_size' ), 10,2);
			
			/* delete attribute */
			add_action( 'woocommerce_attribute_deleted', array( $this, 'kapee_delete_attribute_swatch_size' ), 10, 1 );
			
			/* Product attribute meta */
			$attribute_taxonomies = $this->wc_get_attribute_taxonomies();

			if ( ! empty( $attribute_taxonomies ) ) {
				foreach ( $attribute_taxonomies as $attribute ) {
					add_action( 'pa_' . $attribute->attribute_name . '_add_form_fields', array( $this, 'kapee_taxonomy_add_new_meta_field' ) );
					add_action( 'pa_' . $attribute->attribute_name .'_edit_form_fields', array( $this, 'kapee_taxonomy_edit_meta_field' ), 10 );
					
					// Save taxonomy fields
					add_action('edited_pa_'.$attribute->attribute_name, array($this, 'kapee_save_attr_extra_fields'));
					add_action('create_pa_'.$attribute->attribute_name, array($this, 'kapee_save_attr_extra_fields'));
				}
			}
			if( defined( 'KAPEE_EXTENSIONS_VERSION' ) ) {
				if( apply_filters( 'kapee_enable_offer_service_field' , true ) ) {
				// Add Offer fields
				add_action( 'woocommerce_product_options_general_product_data', array($this, 'kapee_product_offer_field'));
				add_action( 'woocommerce_product_options_general_product_data', array($this, 'kapee_product_service_field'));
				
				//Save offer field data
				add_action( 'woocommerce_process_product_meta', array( $this, 'kapee_save_product_offer_field' ) );
				add_action( 'woocommerce_process_product_meta', array( $this, 'kapee_save_product_service_field' ) );
				}
			}
			
			// Product Category field
			add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 30 );
			add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
			add_action( 'created_term', array( $this, 'save_category_fields' ), 20 );
			add_action( 'edit_term', array( $this, 'save_category_fields' ), 20 );
			add_action( 'save_post', array( $this, 'clear_swatches_cache_save_post' ) );
			add_action( 'woocommerce_before_product_object_save', array( $this, 'clear_swatches_cache_product_object_save' ) );
		}
		
		public function enqueue_variable_script() {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}
		
		public function init() {			
			add_action( 'kapee_product_loop_buttons_variations', array( $this, 'kapee_product_swatches' ) , 15 );
		}
		
		/**
		 * Show swatches
		 */
		public function kapee_product_swatches() {

			global $product;
			$pid = $product->get_id();

			if ( empty( $pid ) || ! $product->is_type( 'variable' ) ) {
				return;
			}
			$pid 			= $product->get_id();
			$cache_enabled 	= apply_filters( 'kapee_has_swatches_cache', true );
			$transient_name = 'kapee_swatches_cache_' . $pid;
			
			if ( $cache_enabled ) {
				$available_variations = get_transient( $transient_name );
			} else {
				$available_variations = array();
			}
			
			if ( ! $available_variations ) {					
				$available_variations = $product->get_available_variations();
				if ( $cache_enabled ) {
					set_transient( $transient_name, $available_variations, apply_filters( 'kapee_swatches_cache_time', WEEK_IN_SECONDS ) );
				}
			}
			
			if ( empty( $available_variations ) ) {
				return;
			}
				
			$attributes 			= $product->get_attributes();
			$variation_attributes 	= $product->get_variation_attributes();
			$selected_attributes 	= $product->get_default_attributes();

			

			$is_loop = current_filter() == 'kapee_product_loop_buttons_variations';

			$args = array(
				'is_loop'              => $is_loop,
				'attributes'           => $attributes,
				'available_variations' => $available_variations,
				'variation_attributes' => $variation_attributes,
				'selected_attributes'  => $selected_attributes,
			);

			if ( $is_loop ) {
				$this->kapee_swatch_loop($args);
			}
						
		}
		public function kapee_swatch_loop($args){
			
			global $product;
			if( ! kapee_get_loop_prop( 'products-variations' ) ) return;
					
			extract($args);	?>
			
			<div class="product-variations">
				<div class="kapee-swatches-wrap" <?php if ( has_post_thumbnail() ) {
				$srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id(), 'shop_catalog' );
				$sizes  = wp_get_attachment_image_sizes( get_post_thumbnail_id(), 'shop_catalog' );
				echo  'data-srcset="' . esc_attr( $srcset ) . '" data-sizes="' . esc_attr( $sizes ) . '" data-product_id="' . esc_attr( get_the_ID() ) . '"';
				$available_variations = $this->kapee_swatch_variations( $available_variations );
				} ?> data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
					<?php 
					foreach ( $attributes as $attribute_name => $options ) {
						
						if ( $options['is_variation'] == 1) {
							$output 		= '';
							$enable_swatch 	= $this->kapee_has_enable_switch($attribute_name);						
							$swatches_html 	= '';
							if($enable_swatch){
								$class = 'kapee-hidden';
								$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
								$swatches_html = $this->kapee_swatch_html($output,$terms,$options, $attribute_name, $selected_attributes, $product );
								if ( ! empty( $swatches_html ) ){ ?>
									<div class="kapee-swatches" data-attribute="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
										<?php echo wp_kses( $swatches_html, kapee_allowed_html(array('span','img')) ); ?>
									</div> <?php
								}
							}
						}
					}?>
					
					<a class="reset_variations reset_variations--loop" href="#" style="display: none;"><?php esc_html_e( 'Clear', 'kapee' ); ?></a>
				</div>
			</div>
			<?php
		}
		
		/**
		 * Customize product variations
		 *
		 * @param $variations
		 *
		 * @return array
		 */
		public function kapee_swatch_variations( $variations ) {

			$new_variations = array();

			foreach ( $variations as $variation ) {

				if ( $variation['variation_id'] != '' ) {

					$id = get_post_thumbnail_id( $variation['variation_id'] );

					$src    = wp_get_attachment_image_src( $id, 'shop_catalog' );
					$srcset = wp_get_attachment_image_srcset( $id, 'shop_catalog' );
					$sizes  = wp_get_attachment_image_sizes( $id, 'shop_catalog' );

					$variation['image_src']    = $src;
					$variation['image_srcset'] = $srcset;
					$variation['image_sizes']  = $sizes;

					$new_variations[] = $variation;
				}
			}

			return $new_variations;
		}
		
		public function kapee_has_enable_switch($attribute_name){
			$prefix = KAPEE_PREFIX;
			$enable_swatch = get_option($prefix.$attribute_name.'_enable_swatch',false);
			if( !empty( $enable_swatch ) && $enable_swatch ){
				return true;
			}
			return false;
		}
		
		public function kapee_swatch_html($html,$terms,$options, $attribute_name, $selected_attributes, $product = null ){

			if ( isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) {
				$selected_value = $_REQUEST[ 'attribute_' . $attribute_name ];
			} elseif ( isset( $selected_attributes[ $attribute_name ] ) ) {
				$selected_value = $selected_attributes[ $attribute_name ];
			} else {
				$selected_value = '';
			}	
			foreach ( $terms as $term ) {
				$html .= $this->kapee_get_swatch_html( $term, $selected_value, $attribute_name, $product);
			}
			return $html;
		}
		
		/* Function get switch html*/
		public function kapee_get_swatch_html($term,$selected_value ='',$attribute_name = '', $product = null){
			$html 					= '';
			$prefix 				= KAPEE_PREFIX;
			$swatch_display_style 	= get_option($prefix.$attribute_name.'_swatch_display_style',true);
			$swatch_display_type 	= get_option($prefix.$attribute_name.'_swatch_display_type',true);
			$swatch_size 			= get_option($prefix.$attribute_name.'_swatch_display_size',true);
			$name     				= esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );
				$selected = sanitize_title( $selected_value ) == $term->slug ? 'swatch-selected' : '';
				if($swatch_display_type == 'color'){			
					$color = get_term_meta( $term->term_id,  $prefix.'color', true );
					list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
					if(empty($color)){
						$color = strtolower($name);
					}
					$html .= sprintf(
					'<span class="swatch-term swatch swatch-color term-%s swatch-%s swatch-%s %s"  title="%s" data-term="%s"><span class="kapee-tooltip" style="background-color:%s;color:%s;">%s</span></span>',
					esc_attr( $term->slug ),
					$swatch_display_style,
					$swatch_size,
					$selected,					
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)",
					$name
					);
				}else if($swatch_display_type == 'image'){
					$image = get_term_meta( $term->term_id, $prefix.'kapee_attachment_id', true );
					
					$show_variation_image = apply_filters( 'kapee_show_variation_image', true );
					if( $show_variation_image ) {						
						$pid 	= $product->get_id();
						$cache_enabled = apply_filters( 'kapee_has_swatches_cache', true );
						$transient_name     = 'kapee_swatches_cache_' . $pid;						
						if ( $cache_enabled ) {
							$available_variations = get_transient( $transient_name );
						} else {
							$available_variations = array();
						}
						
						if ( ! $available_variations ) {					
							$available_variations = $product->get_available_variations();
							if ( $cache_enabled ) {
								set_transient( $transient_name, $available_variations, apply_filters( 'kapee_swatches_cache_time', WEEK_IN_SECONDS ) );
							}
						}
						if ( empty( $available_variations ) ) {
							return;
						}
						foreach ( $available_variations as $variation ) {
							if ( $variation['attributes'][ 'attribute_' . $attribute_name ] == $term->slug ) {
								$data_var_id = $variation['variation_id'];
							}
						}
						$variation = new WC_Product_Variation( $data_var_id );
						$image_id = $variation->get_image_id(); 
						
						if($image_id){
							$image = $image_id;
						}
					}
			
					$image = $image ? wp_get_attachment_image_src( $image ) : '';
					$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					$html  .= sprintf(
						'<span class="swatch-term swatch swatch-image term-%s swatch-%s swatch-%s %s" title="%s" data-term="%s"><img src="%s" alt="%s"></span>',
						esc_attr( $term->slug ),
						$swatch_display_style,
						$swatch_size,
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						esc_url( $image ),
						esc_attr( $name )
					);
				}else{
					$label = get_term_meta( $term->term_id, 'label', true );
					$label = $label ? $label : $name;
					if( $swatch_display_style == 'square' ){
						$swatch_size = 'default';
					}
					$html  .= sprintf(
						'<span class="swatch-term swatch swatch-label term-%s swatch-%s swatch-%s %s" title="%s" data-term="%s"><span>%s</span></span>',
						esc_attr( $term->slug ),
						$swatch_display_style,
						$swatch_size,
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						esc_html( $label )
					);
				}
			return apply_filters('kapee_single_swatch_html',$html,$term,$selected_value);
		}
		
		/**
		 * Function to add attribute
		*/
		public function kapee_add_attribute_swatch_size_selector() {
		?>
			<div class="form-field">
				<label for="kapee_swatch_enable"><?php echo esc_html__('Enable swatch','kapee')?></label>
				<input id="kapee_swatch_enable" type="checkbox" name="<?php echo esc_attr($this->prefix);?>enable_swatch" value="1">
				<p class="description"><?php echo esc_html__('Attribute dropdown will be replaces with swatches.','kapee')?></p>
			</div>
			<div class="form-field">
				<label for="kapee_swatch_size"><?php echo esc_html__('Attributes swatch size','kapee')?></label>
				<select id="kapee_swatch_size" name="<?php echo esc_attr($this->prefix);?>swatch_display_size" class="kapee_swatch_display_size">
					<option value="normal"><?php echo esc_html__('Normal','kapee')?></option>
					<option value="small"><?php echo esc_html__('Small','kapee')?></option>
					<option value="large"><?php echo esc_html__('Large','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select display swatches size for terms of this attribute.','kapee')?></p>
			</div>
			<div class="form-field">
				<label for="kapee_swatch_display_style"><?php echo esc_html__('Swatch display style','kapee')?></label>
				<select id="kapee_swatch_display_style" name="<?php echo esc_attr($this->prefix);?>swatch_display_style" class="kapee_swatch_display_style">
					<option value="square"><?php echo esc_html__('Square','kapee')?></option>
					<option value="circle"><?php echo esc_html__('Circle','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select swatches display style.','kapee')?></p>
			</div>
			<div class="form-field">
				<label for="kapee_swatch_display_type"><?php echo esc_html__('Swatch display type','kapee')?></label>
				<select id="kapee_swatch_display_type" name="<?php echo esc_attr($this->prefix);?>swatch_display_type" class="kapee_swatch_display_type">
					<option value="color"><?php echo esc_html__('Color','kapee')?></option>
					<option value="image"><?php echo esc_html__('Image','kapee')?></option>
					<option value="label"><?php echo esc_html__('Label','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select swatches display type.','kapee')?></p>
			</div>
		<?php
		}
		
		/**
		 * Function to save attribute
		*/
		function kapee_save_attribute_swatch_size($attribute_id,$attribute) {
			
			$prefix = $this->prefix; // Taking metabox prefix
			$attribute_id = (int)$attribute_id;
			
			$enable_swatch 			= isset($_POST[$prefix.'enable_swatch']) ? $_POST[$prefix.'enable_swatch'] : 0 ;
			$swatch_display_size 	= isset($_POST[$prefix.'swatch_display_size']) ? $_POST[$prefix.'swatch_display_size'] : 'normal';
			$swatch_display_style 	= isset($_POST[$prefix.'swatch_display_style']) ? $_POST[$prefix.'swatch_display_style'] : 'square';
			$swatch_display_type 	= isset($_POST[$prefix.'swatch_display_type']) ? $_POST[$prefix.'swatch_display_type'] : 'label';
			
			update_option( $prefix.'pa_' . $attribute['attribute_name'] .'_enable_swatch', $enable_swatch );
			update_option( $prefix.'pa_' . $attribute['attribute_name'] .'_swatch_display_size', $swatch_display_size );	
			update_option( $prefix.'pa_' . $attribute['attribute_name'] .'_swatch_display_style', $swatch_display_style );
			update_option( $prefix.'pa_' . $attribute['attribute_name'] .'_swatch_display_type', $swatch_display_type);
		}
		
		/**
		 * Function to edit attribute
		*/
		function kapee_edit_attribute_swatch_size_selector( $term,$attribute=null,$old_attribute=null) {
			$prefix = $this->prefix; // Taking metabox prefix
			
			//getting term ID
			$attribute_id = absint( $_GET['edit'] );
			$attribute_data = $this->get_tax_attribute($attribute_id);
			
			// Getting stored values
			$swatch_display_size = get_option( $prefix.'pa_' . $attribute_data->attribute_name .'_swatch_display_size', true );
			$enable_swatch = get_option( $prefix.'pa_' . $attribute_data->attribute_name .'_enable_swatch', true );
			$swatch_display_style = get_option( $prefix.'pa_' . $attribute_data->attribute_name .'_swatch_display_style', true );
			$swatch_display_type = get_option( $prefix.'pa_' . $attribute_data->attribute_name .'_swatch_display_type', true );
			   
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee_swatch_enable"><?php echo esc_html__('Enable swatch','kapee')?></label></th>
				<td>
					<input id="kapee_swatch_enable" type="checkbox" name="<?php echo esc_attr($this->prefix);?>enable_swatch" value="1" <?php checked($enable_swatch,'1')?>>
					<p class="description"><?php echo esc_html__('Attribute dropdown will be replaces with swatches.','kapee')?></p>
				</td>
			</tr>  
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee_swatch_display_size"><?php echo esc_html__('Attributes swatch size','kapee')?></label></th>
			<td>
				<select name="<?php echo esc_attr($this->prefix);?>swatch_display_size" id="kapee_swatch_display_size" class="kapee_swatch_display_size">
					<option value="normal" <?php selected('normal',$swatch_display_size);?>><?php echo esc_html__('Normal','kapee')?></option>
					<option value="small" <?php selected('small',$swatch_display_size);?>><?php echo esc_html__('Small','kapee')?></option>
					<option value="large" <?php selected('large',$swatch_display_size);?>><?php echo esc_html__('Large','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select display swatches size for terms of this attribute.','kapee')?></p>
			</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee_swatch_display_style"><?php echo esc_html__('Swatch display style','kapee')?></label></th>
			<td>
				<select id="kapee_swatch_display_style" name="<?php echo esc_attr($this->prefix);?>swatch_display_style" class="kapee_swatch_display_style">
					<option value="square" <?php selected('square',$swatch_display_style);?>><?php echo esc_html__('Square','kapee')?></option>
					<option value="circle" <?php selected('circle',$swatch_display_style);?>><?php echo esc_html__('Circle','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select swatches display style.','kapee')?></p>
			</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee_swatch_display_type"><?php echo esc_html__('Swatch display type','kapee')?></label></th>
			<td>
				<select id="kapee_swatch_display_type" name="<?php echo esc_attr($this->prefix);?>swatch_display_type" class="kapee_swatch_display_type">
					<option value="color" <?php selected('color',$swatch_display_type);?>><?php echo esc_html__('Color','kapee')?></option>
					<option value="image" <?php selected('image',$swatch_display_type);?>><?php echo esc_html__('Image','kapee')?></option>
					<option value="label" <?php selected('label',$swatch_display_type);?>><?php echo esc_html__('Label','kapee')?></option>
				</select>
				<p class="description"><?php echo esc_html__('Select swatches display type.','kapee')?></p>
			</td>
			</tr>  
			<?php
		}
		
		/**
		 * Function to delete attribute
		*/
		public function kapee_delete_attribute_swatch_size($attribute_id){
			$prefix = $this->prefix; // Taking metabox prefix
			$attribute_id = (int)$attribute_id;
			delete_option( $prefix.'pa_' . $attribute_id .'_swatch_display_size');		
			delete_option( $prefix.'pa_' . $attribute_id .'_enable_swatch');		
			delete_option( $prefix.'pa_' . $attribute_id .'_swatch_display_style');		
			delete_option( $prefix.'pa_' . $attribute_id .'_swatch_display_type');		
		}
		
		/**
		 * Get attribute taxonomies.
		 *
		 * @return array of objects
		 */
		function wc_get_attribute_taxonomies() {
			$attribute_taxonomies = get_transient( 'wc_attribute_taxonomies' );
			if ( false === $attribute_taxonomies ) {
				global $wpdb;
				$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
				set_transient( 'wc_attribute_taxonomies', $attribute_taxonomies );
			}
			return (array) array_filter( apply_filters( 'woocommerce_attribute_taxonomies', $attribute_taxonomies ) );
		}
		
		/**
		 * Function to add taxonomy meta field
		*/
		function kapee_taxonomy_add_new_meta_field() {
			$prefix = $this->prefix; // Taking metabox prefix
		?>
			<div class="form-field">
				<label for="kapee-image"><?php echo esc_html__('Upload Image', 'kapee'); ?></label>
				<input type="hidden" class="kapee-attachment-id" name="<?php echo esc_attr( $prefix );?>kapee_attachment_id">
				<img class="kapee-attr-img" src="<?php echo esc_url( wc_placeholder_img_src() );?>" alt="<?php echo esc_attr__('Upload/Add image','kapee')?>" height="50px" width="50px">
				<button class="kapee-image-upload button" type="button"><?php echo esc_html__('Upload/Add image','kapee');?></button>
				<button class="kapee-image-clear button" type="button" data-src="<?php echo esc_url( wc_placeholder_img_src() );?>"><?php esc_html_e('Remove image','kapee');?></button>
				 <p class="description"><?php esc_html_e('Upload image for this value.', 'kapee'); ?></p>
			</div>
			
			<div class="form-field">
				<label for="kapee-color"><?php esc_html_e('Select Color', 'kapee'); ?></label>
				<input type="text" name="<?php echo esc_attr( $prefix );?>color" id="kapee-color-picker" class="kapee-color-picker kapee-color-box" />
				<p class="description"><?php esc_html_e('Select color for this value.', 'kapee'); ?></p>
			</div>
			<script>
			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '.kapee-attr-img').attr( 'src', '<?php echo esc_url(wc_placeholder_img_src()); ?>' );
					jQuery( '.kapee-attachment-id' ).val( '' );
					//jQuery( '.kapee-color-box' ).val( '' );
					/* Color Picker */
					if( jQuery('.kapee-color-box').length > 0 ) {
						var myOptions = {defaultColor: false}; 
						jQuery('.kapee-color-box').wpColorPicker(myOptions);
					}
					return;
				}
			} );
			</script>
		<?php
		}
		
		/**
		 * Function to edit taxonomy meta field
		*/
		function kapee_taxonomy_edit_meta_field( $term ) {		
			$prefix = $this->prefix; // Taking metabox prefix	    
			//getting term ID
			$term_id = $term->term_id;
			// Getting stored values
			$kapee_attachment_id = get_term_meta($term_id, $prefix.'kapee_attachment_id', true);    
			$color = get_term_meta($term_id, $prefix.'color', true); 
			$image = wc_placeholder_img_src();
			if(!empty($kapee_attachment_id)){
				$image = kapee_get_image_src( $kapee_attachment_id,'thumnail');
			}		
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee-attr-image"><?php esc_html_e('Upload Image', 'kapee'); ?></label></label></th>
				<td>
					<input type="hidden" class="kapee-attachment-id" value="<?php echo esc_attr($kapee_attachment_id);?>" name="<?php echo esc_attr( $prefix );?>kapee_attachment_id">
					<img class="kapee-attr-img" src="<?php echo esc_url($image);?>" alt="<?php esc_attr_e('Upload/Add image','kapee')?>" height="50px" width="50px">
					<button class="kapee-image-upload button" type="button"><?php esc_html_e('Upload/Add image','kapee');?></button>
					<button class="kapee-image-clear button" type="button" data-src="<?php echo wc_placeholder_img_src();?>"><?php esc_html_e('Remove image','kapee');?></button>
					<p class="description"><?php esc_html_e('Upload image for this value.', 'kapee'); ?></p>
				</td>
			</tr>  
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee-color"><?php esc_html_e('Select Color', 'kapee'); ?></label></th>
				<td>
					<input type="text" name="<?php echo esc_attr( $prefix );?>color" value="<?php echo esc_attr($color);?>" id="kapee-color-picker" class="kapee-color-picker kapee-color-box" />
					<p class="description"><?php esc_html_e('Select color for this value.', 'kapee'); ?></p>
				</td>
			</tr>  
			<?php
		}
		
		/**
		 * Function to save taxonomy meta field
		*/
		function kapee_save_attr_extra_fields($term_id) {

			$prefix = $this->prefix; // Taking metabox prefix

			$kapee_attachment_id = !empty($_POST[$prefix.'kapee_attachment_id']) ? $_POST[$prefix.'kapee_attachment_id'] : '';
			$color = !empty($_POST[$prefix.'color']) ? $_POST[$prefix.'color'] : '';

			update_term_meta($term_id, $prefix.'kapee_attachment_id', $kapee_attachment_id);
			update_term_meta($term_id, $prefix.'color', $color);
		}
		
		/**
		 * Function to save taxonomy meta field
		*/
		public function get_tax_attribute( $attribute_id ) {
			global $wpdb;
			$attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_id = '$attribute_id'" );

			return $attr;
		}
		
		/**
		 * Function to add offer field for product
		*/
		public function kapee_product_offer_field(){
			global $post;
			$post_id = $post->ID;
			$offer_data = get_post_meta( $post_id, $this->prefix.'offer',true);
			$is_offer_available = get_post_meta( $post_id, $this->prefix.'is_offer_available',true);		
			if(empty($offer_data)){
				$offer_data = array( 0 => '');
			}
			$wrapper_style = 'display:none';
			if($is_offer_available){
				$wrapper_style = '';
			}
			$custom_block = kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE);
		?>	
			<div class="options_group offer_group">
				<p class="form-field <?php echo esc_attr( $this->prefix );?>is_offer_available_field ">
					<label for="<?php echo esc_attr( $this->prefix );?>is_offer_available"><?php echo esc_html__('Is Offer Available.','kapee');?></label>
					<input type="checkbox" class="checkbox" <?php checked($is_offer_available,1);?> 
					name="<?php echo esc_attr( $this->prefix );?>is_offer_available" id="<?php echo esc_attr( $this->prefix );?>is_offer_available" value="1"> 
					<span class="description"><?php echo esc_html__('Check this for add offer.','kapee');?></span>
				</p>
				<div class="wc-metaboxes-wrapper" style="<?php echo esc_attr($wrapper_style);?>">
					<div id="kapee_offer_data_options" class="wc-metaboxes">
						<?php 
						foreach($offer_data  as $key => $data){
						$title = isset($data['title']) ? $data['title'] : '';
						$link_txt = isset($data['link_txt']) ? $data['link_txt'] : '';
						$desc = isset($data['desc']) ? $data['desc'] : '';	
						?>			
						<div class="kapee_offer_option wc-metabox closed">
							<h3>
								<a href="#" class="remove_row delete"><?php echo esc_html__('Remove','kapee');?></a>
								<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
								<strong class="attribute_name"><?php echo esc_html__('Best Offers','kapee');?></strong>
							</h3>
							<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
								<tbody>
									<tr>
										<td class="offer_label" width="33%">
											<label for="offer_title_<?php echo esc_attr($key);?>"><?php echo esc_html__( ' Offer title', 'kapee' ); ?></label>							
										</td>
										<td class="offer_label" width="33%">
											<label for="offer_text_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Link Text', 'kapee' ); ?></label>							
										</td>
										<td class="offer_label" width="33%">
											<label for="offer_detail_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Offer Detail', 'kapee' ); ?></label>							
										</td>							
									</tr>
									<tr>
										<td class="offer_field" width="33%">
											<input id="offer_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>offer[title][]" value="<?php echo esc_attr($title);?>">							
										</td>
										<td class="offer_field" width="33%">
											 <input id="offer_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>offer[link_txt][]" value="<?php echo esc_attr($link_txt);?>">								
										</td>
										<td class="offer_field" width="33%">
											<select id="offer_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $this->prefix );?>offer[desc][]">
												<option value=""><?php echo esc_html__('Select offer detail page','kapee');?></option>
												<?php if(!empty($custom_block)){
													foreach($custom_block as $post_id => $post_title){
													?>
													<option value="<?php echo esc_attr($post_id);?>" <?php selected($post_id,$desc);?>><?php echo esc_html($post_title);?></option>
													<?php
													}
													
												}?>
											</select>																
										</td>	
									</tr>
								</tbody>
							</table>				
						</div>
						<?php } ?>					
					</div>
					<div class="toolbar">								
						<button type="button" class="button add_new_offer_option button-primary"><?php echo  esc_html__( 'Add Offer', 'kapee' ); ?></button>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(function(){
					 jQuery('#_kp_is_offer_available').change(function() {
						 var _this = jQuery(this),
						 metabox_wrap = _this.closest('.options_group').find('.wc-metaboxes-wrapper');
						if(jQuery(this).is(":checked")) {							
							metabox_wrap.show(100);
						}else{
							metabox_wrap.hide(500);
						}
						 
					});
					jQuery('#general_product_data .wc-metaboxes-wrapper').on( 'click', '.add_new_offer_option', function() {
											
						var offer_key = jQuery('#kapee_offer_data_options .kapee_offer_option').size();
						
						var html = '<?php
							
							ob_start();

							$this->kapee_offer_fields();
						
							$html = ob_get_clean();
							
							echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
						
						?>';
						html = html.replace( /{key}/g, offer_key );
						
						jQuery('#kapee_offer_data_options').append( html );
					});
					
					jQuery('#kapee_offer_data_options').on( 'click', '.remove_row', function(e) {
							e.preventDefault();
							var conf = confirm('<?php echo esc_html__('Are you sure you want remove this option?', 'kapee'); ?>');

							if (conf) {
								
								var option = jQuery(this).closest('.kapee_offer_option');
								
								
								jQuery(option).fadeOut(300, function(){ jQuery(this).remove();});
								
							}

							return false;
					});
										
					jQuery('#kapee_offer_data_options').sortable({											
						items:'.kapee_offer_option',					
						cursor:'move',					
						axis:'y',					
						handle:'h3',					
						scrollSensitivity:50,					
						helper:function(e,ui){						
							return ui;						
						},					
						start:function(event,ui){						
							ui.item.css('border-style', 'dashed');						
						},					
						stop:function(event,ui){						
							ui.item.removeAttr('style');
						}					
					});
				});
			</script>
			<?php
		}
		
		/**
		 * Function to add offer field
		*/
		public function kapee_offer_fields() { 
			$key = '{key}';
			$custom_block = kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE);
		?>
			<div class="kapee_offer_option wc-metabox closed">
				<h3>
					<a href="#" class="remove_row delete"><?php echo esc_html__('Remove','kapee');?></a>
					<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
					<strong class="attribute_name"><?php echo esc_html__('Best Offers','kapee');?></strong>
				</h3>
				<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
					<tbody>
						<tr>
							<td class="offer_label" width="33%">
								<label for="offer_title_<?php echo esc_attr($key);?>"><?php echo esc_html__( ' Offer title', 'kapee' ); ?></label>							
							</td>
							<td class="offer_label" width="33%">
								<label for="offer_text_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Link Text', 'kapee' ); ?></label>							
							</td>
							<td class="offer_label" width="33%">
								<label for="offer_detail_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Offer Detail', 'kapee' ); ?></label>							
							</td>							
						</tr>
						<tr>
							<td class="offer_field" width="33%">
								<input id="offer_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>offer[title][]" value="">							
							</td>
							<td class="offer_field" width="33%">
								 <input id="offer_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>offer[link_txt][]" value="">								
							</td>
							<td class="offer_field" width="33%">
								<select id="offer_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $this->prefix );?>offer[desc][]">
											<option value=""><?php echo esc_html__('Select offer detail page','kapee');?></option>
											<?php if(!empty($custom_block)){
												foreach($custom_block as $post_id => $post_title){
												?>
												<option value="<?php echo esc_attr($post_id);?>"><?php echo esc_html($post_title);?></option>
												<?php
												}
												
											}?>
										</select>							
							</td>	
						</tr>
					</tbody>
				</table>				
			</div>
		<?php
		}
		
		/**
		 * Function to add service field for product
		*/
		public function kapee_product_service_field(){
			global $post;
			$post_id = $post->ID;
			$service_data = get_post_meta( $post_id, $this->prefix.'service',true);
			$is_offer_available = get_post_meta( $post_id, $this->prefix.'is_service_available',true);		
			if(empty($service_data)){
				$service_data = array( 0 => '');
			}
			$wrapper_style = 'display:none';
			if($is_offer_available){
				$wrapper_style = '';
			}
			$custom_block = kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE);
		?>	
			<div class="options_group serivce_group">
				<p class="form-field <?php echo esc_attr( $this->prefix );?>is_service_available_field ">
					<label for="<?php echo esc_attr( $this->prefix );?>is_service_available"><?php echo esc_html__('Is Service Available.','kapee');?></label>
					<input type="checkbox" class="checkbox" <?php checked($is_offer_available,1);?> 
					name="<?php echo esc_attr( $this->prefix );?>is_service_available" id="<?php echo esc_attr( $this->prefix );?>is_service_available" value="1"> 
					<span class="description"><?php echo esc_html__('Check this for add service.','kapee');?></span>
				</p>
				<div class="wc-metaboxes-wrapper service-metaboxes-wrapper" style="<?php echo esc_attr($wrapper_style);?>">
					<div id="kapee_service_data_options" class="wc-metaboxes">
						<?php 
						foreach($service_data  as $key => $data){
						$title = isset($data['title']) ? $data['title'] : '';
						$link_txt = isset($data['link_txt']) ? $data['link_txt'] : '';
						$desc = isset($data['desc']) ? $data['desc'] : '';	
						?>			
						<div class="kapee_service_option wc-metabox closed">
							<h3>
								<a href="#" class="remove_row delete"><?php echo esc_html__('Remove','kapee');?></a>
								<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
								<strong class="attribute_name"><?php echo esc_html__('Product Services','kapee');?></strong>
							</h3>
							<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
								<tbody>
									<tr>
										<td class="service_label" width="33%">
											<label for="service_title_<?php echo esc_attr($key);?>"><?php echo esc_html__( ' Service title', 'kapee' ); ?></label>							
										</td>
										<td class="service_label" width="33%">
											<label for="service_text_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Link Text', 'kapee' ); ?></label>							
										</td>
										<td class="service_label" width="33%">
											<label for="service_detail_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Service Detail', 'kapee' ); ?></label>							
										</td>							
									</tr>
									<tr>
										<td class="service_field" width="33%">
											<input id="service_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>service[title][]" value="<?php echo esc_attr($title);?>">							
										</td>
										<td class="service_field" width="33%">
											 <input id="service_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>service[link_txt][]" value="<?php echo esc_attr($link_txt);?>">								
										</td>
										<td class="service_field" width="33%">
											<select id="service_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $this->prefix );?>service[desc][]">
												<option value=""><?php echo esc_html__('Select service detail page','kapee');?></option>
												<?php if(!empty($custom_block)){
													foreach($custom_block as $post_id => $post_title){
													?>
													<option value="<?php echo esc_attr($post_id);?>" <?php selected($post_id,$desc);?>><?php echo esc_html($post_title);?></option>
													<?php
													}
													
												}?>
											</select>																
										</td>	
									</tr>
								</tbody>
							</table>				
						</div>
						<?php } ?>					
					</div>
					<div class="toolbar">								
						<button type="button" class="button add_new_service_option button-primary"><?php echo  esc_html__( 'Add Service', 'kapee' ); ?></button>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(function(){
					 jQuery('#_kp_is_service_available').change(function() {
						 var _this = jQuery(this),
						 metabox_wrap = _this.closest('.options_group').find('.wc-metaboxes-wrapper');
						if(jQuery(this).is(":checked")) {							
							metabox_wrap.show(100);
						}else{
							metabox_wrap.hide(500);
						}
						 
					});
					jQuery('#general_product_data .service-metaboxes-wrapper').on( 'click', '.add_new_service_option', function() {
											
						var service_key = jQuery('#kapee_service_data_options .kapee_service_option').size();
						
						var html = '<?php
							
							ob_start();

							$this->kapee_service_fields();
						
							$html = ob_get_clean();
							
							echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
						
						?>';
						html = html.replace( /{key}/g, service_key );
						
						jQuery('#kapee_service_data_options').append( html );
					});
					
					jQuery('#kapee_service_data_options').on( 'click', '.remove_row', function(e) {
							e.preventDefault();
							var conf = confirm('<?php echo esc_html__('Are you sure you want remove this option?', 'kapee'); ?>');

							if (conf) {
								
								var option = jQuery(this).closest('.kapee_service_option');
								
								
								jQuery(option).fadeOut(300, function(){ jQuery(this).remove();});
								
							}

							return false;
					});
										
					jQuery('#kapee_service_data_options').sortable({											
						items:'.kapee_service_option',					
						cursor:'move',					
						axis:'y',					
						handle:'h3',					
						scrollSensitivity:50,					
						helper:function(e,ui){						
							return ui;						
						},					
						start:function(event,ui){						
							ui.item.css('border-style', 'dashed');						
						},					
						stop:function(event,ui){						
							ui.item.removeAttr('style');
						}					
					});
				});
			</script>
			<?php
		}
		
		/**
		 * Function to add service field
		*/
		public function kapee_service_fields() { 
			$key = '{key}';
			$custom_block = kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE);
		?>
			<div class="kapee_service_option wc-metabox closed">
				<h3>
					<a href="#" class="remove_row delete"><?php echo esc_html__('Remove','kapee');?></a>
					<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
					<strong class="attribute_name"><?php echo esc_html__('Product Services','kapee');?></strong>
				</h3>
				<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
					<tbody>
						<tr>
							<td class="service_label" width="33%">
								<label for="service_title_<?php echo esc_attr($key);?>"><?php echo esc_html__( ' Serivce title', 'kapee' ); ?></label>							
							</td>
							<td class="service_label" width="33%">
								<label for="service_text_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Link Text', 'kapee' ); ?></label>							
							</td>
							<td class="service_label" width="33%">
								<label for="service_detail_<?php echo esc_attr($key);?>"><?php echo esc_html__( 'Service Detail', 'kapee' ); ?></label>							
							</td>							
						</tr>
						<tr>
							<td class="service_field" width="33%">
								<input id="service_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>service[title][]" value="">							
							</td>
							<td class="service_field" width="33%">
								 <input id="service_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $this->prefix );?>service[link_txt][]" value="">								
							</td>
							<td class="service_field" width="33%">
								<select id="service_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $this->prefix );?>service[desc][]">
											<option value=""><?php echo esc_html__('Select service detail page','kapee');?></option>
											<?php if(!empty($custom_block)){
												foreach($custom_block as $post_id => $post_title){
												?>
												<option value="<?php echo esc_attr($post_id);?>"><?php echo esc_html($post_title);?></option>
												<?php
												}
												
											}?>
										</select>							
							</td>	
						</tr>
					</tbody>
				</table>				
			</div>
		<?php
		}
		
		/**
		 * Function to save offer field for product
		*/		
		public function kapee_save_product_offer_field($post_id){
			//var_dump($_POST['_kp_offer']);
			if(isset($_POST[$this->prefix.'is_offer_available'])){
				update_post_meta( $post_id, $this->prefix.'is_offer_available', 1 );	
			}else{
				update_post_meta( $post_id, $this->prefix.'is_offer_available', 0 );	
			}
			
			if(isset($_POST[$this->prefix.'offer'])){
				$output = array();
				$offers = $_POST[$this->prefix.'offer'];
				foreach($offers['title'] as $key => $title){
					$output[$key] = array(
						'title' => $title,
						'link_txt'=>$offers['link_txt'][$key],
						'desc'=>$offers['desc'][$key],
					);
					
				}
				update_post_meta( $post_id, $this->prefix.'offer', $output );			
			}	
			
		}
		
		/**
		 * Function to save service field for product
		*/		
		public function kapee_save_product_service_field($post_id){
			//var_dump($_POST['_kp_offer']);
			if(isset($_POST[$this->prefix.'is_service_available'])){
				update_post_meta( $post_id, $this->prefix.'is_service_available', 1 );	
			}else{
				update_post_meta( $post_id, $this->prefix.'is_service_available', 0 );	
			}
			
			if(isset($_POST[$this->prefix.'service'])){
				$output = array();
				$offers = $_POST[$this->prefix.'service'];
				foreach($offers['title'] as $key => $title){
					$output[$key] = array(
						'title' => $title,
						'link_txt'=>$offers['link_txt'][$key],
						'desc'=>$offers['desc'][$key],
					);
					
				}
				update_post_meta( $post_id, $this->prefix.'service', $output );			
			}
		}
		/**
		 * Category thumbnail fields.
		 */
		function add_category_fields() {
			$prefix = $this->prefix; // Taking metabox prefix
			?>
			<div class="form-field">
				<label for="kapee-image"><?php echo esc_html__('Header Banner', 'kapee'); ?></label>
				<input type="hidden" class="kapee-attachment-id" name="<?php echo esc_attr( $prefix );?>kapee_attachment_id">
				<img class="kapee-attr-img" src="<?php echo esc_url( wc_placeholder_img_src() );?>" alt="<?php echo esc_attr__('Select Image','kapee')?>" height="50px" width="50px">
				<button class="kapee-image-upload button" type="button"><?php echo esc_html__('Upload/Add Images','kapee');?></button>
				<button class="kapee-image-clear button" type="button" data-src="<?php echo esc_url( wc_placeholder_img_src() );?>"><?php esc_html_e('Remove image','kapee');?></button>
				 <p class="description"><?php esc_html_e('Upload banner for this category.', 'kapee'); ?></p>
			</div>
			<div class="form-field">
				<label><?php esc_html_e( 'Title Color', 'kapee' ); ?></label>           
				<select id="kp-sidebar" name="<?php echo esc_attr( $prefix );?>sidebar_title_color">
					<option value="default"><?php echo esc_html__( 'Default', 'kapee'  ); ?></option>						
					<option value="light"><?php echo esc_html__( 'Light', 'kapee'  ); ?></option>						
					<option value="dark"><?php echo esc_html__( 'Dark', 'kapee'  ); ?></option>						
				</select>           
			</div>
			<div class="form-field">
				<label><?php esc_html_e( 'Sidebar', 'kapee' ); ?></label>           
				<select id="kp-sidebar" name="<?php echo esc_attr( $prefix );?>sidebar">
					<?php
					foreach ( $this->cat_sidebars as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>           
			</div>
			<script>
				jQuery( document ).ajaxComplete( function( event, request, options ) {
					if ( request && 4 === request.readyState && 200 === request.status
						&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

						var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
						if ( ! res || res.errors ) {
							return;
						}
						// Clear Thumbnail fields on submit
						jQuery( '.kapee-attr-img').attr( 'src', '<?php echo esc_url(wc_placeholder_img_src()); ?>' );
						jQuery( '.kapee-attachment-id' ).val( '' );
						jQuery( '#kp-sidebar' ).val( '' );
						return;
					}
				} );
			</script>
			<?php
		}
		/**
		 * Edit category thumbnail field.
		 *
		 * @param mixed $term Term (category) being edited
		 */
		function edit_category_fields( $term ) {
			$prefix = $this->prefix; // Taking metabox prefix
			$kapee_attachment_id = get_term_meta( $term->term_id, $prefix.'kapee_attachment_id', true );
			$sidebar = get_term_meta( $term->term_id, $prefix.'sidebar', true );
			$sidebar_title_color = get_term_meta( $term->term_id, $prefix.'sidebar_title_color', true );
			$image = wc_placeholder_img_src();
			if(!empty($kapee_attachment_id)){
				$image = kapee_get_image_src( $kapee_attachment_id,'thumnail');
			}	
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="kapee-attr-image"><?php esc_html_e('Header Banner', 'kapee'); ?></label></label></th>
				<td>
					<input type="hidden" class="kapee-attachment-id" value="<?php echo esc_attr($kapee_attachment_id);?>" name="<?php echo esc_attr( $prefix );?>kapee_attachment_id">
					<img class="kapee-attr-img" src="<?php echo esc_url($image);?>" alt="<?php esc_attr_e('Select Image','kapee')?>" height="50px" width="50px">
					<button class="kapee-image-upload button" type="button"><?php esc_html_e('Upload/Add image','kapee');?></button>
					<button class="kapee-image-clear button" type="button" data-src="<?php echo wc_placeholder_img_src();?>"><?php esc_html_e('Remove image','kapee');?></button>
					<p class="description"><?php esc_html_e('Upload image for this value.', 'kapee'); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Title Color', 'kapee' ); ?></label></th>
				<td>
					<select id="kp-title-color" name="<?php echo esc_attr( $prefix );?>sidebar_title_color">
						<option value="default" <?php selected('default',$sidebar_title_color);?>><?php echo esc_html__( 'Default', 'kapee'  ); ?></option>						
						<option value="light" <?php selected('light',$sidebar_title_color);?>><?php echo esc_html__( 'Light', 'kapee'  ); ?></option>						
						<option value="dark" <?php selected('dark',$sidebar_title_color);?>><?php echo esc_html__( 'Dark', 'kapee'  ); ?></option>		
					</select>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Sidebar', 'kapee' ); ?></label></th>
				<td>
					<select id="kp-sidebar" name="<?php echo esc_attr( $prefix );?>sidebar">
						<?php
						foreach ( $this->cat_sidebars as $key => $value ) {
							$selected = ( $key == $sidebar ) ? 'selected=selected' : '';
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $value ); ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<?php
		}
		
		/**
		 * save_category_fields function.
		 *
		 * @param mixed $term_id Term ID being saved
		 */
		function save_category_fields( $term_id ) {

			$prefix = $this->prefix; // Taking metabox prefix

			$kapee_attachment_id = !empty($_POST[$prefix.'kapee_attachment_id']) ? $_POST[$prefix.'kapee_attachment_id'] : '';
			$sidebar = !empty($_POST[$prefix.'sidebar']) ? $_POST[$prefix.'sidebar'] : '';
			$sidebar_title_color = !empty($_POST[$prefix.'sidebar_title_color']) ? $_POST[$prefix.'sidebar_title_color'] : '';

			update_term_meta($term_id, $prefix.'kapee_attachment_id', $kapee_attachment_id);
			update_term_meta($term_id, $prefix.'sidebar', $sidebar);
			update_term_meta($term_id, $prefix.'sidebar_title_color', $sidebar_title_color);
		}
		
		function clear_swatches_cache_save_post($post_id){
			if ( ! apply_filters( 'kapee_has_swatches_cache', true ) ) {
				return;
			}
			$transient_name     = 'kapee_swatches_cache_' . $post_id;
			delete_transient( $transient_name );
		}
		
		function clear_swatches_cache_product_object_save($product){
			if ( ! apply_filters( 'kapee_has_swatches_cache', true ) ) {
				return;
			}
			$post_id = $product->get_id();
			$transient_name     = 'kapee_swatches_cache_' . $post_id;
			delete_transient( $transient_name );
		}
	}
	function kapee_woocommerce_class_init(){
		$obj_kp_swatches = new Kapee_Woocommerce();
	}
	add_action( 'init', 'kapee_woocommerce_class_init');
	
}