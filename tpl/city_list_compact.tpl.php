<div id="compact-city-list-box">
<h4><?php echo LANG_CHOOSE_OTHER_CITY?></h4>
<ul>
<?php if (is_array($this->city_list)): ?>
<?php foreach ($this->city_list as $key=>$value): ?>
	<?php if ($this->city['id']==$value['id']) : ?>
		<li class="default"><?php echo $this->eprint($value['disp_name']); ?></li>
	<?php else : ?>
		<li><a href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($value['name']); ?>/"> <?php echo $this->eprint($value['disp_name']); ?></a></li>
	<?php endif; ?>
<?php endforeach; ?>
<?php else: ?>
	
	<p>There are no ads to display.</p>
	
<?php endif; ?>		
</ul>

<h4><?php echo LANG_CHOOSE_FORUM?></h4>
<ul>
	<li><a href="http://github.com/azatmardanov/openlist">comment on GitHub</a></li>

</ul>
</div>

</div><!--content-box-->