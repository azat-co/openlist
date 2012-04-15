<div id="content-box">
<div id="category-list-box">
<!--<ul style="display:none;">-->
<?php $i=0; ?>
<?php if (is_array($this->category_list)): ?>
<?php foreach ($this->category_list as $key=>$value): ?>
	<?php if ($value['lvl']==0) : ?>		
		<?php if ($i!=0) :?>
			</ul>
		<?php endif; ?>
		<?php $i++;?>
		<ul id="<?php echo $value['name']?>">
		<li class="category">
	<?php else:	?>
		<li class="subcategory">
	<?php endif; ?>
	<a class="<?php echo ($value['id']==15||$value['id']==30||$value['id']==51||$value['id']==65||$value['id']==75)?'bold':'';?>" href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($this->city['name']); ?>/<?php echo $this->eprint($value['name']); ?>/" title="<?php  echo (!empty($value['description'])&&$value['lvl']==0)? $value['description']:''; /*echo ($value['ad_count']!=0)?' ('.$value['ad_count'].')':''; */?>" ><?php echo $this->eprint($value['disp_name']); ?></a>
	<?php echo ($value['lvl']==0&&$value['ad_count']==0)?'<span class="ad-count">(0)</span>':($value['lvl']==0)?'<span class="ad-count">('.$value['ad_count'].')</span>':''; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
	
	<p><?php echo LANG_NOTHING_TO_DISPLAY; ?></p>
	
<?php endif; ?>		

</div>

