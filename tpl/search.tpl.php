<div id="search-box">
	<form action="<?php echo SITE_URL; ?>search/" method="post" name="searchForm">
		<input type="text" value="<?php if (empty($this->search_term)) echo LANG_SEARCH_TEXT; else echo $this->eprint($this->search_term); ?>" name="search_term" size="23"  defaultSearchTerm="<?php echo LANG_SEARCH_TEXT?>"/>
		<input type="hidden" value="<?php echo $this->eprint($this->city['id']);?>" name="city_id"/>
		<input type="hidden" value="<?php echo $this->eprint($this->category['id']);?>" name="cat_id"/>		
		
		<?php if (is_array($this->field_list)) :?>			
			<?php foreach ($this->field_list as $key=>$value): ?>				
				
				<?php if ($value['searchable']==1&&$value['type']==TYPE_NUMBER) : ?>
					
					<?php echo $this->eprint($value['disp_name']); ?>&nbsp;
					<?php echo LANG_NUM_FIELD_FROM?>:&nbsp;
					<input type="text" size="5" maxlength="10" name="<?php echo $this->eprint($value['name'].TYPE_NUMBER_FROM); ?>" value="<?php echo $this->eprint($value['from']); ?>"/>&nbsp;
					<?php echo LANG_NUM_FIELD_TO?>:&nbsp;
					<input type="text" size="5" maxlength="10" name="<?php echo $this->eprint($value['name'].TYPE_NUMBER_TO); ?>" value="<?php echo $this->eprint($value['to']); ?>"/>&nbsp;
				<?php endif; ?>
				<?php if ($value['searchable']==1&&$value['type']==TYPE_SELECT) : ?>					
					<?php echo $this->eprint($value['disp_name']); ?>:&nbsp;									
					<select name="<?php echo $this->eprint($value['name']); ?>" >
					<option value="" ></option>
						<?php if (is_array($value['option_list'])) :?>			
							<?php foreach ($value['option_list'] as $option_key=>$option_value): ?>				
								<option value="<?php echo $option_value['id'];?>" <?php  if ($option_value['id']==$value['default']){echo  'selected="selected"' ;} ?> ><?php echo $option_value['disp_name'];?></option>
							<?php endforeach; ?>
						<?php endif;?>
					</select>					
				<?php endif; ?>				
				<?php if ($value['type']==TYPE_TEXT) : ?>					
					<?php echo $this->eprint($value['disp_name']); ?>&nbsp;
					<input type="text" size="5" maxlength="10" name="<?php echo $this->eprint($value['name']); ?>" value="<?php echo $this->eprint($value['default']); ?>"/>&nbsp;
				<?php endif; ?>				
			<?php endforeach; ?>
		<?php endif; ?>
		<input type="submit" value="<?php echo LANG_SEARCH_BUTTON?>" name="submit"/>
	</form>
</div>

</div><!--nav-menu-wrapper-box-->
</div> <!--nav-menu-box-->
