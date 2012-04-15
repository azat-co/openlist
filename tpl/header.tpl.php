<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php if (!empty($this->title)) : ?>
			<?php echo $this->title; ?>&nbsp;|&nbsp;
		<?php elseif (!empty($this->post_breadcrumb)) : ?>
			<?php  echo $this->eprint($this->post_breadcrumb); ?>
				<?php if (!empty($this->city['disp_name'])) : ?>&nbsp;|&nbsp;
			<?php endif; ?>	
		<?php endif; ?>
		<?php if (is_array($this->category_path)): ?>
			<?php foreach (array_reverse($this->category_path) as $key=>$value): ?>
				<?php echo $this->eprint($value['disp_name']); ?>&nbsp;|&nbsp;
			<?php endforeach; ?>
		<?php endif; ?>					
		<?php if (!empty($this->city)) : ?>
			<?php echo $this->eprint($this->city['disp_name']); ?>&nbsp;|&nbsp;
		<?php endif; ?>		
		<?php echo LANG_TITLE; ?>
	</title>
	<link href="<?php echo SITE_URL; ?>css/main.css" rel="stylesheet" type="text/css" media="all"/>
	<?php if (!empty($this->stylesheet)) : ?>
		<link href="<?php echo SITE_URL; ?>css/<?php echo $this->stylesheet; ?>" rel="StyleSheet" type="text/css" media="screen"/>
	<?php endif; ?>
	<link rel="shortcut icon" href="<?php echo SITE_URL; ?>favorite.ico"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>	
	<meta name="description" content="<?php echo LANG_DESCRIPTION?>" />
	<meta name="keywords" content="<?php echo (isset($this->keywords)&&!empty($this->keywords))?$this->keywords:LANG_KEYWORDS ; ?>" />
	<meta http-equiv="content-language" content="<?php echo LANG_CONTENT_LANG?>" />
	<meta name="revisit" content="2 days"></meta>
	<meta name="revisit-after" content="2 days"></meta>
	<meta name="robots" content="all, index, follow"></meta>
	<meta name="googlebot" content="all, index, follow"></meta>
	<meta name="title" content="<?php echo LANG_TITLE; ?>" />  
	<!--<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />-->
	<link rel="author" href="<?php echo SITE_URL; ?>contactus/" title="Contact us"/>
	<link rel="contents" href="<?php echo SITE_URL; ?>" title="Categories" />
	<link rel="copyright" href="<?php echo SITE_URL; ?>content/rules.html" title="Rules" />
	<link rel="help" href="<?php echo SITE_URL; ?>content/help.html" title="Help" />
	<link rel="home" href="<?php echo SITE_URL; ?>" title="Home" />
	<!--<link rel="glossary" href="glossary.php" title="Glossary of insert subject Terms" />-->
	<link rel="last" href="#breadcrumbs-box" title="Navigation" />
	<link rel="search" href="#search-box"title="Search" />
	<link rel="up" href="#menu-box" title="Top of the page" />
	<?php if (!empty($this->city)&&!empty($this->category)) :?>
		<link rel="alternate" type="application/rss+xml" title="<?php echo LANG_RSS_TITLE;?>" href="<?php echo SITE_URL;?>rss/<?php echo $this->city['name'];?>/<?php echo $this->category['name'];?>/" />
	<?php endif; ?>
    <script language="javascript" type="text/javascript" src="<?php echo SITE_URL; ?>js/consts.js"></script>
</head>
<body>
	<div id="wrapper-box" >
	<div id="menu-box">
		<div id="menu-wrapper-box">
			<div id="sub-menu-box">
				<span id="link-to-favorites" <?php echo (isset($_COOKIE['in_favorites'])&&!empty($_COOKIE['in_favorites']))?'':'class="hide"'; ?> ><img src="<?php echo SITE_URL; ?>img/star-on.png" width="14" alt="<?php echo LANG_STAR_ALT; ?>" /><a href="<?php echo SITE_URL; ?>favorites/"  defaultText="<?php echo LANG_FAVORITES?>" title="<?php echo LANG_FAVORITES_TITLE;?>"><?php echo LANG_FAVORITES?></a> |</span> <a href="<?php echo SITE_URL; ?>post/<?php if(!empty($this->city['name'])) { echo $this->city['name'].'/'; if (!empty($this->category['name'])) echo $this->category['name'].'/';} ?>"><?php echo LANG_POST_AD?></a> <!--|  <a href=""><?php echo LANG_LOGIN?></a>-->
			</div>
			<div id="logo-box">
				<h1><a href="<?php echo SITE_URL; ?>cities/"><?php echo LANG_LOGO?></a><span id="moto"><?php echo LANG_LOGO_TEXT?></span></h1>
			</div>
		</div>		
		<?php echo ($this->breadcrumbs); ?>
	</div>