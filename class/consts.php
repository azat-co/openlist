<?php
/*MUST BY INSYNC WITH SQL FILE otherwise get truncated in db*/
define('AD_SUBJECT_LIMIT',200); 
define('AD_LOCATION_LIMIT',100);
define('AD_EMAIL_LIMIT',100);
define('AD_TEXT_LIMIT',10240);
define('AD_MSG_TEXT_LIMIT',1024);

define('CONST_AD_VALUE_LIMIT',100);

	define('TYPE_NUMBER','num');
	define('TYPE_NUMBER_FROM','_from');
	define('TYPE_NUMBER_TO','_to');
	define('TYPE_TEXT','txt');
	define('TYPE_SELECT','sel');
	
	define('PHOTO_ACTION_KEEP','keep');
	define('PHOTO_ACTION_DELETE','delete');
	define('PHOTO_ACTION_CHANGE','change');
	define('PHOTO_ACTION_CHANGE','new');
	
	define ('CONST_POST_ANONYMIZE_YES','1');
	define ('CONST_POST_ANONYMIZE_NO','0');
?>
