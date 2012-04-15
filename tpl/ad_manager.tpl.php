
<div id="ad-box">
	<?php if (is_array($this->ad)): ?>
		<div id="manage-ad-menu-box">
			<ul class="plain_ul">
				<li><a href="<?php echo SITE_URL; ?>ads/<?php echo $this->eprint($this->ad['id']);?>.html"><?php echo LANG_AM_VEIW_AD;?></a></li>
				<li><a href="<?php echo SITE_URL; ?>ad_manager/edit_<?php echo $this->eprint($this->ad['id']);?>_<?php echo $this->eprint($this->ad['code']);?>"><?php echo LANG_AM_EDIT_AD ; ?></a></li>
				<li><a href="<?php echo SITE_URL; ?>ad_manager/delete_<?php echo $this->eprint($this->ad['id']);?>_<?php echo $this->eprint($this->ad['code']);?>"><?php echo LANG_AM_DELETE_AD;?></a></li>
			</ul>
		</div>
		
	<?php include ('ad_view_title.tpl.php');?>	
	<?php include ('ad_view.tpl.php');?>
	
	<?php else: ?>		
		<p>There are no ads to display.</p>		
	<?php endif; ?>		
</div>
<div id="manage-ad-instructions-box">
	<?php echo sprintf(LANG_AM_INSTRUCTIONS,CONF_DATE_LIMIT); ?>
</div>
