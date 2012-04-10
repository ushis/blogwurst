<?php echo Form::open(); ?>
	<p>
		<label>
			<?php echo _('username'); ?>
			<?php echo Form::input('username', $username, array('disabled')); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo _('email'); ?>
			<?php echo Form::input('email', $email); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo _('new password'); ?>
			<?php echo Form::password('password'); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo _('confirm password'); ?>
			<?php echo Form::password('c_password'); ?>
		</label>
	</p>
	<p>
		<label>
			<?php echo _('old password'); ?>
			<?php echo Form::password('old_password'); ?>
		</label>
	</p>
	<p>
		<?php echo Form::submit('save', _('save')); ?>
	</p>
<?php echo Form::close(); ?>
