<?php
	include 'class/includes.php';	
	$view=new Savant3();
	$service=Service::getInstance();
	$view->setPath('template',array(TPL_PATH));	
	if (isset($_POST['search_term'])&&chkid($_POST['city_id'])) { //TODO avoid search if term is empty(?)
		$search_term=htmlentities(text_only(trim($_POST['search_term'])),ENT_QUOTES,CONF_ENC);		
		if ($search_term==LANG_SEARCH_TEXT) {			
			$search_term='';
		}
		else {
			//TODO check for other criteria and if none dispaly message - no search term
		}		
		$view->search_term=$search_term;
		$search_term=(mb_strtoupper($search_term,CONF_ENC));
		$city_id=$_POST['city_id'];
		if (chkid($_POST['cat_id'])) {			
			$cat_id=$_POST['cat_id'];
			$field_list=$service->get_searchable_field_list($cat_id);
			if (count($field_list)>0) {				
				foreach ($field_list as $key=>$value) {					
					switch ($value['type']) {
						case TYPE_NUMBER:
							if (isset($_POST[$value['name'].TYPE_NUMBER_FROM])&&ctype_digit($_POST[$value['name'].TYPE_NUMBER_FROM])&&$_POST[$value['name'].TYPE_NUMBER_FROM]>=0) {
								$field_list[$key]['from']=text_only($_POST[$value['name'].TYPE_NUMBER_FROM]);							
							}
							if (isset($_POST[$value['name'].TYPE_NUMBER_TO])&&ctype_digit($_POST[$value['name'].TYPE_NUMBER_TO])&&$_POST[$value['name'].TYPE_NUMBER_TO]>=0) {
								$field_list[$key]['to']=text_only($_POST[$value['name'].TYPE_NUMBER_TO]);
							}							
							break;
						case TYPE_SELECT:
							if (isset($_POST[$value['name']])&&ctype_digit($_POST[$value['name']])&&$_POST[$value['name']]>=0) {
								$field_list[$key]['default']=text_only($_POST[$value['name']]);	
							}
							$field_list[$key]['option_list']=$service->get_option_list_by_field_id($value['id']);															
							break;
						default:
							break;
					}
				}
				$view->field_list=$field_list;
			}
		}
		else {
			$cat_id=null;
		}
		//echo $search_term;
		if (ctype_digit($_POST['page'])&&$_POST['page']>0) {
			$page=$_POST['page'];
		}
		else {
			$page=1;
		}
		list($view->ad_list,$total_ads_found)=$service->get_ad_list_by_search($city_id, $cat_id, $search_term,$field_list,$page);
		$view->page=$page;	
		$view->total_pages=(int)ceil($total_ads_found/(int)CONF_PAGE_LIMIT);		
		//$view->search_term=$search_term;//for search paging
		$view->field_list=$field_list;//for search paging
		
		$view->city=$service->get_city_by_id($city_id);			
		if ($cat_id!=null) {
			$view->category_path=$service->get_category_path($cat_id);
			$view->category=$service->get_category_by_id($cat_id);
		}
		$view->post_breadcrumb=LANG_SEARCH_POST_BREADCUMB;
		$view->title=LANG_SEARCH_POST_BREADCUMB;
		$view->pushToQueue('header.tpl.php');
		$view->pushToQueue('breadcrumbs.tpl.php');				
		$view->pushToQueue('search.tpl.php');
		$view->pushToQueue('ad_list.tpl.php');
		$view->pushToQueue('search_paging.tpl.php');
		$view->pushToQueue('footer.tpl.php');	
	}
	else {
		$view->pushToQueue('header.tpl.php');
		$view->error_message=LANG_ER_WRONG_FORMAT;
		$view->pushToQueue('error_message.tpl.php');
		$view->pushToQueue('footer.tpl.php');	
	}
		$view->displayQueue();
?>