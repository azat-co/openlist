<?php
	include 'class/includes.php';	
    $service = Service::getInstance();
	$view=new Savant3();
	$view->setPath('template',array(TPL_PATH));	
	session_start();
	$view->pushToQueue('header.tpl.php'); 	
	if (chkid($_COOKIE['city_id'])) {
		$city_id=$_COOKIE['city_id'];
		$view->city=$service->get_city_by_id($city_id);			
	}
	$view->post_breadcrumb=LANG_FOOTER_CONTACT_US;
	$view->pushToQueue('breadcrumbs.tpl.php');	
	$view->pushToQueue('search.tpl.php');
	
	if (isset($_POST['action'])&&$_POST['action']=='submit') {//validation
		$error=false;
		$error_list=array();	
		$text=$_POST['text'];

		if (!isset($text)||trim($text)=='') {
			$error=true;
			$error_list['textempty']=LANG_POST_EM_EMPTY_TEXT;
		}
		else {
			if (mb_strlen($text,CONF_ENC)>AD_TEXT_LIMIT) {
				$error=true;
				$error_list['textlimit']=sprintf(LANG_POST_EM_AD_IS_BIG,AD_TEXT_LIMIT);
			}	
		}

		include 'securimage/securimage.php';	//check captcha!
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			$error=true;
			$error_list['captcha']=LANG_POST_EM_WRONG_CAPTCHA;
		}
	   
		if ($error) {
			$view->error_list=$error_list;
		}
		else {	
			try {
				$text=text_only($text);
			//	$values = array(array('cat_id'=>$cat_id, 'text'=>$text,'subject'=>$subject,'location'=>$location,'city_id'=>$city_id,'user_id'=>$email,'code'=>$code));
			//	$view->success_message=$service->insert_new_ad($values,$_FILES['photo'],$all_field_list);	
				//TODO send email
				$data=array('text'=>$text);
				$message_sent=send_email_contactus($data);
				if (!$message_sent) {
					$error=true;
					$error_list['server']=LANG_POST_EM_FAIL_TO_POST;					
				}
			}
			catch(Exception $e) {				
				$error=true;
				$error_list['server']=LANG_POST_EM_FAIL_TO_POST;	
			}
		}
	}
	if ($message_sent) {
		//$view->pushToQueue('contactus_success.tpl.php'); 
		$view->message=LANG_CU_MSG_SENT;		
	
		$view->pushToQueue('message.tpl.php');
	}			
	else {
		if ($error) {
			$view->error_list=$error_list;
		}
		$view->text=$text;
		$view->pushToQueue('contactus.tpl.php'); 
	}
	$view->pushToQueue('footer.tpl.php'); 
	$view->displayQueue();
?>
