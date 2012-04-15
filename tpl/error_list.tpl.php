	<?php if (is_array($this->error_list)&&!empty($this->error_list)) :?>
		<div id="post-ad-form-error-messages-box">
		<h4><?php echo LANG_ERRORS; ?></h4>
			<ul class="error-message">
			<?php foreach ($this->error_list as $key=>$value) : ?>
				<li><span class="error-message" ><?php echo $this->eprint($value);?></span></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>