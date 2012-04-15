
<div id="push-box"></div>
</div> <!--wrapper-box-->
<div id="footer-box">
	<div id="line-footer-box"></div>
	<div id="main-footer-box">
		<a href="<?php echo SITE_URL; ?>content/help.html"><?php echo LANG_FOOTER_HELP?></a>&nbsp;|&nbsp;<a href="<?php echo SITE_URL; ?>content/rules.html"><?php echo LANG_FOOTER_AGREEMENT?></a>&nbsp;|&nbsp;<a href="<?php echo SITE_URL; ?>contactus/"><?php echo LANG_FOOTER_CONTACT_US; ?></a>&nbsp;|&nbsp;<a href="http://github.com/azatmardanov/openlist" title="<?php echo LANG_GITHUB_TITLE; ?>" ><img style="position:relative;top:4px;" src="<?php echo SITE_URL;?>img/github_icon2.png" height="16"/></a>
	</div>
	<div id="logo-footer-box">
		<?php if (!empty($this->city)&&!empty($this->category)) :?>
			<span id="rss-logo"><a href="<?php echo SITE_URL;?>rss/<?php echo $this->city['name'];?>/<?php echo $this->category['name'];?>/" title="<?php echo LANG_RSS_TITLE;?>">RSS</a></span>
			&#160;&#160;
		<?php endif; ?>
		<span id="copyright">&copy;</span>
		<span id="logo-footer">
			<a href="<?php echo SITE_URL; ?>">
				<img src="<?php echo SITE_URL; ?>img/favorite.png" width="16" alt="<?php echo LANG_FAVORITE_LOGO_ALT;?>" title="<?php echo LANG_TITLE?>"/>
			</a>
		</span>
		</div>
<!--	<div id="sub-footer-box"><a href="">Choose City</a></div>-->
</div>
	<script src="<?php echo SITE_URL; ?>js/ui.js" type="text/javascript" language="javascript"></script>

	<?php if (!(isset($this->no_counter)&&!empty($this->no_counter)&&$this->no_counter))include('google_analytics.tpl.php'); ?>
</body>
</html>