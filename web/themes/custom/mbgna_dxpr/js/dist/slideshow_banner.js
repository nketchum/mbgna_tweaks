/**
 * @file
 * A JavaScript file that sets the height of the slide
 * content box based on the largest content box in the
 * slideshow. This prevents rogue bottom margins when
 * content boxes are different heights.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_slideshow_banner = {
    attach(context, settings) {
    	// Runs on page load.
    	// Twig template debugging/comments MUST be turned off.
    	function resize_banner() {
	    	var items = $('.header-banner-text');
	    	var max_height = 0;
	    	$(items).each(function(index, element) {
	    		$(element).css({'height': ''});
	    		if ($(element).height() > max_height) {
	    			max_height = $(element).height();
	    		}
	    	});
	    	$(items).each(function(index, element) {
	    		$(element).height(max_height);
	    	});
    	}
    	resize_banner();

    	// Also runs when window is resize.
			$(window).on('resize', function() {
				resize_banner();
			});
    }
  };
})(jQuery, Drupal, once);
