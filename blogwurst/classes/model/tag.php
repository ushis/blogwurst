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
		),
	);
}
