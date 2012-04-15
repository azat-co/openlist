<div id="captcha-box">
	<div id="captcha-image-box">
		<img id="captcha" src="<?php echo SITE_URL; ?>securimage/securimage_show.php" alt="CAPTCHA Image" />
	</div>
	<div id="captcha-buttons-box">
	<a title="Audible Version of CAPTCHA" href="<?php echo SITE_URL; ?>securimage/securimage_play.php" style="border-style: none;" tabindex="-1">
		<img border="0" align="top" onclick="this.blur()" alt="Audio Version" src="<?php echo SITE_URL; ?>securimage/images/audio_icon.gif"/>
	</a>
	<a onclick="document.getElementById('captcha').src = '<?php echo SITE_URL; ?>securimage/securimage_show.php?sid=' + Math.random(); return false" title="Refresh Image" href="#" style="border-style: none;" tabindex="-1" >
		<img border="0" align="bottom" onclick="this.blur()" alt="Reload Image" src="<?php echo SITE_URL; ?>securimage/images/refresh.gif"/>
	</a>
	</div>
</div>