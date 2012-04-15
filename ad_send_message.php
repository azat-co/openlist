<?php
	include 'class/includes.php';
	session_start();
	$view=new Savant3();
	$view->setPath('template',array(TPL_PATH));		
    $service = Service::getInstance();
	
	//sleep(5);
	if (isset($_POST['action'])&&$_POST['action']=='submit') {	
		$error=false;
		$error_messages=array();
		if (!isset($_POST['text'])||trim($_POST['text'])=='') {
			$error=true;
			$error_messages['text']=LANG_POST_EM_AD_EMPTY_MSG;
		}
		else {
			if (strlen($_POST['text'])>AD_MSG_TEXT_LIMIT) {
				$error=true;
				$error_messages['text']=sprintf(LANG_POST_EM_AD_MSG_IS_BIG,AD_MSG_TEXT_LIMIT);
			}	
		}
		if (isset($_POST['email'])&&trim($_POST['email'])!='') {
			if (!isemail($_POST['email'])) {
				$error=true;
				$error_messages['email']=LANG_POST_EM_NOT_VALID_EMAIL;
			}	
		}

		if (!isset($_POST['ad_id'])||trim($_POST['ad_id'])==''||trim($_POST['ad_id'])=='0'||!chkid($_POST['ad_id'])) {
			$error=true;
			$error_messages['ad_id']=LANG_POST_EM_EMPTY_AD_ID;
		}	
	
		include_once 'securimage/securimage.php';
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			//die(LANG_AD_SM_FAIL);
			$error=true;
			$error_messages['captcha']=LANG_POST_EM_WRONG_CAPTCHA;
		}
		
		if (!$error) {
			$text=$_POST['text'];
			$text=text_only($text);
			$email=$_POST['email'];
			//echo '!'.$text;
			$ad=$service->get_ad_by_id($_POST['ad_id']);
			$data=array('text'=>$text,'email'=>$email,'subject'=>$ad['subject'],'ad_id'=>$ad['id'],'user_id'=>$ad['user_id']);
			$ms=send_email_reply_to_ad($data);
			if ($ms) {
				echo 'success';
			}
			else {
				$error=true;
				$error_messages['general_error']=LANG_ER_ERROR;
			}
		//	echo $_POST['text'].$_POST['email'];
			//echo LANG_AD_SM_SUCCESS;
		}
		if ($error) { 
			$view->error_list=$error_messages;
			$view->pushToQueue('ad_send_message_error_message_list.tpl.php');
			// echo '<div id="post-ad-form-error-messages-box">';		
			// foreach ($error_messages as $key=>$value) {
				// echo '<span class="error_message" >'.$value.'</span><br/>';
			// }
			// echo '</div>';
		}
		$view->displayQueue();
	}
	else {
		die('fail');
		//$view->pushToQueue('ad_send_message.tpl.php');
	}
?>