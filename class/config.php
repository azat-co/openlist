<?php 
	error_reporting(0);//TODO: uncomment in prod
	define('DEFAULT_LANGUAGE','en.lang.php');
	// define('DEFAULT_LANGUAGE','ru.lang.php');
	//$page_limit=20; 
	//$date_limit=60; 
	define ('CONF_PAGE_LIMIT',100);  //number of ad per page
	define ('CONF_DATE_LIMIT',60); //limit after how many days ad won't show
	date_default_timezone_set('Europe/London');
	// date_default_timezone_set('Europe/Moscow');
	define ('CONF_LANG','ru');
	//define ('CONF_LANG','en-us');
	
	define('CONF_ENC','UTF-8');
	define('DATE_FORMAT','d/m/Y');
	//define(DATE_FORMAT,'Д, d л Y');
	define('PHOTO_SIZE_LIMIT','50000');
	define ('PHOTO_TYPES','jpg,jpeg,pjpeg,gif,png,bmp,tiff'); 
	
	define('SITE_URL','http://localhost/');
	// define('SITE_URL','http://openlist.co/');
	define('TPL_PATH','tpl/');
	
	define('ADMIN_EMAIL','admin@openList.co');
	define('MONSTER_EMAIL','monster@openList.co');
	define('LOG_EMAIL','log@openList.co');
	define('CONF_VERSION_LANG','');
	
?>