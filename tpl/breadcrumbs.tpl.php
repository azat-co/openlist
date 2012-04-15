<div id="nav-menu-box">
<div id="nav-menu-wrapper-box">	
	<div id="breadcrumbs-box">
	<a href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($this->city['name']); ?>/"> <?php echo $this->eprint($this->city['disp_name']); ?></a>
	<?php if (is_array($this->category_path)): ?>
		<?php foreach ($this->category_path as $key=>$value): ?>
			&nbsp;&gt;&nbsp;<a href="<?php echo SITE_URL; ?>view/<?php echo $this->eprint($this->city['name']); ?>/<?php echo $this->eprint($value['name']); ?>/"> <?php echo $this->eprint($value['disp_name']); ?></a>
		<?php endforeach; ?>
	<?php endif; ?>	
	<?php if (!empty($this->post_breadcrumb)) : ?>
		<?php if (!empty($this->city['disp_name'])) : ?>
		&nbsp;&gt;&nbsp;
		<?php endif; ?>	
		<em><?php  echo $this->eprint($this->post_breadcrumb); ?></em>
	<?php endif; ?>
	</div>
