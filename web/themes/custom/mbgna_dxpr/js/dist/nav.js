/**
 * @file
 * A JavaScript file that augments dropdown menus.
 *
 * @see sass/styles.scss for more info
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_nav = {
    attach(context, settings) {
    	var close_btns = $('.close-nav-dropdown');
    	$(close_btns).each(function() {
				$(this).on('click', function(e) {
					// $(this).parents('.tb-megamenu-item').removeClass('open');
					// $(this).parents('.tb-megamenu-item').children('.tb-megamenu-submenu, .dropdown-toggle').attr('aria-expanded', 'false');
					// $(this).parents('.mega-dropdown-menu').hide();
					// $(this).parents('.mega-dropdown-menu').removeAttr("style");
					var parents = $(this).parents('.mega-dropdown-menu');
					$(parents).css('display', 'none');
					setTimeout(function() {
						$(parents).removeAttr('style');
					}, 600);
				});
    	});
    }
  };
})(jQuery, Drupal, once);
