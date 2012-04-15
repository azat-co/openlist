<?php
    mb_language("uni");
	mb_internal_encoding('UTF-8');
	/*functions that are used only in one place in classes or scripts, moved here to make code look better or for specific context only*/
	function send_email_to_ad_submitter($data) {
	
		$to      	= $data['user_id'];
		$subject 	= LANG_AD_SUBMITTER_SUBJECT.' '.html_entity_decode($data['subject']);
		//$subject 	= LANG_AD_SUBMITTER_SUBJECT.' '.html_entity_decode($data['subject'],ENT_QUOTES,CONF_ENC,false);
		$subject = mb_encode_mimeheader($subject);
		
		$notice_text = "This is a multi-part message in MIME format.";
		$plain_text = LANG_PLAIN_TEXT.SITE_URL.'ad_manager/view_'.$data['id'].'_'.$data['code'].'/'.LANG_PLAIN_TEXT2;
		$html_text = LANG_HTML_TEXT.'<a href="'.SITE_URL.'ad_manager/view_'.$data['id'].'_'.$data['code'].'/">'.SITE_URL.'ad_manager/view_'.$data['id'].'_'.$data['code'].'/</a>'.LANG_HTML_TEXT2;

		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:multipart/alternative; '."\n".' boundary='.$mime_boundary_header."\r\n";	
		$headers  .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers.= 'From: '.mb_encode_mimeheader(LANG_LOGO,'utf-8').' <'.MONSTER_EMAIL.'>' . "\r\n";
		$headers .= 'Bcc: '.LOG_EMAIL. "\r\n";
		
		$body = "$notice_text

--$mime_boundary
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit

$plain_text

--$mime_boundary
Content-Type: text/html; charset=utf-8
Content-Transfer-Encoding: 8bit

$html_text

--$mime_boundary--";
		
		$body		= wordwrap($body, 70);		
		
		$result = mail($to, $subject, $body, $headers);		 return $result;
		
/*	
	//	mb_language("uni");
	//	$body =  mb_convert_encoding($body, CONF_ENC,"AUTO");
	//	$subject = mb_convert_encoding($subject, CONF_ENC,"AUTO");
	//	$subject = mb_encode_mimeheader($subject);
*/
	}
  function utf8_urldecode($str) {
    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    return html_entity_decode($str,null,'UTF-8');;
  }
	function send_email_reply_to_ad($data) {
		$to = $data['user_id'];
		$subject= $data['subject'];
	//	$subject=mb_convert_encoding($subject, CONF_ENC,"AUTO");
		$subject = mb_encode_mimeheader($subject,'utf-8');

		$data['text']=utf8_urldecode($data['text']);
		
		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:multipart/alternative; '."\n".' boundary='.$mime_boundary_header."\r\n";	
	//	$headers  .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers.= 'From: '.mb_encode_mimeheader(LANG_LOGO,'utf-8').' <'.MONSTER_EMAIL.'>' . "\r\n";
	//	$headers.= 'From: '.mb_encode_mimeheader(mb_convert_encoding(LANG_LOGO, CONF_ENC,"AUTO"),'utf-8').' <'.MONSTER_EMAIL.'>' . "\r\n";
		if (!empty($data['email'])) {
			$headers.= 'Reply-To: '.mb_encode_mimeheader($data['email'],'utf-8')."\r\n";
			$to_text=$data['email']."\r\n";
			$to_html='<a href="mailto:'.$data['email'].'">'.$data['email'].'</a><br/>';
		}
		else {
			$to_text='';
			$to_html='';
		}
		$headers .= 'Bcc: '.LOG_EMAIL. "\r\n";
		
		$notice_text = "This is a multi-part message in MIME format.";
		$plain_text = $data['text']."\r\n\r\n".LANG_AVOID_SPAM_TEXT.' '.$to_text."\r\n\r\n".LANG_AVOID_SPAM_TEXT2.SITE_URL.'ads/'.$data['ad_id'].'.html';
		$html_text = '<html><body>'.'<p>'.$data['text'].'</p><br/><br/>'.LANG_AVOID_SPAM_HTML.' '.$to_html.'<br/><br/>'.LANG_AVOID_SPAM_HTML2.'<a href="'.SITE_URL.'ads/'.$data['ad_id'].'.html'.'">'.SITE_URL.'ads/'.$data['ad_id'].'.html</a>'.'</body></html>';
		
		$body = "$notice_text

--$mime_boundary
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit

$plain_text

--$mime_boundary
Content-Type: text/html; charset=utf-8
Content-Transfer-Encoding: 8bit

$html_text

--$mime_boundary--";
		
		$body		= wordwrap($body, 70);		

		$result=mail($to, $subject , $body,$headers); return $result;	
		//return true;
	}
	function send_email_contactus($data) {
		$to =ADMIN_EMAIL;
		$subject= 'Contact Us';
		$subject = mb_encode_mimeheader($subject,'utf-8');
		
		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type:multipart/alternative; '."\n".' boundary='.$mime_boundary_header."\r\n";		
		$headers.= 'From: '.mb_encode_mimeheader(LANG_LOGO,'utf-8').' <'.MONSTER_EMAIL.'>' . "\r\n";
		
		$notice_text = "This is a multi-part message in MIME format.";
				
		$plain_text = $data['text'];
		$html_text = $data['text'];				
				
		$body = "$notice_text

--$mime_boundary
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit

$plain_text

--$mime_boundary
Content-Type: text/html; charset=utf-8
Content-Transfer-Encoding: 8bit

$html_text

--$mime_boundary--";
		$body		= wordwrap($body, 70);		

		$result=mail($to, $subject , $body,$headers); return $result;	
		//echo $text; return true;


	}


	function ad_email_friend($ad_id,$friend_email,$user_email=null) {
		$to =$friend_email;
		
		
		$subject= LANG_FORWARDED_SUBJECT;
		//$subject= mb_convert_encoding($subject, 'UTF-8','AUTO');
		$subject = mb_encode_mimeheader($subject,'UTF-8','Q');
		//$subject ="?UTF-8?B?".base64_encode($subject)."?=\n";
		
		$semi_rand = md5(time());
		$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
		$mime_boundary_header = chr(34) . $mime_boundary . chr(34);
	
		//$headers= 'From: '.mb_encode_mimeheader(mb_convert_encoding(LANG_LOGO, 'UTF-8','AUTO'),'UTF-8').'<'.MONSTER_EMAIL.'>' . "\r\n";
		//$headers= 'From: '.mb_encode_mimeheader(LANG_LOGO.'<'.MONSTER_EMAIL.'>','UTF-8','Q'). "\r\n";
		//$headers= 'From: '.LANG_LOGO.' <'.MONSTER_EMAIL.'>' . "\r\n";
		$headers= 'From: '.mb_encode_mimeheader(LANG_LOGO,'UTF-8','B').' <'.MONSTER_EMAIL.'>' . "\r\n";
		//$headers= "?UTF-8?B?".base64_encode(LANG_LOGO)."?=".' <'.MONSTER_EMAIL.'>' . "\r\n";
		
		$plain_text = SITE_URL.'ads/'.$ad_id.'.html'."\r\n";
		$html_text ='<a href="'.SITE_URL.'ads/'.$ad_id.'.html'.'" >'.SITE_URL.'ads/'.$ad_id.'.html'.'</a><br/>';
		if (!empty($user_email)) {
			$headers.= 'Reply-To: '.mb_encode_mimeheader($user_email,'utf-8')."\r\n";
			$plain_text.="\r\n".$user_email.' '.LANG_FORWARDED."\r\n\r\n";
			$html_text.='<br/>'.'<a href="mailto:'.$user_email.'">'.$user_email.'</a>'.' '.LANG_FORWARDED.'<br/><br/>';
		}
		$plain_text.="\r\n"."\r\n".LANG_FORWARDED2.' '. ADMIN_EMAIL."\r\n";
		$html_text.='<br/><br/>'.LANG_FORWARDED2.' <a href="mailto:'. ADMIN_EMAIL.'">'. ADMIN_EMAIL."</a><br/><br/>";
		$headers .= 'Bcc: <'.LOG_EMAIL. ">\r\n";
		
		//$headers .= 'Content-type:multipart/alternative; charset=utf-8; '."\n".' boundary='.$mime_boundary_header."\r\n";
		$headers .= 'Content-type:multipart/alternative; '."\n".' boundary='.$mime_boundary_header."\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		//$headers  .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers  .= "X-Mailer: PHP\r\n";
		$body = "$notice_text

--$mime_boundary
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit

$plain_text

--$mime_boundary
Content-Type: text/html; charset=utf-8
Content-Transfer-Encoding: 8bit

$html_text

--$mime_boundary--";
		$body		= wordwrap($body, 70);		

		$result=mail($to, $subject , $body,$headers); return $result;	
		//echo $text; return true;
	
	}
	
	

	function is_image_type($filename,$mimetype,$tmp_filename) {
		/*
		$allowedExtensions = array("jpg","jpeg","gif","png",'bmp','tiff'); 
		return (in_array(end(explode(".", strtolower($filename))),$allowedExtensions));*/
	//	echo $tmp_filename;
	//	if (empty($mimetype)) {
	//		list($width, $height, $type, $attr)=getimagesize($tmp_filename);
	//	}
	//	echo $type;

		return (strpos(PHOTO_TYPES,end(explode(".", strtolower($filename))))!== FALSE && strpos(PHOTO_TYPES,end(explode("/", strtolower($mimetype))))!== FALSE);
	}

	function validate_ad($value_list,$photo,$all_field_list) {
		$error=false;
		$error_list=array();
		$value_list=$value_list[0];
		$subject=$value_list['subject'];
		$location=$value_list['location'];
		$text=$value_list['text'];
		$email=$value_list['user_id'];
		$cat_id=$value_list['cat_id'];
		$city_id=$value_list['city_id'];
		$anonymize=$value_list['anonymize'];
		
		validate_ad_subject($subject,$error,$error_list);
		validate_ad_location($location,$error,$error_list);
		validate_ad_text($text,$error,$error_list);
		validate_ad_photo($photo,$error,$error_list);
		if (!isset($email)||trim($email)=='') {
			$error=true;
			$error_list['email_empty']=LANG_POST_EM_EMPTY_EMAIL;
		}
		elseif (!isemail($email)) {
			$error=true;
			$error_list['email_wrong_format']=LANG_POST_EM_NOT_VALID_EMAIL;
		}
		elseif (strlen($email)>AD_EMAIL_LIMIT) {
			$error=true;
			$error_list['email_too_big']=sprintf(LANG_POST_EM_AD_EMAIL_IS_BIG,AD_EMAIL_LIMIT);
		}		
		if (!isset($cat_id)||trim($cat_id)==''||trim($cat_id)=='0') {
			$error=true;
			$error_list['cat_id']=LANG_POST_EM_EMPTY_CATEGORY;
		}	
		if (!($anonymize==CONST_POST_ANONYMIZE_YES||$anonymize==CONST_POST_ANONYMIZE_NO)) {
			$error=true;
			$error_list['anonymize']=LANG_POST_EM_WRONG_ANONYMIZE;
		}			
		if (!isset($_COOKIE['city_id'])||trim($_COOKIE['city_id'])==''||trim($_COOKIE['city_id'])=='0') {
			$error=true;
			$error_list['city_id']=LANG_POST_EM_EMPTY_CITY;
		}		
	
		validate_field_list ($all_field_list,$error,$error_list);	//TODO check additional fields	
		return array($error, $error_list);
	}
	
	function validate_ad_for_edit($value_list,$photo,$all_field_list) {
		$error=false;
		$error_list=array();
		$subject=$value_list['subject'];
		$location=$value_list['location'];
		$text=$value_list['text'];
		
		validate_ad_subject($subject,$error,$error_list);
		validate_ad_location($location,$error,$error_list);
		validate_ad_text($text,$error,$error_list);
		validate_ad_photo($photo,$error,$error_list);
		validate_field_list ($all_field_list,$error,$error_list);	//TODO check additional fields	
		return array($error, $error_list);
	}
	
	function validate_ad_subject ($subject,&$error,&$error_list) {
		if (!isset($subject)||mb_strlen($subject,CONF_ENC)==0) {
			$error=true;
			$error_list['subject']=LANG_POST_EM_EMPTY_SUBJECT;
		}	
		elseif (mb_strlen($subject,CONF_ENC)>AD_SUBJECT_LIMIT) {
			$error=true;
			$error_list['subject']=sprintf(LANG_POST_EM_AD_SUBJECT_IS_BIG,AD_SUBJECT_LIMIT);
		}			
	}
	
	function validate_ad_location ($location,&$error,&$error_list) {
		if (mb_strlen($location,CONF_ENC)>AD_LOCATION_LIMIT) {
			$error=true;
			$error_list['location']=sprintf(LANG_POST_EM_AD_LOCATION_IS_BIG,AD_LOCATION_LIMIT);	
		}	
	}
	
	function validate_ad_text ($text,&$error,&$error_list) {
		if (!isset($text)||trim($text)=='') {
			$error=true;
			$error_list['text']=LANG_POST_EM_EMPTY_TEXT;
		}
		else {
			if (mb_strlen($text,CONF_ENC)>AD_TEXT_LIMIT) {
				$error=true;
				$error_list['text']=sprintf(LANG_POST_EM_AD_IS_BIG,AD_TEXT_LIMIT);
			}	
		}
	}
	function validate_ad_photo ($photo,&$error,&$error_list) {	
		if (isset($photo)&&!empty($photo['name'])) {
			if (empty($photo['size'])||empty($photo['name'])||empty($photo['tmp_name'])) {
				$error=true;
				$error_list['photo_error']=sprintf(LANG_POST_EM_PHOTO_ERROR,PHOTO_SIZE_LIMIT);				
			}
			else {
				if($photo['size'] > PHOTO_SIZE_LIMIT) {	
					$error=true;
					$error_list['photo_size']=sprintf(LANG_POST_EM_PHOTO_IS_BIG,PHOTO_SIZE_LIMIT);
				}	
				if(!is_image_type($photo['name'],$photo['type'],$photo['tmp_name'])) {	
					$error=true;
					$error_list['photo_type']=sprintf(LANG_POST_EM_PHOTO_WRONG_TYPE,PHOTO_TYPES);
				}
			}
		}
	}
	function validate_field_list($field_list,&$error,&$error_list) {
		foreach ($field_list as $k=>$v){			
			if (!empty($v['default'])) {
				switch($v['type']) {
					case TYPE_NUMBER:
						if (!preg_match('/^([0-9]{1,11})$/',$v['default'])) {						
							$error=true;
							$error_list['field_list'.$v['type'].$k]=LANG_POST_EM_NUM_WRONG_TYPE;
						}				
					break;
					case TYPE_SELECT:
						if (!preg_match('/^([0-9]{1,2})$/',$v['default'])) {
							$error=true;
							$error_list['field_list'.$v['type'].$k]=LANG_POST_EM_SEL_WRONG_TYPE;
						}									
					break;
				}
				if (mb_strlen($v['default'],CONF_ENC)>CONST_AD_VALUE_LIMIT) {
					$error=true;
					$error_list['field_list'.$v['type'].$k]=sprintf(LANG_POST_EM_VALUE_IS_BIG,CONST_AD_VALUE_LIMIT);
				}
			}
		}
	}
	

?>