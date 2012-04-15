<?php
/*functions that are used in many places*/

function isemail($email) {
    return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);

 // /* Define the test for a valid email address */  
 // $email_test = "/  
 // ^([a-zA-Z0-9_\.\-\+])  
 // +  
 // \@  
 // (([a-zA-Z0-9\-])+\.)  
 // +  
 // ([a-zA-Z0-9]{2,4})+$  
 // /x";  
}
   
function chkid($id) {
	return (isset($id)&&ctype_digit($id)&&!empty($id));
}
function chknum($val) {
	//echo ctype_digit($val);
	return (isset($val)&&ctype_digit($val)&&!empty($val));
}
function chkval($value,$type) { //type: num, txt
	//switch ($value
}
// function load_language($lang) {	
	// require_once ($lang);
// }
/*
  these are the russian additional format characters
  д: full textual representation of the day of the week
  Д: full textual representation of the day of the week (first character is uppercase),
  к: short textual representation of the day of the week,
  К: short textual representation of the day of the week (first character is uppercase),
  м: full textual representation of a month
  М: full textual representation of a month (first character is uppercase),
  л: short textual representation of a month
  Л: short textual representation of a month (first character is uppercase),
*/

function date_ru($formatum, $timestamp=0) {

  if (($timestamp <= -1) || !is_numeric($timestamp)) return '';
  
  $q['*'] = array(-1 => 'w', 'воскресенье','понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота');
  $q['Д'] = array(-1 => 'w', 'Воскресенье','Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
  $q['к'] = array(-1 => 'w', 'вс','пн', 'вт', 'ср', 'чт', 'пт', 'сб');
  $q['К'] = array(-1 => 'w',  'Вс','Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб');
  $q['!'] = array(-1 => 'n', '', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
  $q['М'] = array(-1 => 'n', '', 'Января', 'Февраля', 'Март', 'Апреля', 'Май', 'Июня', 'Июля', 'Август', 'Сентября', 'Октября', 'Ноября', 'Декабря');
  $q['л'] = array(-1 => 'n', '', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');
  $q['Л'] = array(-1 => 'n', '',  'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');

  if ($timestamp == 0)
    $timestamp = time();
  $temp = '';
  $i = 0;
  while ( (strpos($formatum, '*', $i) !== FALSE) || (strpos($formatum, 'Д', $i) !== FALSE) ||
          (strpos($formatum, 'к', $i) !== FALSE) || (strpos($formatum, 'К', $i) !== FALSE) ||
          (strpos($formatum, '!', $i) !== FALSE) || (strpos($formatum, 'М', $i) !== FALSE) ||
          (strpos($formatum, 'л', $i) !== FALSE) || (strpos($formatum, 'Л', $i) !== FALSE)) {
    $ch['*']=strpos($formatum, '*', $i);
    $ch['Д']=strpos($formatum, 'Д', $i);
    $ch['к']=strpos($formatum, 'к', $i);
    $ch['К']=strpos($formatum, 'К', $i);
    $ch['!']=strpos($formatum, '!', $i);
    $ch['М']=strpos($formatum, 'М', $i);
    $ch['л']=strpos($formatum, 'л', $i);
    $ch['Л']=strpos($formatum, 'Л', $i);
    foreach ($ch as $k=>$v) {
		if ($v === FALSE) {
			unset($ch[$k]);
		}	
	}
    $a = min($ch);
    $temp .= date(substr($formatum, $i, $a-$i), $timestamp) . $q[$formatum[$a]][date($q[$formatum[$a]][-1], $timestamp)];
    $i = $a+1;
  }
  $temp .= date(substr($formatum, $i), $timestamp);
  return $temp;
}

function validip($ip) {
	if (!empty($ip) && ip2long($ip)!=-1) {
		$reserved_ips = array ( 
			array('0.0.0.0','2.255.255.255'), 
			array('10.0.0.0','10.255.255.255'),	 
			array('127.0.0.0','127.255.255.255'),	 
			array('169.254.0.0','169.254.255.255'),	 
			array('172.16.0.0','172.31.255.255'),	 
			array('192.0.2.0','192.0.2.255'),	 
			array('192.168.0.0','192.168.255.255'), 
			array('255.255.255.0','255.255.255.255')
		);	 	
	foreach ($reserved_ips as $r) {	 
	$min = ip2long($r[0]);	 
	$max = ip2long($r[1]);	 
	if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;	 
	}	 
	return true;	 
	} 
	else {	 
		return false;	 
	}
}
 
function getip() {
	if (validip($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
		if (validip(trim($ip))) {
			return $ip;
		}
	}
	if (validip($_SERVER["HTTP_X_FORWARDED"])) { 
		return $_SERVER["HTTP_X_FORWARDED"];		 
	} elseif (validip($_SERVER["HTTP_FORWARDED_FOR"])) {		 
		return $_SERVER["HTTP_FORWARDED_FOR"];		 
	} elseif (validip($_SERVER["HTTP_FORWARDED"])) {		 
		return $_SERVER["HTTP_FORWARDED"];		 
	} elseif (validip($_SERVER["HTTP_X_FORWARDED"])) {		 
		return $_SERVER["HTTP_X_FORWARDED"];		 
	} else {		 
		return $_SERVER["REMOTE_ADDR"];
	}
}

function text_only($text) {
	static $purifier=false;
	static $purifier_config=false;
	if (!$purifier) {
		$config = HTMLPurifier_Config::createDefault();	// configuration goes here:
		$config->set('Core.Encoding', CONF_ENC); // replace with your encoding
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
		$config->set('HTML.Allowed', '');
		$purifier = new HTMLPurifier($config); //or USE HTMLPurifier ($html,$config) function
	}
	else {
	}
	$text = $purifier->purify($text);
	return $text;
}

?>