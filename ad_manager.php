<?php
	include 'class/includes.php';
	$service=Service::getInstance();
	session_start();
	$view=new Savant3();	
	$view->setPath('template',array(TPL_PATH));		
	$view->pushToQueue('header.tpl.php');
	

	
if (isset($_GET['code'])&&ctype_alnum($_GET['code'])&&isset($_GET['id'])&&ctype_digit($_GET['id'])) {
	if (isset($_GET['action'])&&ctype_alpha($_GET['action'])) {
		$action=$_GET['action'];
	}
	else {
		$action=null;
	}
	$code=$_GET['code'];
	$id=$_GET['id'];

	$ad=$service->get_ad_by_id($id);
	if (!empty($ad)&&is_array($ad)&&$ad['code']==$code&&$ad['active']==1) {	
		$city_id=$ad['city_id'];	
		$cat_id=$ad['cat_id'];
		switch ($action) {
			case 'edit':
			case 'submit':
				if ($action=='submit') {
					//do validation and save					
					$error=false;
					$error_list=array();
					$subject=htmlentities(text_only(trim($_POST['subject'])),ENT_QUOTES,CONF_ENC,false);		//$str = mb_convert_encoding($str, ‘UTF-8', ‘UTF-8');
					$location=htmlentities(text_only(trim($_POST['location'])),ENT_QUOTES,CONF_ENC,false);		
					$text=$_POST['text'];
					$purifier = new HTMLPurifier();
					$text=$purifier->purify($text);	//$text=htmlentities($text,ENT_QUOTES,'UTF-8');			
					$all_field_list = $service->get_all_field_list($cat_id);		
					if (count($all_field_list)>0) {
						foreach ($all_field_list as $k=>$v) {
							if (isset($_POST[$v['name']])) {
								$all_field_list[$k]['default']=htmlentities(text_only(trim($_POST[$v['name']])),ENT_QUOTES,CONF_ENC,false);
							}
						}
					}

					$value_list = array('text'=>$text,'subject'=>$subject,'location'=>$location);

			


					list($error,$error_list)=validate_ad_for_edit($value_list,$_FILES['photo'],$all_field_list);//validation	
					include 'securimage/securimage.php';//check captcha!
					$securimage = new Securimage();
					if ($securimage->check($_POST['captcha_code']) == false) {
						$error=true;
						$error_list['captcha']=LANG_POST_EM_WRONG_CAPTCHA;
					} 					
					$photo_action=$_POST['photo_action'];
					switch ($photo_action) {
						case PHOTO_ACTION_KEEP:
							$photo=null;
							break;
						case PHOTO_ACTION_DELETE:
							$photo=null;
							break;
						case PHOTO_ACTION_CHANGE:
							$photo=$_FILES['photo'];
							break;
						case PHOTO_ACTION_NEW:
							$photo=$_FILES['photo'];
							break;							
						default:
							$photo=null;
							$photo_action=null;
							break;
					}	
					if (!$error) {		
						if (!$service->save_ad($ad['id'],$value_list,$photo,$all_field_list,$photo_action)) {
							$error=true;
							$error_list['server']=LANG_POST_EM_FAIL_TO_POST;
						}
					}					
					$view->city=$service->get_city_by_id($city_id);			
					$view->category_path=$service->get_category_path($cat_id);					
					$view->post_breadcrumb=LANG_AM;		
					$view->pushToQueue('breadcrumbs.tpl.php');
					$view->pushToQueue('search.tpl.php');
					$view->photo_list=$service->get_photo_list($id);
					$view->ad=array('subject'=>$subject,'text'=>$text,'location'=>$location,'code'=>$code,'id'=>$id);

					$view->all_field_list=$all_field_list;

					if (!$error) {					
						$view->message=LANG_AM_SAVED;	
						$view->pushToQueue('message.tpl.php');				
						$view->pushToQueue('ad_manager_edit.tpl.php');							
					}
					else {
						$view->error_list=$error_list;
						$view->pushToQueue('ad_manager_edit.tpl.php');									
					}
				}
				elseif ($action=='edit') {
					$view->city=$service->get_city_by_id($city_id);			
					$view->category_path=$service->get_category_path($cat_id);					
					$view->post_breadcrumb=LANG_AM;		
					$view->pushToQueue('breadcrumbs.tpl.php');
					$view->pushToQueue('search.tpl.php');
					$view->photo_list=$service->get_photo_list($id);
					$view->ad=$ad;	
					
					$all_field_list = $service->get_all_field_list($cat_id);		
					
					$field_list=$service->get_value_list($id);					
					if (count($all_field_list)>0&&count($field_list)>0) {					
						foreach ($all_field_list as $afl_k=>$afl_v) {						
							foreach ($field_list as $fl_k=>$fl_v) {
								if ($afl_v['name']==$fl_v['name']) {								
									$all_field_list[$afl_k]['default']=$fl_v['value'];
								}
							}
						}
					}
					
					$view->all_field_list=$all_field_list;											
					$view->pushToQueue('ad_manager_edit.tpl.php');									
				}
			break;
			case 'delete':
				if ($ad['active']==1) {
					try {
						$service->delete_ad($id);	
						$view->message=LANG_AM_DELETED;
					}
					catch (Exception $e) {
						$view->message=LANG_ER_ERROR;
					}
				}
				if (chkid($_COOKIE['city_id'])) {
					$city_id=$_COOKIE['city_id'];
					$view->city=$service->get_city_by_id($city_id);					
				}				
				$view->pushToQueue('breadcrumbs.tpl.php');
				$view->pushToQueue('search.tpl.php');	
				$view->pushToQueue('message.tpl.php');								
			break;
			case 'verify':
			case 'view':
			default:
				if ($ad['verified']==0) {	//PUBLISH!!!
					try {
						$service->verify_ad($id);						
						$view->message=LANG_AM_PUBLISHED;			
					}
					catch (Exception $e) {
						$view->message=LANG_ER_ERROR;
					}				
				}
				else { //EDIT or DELETE
					$view->message=LANG_AM_PUBLISHED;			
				}
				$city_id=$city_id;	
				$view->city=$service->get_city_by_id($city_id);			
				$view->category_path=$service->get_category_path($cat_id);					
				$view->post_breadcrumb=LANG_AM;		
				$view->pushToQueue('breadcrumbs.tpl.php');
				$view->pushToQueue('search.tpl.php');
				$view->photo_list=$service->get_photo_list($id);
				$view->ad=$ad;	
				$view->value_list=$service->get_value_list($id);	
				$view->pushToQueue('message.tpl.php');				
				$view->pushToQueue('ad_manager.tpl.php');	

		}
	}
	else {
		if (chkid($_COOKIE['city_id'])) {
			$city_id=$_COOKIE['city_id'];
			$view->city=$service->get_city_by_id($city_id);					
		}
		$view->pushToQueue('breadcrumbs.tpl.php');
		$view->pushToQueue('search.tpl.php');		
		$view->message=LANG_ER_NO_AD;
		$view->pushToQueue('message.tpl.php');
	}
	$view->no_counter=true;
	$view->pushToQueue('footer.tpl.php');
	$view->displayQueue();
}

?>