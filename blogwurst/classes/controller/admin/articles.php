<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Articles Admin controller
 *
 * Handles all article admin requests.
 */
class Controller_Admin_Articles extends Controller_Admin
{

	/**
	 * Index
	 *
	 * Displays all articles.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_index()
	{
		$this->template->title = _('articles');
		$this->template->content = View::forge('admin/articles/index');
	}

	/**
	 * Add
	 *
	 * Adds a new article
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_add()
	{

	}

	/**
	 * Edit
	 *
	 * Edits an article
	 *
	 * @param   int  Article id
	 * @return  void
	 */
	public function action_edit($id = null)
	{

	}

	/**
	 * Delete
	 *
	 * Deletes an article
	 *
	 * @param   int  Article id
	 * @return  void
	 */
	public function action_delete($id = null)
	{

	}
}
