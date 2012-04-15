<?php
	include 'class/includes.php';
	$service=Service::getInstance();
	session_start();
	
	$view=new Savant3();	
	$view->setPath('template',array(TPL_PATH));		
	$view->pushToQueue('header.tpl.php');
	
	if (!isset($_GET['id'])||!ctype_digit($_GET['id'])) {
		//TODO redirect to index.php	
	}	
	else {
		$id=$_GET['id'];
		try {
			$ad=$service->get_ad_by_id_pp($id); //pp- plus plus : increase counter of views in DB
			//TODO	this check in sql in model.class.php (to be written in alpha)
			if ($ad['verified']==1&&$ad['active']==1&&((time()-date_format(date_create($ad['date']),'U'))<=(60*60*24*(int)CONF_DATE_LIMIT))) {		
				$cat_id=$ad['cat_id'];
				$city_id=$ad['city_id'];				
				$view->category_path=$service->get_category_path($cat_id);			
				$view->city=$service->get_city_by_id($city_id);			
				$view->category=$service->get_category_by_id($cat_id);							
				$view->field_list=$service->get_searchable_field_list($cat_id);//do additional fields search criterias								
				$view->photo_list=$service->get_photo_list($id);
				$view->ad=$ad;	
				$view->value_list=$service->get_value_list($id);
				$view->post_breadcrumb=$ad['subject'];
				$view->pushToQueue('breadcrumbs.tpl.php');
				$view->pushToQueue('search.tpl.php');
				$view->pushToQueue('ad.tpl.php');
				// if ($ad['anonymize']==1) $view->pushToQueue('ad_send_message.tpl.php');				
			}	
			else {
				$view->error_message=LANG_ER_NO_AD;				
				$view->pushToQueue('error_message.tpl.php');
				}
		}
		catch (Exception $e) {
			$view->error_message=LANG_ER_ERROR;
			$view->pushToQueue('error_message.tpl.php');
		}

	}
	$view->pushToQueue('footer.tpl.php');
	$view->displayQueue();
?>