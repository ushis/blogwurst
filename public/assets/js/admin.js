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
	 * Grandparent plugin
	 *
	 * Returns the grandparent of a jQuery object
	 */
	$.fn.bwGrandparent = function() {
		return this.parent().parent();
	};

	/**
	 * Login plugin
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
})(jQuery);
