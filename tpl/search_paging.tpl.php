<?php if (($this->total_pages>1)) :?>
<div id="search-paging-box">
	<form name="search-paging-form" action="" method="post" >	
		<input type="hidden" name="cat_id" value="<?php echo $this->category['id'];?>"/>
		<input type="hidden" name="city_id" value="<?php echo $this->city['id'];?>"/>
		<input type="hidden" name="search_term" value="<?php echo $this->search_term;?>"/>
		
		<?php echo LANG_SEARCH_PAGING; ?> 
		<select name="page" onchange="submit();">
			<?php for ($i=1;$i<=$this->total_pages;$i++) : ?>
				<option <?php echo ($i==$this->page)?'selected="selected"':'';?> value="<?php echo $i;?>"><?php echo $i;?></option>
			<?php endfor; ?>
		</select>		

	</form>
</div>
<?php endif; ?>		