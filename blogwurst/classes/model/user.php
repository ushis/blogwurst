
<?php
/**
 * Part of Blogwurst
 *
 * @packacge  Blogwurst
 * @version   1.0
 * @license   MIT
 */
/**
 * User model
 *
 * Handles the user data.
 */
class Model_User extends Orm\Model
{

	/**
	 * Table name
	 *
	 * @var  string  The db table
	 */
	protected static $_table_name = 'users';

	/**
	 * Proeprties
	 *
	 * @var  array  The db table cols
	 */
	protected static $_properties = array(
		'id'             => array('data_type' => 'int'),
		'username'       => array('data_type' => 'varchar'),
		'password'       => array('data_type' => 'varchar'),
		'group'          => array('data_type' => 'int'),
		'email'          => array('data_type' => 'varchar'),
		'last_login'     => array('data_type' => 'varchar'),
		'login_hash'     => array('data_type' => 'varchar'),
		'profile_fields' => array('data_type' => 'serialize'),
		'reset_hash'     => array('data_type' => 'varchar'),
		'created_at'     => array('data_type' => 'time_unix'),
	);

	/**
	 * Has many
	 *
	 * @var  array  Has many relations
	 */
	protected static $_has_many = array('articles');

	/**
	 * Observers
	 *
	 * @var  array  Needed observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load'),
		),
	);
}
