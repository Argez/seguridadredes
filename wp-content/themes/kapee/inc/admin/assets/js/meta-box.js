(function($){
    "use strict";
	//console.log(kp_meta_box_title);
	//console.log(kp_meta_box_title[0]);
    var KapeeMetabox = {
        initialize: function() {
            KapeeMetabox.meta_box_tab();
            KapeeMetabox.required_field();
            KapeeMetabox.widget_select2_process();
        },
        meta_box_tab: function() {
           
			var tabBoxes 			= jQuery(kp_meta_box_ids[0]),
			normal_wrap 			= jQuery('#normal-sortables'),
			visual_composer 		= normal_wrap.find('#wpb_wpbakery'),
			product_data 			= normal_wrap.find('#woocommerce-product-data'),
			kp_metabox_wrap_html 	= '<div class="kp-meta-tabs-wrap postbox"><div class="postbox-header"><h2 class="hndle ui-sortable-handle">'+ kp_meta_box_title[0] +'</h2><div class="handle-actions hide-if-no-js"><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Kapee Options</span><span class="toggle-indicator" aria-hidden="true"></span></button></div></div><div id="kp-tabbed-meta-boxes"></div></div>';
			;
			var meta_boxes = kp_meta_box_ids[0].split(",");
			var metabox_exist = false;
			for (var i = 0; i < meta_boxes.length; i++ ) {
               	if($(meta_boxes[i]).length > 0){
					metabox_exist = true;
				}
            }
			if(!metabox_exist){
				return false;
			}
			if(product_data.length > 0){
				product_data.after(kp_metabox_wrap_html);
			}
			else if(visual_composer.length > 0){
				visual_composer.after(kp_metabox_wrap_html);
			}else{
				 jQuery('#normal-sortables').prepend(kp_metabox_wrap_html);
			}
			jQuery(tabBoxes).appendTo('#kp-tabbed-meta-boxes');
            jQuery(tabBoxes).hide().removeClass('hide-if-no-js');

            for (var a = 0, b = tabBoxes.length; a < b; a++ ) {
                var newClass = 'editor-tab' + a;
                jQuery(tabBoxes[a]).addClass(newClass);
            }

            var menu_html 		= '<ul id="kp-meta-box-tabs" class="clearfix">\n';
            var total_hidden 	= 0;
            for (var i = 0, n = tabBoxes.length; i < n; i++ ) {
                var target_id 	= jQuery(tabBoxes[i]).attr('id');
                var tab_name 	= jQuery(tabBoxes[i]).find('.hndle').text();
                var tab_class 	= "";

                if (jQuery(tabBoxes[i]).hasClass('hide-if-js')) {
                    total_hidden++;
                }

                menu_html = menu_html + '\n<li id="li'+ target_id +'" class="'+tab_class+'"><a href="javascript:void(0);" rel="editor-tab' + i + '">' + tab_name + '</a></li>';
            }
            menu_html = menu_html + '\n</ul>';

            jQuery('#kp-tabbed-meta-boxes').before(menu_html);
            jQuery('#kp-meta-box-tabs a:first').addClass('active');

            jQuery('.editor-tab0').addClass('active').show();

            jQuery('.kp-meta-tabs-wrap').on('click', '.handlediv', function() {
                var metaBoxWrap = jQuery(this).parent();
                if (metaBoxWrap.hasClass('closed')) {
                    metaBoxWrap.removeClass('closed');
                } else {
                    metaBoxWrap.addClass('closed');
                }
            });

            jQuery('#kp-meta-box-tabs li').on('click', 'a', function(event) {
				event.preventDefault();
                jQuery(tabBoxes).removeClass('active').hide();
                jQuery('#kp-meta-box-tabs a').removeClass('active');

                var target = jQuery(this).attr('rel');

                jQuery(this).addClass('active');
                jQuery('.' + target).addClass('active').show();
            });
        },
        required_field: function() {
            var ref_arr = [];
            $('[data-required-ref]').each(function () {
                var $this = $(this);
                var data_ref = $this.attr('data-required-ref');
                var data_op = $this.attr('data-required-operator');
                var data_val = $this.attr('data-required-value');
                var data_val_arr = data_val.split(',');				
                if ($('#' + data_ref).is(':checkbox')) {
                    if ($('#' + data_ref).prop('checked')) {
                        ref_arr[data_ref] = $('#' + data_ref).val();
                    }
                    else {
                        ref_arr[data_ref] = '0';
                    }
                }else if($('#' + data_ref).is(':radio')){
					
					if ($('#' + data_ref).prop('checked')) { 
						ref_arr[data_ref] = $('#' + data_ref).val();
                    }
                    else {
                        ref_arr[data_ref] = '0';
                    }
				}
                else {
                    ref_arr[data_ref] = $('#' + data_ref).val();
                }

                if (((data_val_arr.indexOf(ref_arr[data_ref]) != -1) && (data_op == '='))
                    || ((data_val_arr.indexOf(ref_arr[data_ref]) == -1) && (data_op == '<>'))) {
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
            });
            for (var field_ref in ref_arr) {
                $('#' + field_ref).change(function() {
                    var $this_ref = $(this);
                    var this_field_ref = $(this).attr('id');
                    var ref_val = '';
                    if ($this_ref.is(':checkbox')) {
                        if ($this_ref.prop('checked')) {
                            ref_val = $this_ref.val();
                        }
                        else {
                            ref_val = '0';
                        }
                    }else if($this_ref.is(':radio')){
						if ($this_ref.prop('checked')) {
                            ref_val = $this_ref.val();
                        }
                        else {
                            ref_val = '0';
                        }
					}
                    else {
                        ref_val = $this_ref.val();
                    }

                    $('[data-required-ref="' + this_field_ref + '"]').each(function(){
                        var $this = $(this);
                        var data_op = $this.attr('data-required-operator');
                        var data_val = $this.attr('data-required-value');
                        var data_val_arr = data_val.split(',');

                        if (((data_val_arr.indexOf(ref_val) != -1) && (data_op == '='))
                            || ((data_val_arr.indexOf(ref_val) == -1) && (data_op == '<>'))) {
                            $(this).slideDown();
                        }
                        else {
                            $(this).slideUp();
                        }
                    });
                });
            }
        },
        widget_select2: function(event, widget) {
            if (typeof (widget) == "undefined") {
                $('#widgets-right select.widget-select2:not(.select2-ready)').each(function(){
                    KapeeMetabox.widget_select2_item(this);
                });
            }
            else {
                $('select.widget-select2:not(.select2-ready)', widget).each(function(){
                    KapeeMetabox.widget_select2_item(this);
                });
            }
        },
        widget_select2_item: function(target){
            $(target).addClass('select2-ready');

            var data_value = $(target).attr('data-value');

            var choices = [];

            if (data_value != '') {
                var arr_data_value = data_value.split('||');

                for (var i = 0; i < arr_data_value.length; i++) {
                    var option = $('option[value='+ arr_data_value[i]  + ']', target);
                    choices[i] = { 'id':arr_data_value[i], 'text':option.text()};
                }

            }
            $(target).select2().select2('data', choices);
            $(target).on("select2-selecting", function(e) {
                var ids = $('input',$(this).parent()).val();
                if (ids != "") {
                    ids +="||";
                }
                ids += e.val;
                $('input',$(this).parent()).val(ids);
            }).on("select2-removed", function(e) {
                    var ids = $('input',$(this).parent()).val();
                    var arr_ids = ids.split("||");
                    var newIds = "";
                    for(var i = 0 ; i < arr_ids.length; i++) {
                        if (arr_ids[i] != e.val){
                            if (newIds != "") {
                                newIds +="||";
                            }
                            newIds += arr_ids[i];
                        }
                    }
                    $('input',$(this).parent()).val(newIds);
                });
        },
        widget_select2_process: function() {
            $(document).on('widget-added', KapeeMetabox.widget_select2);
            $(document).on('widget-updated', KapeeMetabox.widget_select2);
            KapeeMetabox.widget_select2();
        }
    };
    $(document).ready(function(){
        KapeeMetabox.initialize();
    });   
    
})(jQuery);