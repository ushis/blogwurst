<?php echo Html::doctype('html5'); ?>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo $title; ?> . blogwurst</title>

		<?php echo Asset::css('admin.css'); ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<?php echo Asset::js('admin.js'); ?>
	</head>
	<body>
		<div id="aether">
			<?php echo $content; ?>
		</div>
	</body>
</html>
