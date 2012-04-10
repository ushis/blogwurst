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
	 * After
	 *
	 * Sets the available tags for the navi
	 *
	 * @param   Response         The response object
	 * @return  parent::after()
	 */
	public function after($response)
	{
		$this->template->tags = array();

		foreach (Model_Tag::find()->related('articles')->get() as $tag)
		{
			empty($tag->articles) or $this->template->tags[] = $tag;
		}

		$this->template->is_index = $this->request->action == 'index';

		return parent::after($response);
	}

	/**
	 * Index
	 *
	 * Lists all preview articles.
	 *
	 * @param   void
	 * @return  void
	 */
	public function action_index()
	{
		$data['articles'] = Model_Article::find()->where('upload_id', '>', 0)
		                                         ->order_by('created_at', 'desc')
		                                         ->get();

		$this->template->title = _('projects');
		$this->template->content = View::forge('public/index', $data);
	}

	/**
	 * Blog
	 *
	 * Lists all articles
	 *
	 * @param   string  A tag slug
	 * @return  void
	 */
	public function action_blog($tag = 'all')
	{
		$query = Model_Article::find()->related('tags');
		$config = array();

		if ($tag == 'all')
		{
			$config['total_items'] = Model_Article::count();
			$config['uri_segment'] = 2;
			$config['pagination_url'] = 'blog';
		}
		else
		{
			$query->where('tags.slug', $tag);
			$config['total_items'] = $query->count();
			$config['uri_segment'] = 3;
			$config['pagination_url'] = 'category/'.$tag;
		}

		Pagination::set_config($config);
		$data['projects'] = $query->order_by('created_at', 'desc')
		                          ->rows_offset(Pagination::$offset)
		                          ->rows_limit(Pagination::$limit)
								  ->get();

		$this->template->title = _('blog');
		$this->template->content = View::forge('public/blog', $data);
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
		$this->template->title = _('404 not found');
		$this->template->content = View::forge('public/404');
	}
}
