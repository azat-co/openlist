
<div id="ad-box">
	<?php if (is_array($this->ad)): ?>
		<div id="manage-ad-menu-box">
			<ul class="plain_ul">
				<li><a href="<?php echo SITE_URL; ?>ads/<?php echo $this->eprint($this->ad['id']);?>.html"><?php echo LANG_AM_VEIW_AD;?></a></li>
				<li><a href="<?php echo SITE_URL; ?>ad_manager/view_<?php echo $this->eprint($this->ad['id']);?>_<?php echo $this->eprint($this->ad['code']);?>"><?php echo LANG_AM_VIEW_AD_IN_MANAGER ; ?></a></li>
				<li><a href="<?php echo SITE_URL; ?>ad_manager/delete_<?php echo $this->eprint($this->ad['id']);?>_<?php echo $this->eprint($this->ad['code']);?>"><?php echo LANG_AM_DELETE_AD;?></a></li>
			</ul>
		</div>
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
	<form action="<?php echo SITE_URL; ?>ad_manager/submit_<?php echo $this->eprint($this->ad['id']);?>_<?php echo $this->eprint($this->ad['code']);?>/" method="post"  enctype="multipart/form-data" name="edit-ad-form">
	<table>
	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_SUBJECT?></span><span class="req-star">*</span>:</td>
		<td><input class="subject" type="text" name="subject" value="<?php echo $this->ad['subject']; ?>" size="50"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo LANG_POST_LOCATION?>:&nbsp;<input class="location" type="text" name="location" value="<?php echo  $this->ad['location'] ?>"/></td>
	</tr>

	<tr>
		<td class="label"><span class="req-text"><?php echo LANG_POST_TEXT?></span><span class="req-star">*</span>:</td>
		<td><textarea name="text" rows="10" cols="100" ><?php echo  $this->ad['text'] ?></textarea></td>
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

	<?php if (is_array($this->photo_list)&&count($this->photo_list)>0): ?>
		<?php foreach ($this->photo_list as $key=>$value):  ?>
			<tr>
				<td class="label"><?php echo LANG_POST_PHOTO?>:</td>		
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo PHOTO_SIZE_LIMIT; ?>" />
					<img src="<?php echo SITE_URL; ?>photos/<?php echo $this->eprint($value['photo_id']); ?>" />
					<br/>
					<?php echo LANG_CURRENT_PHOTO;?>
					<br/>
					<label><input type="radio" name="photo_action" value="<?php echo PHOTO_ACTION_KEEP; ?>" checked="checked"/><?php echo LANG_PHOTO_ACTION_KEEP; ?></label>
					<label><input type="radio" name="photo_action" value="<?php echo PHOTO_ACTION_DELETE; ?>"/><?php echo LANG_PHOTO_ACTION_DELETE; ?></label>
					<label><input type="radio" name="photo_action" value="<?php echo PHOTO_ACTION_CHANGE; ?>"/><?php echo LANG_PHOTO_ACTION_CHANGE; ?></label>
					<br/>

					<input class="photo" type="file"  name="photo" value="<?php echo $this->photo; ?>"/>
				</td>
			</tr>
		

		<?php endforeach; ?>
	<?php else: ?>
			<tr>
				<td class="label"><?php echo LANG_POST_PHOTO?>:</td>		
				<td>
					<input type="hidden" name="photo_action" value="<?php echo PHOTO_ACTION_NEW; ?>" />
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo PHOTO_SIZE_LIMIT; ?>" />
					<input class="photo" type="file"  name="photo" value="<?php echo $this->photo; ?>"/>
				</td>
			</tr>
	<?php endif; ?>	
	

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
	<?php else: ?>		
		<p>There are no ads to display.</p>		
	<?php endif; ?>		
</div>
<div id="manage-ad-instructions-box">
	<?php echo sprintf(LANG_AM_INSTRUCTIONS,CONF_DATE_LIMIT); ?>
</div>