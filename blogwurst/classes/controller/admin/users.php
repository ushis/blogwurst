
<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Users Admin controller
 *
 * Handles all users admin requests.
 */
class Controller_Admin_Users extends Controller_Admin
{

	protected function _update_user()
	{
		$input['email'] = Input::post('email');

		if (Input::post('password'))
		{
			$input['password'] = Input::post('password');
			$input['old_password'] = Input::post('old_password');

			if ($input['password'] != Input::post('c_password'))
			{
				Session::set_flash('error', _('passwords did not match'));
				return;
			}
		}

		try
		{
			Auth::update_user($input);
			Session::set_flash('notice', _('saved changes'));
		}
		catch (SimpleUserWrongPassword $e)
		{
			Session::set_flash('error', _('old password was wrong'));
		}
		catch (Exception $e)
		{
			Session::set_flash('error', _('could not save changes'));
		}
	}

	/**
	 * Edit
	 *
	 * Edits the users profile
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_edit()
	{
		Input::post('save') and $this->_update_user();

		$data['username'] = Auth::get_screen_name();
		$data['email'] = Auth::get_email();

		$this->template->title = _('profile');
		$this->template->content = View::forge('admin/users/form', $data);
	}
}
