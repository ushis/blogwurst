<?php echo Form::open(array('action' => 'admin/uploads/add', 'id' => 'upload-form', 'enctype' => 'multipart/form-data')); ?>
	<p>
		<?php echo Form::file('files[]', array('multiple', 'id' => 'file-chooser')); ?>
	</p>
<?php echo Form::close(); ?>

<?php if ( ! empty($uploads)): ?>
<ul class="uploads index">
	<?php foreach ($uploads as $upload): ?>
	<li>
		<?php echo Html::anchor('admin/uploads/delete/'.$upload->id, '×', array('class' => 'del')); ?>

		<?php if ($upload->folder == Model_Upload::IMG_DIR): ?>
			<?php echo Html::anchor('#toggle', $upload->filename, array('class' => 'toggle')); ?>
			<?php echo Asset::img($upload->filename); ?>
		<?php else: ?>
			<?php echo Html::anchor('/assets/'.$upload->folder.'/'.$upload->filename, $upload->filename); ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<script>
	$('#file-chooser').change(function() { $(this).bwGrandparent().submit(); });
	$('ul.uploads li').bwToggleImg('a.toggle');
</script>
