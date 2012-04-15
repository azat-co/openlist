<div id="city-list-box">
<h4 style="padding-left:2em;padding-top:1em;"><?php echo LANG_POST_CHOOSE_CITY;?></h4>
<blockquote style="padding-left:1em;">
	

		
<?php if (is_array($this->city_list)): ?>
<div>
<div style="float:left;">
<?php foreach ($this->city_list as $key=>$value): ?>
	<?php if ($value['id']<=11) : ?>
	<a class="<?php echo ($value['id']==1||$value['id']==2||$value['id']==14)?'bold':''; ?>" href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($value['name']); ?>/"> <?php echo $this->eprint($value['disp_name']); ?></a>
	<br/>
	<?php endif; ?>
<?php endforeach; ?>
</div>
<div style="float: left; margin-left: 10em;">
<?php foreach ($this->city_list as $key=>$value): ?>
	<?php if ($value['id']>11) : ?>
	<a class="<?php echo ($value['id']==1||$value['id']==2||$value['id']==14)?'bold':''; ?>" href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($value['name']); ?>/"> <?php echo $this->eprint($value['disp_name']); ?></a>
	<br/>
	<?php endif; ?>
<?php endforeach; ?>	
<?php else: ?>
</div>
</div>	
	<p>There are no ads to display.</p>
	
<?php endif; ?>		
</blockquote>
<?php include ('welcome_text.tpl.php'); ?>
</div>

