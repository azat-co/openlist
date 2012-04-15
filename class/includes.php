<?php
//error_reporting(0);//TODO: uncomment in prod
require_once 'config.php';
require_once './Savant3/Savant3.php';


//require_once 'crud.class.php';
include 'service.class.php';

include './htmlpurifier/library/HTMLPurifier.auto.php';

require_once 'sqls.php';
require_once 'utils.php';
require_once 'consts.php';//constants for system

include 'helpers.php';

require_once DEFAULT_LANGUAGE;


?>