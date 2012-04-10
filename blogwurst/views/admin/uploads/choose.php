<ul>
	<?php foreach ($uploads as $upload): ?>
	<li class="<?php echo $upload->folder; ?>">
	<?php
		$inner = ($upload->folder == Model_Upload::IMG_DIR) ? Asset::img($upload->filename) : $upload->filename;
		echo Html::anchor('assets/'.$upload->folder.'/'.$upload->filename, $inner, array('id' => 'upload-'.$upload->id));
	?>
	</li>
	<?php endforeach; ?>
<ul>
