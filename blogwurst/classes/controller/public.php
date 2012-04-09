<?php
/**
 * Part of Blogwurst
 *
 * @package  Blogwurst
 * @version  1.0
 * @license  MIT
 */
/**
 * Public controller
 *
 * Handles all public requests.
 */
class Controller_Public extends Controller_Template
{

	/**
	 * Template
	 *
	 * @var  string  The template i need
	 */
	public $template = 'public';

	/**
	 * Index
	 *
	 * Lists all articles.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_index()
	{
		$this->template->title = '';
		$this->template->content = View::forge('public/index');
	}

	/**
	 * View
	 *
	 * Shows an article.
	 *
	 * @param   string   The article slug
	 * @return  void
	 */
	public function action_view($slug = null)
	{
		$article = Model_Article::find()->where('slug', $slug)->related('tags')->get_one();

		if (empty($article))
		{
			throw new HttpNotFoundException();
		}

		$this->template->title = $article->title;
		$this->template->content = View::forge('public/view', array('article' => $article));
	}

	/**
	 * 404
	 *
	 * Shows a nice 404 error page.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_404()
	{
		$this->template->title = '';
		$this->template->content = View::forge('public/404');
	}
}
