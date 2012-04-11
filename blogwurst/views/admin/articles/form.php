<?php echo Form::open(); ?>
	<p>
		<?php echo Form::input('title', $article->title, array('required')); ?>
	</p>
	<p>
		<ul class="md-toolbar">
			<li class="i">i</li>
			<li class="b">b</li>
			<li class="h">h</li>
			<li class="li">li</li>
			<li class="a">a</li>
			<li class="img">img</li>
			<li class="file">file</li>
			<li class="help">
				<?php echo Html::anchor('http://daringfireball.net/projects/markdown/syntax', '?'); ?>
			</li>
		</ul>
		<?php echo Form::textarea('body', $article->body); ?>
	</p>
	<p>
		<?php echo Form::input('tags', implode(', ', $article->tags)); ?>
	</p>
	<p>
		<label>
			<?php echo Form::checkbox('preview', 1, $article->upload_id ? array('checked') : array()); ?>
			<?php echo _('preview'); ?>?
		</label>
	</p>
	<p class="preview">
	<?php if ($article->upload_id): ?>
		<?php echo Html::anchor('#choose-preview', Asset::img($article->upload->filename)); ?>
	<?php else: ?>
		<?php echo Html::anchor('#choose-preview', _('choose preview')); ?>
	<?php endif; ?>
	</p>
	<p>
		<?php echo Form::hidden('upload_id', $article->upload_id); ?>
		<?php echo Form::submit('save', _('save')); ?>
	</p>
<?php echo Form::close(); ?>

<script>
	$('ul.md-toolbar').bwMdToolbar('textarea[name=body]', '<?php echo Uri::create('admin/uploads/index/img'); ?>', '<?php echo Uri::create('admin/uploads/index/files'); ?>');
	$('input[name=tags]').bwCompleteList(<?php echo json_encode($tags); ?>);
	$('p.preview a').bwFileChooser('<?php echo Uri::create('admin/uploads/index/img'); ?>', function(id, uri) {
		$('p.preview a').html($('<img>').attr('src', uri));
		$('input[name=preview]').prop('checked', true);
		$('input[name=upload_id]').val(id);
	});
	$('input[name=preview]').change(function() {
		if ( ! $(this).prop('checked')) {
			$('p.preview a').text('<?php echo _('choose preview'); ?>');
			$('input[name=upload_id]').val('0');
		}
	});
</script>
