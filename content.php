<?php
	include 'class/includes.php';	
    $service = Service::getInstance();
	$view=new Savant3();
	$view->setPath('template',array(TPL_PATH));	
	$view->stylesheet='content.css';
	$view->pushToQueue('header.tpl.php');	
	$error='';
	$content='';
	//echo $_GET['name'];
	if (preg_match('/^([A-Za-z]{1,20})$/', $_GET['name'])) {//([A-Za-z]{1,20})
		$content=$service->get_content_by_name($_GET['name']);		
		if (!is_null($content)&&is_array($content)) {
			$view->post_breadcrumb=$content['title'];
			$content=$content['text'];				
		}
		else {
		$error=LANG_ER_NO_DATA;
		}
	}
	elseif (chkid($_GET['id'])) {	
		$id=$_GET['id'];
		try {
			$content_list=$service->get_content_list($id);		
			
			if (count($content_list)==1) {
				$view->post_breadcrumb=$content_list[0]['title'];
				$content=$content_list[0]['text'];
			}
			else {
				$error= LANG_ER_NO_DATA;
			}	
		}
		catch (Exception $e) {
			$error= LANG_ER_ERROR;
		}
	}
	else {
		$error=LANG_ER_WRONG_FORMAT;
	}
	if (chkid($_COOKIE['city_id'])) {
		$city_id=$_COOKIE['city_id'];
		$view->city=$service->get_city_by_id($city_id);			
	}
	$view->pushToQueue('breadcrumbs.tpl.php');	
	$view->pushToQueue('search.tpl.php');
	if (!empty($error)) {
		$view->error_message=$error;
		$view->pushToQueue('error_message.tpl.php');	
	}
	elseif (!empty($content)) {
		$view->content=$content;	
		$view->pushToQueue('content.tpl.php');	
	}	
	$view->pushToQueue('footer.tpl.php');
	$view->displayQueue();

?>