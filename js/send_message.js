if (document.getElementById('ad-send-message-box')!=null) {
	document.forms['send_message'].elements['captcha_code'].onkeypress=function (event) {
		if (enter_pressed(event)) {
			document.getElementById('sendmessagebtn').click();
		}
	}
	document.getElementById('send-one-more-message').onclick=function() {	
		document.getElementById('ad-send-message-output-box').innerHTML='';
		document.getElementById('ad-send-message-box').className='';
		document.getElementById('ad-send-message-success-box').className='hide';
		document.forms['send_message'].reset();
		return false;
	}
	document.forms['send_message'].elements['send'].onclick=function () {
		document.getElementById('ad-send-message-output-box').innerHTML='<img src="'+siteURL+'img/ajax-loader.gif" />'+langLoading;
		var url='ad_send_message.php';
		var action=escape(document.forms['send_message'].elements['action'].value);
		var text=escape(document.forms['send_message'].elements['text'].value);
		var email=escape(document.forms['send_message'].elements['email'].value);
		var captcha_code=escape(document.forms['send_message'].elements['captcha_code'].value);
		var ad_id=escape(document.forms['send_message'].elements['ad_id'].value);
		
		var params='action='+action+'&text='+text+'&email='+email+'&captcha_code='+captcha_code+'&ad_id='+ad_id;
		if (window.ActiveXObject) {//IE
			http = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else {
			if (window.XMLHttpRequest) {//other
				http = new XMLHttpRequest();
			}
			else{
				alert("your browser does not support AJAX");
			}
		}
		//alert(siteURL+url);
		http.open("POST",siteURL+url,true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");	
		http.setRequestHeader("Cache-Control", "no-cache");
		http.setRequestHeader("Pragma", "no-cache");
		
		http.onreadystatechange = function() {
			if (http.readyState == 4)        {
				if (http.status == 200)            {
					if (http.responseText != null) {
						if (http.responseText=='success') {
							//document.getElementById('ad-send-message-box').innerHTML=http.responseText;
							document.getElementById('ad-send-message-box').className='hide';
							document.getElementById('ad-send-message-success-box').className='';
						}
						else {
							document.getElementById('ad-send-message-output-box').innerHTML=http.responseText;
						}
					}
					else  {
						alert("Failed to receive RSS file from the server - file not found.");
						return false;
					}
					document.getElementById('captcha').src = siteURL+'securimage/securimage_show.php?sid=' + Math.random();
				}
				else{
					alert("Error code " + http.status + " received: " + http.statusText);
				}
			}
		}

		http.send(params);
		return false;
	}
}