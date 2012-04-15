<div id="post-ad-form-box">
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
	
	<h2><?php echo LANG_POST_HEADER?></h2>
	
	<form action="<?php echo SITE_URL; ?>post/" method="post"  enctype="multipart/form-data" name="post-ad-form">
	<table>


	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_SUBJECT?></span><span class="req-star">*</span>:</td>
		<td><input class="subject" type="text" name="subject" value="<?php echo $this->subject; ?>" size="50" title="<?php echo LANG_POST_SUBJECT_TITLE; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LANG_POST_LOCATION?>:&nbsp;<input class="location" type="text" name="location" value="<?php echo  $this->location ?>"  title="<?php echo LANG_POST_LOCATION_TITLE; ?>"/></td>
	</tr>
	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_EMAIL?></span><span class="req-star">*</span>:</td>
		<td><input class="email" type="text" name="email" value="<?php echo  $this->email ?>" size="40" title="<?php echo LANG_POST_EMAIL_TITLE; ?>"/>&nbsp;&nbsp;<span class="instructions"><?php echo LANG_POST_EMAIL_MSG?></span></td>
	</tr>
	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_ANONYMIZE?></span><span class="req-star">*</span>:</td>
		<td>
			<label><input class="" type="radio" name="anonymize" value="<?php echo  CONST_POST_ANONYMIZE_YES; ?>" <?php echo ($this->anonymize==CONST_POST_ANONYMIZE_YES||empty($this->anonymize))?'checked="checked"':'';?> title="<?php echo LANG_POST_ANONYMIZE_YES_TITLE; ?>"/><span class="instructions" for="anonymize" title="<?php echo LANG_POST_ANONYMIZE_YES_TITLE; ?>"><?php echo LANG_POST_ANONYMIZE_YES; ?></span></label>
			<label><input class="" type="radio" name="anonymize" value="<?php echo  CONST_POST_ANONYMIZE_NO; ?>" <?php echo ($this->anonymize==CONST_POST_ANONYMIZE_NO)?'checked="checked"':'';?>  title="<?php echo LANG_POST_ANONYMIZE_NO_TITLE; ?>"/><span class="instructions" for="anonymize" title="<?php echo LANG_POST_ANONYMIZE_NO_TITLE; ?>"><?php echo LANG_POST_ANONYMIZE_NO; ?></span></label>
	</tr>	
	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_TEXT?></span><span class="req-star">*</span>:</td>
		<td><textarea name="text" rows="10" cols="100" ><?php echo  $this->text ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<?php if (is_array($this->all_field_list)): ?>
		<?php foreach ($this->all_field_list as $key=>$value): ?>
			<tr>
				<td  class="label"><?php echo $this->eprint($value['disp_name']); ?>:</td>
				<td>
					<?php if ($value['type']==TYPE_NUMBER) : ?>
						<input class="<?php echo $this->eprint($value['name']); ?>" type="text" name="<?php echo $this->eprint($value['name']); ?>" value="<?php echo  $value['default'] ?>"/>
					<?php elseif ($value['type']==TYPE_SELECT) : ?>						
						<select class="<?php echo $this->eprint($value['name']); ?>" name="<?php echo $this->eprint($value['name']); ?>" />&nbsp;
						<option value="" ></option>
							<?php if (is_array($value['option_list'])) :?>			
								<?php foreach ($value['option_list'] as $option_key=>$option_value): ?>				
									<option value="<?php echo $option_value['id'];?>" <?php  if ($option_value['id']==$value['default']){echo  'selected="selected"' ;} ?> ><?php echo $option_value['disp_name'];?></option>
								<?php endforeach; ?>
							<?php endif;?>
						</select>					
					<?php elseif ($value['type']==TYPE_TEXT) : ?>						
						<input class="<?php echo $this->eprint($value['name']); ?>" type="text" name="<?php echo $this->eprint($value['name']); ?>" value="<?php echo  $value['default'] ?>"/>
					<?php endif; ?>	
				</td>			
			</tr>
			<?php echo $this->eprint($value['value']); ?>
			
		<?php endforeach; ?>
	<?php endif; ?>	

	<tr>
		<td class="label"><?php echo LANG_POST_PHOTO?>:</td>
		
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo PHOTO_SIZE_LIMIT; ?>" />
			<input class="photo" type="file"  name="photo" value="<?php echo $this->photo; ?>"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="label"><?php echo LANG_POST_CODE?>:</td>
		<td>
			<?php include 'captcha.tpl.php'; ?>
		</td>
	</tr>
	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_TYPE_CODE?></span><span class="req-star">*</span>: </td>
		<td><input type="text" name="captcha_code"/ class="code"></td></tr>
		
	<tr>
		<td class="label"></td>
		<td><input type="submit" value="<?php echo LANG_POST_SUBMIT?>" /></td></tr>
	</table>
	<input type="hidden" value="submit" name="action"/>
	<input type="hidden" value="<?php echo  $this->eprint($this->category['id']); ?>" name="cat_id"/>
	<p><?php echo LANG_POST_EXPLAIN?></p>

	<p><?php echo LANG_POST_EXPLAIN_STAR1?><span class="req-star">*</span><?php echo LANG_POST_EXPLAIN_STAR2?></p>

	<script type="text/javascript" src="<?php echo SITE_URL; ?>tiny_mce/tiny_mce_gzip.js"></script>
	<script type="text/javascript">
	tinyMCE_GZ.init({
		plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
			'searchreplace, print,contextmenu,paste,styleselect,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
		themes : 'simple,advanced',
		languages : 'en, ru',
		disk_cache : true,
		debug : false
	});
	</script>

	<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_toolbar_location : "top", 
		plugins : "iespell, paste, style,styleselect",
		theme_advanced_buttons1 : "paste ,pastetext ,pasteword,selectall ,separator, formatselect,fontselect,fontsizeselect,separator,bold,italic,underline, strikethrough, separator,justifyleft, justifycenter,justifyright,  justifyfull, separator,forecolor,backcolor,separator,bullist,numlist,separator,undo,redo,separator,  link, unlink, image,code,iespell",
		theme_advanced_buttons2: "",
		theme_advanced_buttons3: "",
		theme_advanced_buttons4: "",
		theme_advanced_layout_manager : "SimpleLayout",
		theme_advanced_toolbar_align : "left",	
		theme_advanced_disable :"",
		language : "en"
	});
	</script>
	</form>
</div>
