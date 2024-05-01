<?php

/**
 * WCFM Functions
 *
 * @since  1.0
 */

add_filter( 'end_wcfm_products_manage',  'kapee_wcfm_product_manage_offer_service' , 160 );
add_filter( 'end_wcfm_products_manage',  'kapee_wcfm_product_manage_frequently' , 160 );
add_action( 'after_wcfm_products_manage_meta_save',  'kapee_wcfm_product_meta_save', 500, 2 );
add_filter( 'wcfmmp_is_allow_sold_by_review', '__return_false', 10 );

if ( ! function_exists( 'kapee_wcfm_sidebar_args' ) ) :
add_filter( 'wcfmmp_store_sidebar_args', 'kapee_wcfm_sidebar_args' );
add_filter( 'wcfmmp_store_lists_sidebar_args', 'kapee_wcfm_sidebar_args' );
function kapee_wcfm_sidebar_args( $args ){
	$args['before_title'] = '<h2 class="widget-title">';
	$args['after_title'] = '</h2>';
	return $args;
}
endif;

global $WCFM, $WCFMmp;
$kapee_wcfm_shipping = $WCFMmp->wcfmmp_shipping;
remove_action( 'woocommerce_single_product_summary',	array( &$kapee_wcfm_shipping, 'wcfmmp_shipping_info' ), 32 ); 
add_action( 'woocommerce_single_product_summary',	array( &$kapee_wcfm_shipping, 'wcfmmp_shipping_info' ), 35 );

