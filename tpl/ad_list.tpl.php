<div id="ad-list-box">
<?php if (is_array($this->ad_list)&&!empty($this->ad_list)): ?>	
	<?php $date=strtotime('now');?>
	<?php foreach ($this->ad_list as $key=>$value): ?>		
	
		<?php if ($date>strtotime(date_format(date_create($value['date']),'Y-m-d'))) :?>
			<?php $date=strtotime(date_format(date_create($value['date']),'Y-m-d')); ?>
			<h4 class="date"><?php /*echo date('d/m/Y',$date); */ echo date_ru('d !  Yг. - *',$date);?></h4>
		<?php endif;?>
	<p>	
		<img class="favorite" src="<?php echo SITE_URL; ?>img/star-off.png" alt="<?php echo LANG_STAR_ALT?>" title="<?php echo LANG_STAR_TITLE?>" ad_id="<?php echo $this->eprint($value['id']); ?>" />&nbsp;<a href="<?php echo SITE_URL; ?>ads/<?php echo $this->eprint($value['id']); ?>.html"><?php /*echo (!empty($value['sum']))?  $this->eprint($value['sum'].''.LANG_CURRENCY.' '):'';*/ echo $this->eprint($value['subject']); ?></a><?php echo (!empty($value['location']))?$this->eprint(' ('.$value['location'].') '):'&#160;'; ?><?php echo  ($value['has_photo']==1)? '<span class="photo-label">'.LANG_PHOTO_LABEL.'</span>' :''; ?><?php echo  ($value['cat_id']>0&&$value['cat_id']!=$this->cat_id)? '&nbsp;&lt;&lt;&nbsp;<span class="category-label"><a href="'.SITE_URL.'view/'.$value['city_name'].'/'.$value['cat_name'].'/">'.$value['cat_disp_name'].'</a></span>' :''; ?><?php echo  ($value['city_id']>0&&$value['city_id']!=$this->city['id'])? '&nbsp;&lt;&lt;&nbsp;<span class="city-label"><a href="'.SITE_URL.'view/'.$value['city_name'].'/">'.$value['city_disp_name'].'</a></span>' :''; ?>
		
	</p>
	<?php endforeach; ?>	
<?php else: ?>	
	<p><?php echo LANG_NO_ADS_TO_DISPLAY; ?></p>	
<?php endif; ?>		

<?php //if (chknum($this->next_page)) :?>
<?php if (($this->next_page)) :?>
	<?php if ($this->title==LANG_FAVORITES_BC) : ?>
		<div id="next-page-box">
			<a href="<?php echo SITE_URL; ?>favorites/<?php echo $this->next_page?>/" title="<?php echo LANG_NEXT_PAGE_TITLE?>"><?php echo LANG_NEXT_PAGE?> <?php echo $this->page_limit?></a>
		</div>
	<?php else: ?>
		<div id="next-page-box">
			<a href="<?php echo SITE_URL; ?>view/<?php echo $this->city['name'];?>/<?php echo $this->category['name'];?>/<?php echo $this->next_page?>/" title="<?php echo LANG_NEXT_PAGE_TITLE?>"><?php echo LANG_NEXT_PAGE?> <?php echo $this->page_limit?></a>
		</div>	
	<?php endif; ?>
<?php endif; ?>

</div>



