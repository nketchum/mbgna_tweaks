/**
 * @file
 * A JavaScript file that augments dropdown menus so that
 * they can be closed via a nice button and not only upon
 * mouseleave.
 */
(function($, Drupal, once) {
  Drupal.behaviors.mbgna_dxpr_theme_nav = {
    attach(context, settings) {
    	var mobile_menu_btn = $('#dxpr-theme-menu-toggle');
    	var mobile_nav = $('.mobile-nav');
    	$(mobile_menu_btn).click(function() {
    		$(mobile_nav).toggle();
    	});


    	var close_btns = $('.close-nav-dropdown');
    	$(close_btns).each(function() {
				$(this).on('click', function(e) {
					var parents = $(this).parents('.mega-dropdown-menu');
					$(parents).css('display', 'none');
					setTimeout(function() {
						$(parents).removeAttr('style');
					}, 600); // Longer than default timeout from contrib module of 500 ms.
				});
    	});
    }
  };
})(jQuery, Drupal, once);
