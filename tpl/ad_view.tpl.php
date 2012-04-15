
<div><b><?php echo LANG_AD_SM_DATE?></b>:&nbsp;<?php echo $this->eprint(date_format(date_create($this->ad['date']),DATE_FORMAT)); /* echo date_ru('d !  Yг. - *',strtotime($this->ad['date']));*/ ?></div>
<div><b><?php echo LANG_AD_SM_ID?></b>:&nbsp;<?php echo $this->eprint($this->ad['id']); ?></div>		
<p><?php echo $this->ad['text']; ?></p>
<?php if (is_array($this->value_list)): ?>
	<?php foreach ($this->value_list as $k=>$v): ?>				
		<b><?php echo $this->eprint($v['disp_name']); ?></b>:<?php echo $v[($v['type']==TYPE_SELECT) ? 'selvalue':'value']  ; ?>
		<br/>
	<?php endforeach; ?>
<?php endif; ?>	
<br/><br/>
<?php if (is_array($this->photo_list)): ?>
	<?php foreach ($this->photo_list as $key=>$value): ?>
		<img src="<?php echo SITE_URL; ?>photos/<?php echo $this->eprint($value['photo_id']); ?>/" />
		<br/>
	<?php endforeach; ?>
<?php endif; ?>	

<script type="text/javascript" language="javascript" src="<?php echo SITE_URL; ?>js/send_flag.js"></script>