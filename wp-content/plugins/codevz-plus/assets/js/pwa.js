jQuery( function( $ ) {
	"use strict";

	var pwa 	= $( '.codevz-pwa' ),
		cookie 	= pwa.attr( 'data-cookie' );

	$( 'body' ).on( 'click', '.codevz-pwa-close', function() {

		document.cookie = cookie + "=true; expires=Fri, 31 Dec 2040 23:59:59 GMT; path=/";

		pwa.fadeOut();

	});

	if ( window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true ) {

		$( '.codevz-pwa-close' ).trigger( 'click' );

	} else {

		pwa.fadeIn();

	}

});