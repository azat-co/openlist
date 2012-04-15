<div id="ad-box">
	<?php if (is_array($this->ad)): ?>
	
		<?php include ('ad_view_star_title.tpl.php');?>
		<?php if ($this->ad['anonymize']==1) include 'ad_view_send_message_link.tpl.php';?>
		<?php include ('ad_view.tpl.php');?>
		
		
		<div id="ad-flagging-box">
			<span class="flag">flag ad</span>[<a href="<?php echo SITE_URL; ?>content/help.html" target="_blank">?</a>]:
			<ul>
				<li><a class="flag" id="flag-spam" value="spam_<?php echo $this->eprint($this->ad['id'])?>"  href="#" title="repeated, spam">
					repeat / spam</a></li>
				<li><a class="flag" id="flag-miscat" value="miscat_<?php echo $this->eprint($this->ad['id'])?>" href="#" title="wrong category">
					wrong category</a></li>
				<li><a class="flag" id="flag-viol" value="viol_<?php echo $this->eprint($this->ad['id'])?>" href="#" title="rules violation">
					rules violation</a></li>
				<li><a class="flag" id="flag-best" value="best_<?php echo $this->eprint($this->ad['id'])?>" href="#" title="best list!">
				like</a></li>
			</ul>		
		</div>	
		
		
		<div id="ad-email-friend-box">
			<div id="openform-button-box">
				<input value="<?php echo LANG_AD_EF_OPEN;?>" name="openform"type="button" ad_id="<?php echo $this->ad['id']; ?>"/>
			</div>
			<div id="form-box">

			</div>
		</div>

		<script type="text/javascript" language="javascript" src="<?php echo SITE_URL; ?>js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo SITE_URL; ?>js/ad_email_friend.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo SITE_URL; ?>js/send_flag.js"></script>
	<?php else: ?>		
		<p><?php echo LANG_ER_NO_DATA; ?></p>		
	<?php endif; ?>		
</div>
<?php if ($this->ad['anonymize']==1) include ('ad_send_message.tpl.php');				?>