/**
 * @file
 * A JavaScript file that sets some form properties.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_forms = {
    attach(context, settings) {
      // Make the default select the same color as placeholders
      // at first load in css.
      // 
      // Then, when a user changes the selection to a valid
      // option, make the color black so it does not look
      // like a placeholder.
      $('select').on('change', function() {
        if ($(this).val()) {
      return $(this).css('color', 'black');
        } else {
      return $(this).css('color', '#666666');
        }
      });
    }
  }
})(jQuery, Drupal, once);
