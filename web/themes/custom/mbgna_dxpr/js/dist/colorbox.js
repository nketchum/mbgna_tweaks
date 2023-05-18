/**
 * @file
 * A JavaScript file that styles the page with bootstrap classes.
 *
 * @see sass/styles.scss for more info
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
