/**
 * @file
 * A JavaScript file that autoplays banner videos.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_autoplay = {
    attach(context, settings) {
		document.querySelector('.video-banner video').play();
    }
  };
})(jQuery, Drupal, once);


