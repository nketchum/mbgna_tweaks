/**
 * @file
 * A JavaScript file that autoplays banner videos.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_autoplay = {
    attach(context, settings) {
      var player = null;
      if (player = document.querySelector('.video-banner video')) {
        player.play();  
      }
    }
  };
})(jQuery, Drupal, once);
