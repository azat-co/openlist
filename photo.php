<?php
	include 'class/includes.php';
	if (chkid($_GET['id'])){
		
		$id = $_GET['id'];
		
			$host = SystemConsts::HOST;
			$database = SystemConsts::DB;
			$username= SystemConsts::USERNAME;
			$password= SystemConsts::PASSWORD;
			@mysql_connect($host, $username, $password) or die("Can not connect to database: ".mysql_error());
			@mysql_select_db($database) or die("Can not select the database: ".mysql_error());	
			$result = mysql_query('SELECT photo.* FROM photo , ad, ad_photo WHERE photo.id='.$id.' AND ad_photo.ad_id=ad.id AND ad_photo.photo_id=photo.id AND ad.active=1 AND ad.verified AND DATEDIFF(CURDATE(),date)<'.CONF_DATE_LIMIT.'');
			if (mysql_num_rows($result)==1) {
				$row = mysql_fetch_array($result);
				header('Content-length: '.$row['size']);
				header('Content-type: '.$row['type']);
				echo base64_decode($row['photo']);

			}
			else {
				echo 'image not found';
			}
		// }	
	}
	else {

		header( 'Status: 404' );
		echo 'no image id or wrong format';
	}

?>