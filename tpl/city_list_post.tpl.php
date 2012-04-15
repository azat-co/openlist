<div id="city-list-box">
<h4 style="padding-left:2em;padding-top:1em;"><?php echo LANG_POST_CHOOSE_CITY;?></h4>
<ul>
<?php if (is_array($this->city_list)): ?>
<?php foreach ($this->city_list as $key=>$value): ?>
	<li>
		<a href="<?php echo SITE_URL; ?>post/<?php echo $this->eprint($value['name']); ?>/"> <?php echo $this->eprint($value['disp_name']); ?></a>
	</li>
<?php endforeach; ?>
<?php else: ?>	
	<p>There are no ads to display.</p>	
<?php endif; ?>		
</ul>
</div>

