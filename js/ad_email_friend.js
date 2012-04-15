$(function() {  
	$('#ad-email-friend-box').find('div#openform-button-box').find('input[name=openform]').click(function() {  
		 $(this).hide('fast');
		 $('#ad-email-friend-box').find('div#form-box').html('<img src="'+siteURL+'img/ajax-loader.gif" /> '+langLoading).fadeIn('slow');
		//$(this).fadeOut('slow');
		//   $(".stuff").animate({ height: 'show', opacity: 'show' }, 'slow');

	 //alert("Hello world!");
		$('#ad-email-friend-box').find('div#form-box').load('../ad_email_friend.php',{ad_id:$(this).attr('ad_id'), action:'load'}).fadeIn('slow');

	});  
	// $('form[name=email_friend]').onsubmit(function() {
		// $('#ad-email-friend-box').find('div#openform-button-box').find('input[name=openform]').click();
	// });
	

}); 
 /* $(document).ready(function(){
   $("a").toggle(function(){
     $(".stuff").hide('slow');
   },function(){
     $(".stuff").show('fast');
   });
 });
*/