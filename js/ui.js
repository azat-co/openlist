if (document.forms['post-ad-form']) {
	document.forms['post-ad-form'].elements['subject'].focus();
}
//alert(document.forms['searchForm']);
//do search input field
if (document.forms['searchForm']!=null) {
	if (document.forms['searchForm'].elements['search_term']!=null) {
		
		var defaultValue=document.forms['searchForm'].elements['search_term'].getAttribute('defaultSearchTerm');
		if (defaultValue==document.forms['searchForm'].elements['search_term'].value) {
			document.forms['searchForm'].elements['search_term'].className='default';
			//alert(document.forms['searchForm'].elements['search_term'].getAttribute('defaultValue2'));
		}
		else {
			document.forms['searchForm'].elements['search_term'].className='';
		}
		document.forms['searchForm'].elements['search_term'].onfocus=function() {
			if (this.value==defaultValue) {
				this.value='';
				this.className='';
			}
		};
		document.forms['searchForm'].elements['search_term'].onblur=function() {
			if (this.value=='') {
				this.value=defaultValue;
				this.className='default';
			}
		};		
		// if (document.forms['searchForm'].elements['submit']!=null) {
			// document.forms['searchForm'].elements['submit'].onclick =function() {				
				// if (document.forms['searchForm'].elements['search_term'].value==defaultValue) {
					// document.forms['searchForm'].elements['search_term'].value='';
				// }
				// return true;
			// }
		// }
	}
}

//This prototype is provided by the Mozilla foundation and
//is distributed under the MIT license.
//http://www.ibiblio.org/pub/Linux/LICENSES/mit.license

if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=");
  if (c_start!=-1)
    {
    c_start=c_start + c_name.length+1;
    c_end=document.cookie.indexOf(";",c_start);
    if (c_end==-1) c_end=document.cookie.length;
    return unescape(document.cookie.substring(c_start,c_end));
    }
  }
return "";
}
function setCookie(c_name,value,expiredays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate()+expiredays);
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+';path=/';
}
var inFav=getCookie('in_favorites');
var favIDs=new Array();
if (inFav!=null &&inFav!='') {
	//alert(inFav);
	favIDs=inFav.split('_');
}
images=document.getElementsByTagName('img');
var stars=new Array();
for (i=0,j=0; i<images.length;i++) {
 if (images[i].className=='favorite') {
	stars[j]=images[i];
	j++;
	}
}
document.getElementById('link-to-favorites').childNodes[1].innerHTML=document.getElementById('link-to-favorites').childNodes[1].getAttribute('defaultText')+' ('+favIDs.length+')';
if (favIDs.length==0) {
	document.getElementById('link-to-favorites').className='hide';

	//document.getElementById('link-to-favorites').setAttribute('style','display:none;');
	}
else {
	document.getElementById('link-to-favorites').className='show';
	//document.getElementById('link-to-favorites').setAttribute('style','');
	}
//alert(favIDs.length);
for (i=0; i<stars.length;i++) {
	stars[i].onclick=function () {
		clickOnStar(this);
		}
	if (favIDs.indexOf(stars[i].getAttribute('ad_id'))>-1) {
 		stars[i].setAttribute('src',''+siteURL+'img/star-on.png');
	}
	else {
		stars[i].setAttribute('src',''+siteURL+'img/star-off.png');
	}
	
}
function clickOnStar(star) {
	if (favIDs.indexOf(star.getAttribute('ad_id'))>-1) {
	//	alert(favIDs.indexOf(this.getAttribute('ad_id'))+'---id='+(this.getAttribute('ad_id')));
		favIDs.splice(favIDs.indexOf(star.getAttribute('ad_id')),1);			
		inFavs=favIDs.join('_');
		setCookie('in_favorites',inFavs,365);
		star.setAttribute('src',''+siteURL+'img/star-off.png');
		if (favIDs.length==0) {
			document.getElementById('link-to-favorites').className='hide';
			}
		else {
			document.getElementById('link-to-favorites').className='show';
		}			
	}
	else {//push
		favIDs.push(star.getAttribute('ad_id'));
		inFavs=favIDs.join('_');
		setCookie('in_favorites',inFavs,365);			
		star.setAttribute('src',''+siteURL+'img/star-on.png');
		if (favIDs.length==0) {
			document.getElementById('link-to-favorites').className='hide';
			}
		else {
			document.getElementById('link-to-favorites').className='show';
			}			
	}
	document.getElementById('link-to-favorites').childNodes[1].innerHTML=document.getElementById('link-to-favorites').childNodes[1].getAttribute('defaultText')+' ('+favIDs.length+')';		
}
/*
for (i=0; i<stars.length;i++) {
	stars[i].onclick=function() {
		if (favIDs.indexOf(this.getAttribute('ad_id'))>-1) {
		//	alert(favIDs.indexOf(this.getAttribute('ad_id'))+'---id='+(this.getAttribute('ad_id')));
			favIDs.splice(favIDs.indexOf(this.getAttribute('ad_id')),1);			
			inFavs=favIDs.join('_');
			setCookie('in_favorites',inFavs,365);
			this.setAttribute('src','img/star-off.png');
			if (favIDs.length==0) {
				document.getElementById('link-to-favorites').className='hide';
				}
			else {
				document.getElementById('link-to-favorites').className='show';
			}			
		}
		else {//push
			favIDs.push(this.getAttribute('ad_id'));
			inFavs=favIDs.join('_');
			setCookie('in_favorites',inFavs,365);			
			this.setAttribute('src','img/star-on.png');
			if (favIDs.length==0) {
				document.getElementById('link-to-favorites').className='hide';
				}
			else {
				document.getElementById('link-to-favorites').className='show';
				}			
		}
	}
	if (favIDs.indexOf(stars[i].getAttribute('ad_id'))>-1) {
		stars[i].setAttribute('src','img/star-on.png');
	}
	else {
		stars[i].setAttribute('src','img/star-off.png');
	}
	
}*/
function enter_pressed(e){
	var keycode;
	if (window.event) {
		keycode = window.event.keyCode;
	}
	else {
		if (e) {
			keycode = e.which;
		}
		else {
			return false;
		}
	}
	return (keycode == 13);
}