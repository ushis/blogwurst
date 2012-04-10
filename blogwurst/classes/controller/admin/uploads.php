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
	 * @param   string  Folder
	 * @return  void
	 */
	public function action_index($folder = null)
	{
		$query = Model_Upload::find()->order_by('filename');

		is_null($folder) or $query->where('folder', $folder);

		$data['uploads'] = $query->get();
		$view = Input::is_ajax() ? 'choose' : 'index';
		$this->template->title = _('uploads');
		$this->template->content = View::forge('admin/uploads/'.$view, $data);
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
