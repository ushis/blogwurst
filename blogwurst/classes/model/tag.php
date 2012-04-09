<?php
/**
 * Part of Blogwurst
 *
 * @packacge  Blogwurst
 * @version   1.0
 * @license   MIT
 */
/**
 * Tag model
 *
 * Handles the tag data.
 */
class Model_Tag extends Orm\Model
{

	/**
	 * Table name
	 *
	 * @var  string  The db table
	 */
	protected static $_table_name = 'tags';

	/**
	 * Proeprties
	 *
	 * @var  array  The db table cols
	 */
	protected static $_properties = array(
		'id'   => array('data_type' => 'int'),
		'tag'  => array('data_type' => 'varchar'),
		'slug' => array('data_type' => 'varchar'),
	);

	/**
	 * Many many
	 *
	 * @var  array  Many many relations
	 */
	protected static $_many_many = array('articles');

	/**
	 * Observers
	 *
	 * @var  array  Needed observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load'),
		),
		'Orm\\Observer_Slug' => array(
			'events' => array('before_insert'),
			'source' => 'tag',
		),
	);

	/**
	 * All as array
	 *
	 * Returns all tags as array
	 *
	 * @param   void
	 * @return  array
	 */
	public static function all_as_array()
	{
		return array_values(Arr::flatten(DB::select('tag')->from(static::$_table_name)
		                                                  ->execute()
		                                                  ->as_array()));
	}

	/**
	 * From string
	 *
	 * Creates an array of Model_Tag instances from a string.
	 *
	 * @param   string  The string
	 * @return  array()
	 */
	public static function from_string($str)
	{
		$tags = array();

		foreach(explode(',', $str) as $tag)
		{
			if (($tag = trim($tag)) and ! in_array($tag, $tags))
			{
				$tags[] = $tag;
			}
		}

		if (empty($tags))
		{
			return array();
		}

		$return = static::find()->where('tag', 'in', $tags)->get();

		foreach($return as $i => $tag)
		{
			if (($j = array_search($tag, $tags)) !== false)
			{
				unset($tags[$j]);
			}
			else
			{
				unset($return[$i]);
			}
		}

		foreach($tags as $tag)
		{
			$return[] = static::forge(array('tag' => $tag));
		}

		return $return;
	}

	/**
	 * To string
	 *
	 * Returns the tag.
	 *
	 * @param   void
	 * @return  string
	 */
	public function __toString()
	{
		return $this->tag;
	}
}
