<?php
/**
 * Part of Blogwurst
 *
 * @packacge  Blogwurst
 * @version   1.0
 * @license   MIT
 */
/**
 * Article model
 *
 * Handles the article data.
 */
class Model_Article extends Orm\Model
{

	/**
	 * Table name
	 *
	 * @var  string  The db table
	 */
	protected static $_table_name = 'articles';

	/**
	 * Proeprties
	 *
	 * @var  array  The db table cols
	 */
	protected static $_properties = array(
		'id'         => array('data_type' => 'int'),
		'user_id'    => array('data_type' => 'int'),
		'title'      => array(
			'data_type'  => 'varchar',
			'validation' => array('required'),
		),
		'slug'       => array('data_type' => 'varchar'),
		'body'       => array('data_type' => 'text'),
		'created_at' => array('data_type' => 'time_unix'),
		'updated_at' => array('data_type' => 'time_unix'),
	);

	/**
	 * Belongs to
	 *
	 * @var  array  Belongs to relations
	 */
	protected static $_belongs_to = array('user');

	/**
	 * Many many
	 *
	 * @var  array  Many many relations
	 */
	protected static $_many_many = array('tags');

	/**
	 * Observers
	 *
	 * @var  array  Needed observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_Validation' => array(
			'events' => array('before_save'),
		),
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load'),
		),
		'Orm\\Observer_Slug' => array(
			'events' => array('before_insert'),
		),
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);
}
