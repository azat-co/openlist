<div id="message-box">
	<p>
	<?php if (!empty($this->message)&&is_string($this->message)): ?>
		<?php echo $this->message; ?>
	<?php else :?>
		<?php echo LANG_ER_ERROR; ?>	
	<?php endif; ?>
	</p>

</div>