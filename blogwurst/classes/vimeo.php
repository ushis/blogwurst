<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Vimeo
 *
 * Finds vimeo links an replaces them with markdown iframes.
 */
class Vimeo
{

	/**
	 * Link pattern
	 *
	 * @const  string  Regex matches vimeo links
	 */
	const LINK_PATTERN = '#http(?:s)?://vimeo\.com/([0-9]+)#';

	/**
	 * Api
	 *
	 * @const  string  Uri of the vimeo api
	 */
	const API = 'http://vimeo.com/api/v2/video/:id.xml';

	/**
	 * Iframe uri
	 *
	 * @const  string  Iframe src template
	 */
	const IFRAME_URI = 'http://player.vimeo.com/video/:id?title=0&byline=0&portrait=0';

	/**
	 * Request
	 *
	 * Asks vimeo for information about a specific video.
	 *
	 * @param   string      Video id
	 * @return  array|bool  Array with some info or false on error
	 */
	protected static function _request($id)
	{
		$api = Str::tr(static::API, array('id' => $id));

		if (($data = simplexml_load_file($api)) === false)
		{
			return false;
		}

		try
		{
			$video = $data[0]->video;

			if ( ! isset($video->width) or $video->width <= 0)
			{
				return false;
			}

			return array(
				'uri'    => Str::tr(static::IFRAME_URI, array('id' => $id)),
				'width'  => $video->width,
				'height' => $video->height,
			);
		}
		catch (Ecxeption $e)
		{
			return false;
		}
	}

	/**
	 * Replace links
	 *
	 * Replaces vimeo links with markdown iframes.
	 *
	 * @param   string
	 * @return  string
	 */
	public static function replace_links($str)
	{
		if ( ! preg_match_all(static::LINK_PATTERN, $str, $matches))
		{
			return $str;
		}

		foreach ($matches[0] as $key => $match)
		{
			if ($data = static::_request($matches[1][$key]))
			{
				$str = str_replace($match, Str::tr(Markdown::IFRAME_MD, $data), $str);
			}
		}

		return $str;
	}
}
