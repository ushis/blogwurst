<?php echo Form::open(); ?>
	<p>
		<?php echo Form::input('title', $article->title); ?>
	</p>
	<p>
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
	$('input[name=tags]').bwCompleteList(<?php echo json_encode($tags); ?>);
	$('p.preview a').bwImageChooser('<?php echo Uri::create('admin/uploads/index/img'); ?>', function(href, src) {
		$('p.preview a').html($('<img>').attr('src', src));
		$('input[name=preview]').prop('checked', true);
		$('input[name=upload_id]').val(href.substring(8));
	});
	$('input[name=preview]').change(function() {
		if ( ! $(this).prop('checked')) {
			$('p.preview a').text('<?php echo _('choose preview'); ?>');
			$('input[name=upload_id]').val('0');
		}
	});
</script>
