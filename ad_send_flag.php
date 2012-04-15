<?php
	include 'class/includes.php';
	if (isset($_POST['flag'])&&!empty($_POST['flag'])&&chkid($_POST['ad_id'])) {
		
		$clientip=getip();
		$flag=$_POST['flag'];
		$ad_id=$_POST['ad_id'];
		$client=$_SERVER['HTTP_USER_AGENT'];
		$referred = $_SERVER['HTTP_REFERER'];
		switch ($flag) {
			case 'spam':
				
				//break;
			case 'miscat':
				//break;
			case 'viol':
				//break;
			case 'best':
				$service=Service::getInstance();
				$values=array(array('flag'=>$flag,'ad_id'=>$ad_id,'clientip'=>$clientip,'client'=>$client,'referred'=>$referred));
				if ($service->insert_new_flag($values)) {
					echo LANG_AD_SF_SUCCESS;
				}
				else {
					echo LANG_AD_SF_FAIL;
				}
				break;
			default:
				echo 'flag value not found';
				break;
		}
	}
	
?>