/**
 * @file
 * A JavaScript file that styles the page with bootstrap classes.
 *
 * @see sass/styles.scss for more info
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_autoplay = {
    attach(context, settings) {
		document.querySelector('.video-banner video').play();
    }
  };
})(jQuery, Drupal, once);


