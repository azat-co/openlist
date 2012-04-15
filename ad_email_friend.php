<?php 
// sleep(2);
	include 'class/includes.php';
	$error_list=array();
	
	$ad_id=htmlentities(text_only(trim($_POST['ad_id']),ENT_QUOTES,CONF_ENC,false));	
			//$location=htmlentities(text_only(trim($_POST['location'])),ENT_QUOTES,CONF_ENC,false);	
	$friend_email=text_only(trim($_POST['friend_email']));	
	$user_email=text_only(trim($_POST['user_email']));	
	$action=htmlentities(text_only(trim($_POST['action']),ENT_QUOTES,CONF_ENC,false));	
	
	$view=new Savant3();	
	$view->setPath('template',array(TPL_PATH));		

	
	if ($action=='load') {
		$view->value_list=array('ad_id'=>$ad_id,'action'=>'submit');
		$view->pushToQueue('ad_email_friend.tpl.php');		
	}
	elseif ($action=='submit') {
		if (empty($friend_email)) {
			$error_list[]=LANG_AD_EF_F_EMAIL_EMPTY;		
		}
		elseif (!isemail($friend_email)) {
			$error_list[]=LANG_AD_EF_F_EMAIL_WRONG_FORMAT;		
		}
		if (!empty($user_email)&&!isemail($user_email)) {
			$error_list[]=LANG_AD_EF_EMAIL_WRONG_FORMAT;
		}
		if (!chkid($ad_id)) {
			$error_list[]='a';
		}	
		if (empty($error_list)) {
		//	if (ad_email_friend($ad_id,$friend_email,$user_email)) {
		//		$view->message=LANG_AD_EF_SUCCESS;
		//		$view->pushToQueue('message.tpl.php');
		//	}
		//	else {
				$view->message=LANG_AD_EF_FAIL;
				$view->pushToQueue('message.tpl.php');
		//	}
		}
		else {
			$view->error_list=$error_list;
			$view->pushToQueue('error_list.tpl.php');
			$view->value_list=array('ad_id'=>$ad_id,'friend_email'=>$friend_email,'user_email'=>$user_email,'action'=>'submit');
			$view->pushToQueue('ad_email_friend.tpl.php');
		}
		
	}
	
	$view->displayQueue();
?>
