/* Kapee theme activation*/
jQuery( function ( $ ) {
	"use strict";
	var kapee_activation = kapee_activation || {};
	kapee_activation.init = function() {
		var self = this;
		kapee_activation.$doc          	= $(document)
		kapee_activation.$html    		= $('html'),
		kapee_activation.$body 			= $(document.body),
		kapee_activation.$window 		= $(window),
		kapee_activation.$windowWidth 	= $(window).width(),
		kapee_activation.$windowHeight 	= $(window).height();
		self.activate_theme();
		self.deactivate_theme();
	};
	
	kapee_activation.activate_theme = function() {
		// Activate theme
		$('body').on('click', '.kapee-activate-btn', function() {
			var purchase_code = $(".purchase-code").val();
			var activate_btn = $(this);
			activate_btn.addClass('loading');
			if( $.trim(purchase_code) != ''){
				$(this).attr('disabled', 'true');
				var data = {
					action      	: 'activate_theme',
					purchase_code   : purchase_code,
					nonce   		: kapee_admin_params.nonce,
				};
				$.post(ajaxurl,data,function(response) {
					
					var data = $.parseJSON(response);
					
					if(data.success == '1'){
						alert(data.message);
						setTimeout(function(){location.reload();}, 5000);
					}else{
						alert(data.message);
						activate_btn.removeClass('loading');
						activate_btn.removeAttr('disabled');
					}			
				});
			} else {
				alert('Please Enter Purchase Code');
			}
			
			return false;
		});
	};
	
	
	kapee_activation.deactivate_theme = function() {
		// deactivate theme
		$('body').on('click', '.kapee-deactivate-btn', function() {
			var purchase_code = $(".purchase-code").val();
			var activate_btn = $(this);
			activate_btn.addClass('loading');
			if( $.trim(purchase_code) != ''){
				$(this).attr('disabled', 'true');
				var data = {
					action      	: 'deactivate_theme',
					purchase_code   : purchase_code,
					nonce   		: kapee_admin_params.nonce,
				};
				$.post(ajaxurl,data,function(response) {
					
					var data = $.parseJSON(response);
					
					if(data.success == '1'){
						alert(data.message);
						
						setTimeout(function(){location.reload();}, 5000);
					}else{
						alert(data.message);
						activate_btn.removeClass('loading');
						activate_btn.removeAttr('disabled');
					}
				});
			} else {
				alert('Purchase code is empty.');
			}
			//$(this).attr('disabled', 'true');
			return false;
		});
	};
	
	/**
	 * Document ready
	 */ 
	$(document).ready(function(){ 
		kapee_activation.init();
    });
	
});
