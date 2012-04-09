<?php echo Html::doctype('html5'); ?>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo $title; ?> . blogwurst</title>

		<?php echo Asset::css('admin.css'); ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<?php echo Asset::js('admin.js'); ?>
	</head>
	<body>
		<header>
			<nav>
				<ul>
					<li>
						<?php echo Html::anchor('admin', '⌂'); ?>
					</li>
					<li>
						<?php echo Html::anchor('/', '↗'); ?>
					</li>
					<li>
						<h1>
							<?php echo $title; ?>
						</h1>
					</li>
				</ul>
				<ul class="tools">
					<li>
						<?php echo Html::anchor('admin/logout', _('logout')); ?>
					</li>
					<li>
						<?php echo Html::anchor('admin/users/edit', Auth::get_screen_name()); ?>
					</li>
					<li>
						<?php echo Html::anchor('admin/uploads', '#'); ?>
					</li>
					<li>
						<?php echo Html::anchor('admin/articles/add', '+'); ?>
					</li>
				</ul>
			</nav>
			<div class="clearfix"></div>
		</header>
		<div id="wrapper">
			<?php echo $content; ?>
		</div>
	</body>
</html>
