<div id="category-list-box">
	<ul>
		<?php if (is_array($this->category_list)): ?>
		<?php $i=0; ?>
		<?php foreach ($this->category_list as $key=>$value): ?>
			<?php if ($value['lvl']==0) : ?>
				<?php if ($i!=0) :?>					
						</ul>
						</div>
					</li>
				<?php endif; ?>			
				<?php $i++;?>
				<li class="category">
					<a href="#" title="<?php echo $value['description'];?>"><?php echo $this->eprint($value['disp_name']); ?></a>
					<span><?php echo $value['description'];?></span>
				<div  class="hide-if-jsActive">
				<ul id="<?php echo $value['name']?>">		
			<?php else:	?>
				<li class="subcategory">
					<a href="<?php echo SITE_URL; ?>post/<?php echo $this->eprint($this->city['name']); ?>/<?php echo $this->eprint($value['name']); ?>/"  class="<?php echo ($value['id']==15||$value['id']==30||$value['id']==51||$value['id']==65||$value['id']==75)?'bold':'';?>" ><?php echo $this->eprint($value['disp_name']); ?></a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
								</ul>
						</div>
					</li>
	</ul>
	<?php else: ?>
		<p>There are no ads to display.</p>		
	<?php endif; ?>		
</div>

