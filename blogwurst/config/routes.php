<?php
return array(
	'_root_'  => 'public/index',
	'_404_'   => 'public/404',

	'project/(:any)'  => 'public/view/$1',
	'blog'            => 'public/blog/all',
	'blog/(:any)'     => 'public/blog/all/$1',
	'category/(:any)' => 'public/blog/$1',

	'admin' => 'admin/articles/index',
	'admin/index' => 'admin/articles/index',
);
