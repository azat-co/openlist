if (document.getElementById('ad-flagging-box')!=null) {
	linkList=document.getElementById('ad-flagging-box').getElementsByTagName('a');	
	//alert(linkList);
	for (i=0;i<linkList.length;i++) {
		if (linkList[i].className=='flag') {
			linkList[i].onclick=function () {
				sendFlag(this.getAttribute('value'));
				return false;
			}
		}
	}
}
function sendFlag(val) {
	document.getElementById('ad-flagging-box').innerHTML='<img src="'+siteURL+'img/ajax-loader.gif" />'+langLoading;
	var url='ad_send_flag.php';
	var flag=val.split('_')[0];
	var ad_id=val.split('_')[1];
	var params='flag='+flag+'&ad_id='+ad_id;
	//alert(val);
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
					// if (http.responseText=='success') {
						// document.getElementById('ad-flagging-box').className='hide';
						// document.getElementById('ad-flagging-success-box').='';
					// }
					// else {
						// document.getElementById('ad-flagging-box').innerHTML=http.responseText;
					// }
					document.getElementById('ad-flagging-box').innerHTML=http.responseText;
				}
				else  {
					alert("Failed to receive RSS file from the server - file not found.");
					return false;
				}				
			}
			else{
				alert("Error code " + http.status + " received: " + http.statusText);
			}
		}
	}

	http.send(params);
		
}	

