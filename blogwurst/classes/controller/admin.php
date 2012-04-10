
<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Admin controller
 *
 * Handles all admin requests.
 */
class Controller_Admin extends Controller_Template
{

	/**
	 * Template
	 *
	 * @var  string  The template i need
	 */
	public $template = 'admin';

	/**
	 * Before
	 *
	 * Checks authentication and redirects to login, if needed.
	 *
	 * @param   void
	 * @return  void
	 */
	public function before()
	{
		if ( ! in_array($this->request->action, array('login')))
		{
			Auth::check() or Response::redirect('admin/login');
		}
		else
		{
			Auth::check() and Response::redirect('admin');

			$this->template = 'aether';
		}

		return parent::before();
	}

	/**
	 * After
	 *
	 * Dont use a template if this is an ajax request.
	 *
	 * @param   string|Response
	 * @return  parent::after()
	 */
	public function after($response)
	{
		if ( ! Input::is_ajax())
		{
			return parent::after($response);
		}

		if (empty($response))
		{
			$response = $this->template->content;
		}

		if ( ! $response instanceof Response)
		{
			$this->response->body = $response;
			$response = $this->response;
		}

		return parent::after($response);
	}

	/**
	 * Login
	 *
	 * Handles the login.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_login()
	{
		$data['username'] = null;

		if (Input::post('login'))
		{
			if (Auth::instance()->login())
			{
				Response::redirect('admin');
			}

			$data['username'] = Input::post('username');
		}

		$this->template->title = _('login');
		$this->template->content = View::forge('aether/login', $data);
	}

	/**
	 * Logout
	 *
	 * Handles the logout.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_logout()
	{
		Auth::instance()->logout();
		Response::redirect('admin/login');
	}
}
