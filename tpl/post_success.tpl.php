<div id="success-message-box">
	<p>
	<?php if (!empty($this->success_message)&&is_string($this->success_message)): ?>
		<?php echo $this->success_message; ?>
	<?php else :?>
		<?php echo LANG_ER_ERROR; ?>	
	<?php endif; ?>
	</p>
</div>
