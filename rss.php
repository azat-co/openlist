<?php

	include 'class/includes.php';
	$service=Service::getInstance();
	$view=new Savant3();
	$view->setPath('template',array(TPL_PATH));		
	
	if (preg_match('/^([A-Za-z_-]{1,20})$/',$_GET['city_name']) ) {	
		$city_id=$service->get_city_id_by_name($_GET['city_name']);			
		setcookie('city_id',$city_id,time()+60*60*24*365*10 ,'/');
	}
	if (preg_match('/^([A-Za-z0-9_-]{1,20})$/',$_GET['cat_name']) ) {	
		$cat_id=$service->get_cat_id_by_name($_GET['cat_name']);	
		$view->category=$service->get_category_by_id($cat_id);
	}		
	if (chkid($cat_id)&&chkid($city_id)) {		

		$view->category=$service->get_category_by_id($cat_id);

		$view->city=$service->get_city_by_id($city_id);

		$view->ad_list=$service->get_ad_list_for_rss($city_id, $cat_id);		


		header("Content-Type: application/xml; charset=utf-8\r\n");
		echo '<?xml version="1.0" encoding="'.CONF_ENC.'" ?>';
		$view->pushToQueue('rss.tpl.php');

		$view->displayQueue();
		
	}
	else {
		header('Status:404');
		//echo '!';
	}

?>