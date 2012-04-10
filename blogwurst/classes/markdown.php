<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Markdown
 *
 * Extends the core markdown class
 */
class Markdown extends Fuel\Core\Markdown
{

	/**
	 * Iframe pattern
	 *
	 * @var  string  Regex matches markdown iframes
	 */
	const IFRAME_PATTERN = '#{([^\s}]+)}\(([0-9]+)\)\(([0-9]+)\)#';

	/**
	 * Iframe markdown
	 *
	 * @var  string  Markdown syntax for iframes
	 */
	const IFRAME_MD = '{:uri}(:width)(:height)';

	/**
	 * Parse
	 *
	 * Parses the string
	 *
	 * @param   string
	 * @return  string
	 */
	public static function parse($str)
	{
		return parent::parse(static::process_iframes($str));
	}

	/**
	 * Process iframes
	 *
	 * Replaces markdown iframes with their html equivalents.
	 *
	 * @param   string
	 * @return  string
	 */
	public static function process_iframes($str)
	{
		if ( ! preg_match_all(static::IFRAME_PATTERN, $str, $matches))
		{
			return $str;
		}

		foreach($matches[0] as $key => $match)
		{
			$str = str_replace($match, html_tag('iframe', array(
				'src'         => $matches[1][$key],
				'width'       => $matches[2][$key],
				'height'      => $matches[3][$key],
				'frameborder' => '0',
			), ''), $str);
		}

		return $str;
	}
}
