/**
 * Part of Blogwurst
 *
 * @package   Blogwurst
 * @version   1.0
 * @license   MIT
 * @requires  jQuery 1.7
 */
(function($) {

	/**
	 * Grandparent
	 *
	 * Returns the grandparent of a jQuery object
	 */
	$.fn.bwGrandparent = function() {
		return this.parent().parent();
	};

	/**
	 * Login
	 *
	 * Auto focuses the right input field.
	 *
	 * Options:
	 *   username  Selector for the username input field
	 *   password  Selector for the password input field
	 */
	$.fn.bwLogin = function(options) {
		var settings = $.extend({
			username: 'input[name=username]',
			password: 'input[name=password]'
		}, options);

		return this.each(function() {
			var usr = $(this).find(settings.username);

			if (usr && usr.val() == '') {
				usr.focus();
			} else {
				$(this).find(settings.password).focus();
			}
		});
	};

	/**
	 * Complete list
	 *
	 * Auto completes a ',' separated list. The first param must be an array with
	 * valid values.
	 */
	$.fn.bwCompleteList = function(list) {
		return this.each(function() {
			$(this).autocomplete({
				minLength: 0,
				appendTo: $(this).parent(),
				source: function(req, res) {
					res($.ui.autocomplete.filter(list, req.term.split(/,\s*/).pop()));
				},
				focus: function() {
					return false;
				},
				select: function(e, ui) {
					var terms = this.value.split(/,\s*/);
					terms.pop();
					terms.push(ui.item.value);
					terms.push('');
					this.value = terms.join(', ');
					return false;
				}
			});
		});
	};

	/**
	 * Toggle img
	 *
	 * Hides the first image and toggles it on click. The first parameter
	 * is a selector specifying the clickable element. The second is optional
	 * and specifies the duration of the animation.
	 */
	$.fn.bwToggleImg = function(selector, duration) {
		if (duration === undefined) {
			duration = 600;
		}

		return this.each(function() {
			var img = $(this).find('img');

			if (img.length === 0) {
				return;
			}

			img = img.eq(0);
			var wrapper = img.wrap('<div>').parent().css({height: 0, overflow: 'hidden'});
			var height = 0;

			$(this).find(selector).click(function() {
				 height = (height > 0) ? 0 : (img.width() / img[0].naturalWidth *
				                              img[0].naturalHeight) + 10;

				wrapper.stop().animate({height: height}, duration);
				return false;
			});
		});
	};
})(jQuery);
