<?php if ( ! empty($articles)): ?>
<ul class="index">
	<?php foreach($articles as $article): ?>
	<li>
		<?php echo Html::anchor('admin/articles/delete/'.$article->id, '×', array('class' => 'del')); ?>
		<?php echo Html::anchor('admin/articles/edit/'.$article->id, $article->title); ?>
	<li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
	<p class="empty">
		<?php echo Html::anchor('admin/articles/add', '+'); ?>
	</p>
<?php endif; ?>
