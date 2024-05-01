jQuery(function($) {
	'use strict';

	// codevzDebounce function to limit the frequency of the event handler execution
	function codevzDebounce(func, wait, immediate) {
		let timeout;
		return function() {
			const context = this,
				args = arguments;
			const later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			const callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	}

	Codevz_Plus.parallax = function() {
		var body = $(document.body);

		// On mousemove.
		$(document).on('mousemove', codevzDebounce(function(e) {
			$('[class*="cz_mparallax_"]').each(function() {
				var x = $(this);
				if (Codevz_Plus.inview(x, 750)) {
					var sp = -((parseInt(x.attr("class").replace(/[^\d-]/g, "")) || 50) * 10),
						xx = e.pageX - x.offset().left - (x.width() / 2),
						yy = e.pageY - x.offset().top - (x.height() / 2),
						xx = xx / $(this).width(),
						yy = yy / $(this).height();

					x.css('transform', 'translate3d(' + Math.round(xx * sp) + 'px,' + Math.round(yy * sp) + 'px, 0px)');
				}
			});
		}, 10)); // Adjust the codevzDebounce time as needed for smoothness

		// Function to handle scroll parallax
		function handleScrollParallax() {
			$('[class*="cz_parallax_"]').each(function(i) {
				var x = $(this);
				if (Codevz_Plus.inview(x, 750)) {
					var c = x.attr('class'),
						f = c ? parseInt(c.replace(/[^\d-]/g, '')) / 100 : 'undefined',
						g = (x.outerHeight(), f) || 0,
						j = x.data('offset') || 0;

					var e = ($(this).outerHeight(), $(window).scrollTop()) + 250,
						r = Math.round((x.offset().top - $(window).height() / 2 - e) * g - j);

					if (x.hasClass('cz_parallax_stop')) {
						r = r < 0 ? 0 : r;
					}

					if (e < $(document).height()) {
						x.css('transform', 'translate' + (c.indexOf('_v_') >= 0 ? 'Y' : 'X') + '(' + r + 'px)');
					}
				}
			});
		}

		// On scroll.
		$(window).on('scroll', codevzDebounce(function() {
			handleScrollParallax();
		}, 10)); // Adjust the codevzDebounce time as needed for smoothness

		// Initial trigger on page load
		handleScrollParallax();
	};

	Codevz_Plus.parallax();
});