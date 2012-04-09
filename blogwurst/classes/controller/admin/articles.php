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
		$data['articles'] = Model_Article::find()->order_by('created_at', 'desc')->get();

		$this->template->title = _('articles');
		$this->template->content = View::forge('admin/articles/index', $data);
	}

	/**
	 * Input
	 *
	 * Displays a form to add/edit an article
	 *
	 * @param   Model_Article  The article
	 * @return  void
	 */
	protected function _input(Model_Article $article)
	{
		if (Input::post('save'))
		{
			try
			{
				$article->save_input();
				Response::redirect('admin/articles/edit/'.$article->id);
			}
			catch (Orm\ValidationFailed $e)
			{
				Session::set_flash('error', _('check your data'));
			}
			catch (Exception $e)
			{
				echo $e;
				Session::set_flash('error', _('could not save article'));
			}
		}

		$data['article'] = $article;
		$data['tags'] = Model_Tag::all_as_array();
		$this->template->content = View::forge('admin/articles/form', $data);
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
		$this->template->title = _('new article');
		$this->_input(Model_Article::forge());
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
		$article = Model_Article::find()->where('id', $id)->related('tags')->get_one();

		if (empty($article))
		{
			throw new HttpNotFoundException();
		}

		$this->template->title = $article->title;
		$this->_input($article);
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
		$article = Model_Article::find()->where('id', $id)->get_one();

		if ( ! empty($article) and $article->delete())
		{
			Session::set_flash('notice', _('deleted article'));
		}
		else
		{
			Session::set_flash('error', _('could not delete article'));
		}

		Response::redirect('admin/articles/index');
	}
}
