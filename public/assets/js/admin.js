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
	 *   username  string  Selector for the username input field
	 *   password  string  Selector for the password input field
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
	 * Remove after timeout
	 *
	 * Options
	 *   timeout   int  Timeout
	 *   duration  int  Duration of the animation
	 */
	$.fn.bwRemoveAfterTimeout = function(options) {
		var settings = $.extend({
			timeout: 3000,
			duration: 600,
		}, options);

		return this.each(function() {
			var el = $(this);
			setTimeout(function() {
				el.slideUp(settings.duration, function() {
					el.remove();
				});
			}, settings.timeout);
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

	/**
	 * Dim
	 *
	 * Dims the element. First paramater is the optional duration of the animation.
	 */
	$.fn.bwDim = function(duration) {
		if (duration === undefined) {
			duration = 600;
		}

		var dim = $('<div>').attr('id', 'dim').css({opacity: 0});
		this.append(dim.animate({opacity: 0.6}, duration));
		return dim;
	};

	/**
	 * Loader
	 *
	 * Appends a loader to the element.
	 *
	 * Options:
	 *   interval  int     The interval of the loader
	 *   dots      string  The loader string
	 */
	$.fn.bwLoader = function(options) {
		var settings = $.extend({
			interval: 200,
			dots: '...',
		}, options);

		var loader = $('<p>').attr('id', 'loader');
		this.append(loader);
		var i = 0;

		var load = function() {
			i = (i > settings.dots.length - 1) ? 0 : i + 1;
			loader.text(settings.dots.substring(0, i));
		};

		return {loader: loader, interval: setInterval(load, settings.interval)};
	};

	/**
	 * Remove on outer click
	 *
	 * Removes the element on click outside of the element. Additional elements
	 * passed to the method, will be removed too.
	 */
	$.fn.bwRemoveOnOuterClick = function(additional) {
		return this.each(function() {
			var el = $(this);
			var outer = true;

			el.hover(function() {
				outer = false;
			}, function() {
				outer = true;
			});

			$(document).click(function() {
				if (outer) {
					el.remove();

					if (additional !== undefined) {
						additional.remove();
					}
				}

				return true;
			});
		});
	};

	/**
	 * File chooser
	 *
	 * Needs an uri for the ajax request and a callback function.
	 */
	$.fn.bwFileChooser = function(uri, callback) {
		return this.each(function() {
			$(this).click(function() {
				var dim = $('body').bwDim();
				var selection = $('<div>').attr('id', 'selection').bwRemoveOnOuterClick(dim);
				var loader = selection.bwLoader();
				$('body').append(selection);

				$.ajax({
					url: uri,
					success: function(data) {
						selection.html(data);
						selection.find('a').click(function() {
							callback($(this).attr('id').substr(7), $(this).attr('href'));
							dim.remove();
							selection.remove();
							return false;
						});
					},
					complete: function() {
						loader.loader.remove();
						clearInterval(loader.interval);
					},
				});

				return false;
			});
		});
	};

	/**
	 * Markdown toolbar
	 *
	 * Handles a markdown toolbar. Needs a selector specifying the textarea and
	 * 2 uris for the file chooser.
	 */
	$.fn.bwMdToolbar = function(selector, imgUri, filesUri) {
		var Area = function(e) {
			this.start = e.selectionStart;
			this.end = e.selectionEnd;
			this.txt = e.value;
			this.el = e;
		};

		Area.prototype.setTxt = function(txt) {
			this.el.value = txt;
			this.el.selectionStart = this.el.selectionEnd = this.end + txt.length - this.txt.length;
		};

		Area.prototype.insert = function(c) {
			this.setTxt(this.txt.substr(0, this.start) + c + this.txt.substr(this.start));
		};

		Area.prototype.wrap = function(c) {
			if (this.start === this.end) {
				return this.insert(c);
			}

			this.setTxt(this.txt.substr(0, this.start) + c +
			            this.txt.substr(this.start, this.end - this.start) + c +
			            this.txt.substr(this.end));
		};

		Area.prototype.insertNextLine = function(c) {
			var i = this.txt.indexOf('\n', this.end);
			this.start = this.end = (i === -1) ? this.txt.length : i;
			this.insert('\n' + c + ' ');
		};

		Area.prototype.insertBeforeFirst = function(c, multiple) {
			if (this.start > 0) {
				this.start = this.txt.lastIndexOf('\n', this.start - 1)
			}

			this.start !== 0 && this.start++;

			if (this.txt.charAt(this.start) != c) {
				c += ' ';
			} else if ( ! multiple) {
				return this.insertNextLine(c);
			}

			this.insert(c);
		};

		return this.each(function() {
			var el = $(this).next(selector).get(0);

			$(this).children('li.img').bwFileChooser(imgUri, function(id, uri) {
				new Area(el).insert('![' + uri.split('/').pop().split('.').shift() + '](' + uri + ')');
			});

			$(this).children('li.file').bwFileChooser(filesUri, function(id, uri) {
				new Area(el).insert('[' + uri.split('/').pop()  + '](' + uri + ')');
			});

			$(this).children('li').click(function() {
				var area = new Area(el);

				if ($(this).hasClass('i')) {
					area.wrap('*');
				} else if ($(this).hasClass('b')) {
					area.wrap('**');
				} else if($(this).hasClass('h')) {
					area.insertBeforeFirst('#', true);
				} else if($(this).hasClass('li')) {
					area.insertBeforeFirst('-', false);
				} else if($(this).hasClass('a')) {
					area.insert('[text](uri)');
				} else if ($(this).hasClass('help')) {
					return true;
				}

				return false;
			});
		});
	};
})(jQuery);
