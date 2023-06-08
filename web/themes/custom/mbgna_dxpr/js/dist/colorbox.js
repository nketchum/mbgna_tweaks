/**
 * @file
 * A JavaScript file that colorboxes links falling
 * under a container with a "colorbox" css class.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_colorbox = {
    attach(context, settings) {
	    $('.colorbox a').colorbox({
	    	scalePhotos: true,
	    	maxWidth: '85%'
	    });
    }
  };
})(jQuery, Drupal, once);
