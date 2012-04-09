<?php echo Form::open(array('id' => 'login-form')); ?>
	<p>
		<?php echo Form::input('username', $username); ?>
	</p>
	<p>
		<?php echo Form::password('password'); ?>
	</p>
	<p>
		<?php echo Form::submit(_('login'), 'login'); ?>
	</p>
<?php echo Form::close(); ?>

<script>
	$('#login-form').bwLogin();
</script>
