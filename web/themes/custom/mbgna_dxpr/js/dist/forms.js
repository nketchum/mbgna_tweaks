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

      var account_form = $('.user-form .form-type-password-confirm');
      if (account_form) {
        var pass1 = $(account_form).find('.form-item-pass-pass1');
        var pass1_label = $(pass1).find('label');
        $(pass1_label).addClass('hidden');
        var pass1_input = $(pass1).find('input');
        $(pass1_input).attr('placeholder', 'Password...');

        var pass2 = $(account_form).find('.form-item-pass-pass2');
        var pass2_label = $(pass2).find('label');
        $(pass2_label).addClass('hidden');
        var pass2_input = $(pass2).find('input');
        $(pass2_input).attr('placeholder', 'Confirm password...');
      }
    }
  }
})(jQuery, Drupal, once);
