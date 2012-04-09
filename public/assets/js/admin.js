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
})(jQuery);
