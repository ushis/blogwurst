<ul>
	<?php foreach ($uploads as $upload): ?>
	<li>
	<?php if ($upload->folder == Model_Upload::IMG_DIR): ?>
		<?php echo Html::anchor('#choose-'.$upload->id, Asset::img($upload->filename)); ?>
	<?php endif; ?>
	</li>
	<?php endforeach; ?>
<ul>
