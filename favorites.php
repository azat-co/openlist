<?php
	//session_start();
	header("Cache-Control: no-cache");
	header("Expires: -1");
	include ('class/includes.php');	
	$service=Service::getInstance();	
	$view=new Savant3();	
	$view->setPath('template',array(TPL_PATH));		
	
	$view->post_breadcrumb=LANG_FAVORITES_BC;
	$view->title=LANG_FAVORITES_BC;
	if (isset($_COOKIE['city_id'])&&!empty($_COOKIE['city_id']) ) {		
		$city_id=$_COOKIE['city_id'];
		$view->city=$service->get_city_by_id($city_id);	
	}

	//echo '*'.$_COOKIE['in_favorites'];
	if (isset($_COOKIE['in_favorites'])&&!empty($_COOKIE['in_favorites']) ) {
		$ad_id_list=array();
		$ad_id_list=explode('_',$_COOKIE['in_favorites']);
		if (chknum($_GET['page'])) {
			$page=$_GET['page'];
		}
		else {
			$page=1;
		}
		list($view->ad_list,$total_ads_found)=$service->get_ad_list_by_id_list($ad_id_list, $page);		
		if (count($view->ad_list)==0) {
			setcookie('in_favorites', '', time()-99999,'/');
		}
		else {
			// $ad_id_list=array();
			// foreach($view->ad_list as $k=>$v) {
				// $ad_id_list[]=$v['id'];
			// }
			// setcookie('in_favorites', implode('_',$ad_list_array),time()+60*60*24*365*10,'/');
			setcookie('in_favorites', implode('_',array_map(create_function('$v','return $v["id"];'),$view->ad_list)),time()+60*60*24*365*10,'/');
		}
		if ($total_ads_found>ceil(($page)*(int)CONF_PAGE_LIMIT)) {
			$view->next_page=$page+1;	
			$view->page_limit=CONF_PAGE_LIMIT;	
		}					
		
		$has_ads=true;
	}	
	else {		
		$has_ads=false;
		$view->error_message=LANG_NO_FAV_TO_DISPLAY;
	}
	$view->pushToQueue('header.tpl.php');
	$view->pushToQueue('breadcrumbs.tpl.php');
	$view->pushToQueue('search.tpl.php');
	if ($has_ads) {
		$view->pushToQueue('ad_list.tpl.php');	
	}
	else {
		$view->pushToQueue('error_message.tpl.php');		
	}		

	$view->pushToQueue('footer.tpl.php');
	$view->displayQueue();
?>