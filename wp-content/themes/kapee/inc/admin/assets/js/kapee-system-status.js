/* global jQuery, woocommerce_admin_system_status, wcSetClipboard, wcClearClipboard */
jQuery( function ( $ ) {
	 "use strict";
	/**
	 * Users country and state fields
	 */
	var wcSystemStatus = {
		init: function() {
			$( document.body )
				.on( 'click', 'a.debug-report', this.generateReport )				
		},

		/**
		 * Generate system status report.
		 *
		 * @return {Bool}
		 */
		generateReport: function() {
			
			var report = '';

			$( '#kapee-system-status .kp-dash-title,#kapee-system-status table tbody' ).each( function() {
				if ( $( this ).hasClass( 'kp-dash-title' ) ) {
					var label =  $( this ).text();
                    report = report + '\n### ' + $.trim( label ) + ' ###\n\n';
				} else {
					$( 'tr', $( this ) ).each( function() {
						var label       = $( this ).find( 'td:eq(0)' ).data( 'export-label' ) || $( this ).find( 'td:eq(0)' ).text();
                        var the_name    = $.trim( label ).replace( /(<([^>]+)>)/ig, '' ); // Remove HTML.

                        // Find value
                        var $value_html = $( this ).find( 'td:eq(1)' ).clone();
                        $value_html.find( '.private' ).remove();
                        $value_html.find( '.yes' ).replaceWith( '&#10004;' );
                        $value_html.find( '.no, .error' ).replaceWith( '&#10060;' );

						var the_value   = $.trim( $value_html.text() );
						var value_array = the_value.split( ', ' );

						if ( value_array.length > 1 ) {
							// If value have a list of plugins ','.
							// Split to add new line.
							var temp_line ='';
							$.each( value_array, function( key, line ) {
								temp_line = temp_line + line + '\n';
							});

							the_value = temp_line;
						}

						report = report + '' + the_name + ': ' + the_value + '\n';
					});
				}
			});

			try {
				$( '#kapee-debug-report' ).slideDown();
				$( '#kapee-debug-report' ).find( 'textarea' ).val( '`' + report + '`' ).focus().select();
				$( this ).fadeOut();
				return false;
			} catch ( e ) {
				/* jshint devel: true */
				console.log( e );
			}

			return false;
		},		
	};

	wcSystemStatus.init();

	$( '#log-viewer-select' ).on( 'click', 'h2 a.page-title-action', function( evt ) {
		evt.stopImmediatePropagation();
		return window.confirm( woocommerce_admin_system_status.delete_log_confirmation );
	});
});
