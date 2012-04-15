<rss version="2.0">
	<channel>
		<title><?php echo LANG_TITLE; ?> | <?php echo $this->category['disp_name']; ?></title>
		<link><?php echo SITE_URL; ?>view/<?php echo $this->city['name']; ?>/<?php echo $this->category['name']; ?>/</link>
		<description><?php echo $this->category['disp_name']; ?></description>
		<language><?php echo CONF_LANG;?></language>
		<copyright>Copyright &#x26;copy; <?php echo LANG_LOGO;?></copyright>
		<generator><?php echo MONSTER_EMAIL;?></generator>
		<webMaster><?php echo ADMIN_EMAIL; ?></webMaster>
		<image>
			<url><?php echo SITE_URL; ?>img/favorite.png</url>
			<title><?php echo LANG_LOGO;?> </title>
			<link><?php echo SITE_URL; ?></link>
		</image>
		
	
	<?php if (!empty($this->ad_list)&&is_array($this->ad_list)) :?>
		<?php foreach ($this->ad_list as $ad) : ?>
		<item>
			<title><![CDATA[<?php echo $ad['subject']; ?>]]></title>
			<link><?php echo SITE_URL; ?>ads/<?php echo $ad['id']; ?>.html</link>
			<description><![CDATA[		<?php echo $ad['text']; ?>		]]></description>
			<pubDate><?php echo date('r', strtotime($ad['date']));?></pubDate>
			<guid><?php echo $ad['id'];?></guid>		
		</item>
		<?php endforeach; ?>
	<?php else : ?>
	 <!--<item>!</item>-->
	<?php endif;?>
	</channel>
</rss>