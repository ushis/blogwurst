<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
namespace Fuel\Migrations;

/**
 * Blogwurst migration 001
 *
 * Initial tables:
 *   - users     Authentication stuff
 *   - articles  Articles
 *   - tags      Lets tag our articles
 *   - uploads   allow some uploads
 */
class Blogwurst
{

	/**
	 * Up
	 *
	 * Creates the initial tables.
	 *
	 * @param   void
	 * @return  void
	 */
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id'             => array('type' => 'int',     'constraint' => 11, 'auto_increment' => true),
			'username'       => array('type' => 'varchar', 'constraint' => 50),
			'password'       => array('type' => 'varchar', 'constraint' => 256),
			'group'          => array('type' => 'int',     'constraint' => 11, 'default' => 1),
			'email'          => array('type' => 'varchar', 'constraint' => 128),
			'last_login'     => array('type' => 'varchar', 'constraint' => 25),
			'login_hash'     => array('type' => 'varchar', 'constraint' => 256),
			'profile_fields' => array('type' => 'text'),
			'reset_hash'     => array('type' => 'varchar', 'constraint' => 32),
			'created_at'     => array('type' => 'int',     'constraint' => 11),
		), array('id'));

		\DBUtil::create_index('users', 'username', 'username', 'unique');
		\DBUtil::create_index('users', 'email', 'email', 'unique');

		\DBUtil::create_table('articles', array(
			'id'          => array('type' => 'int',     'constraint' => 11, 'auto_increment' => true),
			'user_id'     => array('type' => 'int',     'constraint' => 11),
			'upload_id'   => array('type' => 'int',     'constraint' => 11),
			'title'       => array('type' => 'varchar', 'constraint' => 128),
			'slug'        => array('type' => 'varchar', 'constraint' => 128),
			'body'        => array('type' => 'text'),
			'created_at'  => array('type' => 'int',     'constraint' => 11),
			'updated_at'  => array('type' => 'int',     'constraint' => 11),
		), array('id'));

		\DBUtil::create_index('articles', 'slug', 'slug', 'unique');

		\DBUtil::create_table('tags', array(
			'id'   => array('type' => 'int',     'constraint' => 11, 'auto_increment' => true),
			'tag'  => array('type' => 'varchar', 'constraint' => 128),
			'slug' => array('type' => 'varchar', 'constraint' => 128),
		), array('id'));

		\DBUtil::create_index('tags', 'tag', 'tag', 'unique');
		\DBUtil::create_index('tags', 'slug', 'slug', 'unique');

		\DBUtil::create_table('articles_tags', array(
			'article_id' => array('type' => 'int', 'constraint' => 11),
			'tag_id'     => array('type' => 'int', 'constraint' => 11),
		));

		\DBUtil::create_table('uploads', array(
			'id'       => array('type' => 'int',     'constraint' => 11, 'auto_increment' => true),
			'filename' => array('type' => 'varchar', 'constraint' => 128),
			'folder'   => array('type' => 'varchar', 'constraint' => '64'),
		), array('id'));

		\DBUtil::create_index('uploads', 'filename', 'filename', 'unique');

		\Auth::create_user('admin', 'admin', 'admin@example.com', 100);
	}

	/**
	 * Down
	 *
	 * Drops all initial tables.
	 *
	 * @param   void
	 * @return  void
	 */
	public function down()
	{
		\DBUtil::drop_table('users');
		\DBUtil::drop_table('articles');
		\DBUtil::drop_table('tags');
		\DBUtil::drop_table('articles_tags');
		\DBUtil::drop_table('uploads');
	}
}
