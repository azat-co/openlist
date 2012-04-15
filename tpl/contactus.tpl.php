<div id="contactus-form-box">
<h2>Contact us</h2>

	<?php if (is_array($this->error_list)&&!empty($this->error_list)) :?>
		<div id="post-ad-form-error-messages-box">
		<h4><?php echo LANG_ERRORS; ?></h4>
			<?php foreach ($this->error_list as $key=>$value) : ?>
				<span class="error-message" ><?php echo $this->eprint($value);?></span><br/>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

<form action="" method="post" >
	<table>
		<tr>
			<td class="label">
				<spam class="req-text"><?php echo LANG_CU_TEXT; ?></spam><span class="req-star">*</span>:
			</td>
			<td>
				<textarea name="text" rows="10" cols="50" ><?php echo  $this->text ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="label">
				<?php echo LANG_POST_CODE?>:					
			</td>
			<td>
				<?php include 'captcha.tpl.php'; ?>
			</td>
		</tr>
		<tr>
			<td class="label">
				<spam class="req-text"><?php echo LANG_POST_TYPE_CODE?></spam><span class="req-star">*</span>: 
			</td>
			<td>
				<input type="text" name="captcha_code"/ class="code">
			</td>
		</tr>	
		<tr>		
			<td class="label"></td>
			<td><input type="submit" value="<?php echo LANG_POST_SUBMIT?>" /></td>
		</tr>		
	</table>
<input type="hidden" value="submit" name="action"/>		
</form>
</div>
<?php ?>