/**
 * @file
 * A JavaScript file that sets the border-bottom-left-radius
 * of thin header banners to have a circular radius size
 * equal to the height of the responsive thin header.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_banner = {
    attach(context, settings) {

    	function changeRadius() {
	    	var banner = $('.banner-thin');
	    	var banner_image = $('.banner-thin .banner-image');
	    	var height = $(banner).height();
	    	$(banner_image).css('border-bottom-left-radius', height + 'px');
    	}

	    if ($('.banner-thin')) {
	    	changeRadius();
	    }

    	// Also runs when window is resize.
			$(window).on('resize', function() {
				if ($('.banner-thin')) {
					changeRadius();
				}
			});
    }
  };
})(jQuery, Drupal, once);
