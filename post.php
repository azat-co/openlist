<?php
	include 'class/includes.php';
	
	$purifier = new HTMLPurifier();
	$service=Service::getInstance();
	session_start();
	$view=new Savant3();	
	$view->setPath('template',array(TPL_PATH));	
	$view->stylesheet='post.css';	
	if (preg_match('/^([A-Za-z_-]{1,20})$/',$_GET['city_name']) ) {	
		$city_id=$service->get_city_id_by_name($_GET['city_name']);	
		$view->city=$service->get_city_by_id($city_id);			
	}
	if (preg_match('/^([A-Za-z0-9_-]{1,20})$/',$_GET['cat_name']) ) {	
		$cat_id=$service->get_cat_id_by_name($_GET['cat_name']);	
		$view->category=$service->get_category_by_id($cat_id);		
	}			
	if (isset($city_id)&&ctype_digit($city_id)){				
		setcookie('city_id',$city_id,time()+60*60*24*365*10 ,'/');			
	}
	else {		
	}	
	$view->title=LANG_POST_BC;
	$view->pushToQueue('header.tpl.php');
	if (isset($_POST['action'])&&$_POST['action']=='submit'&&(chkid($city_id)||(isset($_COOKIE['city_id'])&&ctype_digit($_COOKIE['city_id'])))) {	
		$error=false;
		$error_messages=array();
		$anonymize=htmlentities(text_only(trim($_POST['anonymize'])),ENT_QUOTES,CONF_ENC,false);
		$subject=htmlentities(text_only(trim($_POST['subject'])),ENT_QUOTES,CONF_ENC,false);		//$str = mb_convert_encoding($str, ‘UTF-8', ‘UTF-8');
		$location=htmlentities(text_only(trim($_POST['location'])),ENT_QUOTES,CONF_ENC,false);		
		$text=$_POST['text'];
		$text=$purifier->purify($text);//		$text=htmlentities($text,ENT_QUOTES,'UTF-8');
		$email=htmlentities(text_only(trim($_POST['email'])),ENT_QUOTES,CONF_ENC,false);
		$cat_id=htmlentities(text_only(trim($_POST['cat_id'])),ENT_QUOTES,CONF_ENC,false);
		$city_id=htmlentities(text_only(trim($_COOKIE['city_id'])),ENT_QUOTES,CONF_ENC,false);//change to vars from dir
		$code = md5(uniqid(rand(), true)); //need it to verify email
		$photo=$_FILES['photo']['name'];//echo $photo;
		$rows = $service->get_all_field_list($cat_id);		
		if (count($rows)>0) {
			foreach ($rows as $key=>$value) {
				if (isset($_POST[$value['name']])) {
					$rows[$key]['default']=htmlentities(text_only(trim($_POST[$value['name']])),ENT_QUOTES,CONF_ENC,false);
				}
			}
		}
		$all_field_list=$rows;
		$values = array(array('cat_id'=>$cat_id, 'text'=>$text,'subject'=>$subject,'location'=>$location,'city_id'=>$city_id,'user_id'=>$email,'code'=>$code,'anonymize'=>$anonymize));
		list($error,$error_messages)=validate_ad($values,$_FILES['photo'],$all_field_list);//validation
		
		include 'securimage/securimage.php';//check captcha!
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			$error=true;
			$error_messages['captcha']=LANG_POST_EM_WRONG_CAPTCHA;
		}   
		if ($error) {
			$view->error_list=$error_messages;
		}
		else {	
			try {		
				$data=$service->insert_new_ad($values,$_FILES['photo'],$all_field_list);
				if ($data!=null&&!empty($data)&&is_array($data)) {
					$msg_sent=send_email_to_ad_submitter($data);
					if ($msg_sent) {
						$ad_posted=true;
					}
					else {
						$error=true;
						$error_messages['email_error']=LANG_POST_EM_FAIL_TO_POST;	
					}				
				}
				else {
					$error=true;
					$error_messages['service_error']=LANG_POST_EM_FAIL_TO_POST;	
				}			
			}
			catch(Exception $e) {//echo $e->getMessage();				
				$error=true;
				$error_messages['service_error']=LANG_POST_EM_FAIL_TO_POST;	
			}
		}
	}
	if ($ad_posted) {
		$view->city=$service->get_city_by_id($city_id);			
		$view->category_path=$service->get_category_path($cat_id);					
		$view->post_breadcrumb=LANG_POST_BC;		
		$view->pushToQueue('breadcrumbs.tpl.php');
		$view->field_list=$service->get_searchable_field_list($cat_id);
		$view->pushToQueue('search.tpl.php');
		$view->success_message=LANG_POST_EXPLAIN.'<br/><br/><br/>'.LANG_ER_HOME_PAGE.sprintf(LANG_POST_SUCCESS_POST_NEW,SITE_URL.'post/'.$view->city['name'].'/');
		$view->pushToQueue('post_success.tpl.php'); 
	}			
	else {
		if ( (chkid($cat_id)||chkid($_POST['cat_id']))&&(chkid($city_id)||chkid($_COOKIE['city_id'])) ) { //FILL FORM	
			if (!chkid($cat_id)) {
				$cat_id=$_POST['cat_id'];
			}
			$category=$service->get_category($cat_id);
			if (count($category)==1) {
				$view->category=$category[0];
				$view->subject=$subject;
				$view->location=$location;
				$view->text=$text;
				$view->email=$email;
				$view->anonymize=$anonymize;
				$view->photo=$photo;
				
				if (!isset($all_field_list)) {
					$view->all_field_list=$service->get_all_field_list($cat_id);				
				}
				else {
					$view->all_field_list=$all_field_list;
				}	
				if (!isset($city_id)) {
					$city_id=$_COOKIE['city_id'];	
				}
				$view->city=$service->get_city_by_id($city_id);			
				$view->category_path=$service->get_category_path($cat_id);					
				$view->post_breadcrumb=LANG_POST_BC;			
				$view->pushToQueue('breadcrumbs.tpl.php');
				$view->field_list=$service->get_searchable_field_list($cat_id);
				$view->pushToQueue('search.tpl.php');
				$view->pushToQueue('post.tpl.php');
				}
			else {
				echo LANG_POST_EM_WRONG_CATEGORY;
			}
		}
		else {
			if (isset($city_id)||(isset($_COOKIE['city_id'])&&ctype_digit($_COOKIE['city_id'])) ){//CHOOSE CATEGORY			
				if (!isset($city_id)) {
					$city_id=$_COOKIE['city_id'];			
				}
				//$view->category_list=$service->get_category_list();
				$view->category_list=$service->get_category_list_with_ad_count($city_id);
				$view->city=$service->get_city_by_id($city_id);	
				$view->post_breadcrumb=LANG_POST_BC;
				$view->pushToQueue('breadcrumbs.tpl.php');	
				$view->pushToQueue('search.tpl.php');
				$view->message= '<h4 style="padding-left:2em;padding-top:1em;">'.LANG_POST_CHOOSE_CATEGORY.'</h4>';
				$view->pushToQueue('message.tpl.php');
				$view->pushToQueue('category_list_post.tpl.php');			
			//	$view->pushToQueue('category_list.tpl.php');	
				$view->pushToQueue('post_js.tpl.php');	
			}
			else { //CHOOSE CITY
				$view->city_list=$service->get_city_list();
				$view->post_breadcrumb=LANG_POST_BC;
			//	$view->pushToQueue('breadcrumbs.tpl.php');	
			//	$view->pushToQueue('search.tpl.php');
			//	$view->message='<h4 style="padding-left:2em;padding-top:1em;">'.LANG_POST_CHOOSE_CITY.'</h4>';
			//	$view->pushToQueue('message.tpl.php');
				$view->pushToQueue('city_list_post.tpl.php');
			//	$view->pushToQueue('city_list.tpl.php');
			}
		}
	}
	$view->pushToQueue('footer.tpl.php');
	$view->displayQueue();
?>