<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Uploads Admin controller
 *
 * Handles all upload admin requests.
 */
class Controller_Admin_Uploads extends Controller_Admin
{

	/**
	 * Index
	 *
	 * Displays all uploads.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_index()
	{
		$data['uploads'] = Model_Upload::find()->order_by('filename')->get();

		$this->template->title = _('uploads');
		$this->template->content = View::forge('admin/uploads/index', $data);
	}

	/**
	 * Add
	 *
	 * Adds some uploads
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_add()
	{
		if ( ! Model_Upload::save_uploads())
		{
			Session::set_flash('error', 'could not save uploads');
		}

		Response::redirect('admin/uploads/index');
	}

	/**
	 * Delete
	 *
	 * Deletes an upload
	 *
	 * @param   int  Article id
	 * @return  void
	 */
	public function action_delete($id = null)
	{
		$upload = Model_Upload::find()->where('id', $id)->get_one();

		if ( ! empty($upload) and $upload->delete())
		{
			Session::set_flash('notice', _('deleted upload'));
		}
		else
		{
			Session::set_flash('error', _('could not delete upload'));
		}

		Response::redirect('admin/uploads/index');
	}
}
