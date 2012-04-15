<div id="error-message-box">
	<p>
	<?php if (!empty($this->error_message)&&is_string($this->error_message)): ?>
		<?php echo $this->error_message; ?>
	<?php else :?>
		<?php echo LANG_ER_ERROR; ?>	
	<?php endif; ?>
	</p>
	<p>
		<?php echo LANG_ER_HOME_PAGE; ?>
	</p>
</div>