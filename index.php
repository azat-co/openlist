<?php
	include 'class/includes.php';
	$service=Service::getInstance();
	$view=new Savant3();
	$view->setPath('template',array(TPL_PATH));		

	if (preg_match('/^([A-Za-z_-]{1,20})$/',$_GET['city_name']) ) {	
		$city_id=$service->get_city_id_by_name($_GET['city_name']);			
		setcookie('city_id',$city_id,time()+60*60*24*365*10 ,'/');
	}
	elseif (isset($_COOKIE['city_id'])) {
		$city_id=$_COOKIE['city_id'];
	}
	if (preg_match('/^([A-Za-z0-9_-]{1,20})$/',$_GET['cat_name']) ) {	
		$cat_id=$service->get_cat_id_by_name($_GET['cat_name']);	
		$view->category=$service->get_category_by_id($cat_id);
	}		
	if (isset($city_id)) {
		$view->city=$service->get_city_by_id($city_id);			
	}	
	if (!isset($city_id)||(isset($_GET['action'])&&$_GET['action']=='cities')) {//cities	
		$view->city_list=$service->get_city_list();
		$view->stylesheet='category_list.css';		
		$view->pushToQueue('header.tpl.php');	
		$view->pushToQueue('city_list.tpl.php');
		$view->keywords=LANG_KEYWORDS_CITIES;
	}
	elseif (!isset($cat_id)) {//list of categories MAIN SCREEN!!!
		$view->category_list=$service->get_category_list_with_ad_count($city_id);	
		$view->stylesheet='category_list.css';
		$view->pushToQueue('header.tpl.php');
		$view->pushToQueue('breadcrumbs.tpl.php');	
		$view->pushToQueue('search.tpl.php');
		$view->city_list=$service->get_city_list();			
		$view->pushToQueue('category_list.tpl.php');
		$view->pushToQueue('city_list_compact.tpl.php');
	}
	else { //view category			
		$view->category_path=$service->get_category_path($cat_id);				
		$view->category=$service->get_category_by_id($cat_id);	
		//$view->title=$view->category['disp_name'];
		$view->field_list=$service->get_searchable_field_list($cat_id);//do additional fields search criterias		
		if (chknum($_GET['page'])) {//do NEXT link and extract ads
			$page=$_GET['page'];
		}
		else {
			$page=1;
		}
		list($view->ad_list,$total_ads_found)=$service->get_ad_list($city_id, $cat_id, $page);		
		if ($total_ads_found>ceil(($page)*(int)CONF_PAGE_LIMIT)) {
			$view->next_page=$page+1;	
			$view->page_limit=CONF_PAGE_LIMIT;				
		}								

		$view->pushToQueue('header.tpl.php');
		$view->pushToQueue('breadcrumbs.tpl.php');												
		$view->pushToQueue('search.tpl.php');							
		$view->pushToQueue('ad_list.tpl.php');			
	}
	$view->pushToQueue('footer.tpl.php');									
	$view->displayQueue();
?>