function kapee_wcfm_product_manage_offer_service() {
	if( !apply_filters( 'kapee_enable_offer_service_field' , true ) ) {
		return;
	}
	global $wp, $WCFM;
	$prefix 		= KAPEE_PREFIX;	
	$product_id 	= 0;
	if( isset( $wp->query_vars['wcfm-products-manage'] ) && !empty( $wp->query_vars['wcfm-products-manage'] ) ) {
		$product_id = absint( $wp->query_vars['wcfm-products-manage'] );
	} ?>
	
	<div class="page_collapsible products_manage_wc_product_kapee_offer simple variable" id="wcfm_products_manage_form_wc_product_kapee_offer_head">
		<label class="wcfm pls-present"></label><?php esc_html_e('Offers/Services', 'kapee'); ?><span></span>
	</div>
	<div class="wcfm-container simple variable">
		<div id="wcfm_products_manage_form_wc_product_kapee_offer_expander" class="wcfm-content">
			<?php
			$offer_data 			= get_post_meta( $product_id, $prefix.'offer',true);
			$is_offer_available 	= get_post_meta( $product_id, $prefix.'is_offer_available',true);		
			if( empty( $offer_data ) ){
				$offer_data = array( 0 => '');
			}
			
			$wrapper_style 			= 'display:none';
			if( $is_offer_available ){
				$wrapper_style = '';
			}
			
			$service_data 			= get_post_meta( $product_id, $prefix.'service',true);
			$is_service_available 	= get_post_meta( $product_id, $prefix.'is_service_available',true);		
			if(empty($service_data)){
				$service_data = array( 0 => '');
			}
			
			$service_wrapper_style 	= 'display:none';
			if($is_service_available){
				$service_wrapper_style = '';
			}
			
			$custom_block = kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE); 
			?>	
			<div class="options_group offer_group">				
				<?php 
				$WCFM->wcfm_fields->wcfm_generate_form_field( array(
					$prefix.'is_offer_available' =>  array('label' => __( 'Is Offer Available.', 'kapee' ), 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele simple variable external ', 'label_class' => 'wcfm_ele checkbox_title wcfm_title simple variable', 'value' => 1,'dfvalue' => $is_offer_available),
				) );
				?>
				<div class="wc-metaboxes-wrapper" style="<?php echo esc_attr($wrapper_style);?>">
					<div id="kapee_offer_data_options" class="wc-metaboxes">
						<?php 
						foreach($offer_data  as $key => $data){
						$title = isset($data['title']) ? $data['title'] : '';
						$link_txt = isset($data['link_txt']) ? $data['link_txt'] : '';
						$desc = isset($data['desc']) ? $data['desc'] : '';	
						?>			
						<div class="kapee_offer_option wc-metabox closed">
							<div class="wcfm-block-head">
								<span class="remove_row delete wcfm pls-close-circle"></span>
								<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
								<strong class="attribute_name"><?php echo esc_html__('Best Offers','kapee');?></strong>
							</div>
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
											<input id="offer_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>offer[title][]" value="<?php echo esc_attr($title);?>">							
										</td>
										<td class="offer_field" width="33%">
											 <input id="offer_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>offer[link_txt][]" value="<?php echo esc_attr($link_txt);?>">								
										</td>
										<td class="offer_field" width="33%">
											<select id="offer_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $prefix );?>offer[desc][]">
												<option value=""><?php echo esc_html__('Select offer detail page','kapee');?></option>
												<?php if( ! empty( $custom_block )  ){
													foreach( $custom_block as $post_id => $post_title ){ ?>
														<option value="<?php echo esc_attr($post_id);?>" <?php selected($post_id,$desc);?>><?php echo esc_html($post_title);?></option>
													<?php }													
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
		
			<div class="options_group serivce_group">
				
				<?php 
				$WCFM->wcfm_fields->wcfm_generate_form_field( array(
					$prefix.'is_service_available' =>  array('label' => __( 'Is Serivce Available.', 'kapee' ), 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele simple variable external ', 'label_class' => 'wcfm_ele checkbox_title wcfm_title simple variable', 'value' => 1,'dfvalue' => $is_service_available),
				) );
				?>
				
				<div class="wc-metaboxes-wrapper service-metaboxes-wrapper" style="<?php echo esc_attr($service_wrapper_style);?>">
					<div id="kapee_service_data_options" class="wc-metaboxes">
						<?php 
						foreach( $service_data  as $key => $data ){
						$title = isset($data['title']) ? $data['title'] : '';
						$link_txt = isset($data['link_txt']) ? $data['link_txt'] : '';
						$desc = isset($data['desc']) ? $data['desc'] : '';	
						?>			
						<div class="kapee_service_option wc-metabox closed">
							<div class="wcfm-block-head">
								<span class="remove_row delete wcfm pls-close-circle"></span>
								<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
								<strong class="attribute_name"><?php echo esc_html__('Product Services','kapee');?></strong>
							</div>
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
											<input id="service_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr($prefix );?>service[title][]" value="<?php echo esc_attr($title);?>">							
										</td>
										<td class="service_field" width="33%">
											 <input id="service_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr($prefix );?>service[link_txt][]" value="<?php echo esc_attr($link_txt);?>">								
										</td>
										<td class="service_field" width="33%">
											<select id="service_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr($prefix );?>service[desc][]">
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
		</div>
	</div>
		
	<script type="text/javascript">
		jQuery(function(){
			 jQuery('#_kp_is_offer_available').change(function() {
				 var _this = $(this),
				 metabox_wrap = _this.closest('.options_group').find('.wc-metaboxes-wrapper');
				if($(this).is(":checked")) {							
					metabox_wrap.show(100);
				}else{
					metabox_wrap.hide(500);
				}
				 
			});
			jQuery('#wcfm_products_manage_form_wc_product_kapee_offer_expander .wc-metaboxes-wrapper').on( 'click', '.add_new_offer_option', function() {
									
				var offer_key = jQuery('#kapee_offer_data_options .kapee_offer_option').size();
				
				var html = '<?php
					
					ob_start();

					kapee_wcfm_offer_fields();
				
					$html = ob_get_clean();
					
					echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
				
				?>';
				html = html.replace( /{key}/g, offer_key );
				
				jQuery('#kapee_offer_data_options').append( html );
				resetCollapsHeight($('#wcfm_products_manage_form_wc_product_kapee_offer_expander'));
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
			
	<script type="text/javascript">
		jQuery(function(){
			 jQuery('#_kp_is_service_available').change(function() {
				 var _this = $(this),
				 metabox_wrap = _this.closest('.options_group').find('.wc-metaboxes-wrapper');
				if($(this).is(":checked")) {							
					metabox_wrap.show(100);
				}else{
					metabox_wrap.hide(500);
				}
				 
			});
			jQuery('#wcfm_products_manage_form_wc_product_kapee_offer_expander .service-metaboxes-wrapper').on( 'click', '.add_new_service_option', function() {
									
				var service_key = jQuery('#kapee_service_data_options .kapee_service_option').size();
				
				var html = '<?php
					
					ob_start();

					kapee_wcfm_service_fields();
				
					$html = ob_get_clean();
					
					echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
				
				?>';
				html = html.replace( /{key}/g, service_key );
				
				jQuery('#kapee_service_data_options').append( html );
				resetCollapsHeight($('#wcfm_products_manage_form_wc_product_kapee_offer_expander'));
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
 * Function to add offer field
*/
function kapee_wcfm_offer_fields() {
	$prefix 		= KAPEE_PREFIX;
	$key 			= '{key}';
	$custom_block 	= kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE); ?>
	
	<div class="kapee_offer_option wc-metabox closed">
		<div class="wcfm-block-head">
			<span class="remove_row delete wcfm pls-close-circle"></span>
			<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
			<strong class="attribute_name"><?php echo esc_html__('Best Offers','kapee');?></strong>
		</div>
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
						<input id="offer_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>offer[title][]" value="">							
					</td>
					<td class="offer_field" width="33%">
						 <input id="offer_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>offer[link_txt][]" value="">								
					</td>
					<td class="offer_field" width="33%">
						<select id="offer_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $prefix );?>offer[desc][]">
							<option value=""><?php echo esc_html__('Select offer detail page','kapee');?></option>
							<?php if( ! empty( $custom_block ) ){
								foreach( $custom_block as $post_id => $post_title ){ ?>
									<option value="<?php echo esc_attr($post_id);?>"><?php echo esc_html($post_title);?></option>
								<?php }
							}?>
						</select>							
					</td>	
				</tr>
			</tbody>
		</table>				
	</div>
	<?php
}

function kapee_wcfm_service_fields() { 
	$prefix 		= KAPEE_PREFIX;
	$key 			= '{key}';
	$custom_block 	= kapee_get_posts_by_post_type(KAPEE_EXTENSIONS_BLOCK_POST_TYPE); ?>
	
	<div class="kapee_service_option wc-metabox closed">
		<div class="wcfm-block-head">
			<span class="remove_row delete wcfm pls-close-circle"></span>
			<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle' , 'kapee'); ?>"></div>
			<strong class="attribute_name"><?php echo esc_html__('Product Services','kapee');?></strong>
		</div>
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
						<input id="service_title_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>service[title][]" value="">							
					</td>
					<td class="service_field" width="33%">
						 <input id="service_text_<?php echo esc_attr($key);?>" type="text" name="<?php echo esc_attr( $prefix );?>service[link_txt][]" value="">								
					</td>
					<td class="service_field" width="33%">
						<select id="service_detail_<?php echo esc_attr($key);?>" name="<?php echo esc_attr( $prefix );?>service[desc][]">
							<option value=""><?php echo esc_html__('Select service detail page','kapee');?></option>
							<?php if( ! empty( $custom_block ) ){
								foreach( $custom_block as $post_id => $post_title ){ ?>
									<option value="<?php echo esc_attr($post_id);?>"><?php echo esc_html($post_title);?></option>
								<?php }
							}?>
						</select>							
					</td>	
				</tr>
			</tbody>
		</table>				
	</div>
	<?php
}
		
function kapee_wcfm_product_manage_frequently() {
	if( !apply_filters( 'kapee_enable_frequently_bought_together' , true ) ) {
		return;
	}
	
	$bought_together = kapee_get_option( 'single-product-bought-together', 1 );
	if(!$bought_together){
		return;
	}
	global $wp, $WCFM;
	$prefix 		= KAPEE_PREFIX;	
	$product_id 	= 0;
	if( isset( $wp->query_vars['wcfm-products-manage'] ) && !empty( $wp->query_vars['wcfm-products-manage'] ) ) {
		$product_id = absint( $wp->query_vars['wcfm-products-manage'] );
	} ?>
	
	<div class="page_collapsible products_manage_wc_product_kapee_fbt simple variable" id="wcfm_products_manage_form_wc_product_kapee_fbt_head">
		<label class="wcfm pls-docs"></label><?php esc_html_e('Frequently Bought Together', 'kapee'); ?><span></span>
	</div>
	<div class="wcfm-container simple variable">
		<div id="wcfm_products_manage_form_wc_product_kapee_fbt_expander" class="wcfm-content">
			<?php 
			$products_array 	= array();
			$pbt_product_ids 	= get_post_meta( $product_id,$prefix.'product_ids', true );	
			$pbt_product_ids 	= $pbt_product_ids ? $pbt_product_ids : array();
			
			if ( ! empty( $pbt_product_ids ) ) {
				foreach ( $pbt_product_ids as $pbt_product_id ) {
					$products_array[ $pbt_product_id ] = get_post( absint( $pbt_product_id ) )->post_title;
				}
			}
			
			$WCFM->wcfm_fields->wcfm_generate_form_field( array(
				$prefix.'product_ids' => array(
					'label'       => esc_html__( 'Frequently Bought Together', 'kapee' ),
					'type'        => 'select',
					'attributes'  => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ),
					'class'       => 'wcfm-select wcfm_ele simple variable',
					'label_class' => 'wcfm_title',
					'options'     => $products_array,
					'value'       => $pbt_product_ids,
				)
			) ); 
			?>
		</div>
	</div>
	<?php
}

function kapee_wcfm_product_meta_save( $post_id, $wcfm_products_manage_form_data ) {
	$prefix 			= KAPEE_PREFIX;
	$pbt_product_ids 	= ( isset( $wcfm_products_manage_form_data[$prefix.'product_ids'] ) ) ? array_map( 'intval', (array) $wcfm_products_manage_form_data[$prefix.'product_ids'] ) : array();
	update_post_meta( $post_id, $prefix.'product_ids', $pbt_product_ids );
	
	if( isset( $wcfm_products_manage_form_data[$prefix.'is_offer_available'] ) ) {
		update_post_meta( $post_id, $prefix.'is_offer_available', 1 );	
	} else {
		update_post_meta( $post_id, $prefix.'is_offer_available', 0 );	
	}
	
	if( isset( $wcfm_products_manage_form_data[$prefix.'offer'] ) ) {
		$output = array();
		$offers = $wcfm_products_manage_form_data[$prefix.'offer'];
		foreach($offers['title'] as $key => $title){
			$output[$key] = array(
				'title' => $title,
				'link_txt'=>$offers['link_txt'][$key],
				'desc'=>$offers['desc'][$key],
			); 
		}
		update_post_meta( $post_id, $prefix.'offer', $output );			
	}
	
	if( isset( $wcfm_products_manage_form_data[$prefix.'is_service_available'] ) ) {
		update_post_meta( $post_id, $prefix.'is_service_available', 1 );	
	} else {
		update_post_meta( $post_id, $prefix.'is_service_available', 0 );	
	}
	
	if( isset( $wcfm_products_manage_form_data[$prefix.'service'] ) ) {
		$output = array();
		$offers = $wcfm_products_manage_form_data[$prefix.'service'];
		foreach($offers['title'] as $key => $title){
			$output[$key] = array(
				'title' => $title,
				'link_txt'=>$offers['link_txt'][$key],
				'desc'=>$offers['desc'][$key],
			); 
		}
		update_post_meta( $post_id, $prefix.'service', $output );			
	} 
}

add_action('init','kapee_wcfm_hook');

function kapee_wcfm_hook(){
	add_filter( 'wcfmmp_is_allow_archive_product_sold_by', '__return_false' );
	$sold_by_template = kapee_get_option('vendor-sold-by-template','theme');
	if( $sold_by_template == 'theme' ) {
		add_filter( 'wcfmmp_is_allow_single_product_sold_by', '__return_false' );
		add_action( 'kapee_shop_loop_item_title', 'kapee_wcfm_loop_sold_by_label', 21 );
		add_action( 'woocommerce_single_product_summary', 'kapee_wcfm_item_sold_by_label',8 );
	}
}

function kapee_wcfm_loop_sold_by_label(){	
	$sold_by_loop = kapee_get_option( 'enable-sold-by-in-loop' , 1 );
	if( !$sold_by_loop ) { return false; }
	kapee_get_wcfm_vendor_name();	
}

function kapee_wcfm_item_sold_by_label(){
	$sold_by_single = kapee_get_option( 'enable-sold-by-in-single' , 1 );
	if( !$sold_by_single ) { return false; }
	kapee_get_wcfm_vendor_name();	
}

function kapee_get_wcfm_vendor_name(){
	
	global $WCFM, $post;

	$vendor_id 		= $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );

	if ( ! $vendor_id ) {
		return;
	}

	$shop_name   	= $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint( $vendor_id ) );
	
	$store_user     = wcfmmp_get_store( $vendor_id );
	$store_info     = $store_user->get_shop_info();
	$store_name     = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : esc_html__( 'N/A', 'kapee' );
	$store_name     = apply_filters( 'wcfmmp_store_title', $store_name , $vendor_id );
	$store_url      = wcfmmp_get_store_url( $vendor_id );
	$sold_by_label	= apply_filters('wcfmmp_sold_by_label',esc_html__( 'Sold By : ', 'kapee' ));
	?>
	<div class="sold-by">
		<span class="sold-by-label"><?php echo esc_html( $sold_by_label ); ?> </span>
		<a href="<?php echo esc_url(  $store_url  ); ?>"><?php echo esc_html( $store_name ); ?></a>
	</div>
	<?php	
}